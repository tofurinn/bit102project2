<?php
session_start();
require 'userdb.php'; // Include your database connection

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: PreMenu.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $userID = $_SESSION['userID'];

    // Prepare the DELETE query
    $stmt = $conn->prepare("DELETE FROM user WHERE userID = ?");
    $stmt->bind_param("s", $userID);

    if ($stmt->execute()) {
        // Destroy session and redirect
        session_unset();
        session_destroy();
        header("Location: PreMenu.html");
        exit();
    } else {
        echo "Error deleting account: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>