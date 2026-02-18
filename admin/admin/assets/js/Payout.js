let payoutPageInitialized = false;

function initPayoutPage() {
    if (payoutPageInitialized) return;
    payoutPageInitialized = true;
    bindPayoutStatusFilter();
    loadPayouts();
}

if (document.readyState === 'loading') {
    document.addEventListener("DOMContentLoaded", initPayoutPage, { once: true });
} else {
    initPayoutPage();
}

window.payoutData = []; // store fetched data for modal lookup
window.activePayoutStatus = 'success';

function getCurrentPayoutStatus() {
    const select = document.getElementById('payoutStatusSelect');
    const value = (select && select.value) ? select.value : window.activePayoutStatus;
    return (value || 'success').toString().trim().toLowerCase();
}

function normalizeStatus(status) {
    const value = (status || '').toString().trim().toLowerCase();

    if (value === 'success' || value === 'completed' || value === 'paid' || value === '1') return 'success';
    if (value === 'failed' || value === 'error' || value === 'canceled' || value === 'cancelled' || value === '0' || value === '-1') return 'failed';
    if (value === 'pending' || value === 'processing' || value === '2') return 'pending';

    return value;
}

function getItemStatus(item) {
    const fromStatus = normalizeStatus(item?.status);
    if (fromStatus === 'success' || fromStatus === 'failed' || fromStatus === 'pending') {
        return fromStatus;
    }

    const fromCode = normalizeStatus(item?.status_code);
    if (fromCode === 'success' || fromCode === 'failed' || fromCode === 'pending') {
        return fromCode;
    }

    return fromStatus || fromCode || 'unknown';
}

function bindPayoutStatusFilter() {
    const select = document.getElementById('payoutStatusSelect');
    if (!select) return;

    window.activePayoutStatus = select.value || 'success';

    select.addEventListener('change', function () {
        window.activePayoutStatus = this.value || 'success';
        renderPayoutRows();
    });
}

document.addEventListener('change', function (event) {
    const target = event.target;
    if (!target || target.id !== 'payoutStatusSelect') return;
    window.activePayoutStatus = target.value || 'success';
    renderPayoutRows();
});

window.filterPayoutRowsByStatus = function (value) {
    window.activePayoutStatus = (value || 'success').toString().trim().toLowerCase();
    renderPayoutRows();
};

function statusBadge(item) {
    const status = getItemStatus(item);

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

function isStatusMatch(item) {
    const selectedStatus = getCurrentPayoutStatus();
    if (selectedStatus === 'all') return true;
    return getItemStatus(item) === selectedStatus;
}

function renderPayoutRows() {
    const tbody = document.getElementById("payoutTableBody");
    if (!tbody) {
        console.warn('payoutTableBody element not found');
        return;
    }

    tbody.innerHTML = "";
    let count = 0;

    window.payoutData.forEach((item, idx) => {
        if (!isStatusMatch(item)) return;

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
        count += 1;
    });

    if (count === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-muted">No payouts found for selected status.</td>
            </tr>
        `;
        return;
    }

    document.querySelectorAll('.btn-more').forEach(btn => {
        btn.addEventListener('click', function () {
            const idx = parseInt(this.getAttribute('data-idx'), 10);
            showDetails(idx);
        });
    });
}


function loadPayouts() {
    fetch("fetchPayout.php")
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            window.payoutData = data || [];
            renderPayoutRows();
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
