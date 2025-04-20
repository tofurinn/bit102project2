<?php
session_start();
require_once 'userdb.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['userID'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

// Check if required data is present
if (!isset($_POST['title']) || !isset($_POST['content'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required data']);
    exit;
}

$title = trim($_POST['title']);
$content = trim($_POST['content']);
$user_id = $_SESSION['userID'];

// Validate post content
if (empty($title)) {
    echo json_encode(['success' => false, 'message' => 'Title cannot be empty']);
    exit;
}

if (empty($content)) {
    echo json_encode(['success' => false, 'message' => 'Content cannot be empty']);
    exit;
}

// Generate unique post ID
$postID = 'P' . uniqid();

// Insert the post
$sql = "INSERT INTO post (postID, postTitle, postContent, USER_userID, postDateTime) VALUES (?, ?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    exit;
}

$stmt->bind_param("ssss", $postID, $title, $content, $user_id);

if ($stmt->execute()) {
    // Get the new post with user details
    $new_post_sql = "SELECT p.*, u.userName, u.userPic 
                    FROM post p 
                    JOIN user u ON p.USER_userID = u.userID 
                    WHERE p.postID = ?";
    $stmt = $conn->prepare($new_post_sql);
    $stmt->bind_param("s", $postID);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();
    
    // Generate HTML for the new post
    $html = '<div class="explore" data-post-id="' . htmlspecialchars($post["postID"]) . '">';
    $html .= '<div class="profile-picture">';
    $html .= '<img src="' . (empty($post["userPic"]) ? 'images/default-profile.png' : htmlspecialchars($post["userPic"])) . '" alt="Profile Picture" onerror="this.src=\'images/default-profile.png\'">';
    $html .= '</div>';
    $html .= '<div class="post-content">';
    $html .= '<h4 class="username">';
    $html .= '<div style="display: flex; justify-content: space-between; align-items: center;">';
    $html .= '<a href="#profile">@' . htmlspecialchars($post["userName"]) . '</a>';
    $html .= '<div class="actions">';
    $html .= '<button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">';
    $html .= '<i class="fa fa-ellipsis-v"></i>';
    $html .= '</button>';
    $html .= '<ul class="dropdown-menu">';
    $html .= '<li><a class="dropdown-item edit-post" href="#" data-post-id="' . htmlspecialchars($post["postID"]) . '">Edit</a></li>';
    $html .= '<li><a class="dropdown-item delete-post" href="#" data-post-id="' . htmlspecialchars($post["postID"]) . '">Delete</a></li>';
    $html .= '</ul>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</h4>';
    $html .= '<h5 class="post-title">' . htmlspecialchars($post["postTitle"]) . '</h5>';
    $html .= '<p class="post-text">' . nl2br(htmlspecialchars($post["postContent"])) . '</p>';
    $html .= '<div class="comment">';
    $html .= '<div class="collapse multi-collapse" id="multiCollapseExample' . substr($post["postID"], 1) . '">';
    $html .= '<form class="comment-form">';
    $html .= '<input type="text" name="comment" placeholder="comment nice stuff please ♫">';
    $html .= '<input type="hidden" name="post_id" value="' . htmlspecialchars($post["postID"]) . '">';
    $html .= '<input type="hidden" id="profilePicture" value="' . htmlspecialchars($_SESSION["userPic"]) . '">';
    $html .= '<input type="hidden" id="username" value="' . htmlspecialchars($_SESSION["userName"]) . '">';
    $html .= '<input type="submit" value="post">';
    $html .= '</form>';
    $html .= '<div id="comments"></div>';
    $html .= '</div>';
    $html .= '<a class="btn btn-warning comment-toggle" data-bs-toggle="collapse" href="#multiCollapseExample' . substr($post["postID"], 1) . '" role="button" aria-expanded="false" aria-controls="multiCollapseExample' . substr($post["postID"], 1) . '">comment</a>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    
    echo json_encode(['success' => true, 'html' => $html]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to create post: ' . $stmt->error]);
}

$stmt->close();
?> 