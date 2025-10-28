document.addEventListener('DOMContentLoaded', function() {
    loadAdvanceRate();
});

function loadAdvanceRate() {
    fetch('fetchAdvanceRate.php')
        .then(res => res.json())
        .then(data => {
            document.getElementById('rateValue').value = data.value;
        })
        .catch(err => console.error('Error loading rate:', err));
}

function updateRate() {
    const value = parseInt(document.getElementById('rateValue').value);
    
    if (!value || value < 0 || value > 100) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid Value',
            text: 'Please enter a value between 0 and 100'
        });
        return;
    }

    const formData = new FormData();
    formData.append('value', value);

    fetch('UpdateAdvanceRate.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Rate updated successfully'
            });
        } else {
            throw new Error(data.message || 'Update failed');
        }
    })
    .catch(err => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: err.message || 'Failed to update rate'
        });
    });
}