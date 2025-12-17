document.addEventListener("DOMContentLoaded", function () {
    loadPayouts();
});

window.payoutData = []; // store fetched data for modal lookup

function statusBadge(item) {
    const status = (item.status || '').toString().toLowerCase();

    if (status === 'success') {
        return '<span class="badge bg-success">Success</span>';
    }

    if (status === 'failed' || status === 'canceled' || status === 'cancelled') {
        return '<span class="badge bg-danger">Failed</span>';
    }

    if (status === 'pending' || status === 'processing') {
        return '<span class="badge bg-warning">Pending</span>';
    }

    return `<span class="badge bg-secondary">${item.status || 'Unknown'}</span>`;
}


function loadPayouts() {
    fetch("fetchPayout.php")
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            window.payoutData = data || [];
            const tbody = document.getElementById("payoutTableBody");
            if (!tbody) {
                console.warn('payoutTableBody element not found');
                return;
            }
            tbody.innerHTML = "";

            data.forEach((item, idx) => {
                const badge = statusBadge(item);
                const row = `
                    <tr>
                        <td>${item.id ?? '-'}</td>
                        <td>${item.email ?? '-'}</td>
                        <td>${item.lkr_amount != null ? item.lkr_amount : '-'}</td>
                        <td>${badge}</td>
                        <td>${item.createdAt ?? '-'}</td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm btn-more" data-idx="${idx}">
                                <i class="fas fa-info-circle"></i> More
                            </button>
                        </td>
                    </tr>
                `;
                tbody.insertAdjacentHTML("beforeend", row);
            });

            // attach click handlers (event delegation)
            document.querySelectorAll('.btn-more').forEach(btn => {
                btn.addEventListener('click', function () {
                    const idx = parseInt(this.getAttribute('data-idx'), 10);
                    showDetails(idx);
                });
            });
        })
        .catch(err => console.error("Error loading payouts:", err));
}

function showDetails(index) {
    const item = window.payoutData[index];
    if (!item) return console.warn('Payout item not found for index', index);

    const modalEl = document.getElementById('payoutDetailsModal');
    if (!modalEl) {
        console.warn('payoutDetailsModal element not found');
        return;
    }

    // Fill modal fields safely using textContent
    document.getElementById('pd_id').textContent = item.id ?? '-';
    document.getElementById('pd_email').textContent = item.email ?? '-';
    document.getElementById('pd_description').textContent = item.description ?? '-';
    document.getElementById('pd_currency').textContent = (item.currency_code ?? item.currency ?? '-') + (item.currency_name ? ' (' + item.currency_name + ')' : '');
    document.getElementById('pd_amount').textContent = item.amount != null ? item.amount : '-';
    document.getElementById('pd_lkr_amount').textContent = item.lkr_amount != null ? item.lkr_amount : '-';
    document.getElementById('pd_status').innerHTML = statusBadge(item);
    document.getElementById('pd_createdAt').textContent = item.createdAt ?? '-';

    // show bootstrap modal
    if (typeof bootstrap !== 'undefined') {
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    } else {
        // fallback: simple alert with JSON
        alert(JSON.stringify(item, null, 2));
    }
}
