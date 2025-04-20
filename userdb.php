<?php
// Database connection configuration
$host = 'localhost';
$username = 'root';
$password = 'mysql';
$database = 'sreccer';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set character set to utf8mb4
if (!$conn->set_charset("utf8mb4")) {
    die("Error loading character set utf8mb4: " . $conn->error);
}

// Function to safely close database connection
if (!function_exists('closeConnection')) {
    function closeConnection() {
        global $conn;
        if (isset($conn) && is_object($conn)) {
            try {
                $conn->close();
            } catch (Exception $e) {
                // Connection already closed or other error
            }
        }
    }
}

// Register shutdown function to ensure connection is closed
register_shutdown_function('closeConnection');
?>