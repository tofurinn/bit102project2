<?php
require 'userdb.php';

// Drop existing comment table first (because it references post)
$sql = "DROP TABLE IF EXISTS comment";
if ($conn->query($sql) === TRUE) {
    echo "Existing comment table dropped successfully\n";
} else {
    echo "Error dropping comment table: " . $conn->error . "\n";
}

// Drop existing post table
$sql = "DROP TABLE IF EXISTS post";
if ($conn->query($sql) === TRUE) {
    echo "Existing post table dropped successfully\n";
} else {
    echo "Error dropping post table: " . $conn->error . "\n";
}

// Create post table with correct structure
$sql = "CREATE TABLE IF NOT EXISTS post (
    postID VARCHAR(50) PRIMARY KEY,
    postTitle VARCHAR(255) NOT NULL,
    postContent TEXT NOT NULL,
    USER_userID VARCHAR(13) NOT NULL,
    postDateTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (USER_userID) REFERENCES user(userID)
)";

if ($conn->query($sql) === TRUE) {
    echo "Post table created successfully\n";
} else {
    echo "Error creating post table: " . $conn->error . "\n";
}

// Insert sample posts
$sql = "INSERT INTO post (postID, postTitle, postContent, USER_userID) VALUES
('P001', 'Artists Similar to Joji!', 'Hey guys!! here are some artists similar to Joji to you Joji fans!\n1. Keshi\n2. Beanie\n3. Frank Ocean', 'U001'),
('P002', 'Anyone Selling Wave to Earth Vinyls?', 'IM BEGGING... please anybody... let me buy your wave to earth vinyl... im desperate', '6802609295ab0'),
('P003', 'LISA ALTEREGO ALBUM RATING', 'Absolutely loved her new album! A few skips... but overall still great!\n1. Born Again: 10/10\n2. ROCKSTAR: 7/10\n3. Elastigirl: 6/10\n4. Moonlit Floor: 8/10\n5. Lifestyle: 10/10!!', '6802299ecab85'),
('P004', 'Is Frank Ocean ever COMING BACK?!', 'what happened to frank ocean guys.. where is he??', '6802299ecab85')";

if ($conn->query($sql) === TRUE) {
    echo "Sample posts inserted successfully\n";
} else {
    echo "Error inserting sample posts: " . $conn->error . "\n";
}

// Now recreate the comment table
$sql = "CREATE TABLE IF NOT EXISTS comment (
    commentID INT AUTO_INCREMENT PRIMARY KEY,
    commContent TEXT NOT NULL,
    USER_userID VARCHAR(13) NOT NULL,
    POST_postID VARCHAR(50) NOT NULL,
    commDateTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (USER_userID) REFERENCES user(userID),
    FOREIGN KEY (POST_postID) REFERENCES post(postID)
)";

if ($conn->query($sql) === TRUE) {
    echo "Comment table created successfully\n";
} else {
    echo "Error creating comment table: " . $conn->error . "\n";
}

$conn->close();
?> 