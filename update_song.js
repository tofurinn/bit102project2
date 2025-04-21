function updateSong(songId) {
    // Fetch current song data
    fetch(`get_song.php?songID=${songId}`)
        .then(response => response.json())
        .then(song => {
            // Create modal for update form
            const modal = document.createElement('div');
            modal.className = 'modal fade';
            modal.id = 'updateModal';
            modal.innerHTML = `
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Update Song</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="updateForm" enctype="multipart/form-data">
                                <input type="hidden" name="songID" value="${songId}">
                                <div class="mb-3">
                                    <label for="songName" class="form-label">Song Name</label>
                                    <input type="text" class="form-control" id="songName" name="songName" value="${song.songName}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="songImage" class="form-label">Song Image</label>
                                    <input type="file" class="form-control" id="songImage" name="songImage" accept="image/*">
                                    <small class="text-muted">Current image: ${song.songImage}</small>
                                </div>
                                <div class="mb-3">
                                    <label for="songMP3" class="form-label">Song File (MP3)</label>
                                    <input type="file" class="form-control" id="songMP3" name="songMP3" accept="audio/mp3">
                                    <small class="text-muted">Current file: ${song.songMP3}</small>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="submitUpdate()">Update</button>
                        </div>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);

            // Show modal
            const updateModal = new bootstrap.Modal(document.getElementById('updateModal'));
            updateModal.show();

            // Remove modal when closed
            document.getElementById('updateModal').addEventListener('hidden.bs.modal', function () {
                this.remove();
            });
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to load song data');
        });
}

function submitUpdate() {
    const form = document.getElementById('updateForm');
    const formData = new FormData(form);

    fetch('update_song.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Song updated successfully!');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the song.');
    });
} 