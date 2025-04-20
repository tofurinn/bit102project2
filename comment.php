<?php
session_start();
require_once 'userdb.php';

// Check if user is logged in
if (!isset($_SESSION['userID'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

// Check if required data is present
if (!isset($_POST['comment']) || !isset($_POST['post_id'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required data']);
    exit;
}

$comment = trim($_POST['comment']);
$post_id = $_POST['post_id'];
$user_id = $_SESSION['userID'];

// Validate comment content
if (empty($comment)) {
    echo json_encode(['success' => false, 'message' => 'Comment cannot be empty']);
    exit;
}

// Insert the comment
$sql = "INSERT INTO comment (commContent, USER_userID, POST_postID) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Database error']);
    exit;
}

$stmt->bind_param("sss", $comment, $user_id, $post_id);

if ($stmt->execute()) {
    // Get the new comment with user details
    $new_comment_sql = "SELECT c.*, u.userName, u.userPic 
                       FROM comment c 
                       JOIN user u ON c.USER_userID = u.userID 
                       WHERE c.commentID = LAST_INSERT_ID()";
    $result = $conn->query($new_comment_sql);
    $comment_data = $result->fetch_assoc();
    
    // Generate HTML for the new comment
    $html = '<div class="comment" data-comment-id="' . $comment_data['commentID'] . '">';
    $html .= '  <div class="comment-row">';
    $html .= '    <img src="' . (empty($comment_data["userPic"]) ? 'images/default-profile.png' : htmlspecialchars($comment_data["userPic"])) . '" alt="Profile Picture" onerror="this.src=\'images/default-profile.png\'">';
    $html .= '    <div class="comment-content">';
    $html .= '      <div class="comment-header">';
    $html .= '        <h4>@' . htmlspecialchars($comment_data["userName"]) . '</h4>';
    
    if ($comment_data["USER_userID"] === $_SESSION['userID']) {
        $html .= '        <div class="actions">';
        $html .= '          <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>';
        $html .= '          <ul class="dropdown-menu">';
        $html .= '            <li><a class="dropdown-item edit-comment" href="#">Edit</a></li>';
        $html .= '            <li><a class="dropdown-item delete-comment" href="#">Delete</a></li>';
        $html .= '          </ul>';
        $html .= '        </div>';
    }
    
    $html .= '      </div>';
    $html .= '      <p class="comment-text">' . htmlspecialchars($comment_data["commContent"]) . '</p>';
    $html .= '    </div>';
    $html .= '  </div>';
    $html .= '</div>';
    
    echo $html;
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to post comment']);
}

$stmt->close();
?>
