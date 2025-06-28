//ටොඋර් ස්ටේටස් වෙනස් කිරීමේ ක්‍රියාවලිය
// File: admin/process/changeTourStatusProcess.php
function changeStatusTours(tourId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to change the status of this tour?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, change it!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('../process/changeTourStatusProcess.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'id=' + tourId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Changed!', data.message, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error!', data.message, 'error');
                }
            })
            .catch(() => {
                Swal.fire('Error!', 'Something went wrong.', 'error');
            });
        }
    });
}

// Function to delete a tour
// This function will be called when the delete button is clicked
function deleteTours(tourId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This tour will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('../process/deleteTourProcess.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'id=' + tourId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Deleted!', data.message, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error!', data.message, 'error');
                }
            })
            .catch(() => {
                Swal.fire('Error!', 'Something went wrong.', 'error');
            });
        }
    });
}




//addTourForm.addEventListener('submit', function(event) {
//    event.preventDefault(); // Prevent the default form submission


document.getElementById('addTourBtn').addEventListener('click', function() {
    const name = document.getElementById('name').value.trim();
    const description = document.getElementById('message').value.trim();
    const duration = document.getElementById('Duration').value.trim();
    const kidsPrice = document.getElementById('subject').value.trim();
    const adultPrice = document.getElementById('adult-price').value.trim();
    const maxPeople = document.getElementById('body-title').value.trim();
    const tourType = document.getElementById('tourType').value;
    const errors = [];

    // Validation
    if (!name) errors.push('Tour Name is required.');
    if (!description) errors.push('Description is required.');
    if (!duration || isNaN(duration) || duration <= 0) errors.push('Duration must be a positive number.');
    if (!kidsPrice || isNaN(kidsPrice) || kidsPrice < 0) errors.push('Kids Price must be a non-negative number.');
    if (!adultPrice || isNaN(adultPrice) || adultPrice < 0) errors.push('Adult Price must be a non-negative number.');
    if (!maxPeople || isNaN(maxPeople) || maxPeople <= 0) errors.push('Maximum People Count must be a positive number.');
    if (!tourType) errors.push('Tour Type is required.');

    const errorDiv = document.getElementById('validation-errors1');
    const successDiv = document.getElementById('success-message1');
    errorDiv.classList.add('d-none');
    successDiv.classList.add('d-none');
    errorDiv.innerHTML = '';
    successDiv.innerHTML = '';

    if (errors.length > 0) {
        errorDiv.innerHTML = errors.join('<br>');
        errorDiv.classList.remove('d-none');
        return;
    }

    document.getElementById('loading-spinner1').classList.remove('d-none');

    // Send data via AJAX
    fetch('../process/AddTourProcess.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            name: name,
            description: description,
            duration: duration,
            kids_price: kidsPrice,
            adult_price: adultPrice,
            maximum_people_count: maxPeople,
            tours_type_id: tourType
        })
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('loading-spinner1').classList.add('d-none');
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "Tour successfully added, but it's not live yet.",
                confirmButtonText: 'OK'
            }).then(() => {
                location.reload();
            });
        } else {
            errorDiv.innerHTML = data.message;
            errorDiv.classList.remove('d-none');
        }
    })
    .catch(() => {
        document.getElementById('loading-spinner1').classList.add('d-none');
        errorDiv.innerHTML = 'An error occurred. Please try again.';
        errorDiv.classList.remove('d-none');
    });
});