function addImage() {
    var formData = new FormData(document.getElementById('addaImageForm'));

    var validationErrors = document.getElementById('validation-errors-image');
    var successMessage = document.getElementById('success-message-image');
    var loadingSpinner = document.getElementById('loading-spinner-add-image');
    var progressBarContainer = document.getElementById('upload-progress-pod');
    var progressBar = document.getElementById('upload-progress-bar-pod');

    var r = new XMLHttpRequest();

    // Progress event
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
            var t = r.responseText;
            loadingSpinner.classList.add('d-none'); // Hide the spinner
            if (r.status == 200) {
                if (t.includes("New image added successfully")) {
                    successMessage.innerHTML = t;
                    successMessage.classList.remove('d-none');
                    validationErrors.classList.add('d-none');
                    document.getElementById('addaImageForm').reset(); // Clear the form fields
                    var modal = bootstrap.Modal.getInstance(document.getElementById('addImageModal'));
                    modal.hide(); // Hide the modal
                    Swal.fire(
                        'Success!',
                        'New image added successfully.',
                        'success'
                    ).then(() => {
                        window.location.reload(); // Reload the window
                    });
                } else {
                    validationErrors.innerHTML = t;
                    validationErrors.classList.remove('d-none');
                    successMessage.classList.add('d-none');
                    Swal.fire(
                        'Error!',
                        t,
                        'error'
                    );
                }
            } else {
                validationErrors.innerHTML = t;
                validationErrors.classList.remove('d-none');
                successMessage.classList.add('d-none');
                Swal.fire(
                    'Error!',
                    t,
                    'error'
                );
            }
        }
    };

    loadingSpinner.classList.remove('d-none'); // Show the spinner
    r.open("POST", "../process/addImageProcess.php", true);
    r.send(formData);
}

function previewImage(event, previewId) {
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById(previewId);
        output.src = reader.result;
        output.style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
}

function updateImage(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Are you sure you want to update this image?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, update it!'
    }).then((result) => {
        if (result.isConfirmed) {
            loadImageData(id);
            var modal = new bootstrap.Modal(document.getElementById('updateImageModal'));
            modal.show();
        }
    });
}

function loadImageData(id) {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var image = JSON.parse(r.responseText);

            if (image.error) {
                Swal.fire('Error!', image.error, 'error');
                return;
            }

            // Populate the title field in the update modal
            document.getElementById('update_image_title').value = image.title || '';

            // Set the image preview in the update modal
            var imagePreview = document.getElementById('update_logo_preview');
            if (image.url) {
                imagePreview.src = image.url;
                imagePreview.style.display = 'block';
            } else {
                imagePreview.style.display = 'none';
            }

            // Set the tour dropdown in the update modal
            loadTours('update_tour_id', image.tour_id);

            document.getElementById('updateImageButton').dataset.id = id;
        }
    };
    r.open("GET", "../process/getImageData.php?id=" + id, true);
    r.send();
}

document.getElementById('updateImageButton').addEventListener('click', function () {
    var id = this.dataset.id;
    var formData = new FormData(document.getElementById('updateImageForm'));
    formData.append('id', id);

    var validationErrors = document.getElementById('validation-errors-image-update');
    var successMessage = document.getElementById('success-message-image-update');
    var loadingSpinner = document.getElementById('loading-spinner-image-update');
    var progressBarContainer = document.getElementById('upload-progress-pod');
    var progressBar = document.getElementById('upload-progress-bar-pod');
    var r = new XMLHttpRequest();

    // Only show progress bar for update
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
            var t = r.responseText;
            loadingSpinner.classList.add('d-none'); // Hide the spinner
            if (r.status == 200) {
                if (t.includes("Image updated successfully")) {
                    successMessage.innerHTML = t;
                    successMessage.classList.remove('d-none');
                    validationErrors.classList.add('d-none');
                    progressBar.style.width = "0%";
                    progressBar.innerText = "0%";
                    progressBarContainer.classList.add('d-none');
                    var modal = bootstrap.Modal.getInstance(document.getElementById('updateImageModal'));
                    modal.hide(); // Hide the modal
                    Swal.fire(
                        'Success!',
                        'Image updated successfully.',
                        'success'
                    ).then(() => {
                        window.location.reload(); // Reload the window
                    });
                } else {
                    validationErrors.innerHTML = t;
                    validationErrors.classList.remove('d-none');
                    successMessage.classList.add('d-none');
                    Swal.fire(
                        'Error!',
                        t,
                        'error'
                    );
                }
            } else {
                validationErrors.innerHTML = t;
                validationErrors.classList.remove('d-none');
                successMessage.classList.add('d-none');
                Swal.fire(
                    'Error!',
                    t,
                    'error'
                );
            }
        }
    };

    loadingSpinner.classList.remove('d-none'); // Show the spinner
    r.open("POST", "../process/updateImageProcess.php", true);
    r.send(formData);
});

document.getElementById('updateImageForm').addEventListener('input', function () {
    var updateButton = document.getElementById('updateImageButton');
    updateButton.disabled = false;
});

function deleteImage(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Are you sure you want to delete this image?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            var r = new XMLHttpRequest();
            r.onreadystatechange = function () {
                if (r.readyState == 4 && r.status == 200) {
                    if (r.responseText.includes("Image deleted successfully")) {
                        Swal.fire(
                            'Deleted!',
                            'Image has been deleted.',
                            'success'
                        ).then(() => {
                            window.location.reload(); // Reload the window
                        });
                    } else {
                        Swal.fire(
                            'Error!',
                            r.responseText,
                            'error'
                        );
                    }
                }
            };
            r.open("GET", "../process/deleteImageProcess.php?id=" + id, true);
            r.send();
        }
    });
}

function downloadPod(id) {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var response = JSON.parse(r.responseText);

            if (response.error) {
                Swal.fire('Error!', response.error, 'error');
                return;
            }

            // Create a temporary link to download the file
            var link = document.createElement('a');
            link.href = response.url;
            link.download = response.filename || 'downloaded_image';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    };
    r.open("GET", "../process/downloadImageProcess.php?id=" + id, true);
    r.send();
}