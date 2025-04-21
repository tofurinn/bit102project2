<?php
$host = "localhost";
$user = "root";
$pass = "mysql";
$dbname = "sreccer";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['action']) && $_GET['action'] == 'fetch_genres') {
    $sql = "SELECT catID, catName FROM CATEGORY";
    $result = $conn->query($sql);

    $genres = [];
    while ($row = $result->fetch_assoc()) {
        $genres[] = $row;
    }

    // Send the genres back as JSON
    echo json_encode($genres);
    exit();
}

// Check if the request is a POST for deleting a genre
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete_genre') {
    $catID = isset($_POST['catID']) ? intval($_POST['catID']) : 0;

    if ($catID) {
        // 1. Delete the genre itself from the CATEGORY table
        $stmt = $conn->prepare("DELETE FROM CATEGORY WHERE catID = ?");
        $stmt->bind_param("i", $catID);
        $stmt->execute();
        $stmt->close();

        // Return a success message
        echo json_encode(['status' => 'success', 'message' => 'Genre deleted successfully']);
    } else {
        // Return an error if no valid catID is provided
        echo json_encode(['error' => 'Invalid genre ID']);
    }
    exit();
}


$sql = "SELECT * FROM CATEGORY";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($category = $result->fetch_assoc()) {
        $catID = $category['catID'];
        $catName = htmlspecialchars($category['catName']);
        $catDesc = htmlspecialchars($category['catDesc']);

        // Get related artists
        $stmt = $conn->prepare("
            SELECT a.artistID, a.artistName, a.artistLink
            FROM ARTIST a
            JOIN ARTIST_CATEGORY ac ON a.artistID = ac.artistID
            WHERE ac.catID = ?
        ");
        $stmt->bind_param("i", $catID);
        $stmt->execute();
        $artist_result = $stmt->get_result();

        $artistNames = [];
        $artistLinks = [];
        $artistImages = [];
        $cover_image_url = null;
        
        while ($artist = $artist_result->fetch_assoc()) {
            $name = htmlspecialchars($artist['artistName']);
            $link = htmlspecialchars($artist['artistLink']);
            $artistID = $artist['artistID']; // Get the artist ID

            // Create the URL for fetching the image from the get_artist_image.php script
            $imgSrc = "get_artist_image.php?artistID=" . $artistID;

            if (!$cover_image_url) {
                $cover_image_url = $imgSrc; // Set the first artist's image as the cover
            }

            $artistNames[] = $name;
            $artistLinks[] = $link;
            $artistImages[] = $imgSrc;
        }

        $stmt->close();

        if (!$cover_image_url) {
            $cover_image_url = "images/placeholder.jpg"; // Fallback to a placeholder
        }

        // Convert arrays to comma-separated strings with escaping
        $artistNamesStr = htmlspecialchars(implode(',', $artistNames), ENT_QUOTES);
        $artistLinksStr = htmlspecialchars(implode(',', $artistLinks), ENT_QUOTES);
        $artistImagesStr = htmlspecialchars(implode(',', $artistImages), ENT_QUOTES);
?>
        <!-- Genre Card -->
        <div class="col-md-4 mt-4 d-flex justify-content-center">
            <div class="card" style="width: 18rem;">
                <!-- Use the PHP script URL for the image -->
                <img src="<?= $cover_image_url ?>" class="card-img-top" alt="<?= $catName ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $catName ?></h5>
                    <p class="card-text"><?= $catDesc ?></p>
                    <button class="btn btn-primary show-more-btn"
                        data-genre="<?= $catName ?>"
                        data-artists="<?= $artistNamesStr ?>"
                        data-links="<?= $artistLinksStr ?>"
                        data-images="<?= $artistImagesStr ?>">
                        Show More
                    </button>
                </div>
            </div>
        </div>
    <script>
    $('#deleteGenreBtn').on('click', function() {
    var catID = $('#deleteGenre').val(); // Get the selected genre ID

    if (!catID) {
        alert('Please select a genre to delete.');
        return;
    }

    // Make the AJAX request to delete the genre
    $.ajax({
        url: 'genre_display.php', // The current PHP file will handle the request
        type: 'POST',
        data: {
            action: 'delete_genre',
            catID: catID
        },
        success: function(response) {
            var res = JSON.parse(response);
            if (res.status == 'success') {
                // Show a success message
                alert(res.message);
                $('#deleteGenreModal').modal('hide'); // Close the modal
                location.reload(); // Refresh the page to reflect the deletion
            } else {
                alert(res.message); // Show error message
            }
        }
    });
});
</script>    
<?php
    }
}
$conn->close();
?>