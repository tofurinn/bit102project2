<?php
$host = "localhost";
$user = "root";
$pass = "mysql";
$dbname = "final_sql";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get artist ID from the query string
$artistID = isset($_GET['artistID']) ? intval($_GET['artistID']) : 0;

if ($artistID) {
    // Query the database to get the artist's image
    $stmt = $conn->prepare("SELECT artistPic FROM ARTIST WHERE artistID = ?");
    $stmt->bind_param("i", $artistID);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($imageData);

    if ($stmt->fetch()) {
        // Set headers to inform the browser this is an image
        header("Content-Type: image/jpeg");
        echo $imageData;  // Output the binary image data
    } else {
        // If no image found, serve a placeholder
        header("Content-Type: image/jpeg");
        echo file_get_contents('images/placeholder.jpg');
    }

    $stmt->close();
}

$conn->close();
?>
