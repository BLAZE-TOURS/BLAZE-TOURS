function deleteToursType(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Are you sure you want to delete this tour type?",
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
                        if (t.includes("Tour type deleted successfully")) {
                            Swal.fire(
                                'Deleted!',
                                'The tour type has been deleted.',
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
            r.open("POST", "../process/deleteToursTypeProcess.php", true);
            r.send(formData);
        }
    });
}

function updateToursType(id) {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var data = JSON.parse(r.responseText);
            document.getElementById('update_tours_id').value = data.id;
            document.getElementById('update_tours_name').value = data.name;
            var modal = new bootstrap.Modal(document.getElementById('updateToursTypeModal'));
            modal.show();
        }
    };
    r.open("GET", "../process/getToursTypeById.php?id=" + id, true);
    r.send();
}

function submitUpdateToursType() {
    var form = document.getElementById('updateToursTypeForm');
    var formData = new FormData(form);

    var validationErrors = document.getElementById('validation-errors-tours-update');
    var successMessage = document.getElementById('success-message-tours-update');
    var loadingSpinner = document.getElementById('loading-spinner-tours-update');

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            loadingSpinner.classList.add('d-none');
            var t = r.responseText;
            if (r.status == 200) {
                if (t.includes("Tour type updated successfully")) {
                    successMessage.innerHTML = t;
                    successMessage.classList.remove('d-none');
                    validationErrors.classList.add('d-none');
                    var modal = bootstrap.Modal.getInstance(document.getElementById('updateToursTypeModal'));
                    modal.hide();
                    Swal.fire(
                        'Success!',
                        'Tour type updated successfully.',
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
    r.open("POST", "../process/updateToursTypeProcess.php", true);
    r.send(formData);
}

function addToursType() {
    var form = document.getElementById('addToursTypeForm');
    var formData = new FormData(form);

    var validationErrors = document.getElementById('validation-errors-tours');
    var successMessage = document.getElementById('success-message-tours');
    var loadingSpinner = document.getElementById('loading-spinner-tours');
    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            loadingSpinner.classList.add('d-none');
            if (r.status == 200) {
                if (t.includes("Tour type added successfully")) {
                    successMessage.innerHTML = t;
                    successMessage.classList.remove('d-none');
                    validationErrors.classList.add('d-none');
                    form.reset();
                    var modal = bootstrap.Modal.getInstance(document.getElementById('addToursTypeModal'));
                    modal.hide();
                    Swal.fire(
                        'Success!',
                        'Tour type added successfully.',
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
    r.open("POST", "../process/addToursTypeProcess.php", true);
    r.send(formData);
}