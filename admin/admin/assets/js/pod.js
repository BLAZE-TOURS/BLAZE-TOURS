function previewImage(event, previewId) {
    const reader = new FileReader();
    reader.onload = function () {
        const output = document.getElementById(previewId);
        output.src = reader.result;
        output.style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
}

function previewAudio(event, previewId) {
    const file = event.target.files[0];
    if (file) {
        const audioPreview = document.getElementById(previewId);
        const audioSource = audioPreview.querySelector('source');
        audioSource.src = URL.createObjectURL(file);
        audioPreview.load();
        audioPreview.style.display = 'block';
    }
}

function addPod() {
    var formData = new FormData(document.getElementById('addPodForm'));

    var validationErrors = document.getElementById('validation-errors-pod');
    var successMessage = document.getElementById('success-message-pod');
    var loadingSpinner = document.getElementById('loading-spinner-pod');
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
            loadingSpinner.classList.add('d-none');
            progressBarContainer.classList.add('d-none');
            progressBar.style.width = "0%";
            progressBar.innerText = "0%";
            var t = r.responseText;
            if (r.status == 200) {
                if (t.includes("New Podcast added successfully")) {
                    successMessage.innerHTML = t;
                    successMessage.classList.remove('d-none');
                    validationErrors.classList.add('d-none');
                    document.getElementById('addPodForm').reset();
                    var modal = bootstrap.Modal.getInstance(document.getElementById('addPodModal'));
                    modal.hide();
                    Swal.fire(
                        'Success!',
                        'New Podcast added successfully.',
                        'success'
                    ).then(() => {
                        window.location.reload();
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

    loadingSpinner.classList.remove('d-none');
    progressBarContainer.classList.remove('d-none');
    progressBar.style.width = "0%";
    progressBar.innerText = "0%";
    r.open("POST", "../process/addPodProcess.php", true);
    r.send(formData);
}

function deletePod(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Are you sure you want to delete this podcast?",
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
                    if (r.responseText.includes("Podcast deleted successfully")) {
                        Swal.fire(
                            'Deleted!',
                            'Podcast has been deleted.',
                            'success'
                        ).then(() => {
                            window.location.reload();
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
            r.open("GET", "../process/deletePodProcess.php?id=" + id, true);
            r.send();
        }
    });
}

function updatePod(id) {
    Swal.fire({
        title: 'Update Podcast',
        text: "Do you want to update this podcast?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, update',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Fetch podcast data via AJAX
            $.ajax({
                url: '../process/getPodProcess.php',
                method: 'GET',
                data: { id: id },
                dataType: 'json',
                success: function (data) {
                    if (data.success) {
                        $('#update_pod_id').val(data.podcast.id);
                        $('#update_pod_name').val(data.podcast.pod_name);
                        $('#update_description').val(data.podcast.pod_description);

                        // Set image preview
                        if (data.podcast.pod_img_url) {
                            $('#update-img-preview').attr('src', '../' + data.podcast.pod_img_url).show();
                        } else {
                            $('#update-img-preview').hide();
                        }

                        // Set audio preview
                        if (data.podcast.pod_url) {
                            $('#update-audio-preview source').attr('src', '../' + data.podcast.pod_url);
                            $('#update-audio-preview')[0].load();
                            $('#update-audio-preview').show();
                        } else {
                            $('#update-audio-preview').hide();
                        }

                        // Show modal
                        var modal = new bootstrap.Modal(document.getElementById('updatePodModal'));
                        modal.show();
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'Failed to fetch podcast data.', 'error');
                }
            });
        }
    });
}

// Handle update form submission
$('#updatePodButton').on('click', function () {
    var formData = new FormData(document.getElementById('updatePodForm'));
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
            if (r.status == 200) {
                if (t.includes("Podcast updated successfully")) {
                    successMessage.innerHTML = t;
                    successMessage.classList.remove('d-none');
                    validationErrors.classList.add('d-none');
                    var modal = bootstrap.Modal.getInstance(document.getElementById('updatePodModal'));
                    modal.hide();
                    Swal.fire(
                        'Success!',
                        'Podcast updated successfully.',
                        'success'
                    ).then(() => {
                        window.location.reload();
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

    loadingSpinner.classList.remove('d-none');
    progressBarContainer.classList.remove('d-none');
    progressBar.style.width = "0%";
    progressBar.innerText = "0%";
    r.open("POST", "../process/updatePodProcess.php", true);
    r.send(formData);
});
