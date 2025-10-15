function loadCloseDays() {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var days = JSON.parse(r.responseText);
            var tbody = document.getElementById('closeDaysTableBody');
            tbody.innerHTML = '';
            days.forEach(function (row, idx) {
                tbody.innerHTML += `
                    <tr class="text-center">
                        <td>${row.id}</td>
                        <td>${row.date}</td>
                        <td>
                            <button class="btn btn-sm btn-danger" onclick="deleteCloseDay(${row.id});">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
        }
    };
    r.open("GET", "fetchCloseDays.php", true);
    r.send();
}

function addCloseDay() {
    var formData = new FormData(document.getElementById('addCloseDayForm'));
    var validationErrors = document.getElementById('validation-errors-close-day');
    var successMessage = document.getElementById('success-message-close-day');
    var loadingSpinner = document.getElementById('loading-spinner-close-day');
    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            loadingSpinner.classList.add('d-none');
            try {
                var res = JSON.parse(r.responseText);
                if (res.status === 'success') {
                    successMessage.innerHTML = res.message;
                    successMessage.classList.remove('d-none');
                    validationErrors.classList.add('d-none');
                    document.getElementById('addCloseDayForm').reset();
                    var modal = bootstrap.Modal.getInstance(document.getElementById('addCloseDayModal'));
                    modal.hide();
                    // Force remove backdrop after modal close
                    setTimeout(function() {
                        var backdrops = document.getElementsByClassName('modal-backdrop');
                        while (backdrops.length > 0) {
                            backdrops[0].parentNode.removeChild(backdrops[0]);
                        }
                        document.body.classList.remove('modal-open');
                        document.body.style.overflow = '';
                    }, 500);
                    Swal.fire('Success!', res.message, 'success').then(() => {
                        loadCloseDays();
                    });
                } else {
                    validationErrors.innerHTML = res.message;
                    validationErrors.classList.remove('d-none');
                    successMessage.classList.add('d-none');
                    Swal.fire('Error!', res.message, 'error');
                }
            } catch (e) {
                validationErrors.innerHTML = r.responseText;
                validationErrors.classList.remove('d-none');
                successMessage.classList.add('d-none');
                Swal.fire('Error!', r.responseText, 'error');
            }
        }
    };

    loadingSpinner.classList.remove('d-none');
    r.open("POST", "../process/addCloseDaysProcess.php", true);
    r.send(formData);
}

function deleteCloseDay(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to delete this closed day?",
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
                    try {
                        var res = JSON.parse(r.responseText);
                        if (r.status == 200 && res.status === 'success') {
                            Swal.fire('Deleted!', res.message, 'success').then(() => {
                                loadCloseDays();
                            });
                        } else {
                            Swal.fire('Error!', res.message, 'error');
                        }
                    } catch (e) {
                        Swal.fire('Error!', r.responseText, 'error');
                    }
                }
            };
            r.open("POST", "../process/deleteCloseDaysProcess.php", true);
            r.send(formData);
        }
    });
}

// Initial load
document.addEventListener('DOMContentLoaded', loadCloseDays);