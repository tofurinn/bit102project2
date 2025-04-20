<?php
require 'userdb.php';

// Create post table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS post (
    postID VARCHAR(50) PRIMARY KEY,
    postTitle VARCHAR(255) NOT NULL,
    postContent TEXT NOT NULL,
    USER_userID VARCHAR(13) NOT NULL,
    postDateTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (USER_userID) REFERENCES user(userID)
)";

if ($conn->query($sql) === TRUE) {
    echo "Post table created successfully or already exists<br>";
} else {
    echo "Error creating post table: " . $conn->error . "<br>";
}

$conn->close();
?> 