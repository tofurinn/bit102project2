<?php
session_start();
require_once 'userdb.php';

header('Content-Type: application/json');

// Debug information
error_log("Delete post request received");
error_log("Session userID: " . (isset($_SESSION['userID']) ? $_SESSION['userID'] : 'not set'));
error_log("POST data: " . print_r($_POST, true));

// Check if user is logged in
if (!isset($_SESSION['userID'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

// Check if post ID is provided
if (!isset($_POST['post_id'])) {
    echo json_encode(['success' => false, 'message' => 'Post ID not provided']);
    exit;
}

$post_id = $_POST['post_id'];
$user_id = $_SESSION['userID'];

error_log("Attempting to delete post_id: " . $post_id . " for user_id: " . $user_id);

// Verify that the user owns this post
$check_sql = "SELECT USER_userID FROM post WHERE postID = ?";
$check_stmt = $conn->prepare($check_sql);
if (!$check_stmt) {
    echo json_encode(['success' => false, 'message' => 'Prepare statement failed: ' . $conn->error]);
    exit;
}

$check_stmt->bind_param("s", $post_id);
if (!$check_stmt->execute()) {
    echo json_encode(['success' => false, 'message' => 'Execute failed: ' . $check_stmt->error]);
    exit;
}

$result = $check_stmt->get_result();
$post = $result->fetch_assoc();

error_log("Post data found: " . print_r($post, true));

if (!$post) {
    echo json_encode(['success' => false, 'message' => 'Post not found']);
    exit;
}

if ($post['USER_userID'] !== $user_id) {
    error_log("User ID mismatch - Post user: " . $post['USER_userID'] . ", Session user: " . $user_id);
    echo json_encode(['success' => false, 'message' => 'Unauthorized - Not your post']);
    exit;
}

// Start transaction
$conn->begin_transaction();

try {
    // Delete comments first
    $delete_comments_sql = "DELETE FROM comment WHERE POST_postID = ?";
    $delete_comments_stmt = $conn->prepare($delete_comments_sql);
    if (!$delete_comments_stmt) {
        throw new Exception('Failed to prepare delete comments statement: ' . $conn->error);
    }
    
    $delete_comments_stmt->bind_param("s", $post_id);
    if (!$delete_comments_stmt->execute()) {
        throw new Exception('Failed to delete comments: ' . $delete_comments_stmt->error);
    }

    error_log("Comments deleted successfully");

    // Delete the post
    $delete_post_sql = "DELETE FROM post WHERE postID = ? AND USER_userID = ?";
    $delete_post_stmt = $conn->prepare($delete_post_sql);
    if (!$delete_post_stmt) {
        throw new Exception('Failed to prepare delete post statement: ' . $conn->error);
    }
    
    $delete_post_stmt->bind_param("ss", $post_id, $user_id);
    if (!$delete_post_stmt->execute()) {
        throw new Exception('Failed to delete post: ' . $delete_post_stmt->error);
    }

    // Check if any rows were affected
    if ($delete_post_stmt->affected_rows === 0) {
        throw new Exception('No post was deleted - Affected rows: ' . $delete_post_stmt->affected_rows);
    }

    error_log("Post deleted successfully");

    // Commit transaction
    $conn->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    // Rollback on error
    $conn->rollback();
    error_log("Delete post error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?> 