<?php
require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $songID = $_POST['songID'] ?? '';

    if ($songID) {
        // Prepare and execute delete query
        $stmt = $conn->prepare("DELETE FROM songs WHERE songID = ?");
        $stmt->execute([$songID]);

        // Check if the row was deleted
        if ($stmt->rowCount() > 0) {
            echo 'Deleted';
        } else {
            echo 'Error';
        }
    } else {
        echo 'Missing songID';
    }
}
?>
