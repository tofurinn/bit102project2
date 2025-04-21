<?php
$host = "localhost";
$user = "root";
$pass = "mysql";
$dbname = "sreccer";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$genreName = $_POST['genreName'];
$genreDesc = $_POST['genreDesc'];
$artistIDs = $_POST['artistIDs']; // array from form

$coverImage = null;
$validArtists = [];

// Check valid artists and get the first artist's image
foreach ($artistIDs as $artistID) {
    if (!empty($artistID)) {
        $artistID = trim($artistID);

        $stmt = $conn->prepare("SELECT artistID, artistPic FROM ARTIST WHERE artistID = ?");
        $stmt->bind_param("s", $artistID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $validArtists[] = $row['artistID'];

            if (!$coverImage && !empty($row['artistPic'])) {
                $coverImage = $row['artistPic']; // Binary image
            }
        }

        $stmt->close();
    }
}

if (empty($validArtists)) {
    echo json_encode(['error' => 'No matching artists found in the database.']);
    exit();
}

// Insert into CATEGORY (auto-increment ID assumed)
$stmt = $conn->prepare("INSERT INTO CATEGORY (catName, catDesc) VALUES (?, ?)");
$stmt->bind_param("ss", $genreName, $genreDesc);
$stmt->execute();
$categoryId = $stmt->insert_id;
$stmt->close();

// Insert into ARTIST_CATEGORY table
foreach ($validArtists as $artistId) {
    $insert = $conn->prepare("INSERT INTO ARTIST_CATEGORY (artistID, catID) VALUES (?, ?)");
    $insert->bind_param("si", $artistId, $categoryId);
    $insert->execute();
    $insert->close();
}

header("Location: Categories.html");
exit();

$conn->close();
?>
