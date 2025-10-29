<div class="content-page mt-5 fade-in">
    <div class="row justify-content-center mt-2">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <!-- Total LKR Summary -->
                    <div class="d-flex justify-content-end mb-4">
                        <div class="text-end">
                            <h5 class="fw-semibold">Total Earnings</h5>
                            <h2 class="fw-bold text-success" id="totalEarnings">0 LKR</h2>
                        </div>
                    </div>

                    <!-- Filters Section -->
                    <form id="filterForm" class="row g-3 align-items-end mb-4 border rounded p-3 bg-light">

                        <!-- Type Selector -->
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Type</label>
                            <select class="form-select" id="filterType">
                                <option value="">All</option>
                                <option value="Booking">Booking</option>
                                <option value="Payout">Payout</option>
                            </select>
                        </div>

                        <!-- Date Range -->
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">From Date</label>
                            <input type="date" class="form-control" id="fromDate">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">To Date</label>
                            <input type="date" class="form-control" id="toDate">
                        </div>

                        <!-- Single Day -->
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Specific Day</label>
                            <input type="date" class="form-control" id="singleDate">
                        </div>

                        <!-- Amount Range -->
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Min Amount (LKR)</label>
                            <input type="number" class="form-control" id="minAmount" placeholder="e.g. 500">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Max Amount (LKR)</label>
                            <input type="number" class="form-control" id="maxAmount" placeholder="e.g. 5000">
                        </div>

                        <!-- Sorting -->
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Sort By</label>
                            <select class="form-select" id="sortOption">
                                <option value="newest">Newest → Oldest</option>
                                <option value="oldest">Oldest → Newest</option>
                                <option value="highest">Highest → Lowest Amount</option>
                                <option value="lowest">Lowest → Highest Amount</option>
                            </select>
                        </div>

                        <!-- Clear Button -->
                        <div class="col-md-3 text-end">
                            <button type="button" id="clearFilters" class="btn btn-outline-secondary px-4">
                                <i class="bi bi-x-circle"></i> Clear Filters
                            </button>
                        </div>
                    </form>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table id="dataTableEarm" class="table table-striped table-bordered align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>#ID</th>
                                    <th>LKR Amount</th>
                                    <th>Locate</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody id="earningsTable">
                                <tr>
                                    <td>1001</td>
                                    <td>2500</td>
                                    <td><span class="badge bg-success">Booking</span></td>
                                    <td>2025-10-27</td>
                                </tr>
                                <tr>
                                    <td>1002</td>
                                    <td>1200</td>
                                    <td><span class="badge bg-primary">Payout</span></td>
                                    <td>2025-10-28</td>
                                </tr>
                                <tr>
                                    <td>1003</td>
                                    <td>3200</td>
                                    <td><span class="badge bg-success">Booking</span></td>
                                    <td>2025-10-29</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
const tableBody = document.getElementById('earningsTable');
const totalEarnings = document.getElementById('totalEarnings');
const filterInputs = document.querySelectorAll('#filterForm input, #filterForm select');

// Function: Update total earnings
function updateTotal() {
    let total = 0;
    tableBody.querySelectorAll('tr').forEach(row => {
        if (row.style.display !== 'none') {
            total += parseFloat(row.cells[1]?.textContent || 0);
        }
    });
    totalEarnings.textContent = total.toLocaleString() + " LKR";
}

// Function: Apply filters
function applyFilters() {
    const type = document.getElementById('filterType').value.trim();
    const fromDate = document.getElementById('fromDate').value;
    const toDate = document.getElementById('toDate').value;
    const singleDate = document.getElementById('singleDate').value;
    const minAmount = parseFloat(document.getElementById('minAmount').value) || 0;
    const maxAmount = parseFloat(document.getElementById('maxAmount').value) || Infinity;

    tableBody.querySelectorAll('tr').forEach(row => {
        const locate = row.querySelector('.badge')?.textContent.trim();
        const date = row.cells[3]?.textContent.trim();
        const amount = parseFloat(row.cells[1]?.textContent || 0);

        let visible = true;

        if (type && locate !== type) visible = false;
        if (fromDate && toDate && !(date >= fromDate && date <= toDate)) visible = false;
        if (singleDate && date !== singleDate) visible = false;
        if (amount < minAmount || amount > maxAmount) visible = false;

        row.style.display = visible ? '' : 'none';
    });

    updateTotal();
}

// Function: Sort rows
function sortTable(option) {
    const rows = Array.from(tableBody.querySelectorAll('tr'));

    rows.sort((a, b) => {
        const dateA = a.cells[3].textContent;
        const dateB = b.cells[3].textContent;
        const amountA = parseFloat(a.cells[1].textContent);
        const amountB = parseFloat(b.cells[1].textContent);

        switch (option) {
            case 'newest': return dateB.localeCompare(dateA);
            case 'oldest': return dateA.localeCompare(dateB);
            case 'highest': return amountB - amountA;
            case 'lowest': return amountA - amountB;
        }
    });

    tableBody.innerHTML = '';
    rows.forEach(r => tableBody.appendChild(r));
    updateTotal();
}

// Function: Clear filters
document.getElementById('clearFilters').addEventListener('click', () => {
    document.getElementById('filterForm').reset();
    tableBody.querySelectorAll('tr').forEach(row => row.style.display = '');
    sortTable('newest');
    updateTotal();
});

// Apply live filtering (instant updates)
filterInputs.forEach(el => el.addEventListener('input', applyFilters));
filterInputs.forEach(el => el.addEventListener('change', applyFilters));

// Sort listener
document.getElementById('sortOption').addEventListener('change', (e) => {
    sortTable(e.target.value);
});

// Function to load transactions
async function loadTransactions() {
    try {
        const response = await fetch('fetchEarning.php');
        const data = await response.json();
        
        if (data.status === 'success') {
            const tableBody = document.getElementById('earningsTable');
            tableBody.innerHTML = ''; // Clear existing rows
            
            data.data.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${item.id}</td>
                    <td>${item.amount}</td>
                    <td><span class="badge ${item.locate === 'Booking' ? 'bg-success' : 'bg-primary'}">${item.locate}</span></td>
                    <td>${item.created_date}</td>
                `;
                tableBody.appendChild(row);
            });
            
            // Apply initial sort and update total
            sortTable('newest');
            updateTotal();
        }
    } catch (error) {
        console.error('Error loading transactions:', error);
    }
}

// Load transactions when page loads
document.addEventListener('DOMContentLoaded', loadTransactions);

// Initial load
sortTable('newest');
updateTotal();
</script>
