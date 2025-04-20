<?php
session_start(); // Start the session
require 'userdb.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID = $_SESSION['userID'] ?? null;

    if (!$userID) {
        echo "No user logged in.";
        exit;
    }

    $userFullName = $_POST['userFullName'] ?? '';
    $userBio = $_POST['userBio'] ?? '';
    $ticketColor = $_POST['bgcolor'] ?? '#000000';

    // Handle file upload
    $userPic = $_SESSION['userPic'] ?? "images/default-profile.png";
    if (!empty($_FILES['userPic']['name'])) {
        $targetDir = "images/";
        $targetFile = $targetDir . basename($_FILES["userPic"]["name"]);

        if (move_uploaded_file($_FILES["userPic"]["tmp_name"], $targetFile)) {
            $userPic = $targetFile;
        }
    }

    // Update database
    $stmt = $conn->prepare("UPDATE user SET userFullName=?, userBio=?, userPic=?, ticketLeftColor=? WHERE userID=?");
    $stmt->bind_param("sssss", $userFullName, $userBio, $userPic, $ticketColor, $userID);

    if ($stmt->execute()) {
        $_SESSION['userFullName'] = $userFullName;
        $_SESSION['userBio'] = $userBio;
        $_SESSION['userPic'] = $userPic;
        $_SESSION['ticketLeftColor'] = $ticketColor;

        header("Location: profile.php"); // Go back to profile
        exit();
    } else {
        echo "Update failed: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
?>