<?php
require_once 'db_config.php';

if (
    isset($_POST['songID'], $_POST['songName']) &&
    !empty($_POST['songID']) &&
    !empty($_POST['songName'])
) {
    $songID = $_POST['songID'];
    $songName = trim($_POST['songName']);
    $songMP3 = null;
    $songImage = null;

    // Validate and process MP3 file upload
    if (isset($_FILES['songMP3']) && $_FILES['songMP3']['error'] == 0) {
        $mp3TmpName = $_FILES['songMP3']['tmp_name'];
        $mp3Name = $_FILES['songMP3']['name'];
        $mp3Ext = strtolower(pathinfo($mp3Name, PATHINFO_EXTENSION));

        if ($mp3Ext === 'mp3') {
            $songMP3 = 'uploads/mp3/' . uniqid('song_', true) . '.' . $mp3Ext;
            move_uploaded_file($mp3TmpName, $songMP3);
        }
    }

    // Validate and process image file upload
    if (isset($_FILES['songImage']) && $_FILES['songImage']['error'] == 0) {
        $imageTmpName = $_FILES['songImage']['tmp_name'];
        $imageName = $_FILES['songImage']['name'];
        $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

        if (in_array($imageExt, ['jpg', 'jpeg', 'png', 'gif'])) {
            $songImage = 'uploads/images/' . uniqid('image_', true) . '.' . $imageExt;
            move_uploaded_file($imageTmpName, $songImage);
        }
    }

    try {
        // Check if the song exists
        $checkStmt = $conn->prepare("SELECT * FROM songs WHERE songID = ?");
        $checkStmt->execute([$songID]);

        if ($checkStmt->rowCount() === 0) {
            echo 'Song not found';
            exit;
        }

        // Update song in the database
        $updateSQL = "UPDATE songs SET songName = ?";
        $params = [$songName];

        if ($songMP3) {
            $updateSQL .= ", songMP3 = ?";
            $params[] = $songMP3;
        }
        if ($songImage) {
            $updateSQL .= ", songImage = ?";
            $params[] = $songImage;
        }

        $updateSQL .= " WHERE songID = ?";
        $params[] = $songID;

        $updateStmt = $conn->prepare($updateSQL);
        $updated = $updateStmt->execute($params);

        echo $updated ? 'success' : 'error';

    } catch (PDOException $e) {
        echo 'error';
    }
} else {
    echo 'invalid';
}
?>
