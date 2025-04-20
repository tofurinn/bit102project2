<?php
require_once 'db_config.php';

$songID = $_GET['songID'] ?? '';

if (!empty($songID) && isset($_POST['songName']) && !empty(trim($_POST['songName']))) {
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
            if (!file_exists('uploads/mp3/')) {
                mkdir('uploads/mp3/', 0777, true);
            }
            move_uploaded_file($mp3TmpName, $songMP3);
        } else {
            echo 'Invalid MP3 file format';
            exit;
        }
    }

    // Validate and process image file upload
    if (isset($_FILES['songImage']) && $_FILES['songImage']['error'] == 0) {
        $imageTmpName = $_FILES['songImage']['tmp_name'];
        $imageName = $_FILES['songImage']['name'];
        $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

        if (in_array($imageExt, ['jpg', 'jpeg', 'png', 'gif'])) {
            $songImage = 'uploads/images/' . uniqid('image_', true) . '.' . $imageExt;
            if (!file_exists('uploads/images/')) {
                mkdir('uploads/images/', 0777, true);
            }
            move_uploaded_file($imageTmpName, $songImage);
        } else {
            echo 'Invalid image file format';
            exit;
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

        // Build the update query
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

        if ($updated) {
            echo 'success';
        } else {
            echo 'error: failed to update';
        }

    } catch (PDOException $e) {
        error_log($e->getMessage());
        echo 'An error occurred. Please try again later.';
    }

} else {
    echo 'invalid';
}
?>
