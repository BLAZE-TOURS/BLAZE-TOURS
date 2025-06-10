function previewImage(event, previewId) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById(previewId);
        output.src = reader.result;
        output.style.display = 'block';
    }
    reader.readAsDataURL(event.target.files[0]);
}

function addNews() {
    var form = document.getElementById('addNewsForm');
    var formData = new FormData(form);

    var validationErrors = document.getElementById('validation-errors-news');
    var successMessage = document.getElementById('success-message-news');
    var loadingSpinner = document.getElementById('loading-spinner-news');
    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            loadingSpinner.classList.add('d-none'); // Hide the spinner
            if (r.status == 200) {
                if (t.includes("News added successfully")) {
                    successMessage.innerHTML = t;
                    successMessage.classList.remove('d-none');
                    validationErrors.classList.add('d-none');
                    form.reset(); // Clear the form fields
                    document.getElementById('news_image_preview').style.display = 'none';
                    var modal = bootstrap.Modal.getInstance(document.getElementById('news_image_preview'));
                    modal.hide(); // Hide the modal
                    Swal.fire(
                        'Success!',
                        'New News added successfully.',
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
    r.open("POST", "../process/addNewsProcess.php", true);
    r.send(formData);
}



function deleteMediType(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Are you sure you want to delete this meditation type?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            var formData = new FormData();
            formData.append("id", id);
            var r = new XMLHttpRequest();
            r.onreadystatechange = function () {
                if (r.readyState == 4) {
                    var t = r.responseText;
                    if (r.status == 200) {
                        if (t.includes("Meditation type deleted successfully")) {
                            Swal.fire(
                                'Deleted!',
                                'The meditation type has been deleted.',
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                t,
                                'error'
                            );
                        }
                    } else {
                        Swal.fire(
                            'Error!',
                            t,
                            'error'
                        );
                    }
                }
            };
            r.open("POST", "../process/deleteMediTypeProcess.php", true);
            r.send(formData);
        }
    });
}

function updateMediType(id) {
    // Fetch meditation type details via AJAX
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var data = JSON.parse(r.responseText);
            // Fill modal fields
            document.getElementById('update_meditation_id').value = data.id;
            document.getElementById('update_meditation_name').value = data.name;
            document.getElementById('update_meditation_category_id').value = data.meditation_category_id;
            document.getElementById('update_meditation_start_time').value = data.start;
            document.getElementById('update_meditation_end_time').value = data.end;
            document.getElementById('update_meditation_description').value = data.description;
            // Show current image
            var imgContainer = document.getElementById('current-image-container');
            if (data.img_url) {
                imgContainer.innerHTML = '<span>Current Image:</span><br><img src="images/medi/' + data.img_url + '" style="max-width:100px;">';
            } else {
                imgContainer.innerHTML = '';
            }
            document.getElementById('update_meditation_image_preview').style.display = 'none';
            // Show modal
            var modal = new bootstrap.Modal(document.getElementById('updateMediTypeModal'));
            modal.show();
        }
    };
    r.open("GET", "../process/getMediTypeById.php?id=" + id, true);
    r.send();
}

function submitUpdateMeditationType() {
    var form = document.getElementById('updateMeditationTypeForm');
    var formData = new FormData(form);

    var validationErrors = document.getElementById('validation-errors-meditation-update');
    var successMessage = document.getElementById('success-message-meditation-update');
    var loadingSpinner = document.getElementById('loading-spinner-meditation-update');

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            loadingSpinner.classList.add('d-none');
            var t = r.responseText;
            if (r.status == 200) {
                if (t.includes("Meditation type updated successfully")) {
                    successMessage.innerHTML = t;
                    successMessage.classList.remove('d-none');
                    validationErrors.classList.add('d-none');
                    var modal = bootstrap.Modal.getInstance(document.getElementById('updateMediTypeModal'));
                    modal.hide();
                    Swal.fire(
                        'Success!',
                        'Meditation type updated successfully.',
                        'success'
                    ).then(() => {
                        window.location.reload();
                    });
                } else {
                    validationErrors.innerHTML = t;
                    validationErrors.classList.remove('d-none');
                    successMessage.classList.add('d-none');
                    Swal.fire('Error!', t, 'error');
                }
            } else {
                validationErrors.innerHTML = t;
                validationErrors.classList.remove('d-none');
                successMessage.classList.add('d-none');
                Swal.fire('Error!', t, 'error');
            }
        }
    };
    loadingSpinner.classList.remove('d-none');
    r.open("POST", "../process/updateMediTypeProcess.php", true);
    r.send(formData);
}