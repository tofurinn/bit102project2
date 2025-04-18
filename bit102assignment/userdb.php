<?php
$conn = new mysqli('localhost', 'root', 'mysql', 'SRECCER');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>