<?php
require_once 'userdb.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $song_name = $_POST['songName'];
    $artist_id = $_POST['artist_id'];

    $img_name = $_FILES['songImage']['name'];
    $img_tmp = $_FILES['songImage']['tmp_name'];
    $img_path = "uploads/images/" . basename($img_name);

    $mp3_name = $_FILES['songMP3']['name'];
    $mp3_tmp = $_FILES['songMP3']['tmp_name'];
    $mp3_path = "uploads/musics/" . basename($mp3_name);

    if (!is_dir("uploads/images")) {
        mkdir("uploads/images", 0777, true);
    }
    if (!is_dir("uploads/musics")) {
        mkdir("uploads/musics", 0777, true);
    }

    if (move_uploaded_file($img_tmp, $img_path) && move_uploaded_file($mp3_tmp, $mp3_path)) {
        $sql = "INSERT INTO songs (songName, songImage, songMP3, artistID) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$song_name, $img_path, $mp3_path, $artist_id]);

        header("Location: artist" . $artist_id . ".html");
        exit();
    } else {
        echo "File upload failed.";
    }
}
?>
