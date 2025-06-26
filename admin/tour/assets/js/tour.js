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
