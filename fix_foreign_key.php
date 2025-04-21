<?php
require 'userdb.php';

// Drop the foreign key constraint
$sql = "ALTER TABLE comment DROP FOREIGN KEY comment_ibfk_2";
$result = $conn->query($sql);

if ($result) {
    echo "Foreign key constraint dropped successfully<br>";
} else {
    echo "Error dropping foreign key: " . $conn->error . "<br>";
}

// Recreate the foreign key constraint
$sql = "ALTER TABLE comment ADD CONSTRAINT comment_ibfk_2 FOREIGN KEY (USER_userID) REFERENCES user(userID)";
$result = $conn->query($sql);

if ($result) {
    echo "Foreign key constraint recreated successfully<br>";
} else {
    echo "Error recreating foreign key: " . $conn->error . "<br>";
}

$conn->close();
?> 