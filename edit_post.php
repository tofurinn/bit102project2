<?php
session_start();
require_once 'userdb.php';

// Ensure no output before headers
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['userID'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

// Check if all required data is present
if (!isset($_POST['postId']) || !isset($_POST['title']) || !isset($_POST['content'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required data']);
    exit;
}

$postId = $_POST['postId'];
$title = trim($_POST['title']);
$content = trim($_POST['content']);
$userId = $_SESSION['userID'];

// Verify that the user owns this post
$check_sql = "SELECT USER_userID FROM post WHERE postID = ?";
$check_stmt = $conn->prepare($check_sql);

if (!$check_stmt) {
    echo json_encode(['success' => false, 'message' => 'Database error']);
    exit;
}

$check_stmt->bind_param("s", $postId);
$check_stmt->execute();
$result = $check_stmt->get_result();
$post = $result->fetch_assoc();

if (!$post) {
    echo json_encode(['success' => false, 'message' => 'Post not found']);
    exit;
}

if ($post['USER_userID'] !== $userId) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Update the post
$update_sql = "UPDATE post SET postTitle = ?, postContent = ? WHERE postID = ? AND USER_userID = ?";
$update_stmt = $conn->prepare($update_sql);

if (!$update_stmt) {
    echo json_encode(['success' => false, 'message' => 'Database error']);
    exit;
}

$update_stmt->bind_param("ssss", $title, $content, $postId, $userId);

if ($update_stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Post updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update post']);
}

// Clean up statements
$update_stmt->close();
$check_stmt->close();

// Don't manually close the connection - it will be handled by the shutdown function
exit;
?> 