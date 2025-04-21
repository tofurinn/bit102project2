<?php
require_once 'userdb.php';

if (isset($_GET['songID']) && !empty($_GET['songID'])) {
    $songID = $_GET['songID'];
    
    $sql = "SELECT * FROM songs WHERE songID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $songID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($song = $result->fetch_assoc()) {
        echo json_encode($song);
    } else {
        echo json_encode(['error' => 'Song not found']);
    }
} else {
    echo json_encode(['error' => 'No song ID provided']);
}
?> 