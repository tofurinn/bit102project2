function deleteSong(songId) {
    if (confirm('Are you sure you want to delete this song?')) {
        const formData = new FormData();
        formData.append('songID', songId);

        fetch('delete_song.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Find and remove the song card
                const songCard = document.querySelector(`.song-card[data-song-id="${songId}"]`);
                if (songCard) {
                    songCard.remove();
                    // Check if there are no more songs
                    const songSection = document.getElementById('songSection');
                    if (songSection && songSection.children.length === 0) {
                        songSection.innerHTML = '<p>No fan-uploaded songs yet. Be the first to share!</p>';
                    }
                }
                showMessage('success', data.message);
            } else {
                showMessage('danger', data.message || 'Failed to delete song');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('danger', 'An error occurred while deleting the song');
        });
    }
}

function showMessage(type, message) {
    // Remove any existing messages
    const existingMessages = document.querySelectorAll('.alert');
    existingMessages.forEach(msg => msg.remove());

    // Create new message
    const messageDiv = document.createElement('div');
    messageDiv.className = `alert alert-${type} alert-dismissible fade show`;
    messageDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    // Insert message at the top of the song section
    const container = document.querySelector('.container');
    const songSection = document.querySelector('.song-section');
    if (container && songSection) {
        container.insertBefore(messageDiv, songSection);
        // Auto-remove after 3 seconds
        setTimeout(() => {
            messageDiv.remove();
        }, 3000);
    }
}

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