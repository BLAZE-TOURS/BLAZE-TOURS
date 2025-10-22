document.addEventListener("DOMContentLoaded", function () {
    loadPayouts();
});

function statusBadge(item) {
    const sid = Number(item.status_id ?? item.status ?? 0);

    if (sid === 1) return '<span class="badge bg-success">Active</span>';
    if (sid === 2) return '<span class="badge bg-danger">De-Active</span>';
    if (sid === 3) return '<span class="badge bg-warning text-dark">Processing</span>';

    // fallback to text if numeric not present
    const sname = (item.status_name || '').toString().toLowerCase();
    if (sname.includes('active')) return '<span class="badge bg-success">Active</span>';
    if (sname.includes('de') || sname.includes('cancel')) return '<span class="badge bg-danger">De-Active</span>';
    if (sname.includes('process') || sname.includes('pending')) return '<span class="badge bg-warning text-dark">Processing</span>';

    return `<span class="badge bg-secondary">${item.status_name ?? 'Unknown'}</span>`;
}

function loadPayouts() {
    fetch("fetchPayout.php")
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            const tbody = document.getElementById("payoutTableBody");
            if (!tbody) {
                console.warn('payoutTableBody element not found');
                return;
            }
            tbody.innerHTML = "";

            data.forEach((item) => {
                const badge = statusBadge(item);
                const row = `
                    <tr>
                        <td>${item.id}</td>
                        <td>${item.email}</td>
                        <td>${item.currency_code ?? item.currency} ${item.currency_name ? '(' + item.currency_name + ')' : ''}</td>
                        <td>${item.amount ?? "-"}</td>
                        <td>${item.lkr_amount ?? "-"}</td>
                        <td>${badge}</td>
                        <td>${item.createdAt ?? "-"}</td>
                    </tr>
                `;
                tbody.insertAdjacentHTML("beforeend", row);
            });
        })
        .catch(err => console.error("Error loading payouts:", err));
}
