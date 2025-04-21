<?php
require_once 'userdb.php';

if (
    isset($_POST['songID'], $_POST['songName']) &&
    !empty($_POST['songID']) &&
    !empty($_POST['songName'])
) {
    $songID = $_POST['songID'];
    $songName = trim($_POST['songName']);
    $songMP3 = null;
    $songImage = null;
    $updateFields = ['songName' => $songName];
    $types = "s";
    $params = [$songName];

    // Create upload directories if they don't exist
    if (!is_dir("uploads/images")) {
        mkdir("uploads/images", 0777, true);
    }
    if (!is_dir("uploads/musics")) {
        mkdir("uploads/musics", 0777, true);
    }

    // Validate and process MP3 file upload
    if (isset($_FILES['songMP3']) && $_FILES['songMP3']['error'] == 0) {
        $mp3TmpName = $_FILES['songMP3']['tmp_name'];
        $mp3Name = $_FILES['songMP3']['name'];
        $mp3Ext = strtolower(pathinfo($mp3Name, PATHINFO_EXTENSION));

        if ($mp3Ext === 'mp3') {
            $songMP3 = 'uploads/musics/' . uniqid('song_', true) . '.' . $mp3Ext;
            if (!move_uploaded_file($mp3TmpName, $songMP3)) {
                echo json_encode(['success' => false, 'message' => 'Failed to upload MP3 file']);
                exit;
            }
            $updateFields['songMP3'] = $songMP3;
            $types .= "s";
            $params[] = $songMP3;
        }
    }

    // Validate and process image file upload
    if (isset($_FILES['songImage']) && $_FILES['songImage']['error'] == 0) {
        $imageTmpName = $_FILES['songImage']['tmp_name'];
        $imageName = $_FILES['songImage']['name'];
        $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
        $allowedImageTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageExt, $allowedImageTypes)) {
            $songImage = 'uploads/images/' . uniqid('image_', true) . '.' . $imageExt;
            if (!move_uploaded_file($imageTmpName, $songImage)) {
                echo json_encode(['success' => false, 'message' => 'Failed to upload image file']);
                exit;
            }
            $updateFields['songImage'] = $songImage;
            $types .= "s";
            $params[] = $songImage;
        }
    }

    // Build the SQL query
    $sql = "UPDATE songs SET ";
    $setParts = [];
    foreach ($updateFields as $field => $value) {
        $setParts[] = "$field = ?";
    }
    $sql .= implode(", ", $setParts);
    $sql .= " WHERE songID = ?";
    $types .= "i";
    $params[] = $songID;

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Song updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update song: ' . $stmt->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
}
?>
