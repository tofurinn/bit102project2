<?php
require_once 'userdb.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $songID = $_POST['songID'] ?? '';

    if ($songID) {
        try {
            // First get the file paths to delete the files
            $stmt = $conn->prepare("SELECT songMP3, songImage FROM songs WHERE songID = ?");
            $stmt->bind_param("s", $songID);
            $stmt->execute();
            $result = $stmt->get_result();
            $song = $result->fetch_assoc();

            // Delete the files if they exist
            if ($song) {
                if (!empty($song['songMP3']) && file_exists($song['songMP3'])) {
                    @unlink($song['songMP3']);
                }
                if (!empty($song['songImage']) && file_exists($song['songImage'])) {
                    @unlink($song['songImage']);
                }
            }

            // Now delete from database
            $stmt = $conn->prepare("DELETE FROM songs WHERE songID = ?");
            $stmt->bind_param("s", $songID);
            $stmt->execute();

            // Check if the deletion was successful
            if ($stmt->affected_rows > 0) {
                echo json_encode(['success' => true, 'message' => 'Song deleted successfully']);
            } else {
                // If no rows were affected but no error occurred, the song might not exist
                echo json_encode(['success' => true, 'message' => 'Song not found or already deleted']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing song ID']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
