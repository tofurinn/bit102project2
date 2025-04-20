<?php
session_start();
require 'userdb.php';

header('Content-Type: application/json');

if (!isset($_SESSION['userID'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $comment_id = $_POST['comment_id'];
    $user_id = $_SESSION['userID'];

    // Verify the comment belongs to the current user
    $check_sql = "SELECT USER_userID FROM comment WHERE commentID = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $comment_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    $comment = $result->fetch_assoc();

    if ($comment['USER_userID'] !== $user_id) {
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }

    if ($action === 'delete') {
        // Delete the comment
        $sql = "DELETE FROM comment WHERE commentID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $comment_id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Comment deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting comment']);
        }
    } elseif ($action === 'edit' && isset($_POST['content'])) {
        // Update the comment
        $content = trim($_POST['content']);
        if (empty($content)) {
            echo json_encode(['success' => false, 'message' => 'Comment cannot be empty']);
            exit;
        }
        
        $sql = "UPDATE comment SET commContent = ? WHERE commentID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $content, $comment_id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Comment updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error updating comment']);
        }
    }
}
?> 