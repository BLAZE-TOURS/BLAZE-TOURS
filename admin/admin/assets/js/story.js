function previewImage(event, previewId) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById(previewId);
        output.src = reader.result;
        output.style.display = 'block';
    }
    reader.readAsDataURL(event.target.files[0]);
}

function updateStory(id) {
    Swal.fire({
        title: 'Update Story',
        text: "Do you want to update this story?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            var r = new XMLHttpRequest();
            r.onreadystatechange = function () {
                if (r.readyState == 4 && r.status == 200) {
                    var data = JSON.parse(r.responseText);
                    document.getElementById('update_story_id').value = data.id;
                    document.getElementById('update_story_name').value = data.title;
                    document.getElementById('update_story_date').value = data.date_time;
                    document.getElementById('update_story_description').value = data.description;
                    var imgContainer = document.getElementById('current-image-container');
                    var previewImg = document.getElementById('update_story_image_preview');
                    if (data.img_url) {
                        imgContainer.innerHTML = '<span>Current Image:</span><br><img src="images/news/' + data.img_url + '" style="max-width:100px;">';
                        previewImg.src = 'images/story/' + data.img_url;
                        previewImg.style.display = 'block';
                    } else {
                        imgContainer.innerHTML = '';
                        previewImg.style.display = 'none';
                    }
                    var fileInput = document.getElementById('update_story_image');
                    if (fileInput) {
                        fileInput.onchange = function(event) {
                            previewImage(event, 'update_story_image_preview');
                        };
                    }
                    var modal = new bootstrap.Modal(document.getElementById('updateStoryModal'));
                    modal.show();
                }
            };
            r.open("GET", "../process/getStoryById.php?id=" + id, true);
            r.send();
        }
    });
}

function submitUpdateStory() {
    var form = document.getElementById('updateStoryForm');
    var formData = new FormData(form);

    var validationErrors = document.getElementById('validation-errors-story-update');
    var successMessage = document.getElementById('success-message-story-update');
    var loadingSpinner = document.getElementById('loading-spinner-story-update');

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            loadingSpinner.classList.add('d-none');
            var t = r.responseText;
            if (r.status == 200) {
                if (t.includes("Story updated successfully")) {
                    successMessage.innerHTML = t;
                    successMessage.classList.remove('d-none');
                    validationErrors.classList.add('d-none');
                    var modal = bootstrap.Modal.getInstance(document.getElementById('updateStoryModal'));
                    modal.hide();
                    Swal.fire(
                        'Success!',
                        'Story updated successfully.',
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
    r.open("POST", "../process/updateStoryProcess.php", true);
    r.send(formData);
}

function deleteStory(id) {
    Swal.fire({
        title: 'Delete Story',
        text: "Are you sure you want to delete this story?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            var formData = new FormData();
            formData.append("id", id);
            var r = new XMLHttpRequest();
            r.onreadystatechange = function () {
                if (r.readyState == 4) {
                    var t = r.responseText;
                    if (r.status == 200 && t.includes("Story deleted successfully")) {
                        Swal.fire(
                            'Deleted!',
                            'The story has been deleted.',
                            'success'
                        ).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire('Error!', t, 'error');
                    }
                }
            };
            r.open("POST", "../process/deleteStoryProcess.php", true);
            r.send(formData);
        }
    });
}

function addStory() {
    var form = document.getElementById('addStoryForm');
    var formData = new FormData(form);

    var validationErrors = document.getElementById('validation-errors-story');
    var successMessage = document.getElementById('success-message-story');
    var loadingSpinner = document.getElementById('loading-spinner-story');

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            loadingSpinner.classList.add('d-none');
            var t = r.responseText;
            if (r.status == 200) {
                if (t.includes("Story added successfully")) {
                    successMessage.innerHTML = t;
                    successMessage.classList.remove('d-none');
                    validationErrors.classList.add('d-none');
                    form.reset();
                    document.getElementById('story_image_preview').style.display = 'none';
                    var modal = bootstrap.Modal.getInstance(document.getElementById('addStoryModal'));
                    modal.hide();
                    Swal.fire(
                        'Success!',
                        'Story added successfully.',
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
    r.open("POST", "../process/addStoryProcess.php", true);
    r.send(formData);
}