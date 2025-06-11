function previewVideo(event, previewId) {
    const file = event.target.files[0];
    const maxSize = 5 * 1024 * 1024; // 5MB

    if (file) {
        if (file.size > maxSize) {
            Swal.fire('Error', 'Video must be less than 5MB!', 'error');
            event.target.value = '';
            document.getElementById(previewId).style.display = 'none';
            return;
        }
        const videoPreview = document.getElementById(previewId);
        const videoSource = videoPreview.querySelector('source');
        videoSource.src = URL.createObjectURL(file);
        videoPreview.load();
        videoPreview.style.display = 'block';
    } else {
        // Hide preview if no file selected
        const videoPreview = document.getElementById(previewId);
        const videoSource = videoPreview.querySelector('source');
        videoSource.src = '';
        videoPreview.load();
        videoPreview.style.display = 'none';
    }
}



function addShorts() {
    var formData = new FormData(document.getElementById('addShortsForm'));

    var loadingSpinner = document.getElementById('loading-spinner-shorts');
    var progressBarContainer = document.getElementById('upload-progress-shorts');
    var progressBar = document.getElementById('upload-progress-bar-shorts');

    var r = new XMLHttpRequest();

    r.upload.onprogress = function (event) {
        if (event.lengthComputable) {
            var percent = Math.round((event.loaded / event.total) * 100);
            progressBar.style.width = percent + "%";
            progressBar.innerText = percent + "%";
            progressBarContainer.classList.remove('d-none');
        }
    };

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            loadingSpinner.classList.add('d-none');
            progressBarContainer.classList.add('d-none');
            progressBar.style.width = "0%";
            progressBar.innerText = "0%";
            var t = r.responseText;
            console.log("Response:", t); // Debug log
            try {
                var json = JSON.parse(t);
                if (json.success) {
                    console.log("Success"); // Debug log
                    document.getElementById('addShortsForm').reset();
                    var modal = bootstrap.Modal.getInstance(document.getElementById('addShortsModal'));
                    modal.hide();
                    Swal.fire({
                        title: 'Success!',
                        text: json.message,
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                } else {
                    console.log("Error:", json.message); // Debug log
                    Swal.fire({
                        title: 'Error!',
                        text: json.message,
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                }
            } catch (e) {
                console.log("Parse Error:", e); // Debug log for JSON parse issues
            }
        }
    };

    loadingSpinner.classList.remove('d-none');
    progressBarContainer.classList.remove('d-none');
    progressBar.style.width = "0%";
    progressBar.innerText = "0%";
    r.open("POST", "../process/addShortsProcess.php", true);
    r.send(formData);
}

function deleteShorts(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Are you sure you want to delete this Shorts?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '../process/deleteShortsProcess.php',
                method: 'POST',
                data: { id: id },
                success: function (response) {
                    if (response.includes("Shorts deleted successfully")) {
                        Swal.fire('Deleted!', 'Shorts has been deleted.', 'success').then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire('Error!', response, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error!', 'Failed to delete Shorts.', 'error');
                }
            });
        }
    });
}

function updateShorts(id) {
    Swal.fire({
        title: 'Update Shorts',
        text: "Do you want to update this Shorts item?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            // Fetch shorts data via AJAX
            $.ajax({
                url: '../process/getShortsProcess.php',
                method: 'GET',
                data: { id: id },
                dataType: 'json',
                success: function (data) {
                    if (data.success) {
                        $('#update_pod_id').val(data.shorts.id);
                        $('#update_pod_name').val(data.shorts.name);
                        $('#update_description').val(data.shorts.description);

                        // Set video preview
                        const videoPreview = document.getElementById('update-video-preview');
                        const videoSource = videoPreview.querySelector('source');
                        if (data.shorts.url) {
                            videoSource.src = '../' + data.shorts.url;
                            videoPreview.load();
                            videoPreview.style.display = 'block';
                        } else {
                            videoSource.src = '';
                            videoPreview.load();
                            videoPreview.style.display = 'none';
                        }

                        // Reset file input (so onchange works if user re-selects same file)
                        $('#update_shorts').val('');

                        // Show modal
                        var modal = new bootstrap.Modal(document.getElementById('updateShortsModal'));
                        modal.show();
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'Failed to fetch Shorts data.', 'error');
                }
            });
        }
    });
}

// Add this event handler for update file input to preview selected video
document.getElementById('update_shorts').addEventListener('change', function(event) {
    previewVideo(event, 'update-video-preview');
});

// Handle update form submission for Shorts
$('#updateShortsButton').on('click', function () {
    var formData = new FormData(document.getElementById('updateShortsForm'));
    var loadingSpinner = document.getElementById('loading-spinner-pod-update');
    var progressBarContainer = document.getElementById('upload-progress-pod-update');
    var progressBar = document.getElementById('upload-progress-bar-pod-update');
    var validationErrors = document.getElementById('validation-errors-pod-update');
    var successMessage = document.getElementById('success-message-pod-update');

    var r = new XMLHttpRequest();

    r.upload.onprogress = function (event) {
        if (event.lengthComputable) {
            var percent = Math.round((event.loaded / event.total) * 100);
            progressBar.style.width = percent + "%";
            progressBar.innerText = percent + "%";
            progressBarContainer.classList.remove('d-none');
        }
    };

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            loadingSpinner.classList.add('d-none');
            progressBarContainer.classList.add('d-none');
            progressBar.style.width = "0%";
            progressBar.innerText = "0%";
            var t = r.responseText;
            try {
                var json = JSON.parse(t);
                if (r.status == 200 && json.success) {
                    successMessage.innerHTML = json.message;
                    successMessage.classList.remove('d-none');
                    validationErrors.classList.add('d-none');
                    var modal = bootstrap.Modal.getInstance(document.getElementById('updateShortsModal'));
                    modal.hide();
                    Swal.fire({
                        title: 'Success!',
                        text: json.message,
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                } else {
                    validationErrors.innerHTML = json.message || t;
                    validationErrors.classList.remove('d-none');
                    successMessage.classList.add('d-none');
                    Swal.fire({
                        title: 'Error!',
                        text: json.message || t,
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                }
            } catch (e) {
                validationErrors.innerHTML = t;
                validationErrors.classList.remove('d-none');
                successMessage.classList.add('d-none');
                Swal.fire({
                    title: 'Error!',
                    text: t,
                    icon: 'error',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            }
        }
    };

    loadingSpinner.classList.remove('d-none');
    progressBarContainer.classList.remove('d-none');
    progressBar.style.width = "0%";
    progressBar.innerText = "0%";
    r.open("POST", "../process/updateShortsProcess.php", true);
    r.send(formData);
});
