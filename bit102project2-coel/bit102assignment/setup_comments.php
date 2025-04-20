<?php
require 'userdb.php';

// Create comments table
$sql = "CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id VARCHAR(50) NOT NULL,
    username VARCHAR(100) NOT NULL,
    profile_pic VARCHAR(255) NOT NULL,
    comment_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Comments table created successfully!";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?> 