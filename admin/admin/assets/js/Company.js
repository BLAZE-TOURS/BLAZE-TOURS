function addCompany() {

    var formData = new FormData(document.getElementById('addCompanyForm'));

    var validationErrors = document.getElementById('validation-errors-company');
    var successMessage = document.getElementById('success-message-company');
    var loadingSpinner = document.getElementById('loading-spinner-company');
    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            loadingSpinner.classList.add('d-none'); // Hide the spinner
            if (r.status == 200) {
                if (t.includes("New company added successfully")) {
                    successMessage.innerHTML = t;
                    successMessage.classList.remove('d-none');
                    validationErrors.classList.add('d-none');
                    document.getElementById('addCompanyForm').reset(); // Clear the form fields
                    var modal = bootstrap.Modal.getInstance(document.getElementById('addCompanyModal'));
                    modal.hide(); // Hide the modal
                    Swal.fire(
                        'Success!',
                        'New company added successfully.',
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
    r.open("POST", "../process/addCompanyProcess.php", true);
    r.send(formData);
}

function updateCompany(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Are you sure you want to update this company?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, update it!'
    }).then((result) => {
        if (result.isConfirmed) {
            loadCompanyData(id);
            var modal = new bootstrap.Modal(document.getElementById('updateCompanyModal'));
            modal.show();
        }
    });
}

function updateMediType(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Are you sure you want to update this company?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, update it!'
    }).then((result) => {
        if (result.isConfirmed) {
            loadCompanyData(id);
            var modal = new bootstrap.Modal(document.getElementById('updateMediTypeModal'));
            modal.show();
        }
    });
}


function loadCompanyData(id) {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var company = JSON.parse(r.responseText);

            // Populate form fields
            document.getElementById('company_name_update').value = company.name;
            document.getElementById('website_update').value = company.website;
            document.getElementById('location_update').value = company.location;
            document.getElementById('contact1_update').value = company.contact1;
            document.getElementById('contact2_update').value = company.contact2;
            document.getElementById('email_update').value = company.email;
            document.getElementById('copywrite_update').value = company.copywrite;
            document.getElementById('facebook_update').value = company.facebook;
            document.getElementById('insta_update').value = company.insta;
            document.getElementById('yt_update').value = company.yt;

            // Set the logo preview
            if (company.logo) {
                var logoPreview = document.getElementById('logo-preview-update');
                logoPreview.src = company.logo; // Set the logo URL
                logoPreview.style.display = 'block'; // Make the image visible
            } else {
                document.getElementById('logo-preview-update').style.display = 'none'; // Hide if no logo
            }

            document.getElementById('updateCompanyButton').dataset.id = id;
        }
    };
    r.open("GET", "../process/getCompanyData.php?id=" + id, true);
    r.send();
}


document.getElementById('updateCompanyButton').addEventListener('click', function () {
    var id = this.dataset.id;
    var formData = new FormData(document.getElementById('updateCompanyForm'));
    formData.append('id', id);

    var validationErrors = document.getElementById('validation-errors-company-update');
    var successMessage = document.getElementById('success-message-company-update');
    var loadingSpinner = document.getElementById('loading-spinner-company-update');
    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            loadingSpinner.classList.add('d-none'); // Hide the spinner
            if (r.status == 200) {
                if (t.includes("Company updated successfully")) {
                    successMessage.innerHTML = t;
                    successMessage.classList.remove('d-none');
                    validationErrors.classList.add('d-none');
                    var modal = bootstrap.Modal.getInstance(document.getElementById('updateCompanyModal'));
                    modal.hide(); // Hide the modal
                    Swal.fire(
                        'Success!',
                        'Company updated successfully.',
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
    r.open("POST", "../process/updateCompanyProcess.php", true);
    r.send(formData);
});

document.getElementById('updateCompanyForm').addEventListener('input', function () {
    var updateButton = document.getElementById('updateCompanyButton');
    updateButton.disabled = false;
});

function deleteCompany(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Are you sure you want to delete this company?",
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
                        if (t.includes("Company deleted successfully")) {
                            Swal.fire(
                                'Deleted!',
                                'The company has been deleted.',
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
            r.open("POST", "../process/deleteCompanyProcess.php", true);
            r.send(formData);
        }
    });
}