<?php
require_once 'db_config.php';

$artistID = $_GET['artist'] ?? '';

if (!$artistID) {
    echo '<p>No artist specified.</p>';
    exit;
}

$sql = "SELECT * FROM songs WHERE artistID = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$artistID]);
$songs = $stmt->fetchAll();

if (count($songs) === 0) {
    echo '<p>No fan-uploaded songs yet. Be the first to share!</p>';
    exit;
}

foreach ($songs as $row) {
    echo '
    <div class="song-card text-end" data-song-id="' . $row['songID'] . '">
        <img src="' . htmlspecialchars($row['songImage']) . '" alt="' . htmlspecialchars($row['songName']) . '" class="img-fluid">
        <div class="song-info">
            <p>
                <strong>' . htmlspecialchars($row['songName']) . '</strong>
                <button class="btn btn-outline-danger like-btn">❤ Like <span>0</span></button>
            </p>
            <audio controls>
                <source src="' . htmlspecialchars($row['songMP3']) . '" type="audio/mp3">
                Your browser does not support the audio element.
            </audio>
            <div class="mt-2">
                <button class="btn btn-sm btn-warning" onclick="updateSong(' . $row['songID'] . ')">Update</button>
                <button class="btn btn-sm btn-danger" onclick="deleteSong(' . $row['songID'] . ')">Delete</button>
            </div>
        </div>
    </div>';
}
?>
