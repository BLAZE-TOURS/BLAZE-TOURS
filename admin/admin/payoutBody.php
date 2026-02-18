<?php
require_once '../connection.php';

// load currencies for modal selector
$currency_rs = Database::search("SELECT id, currency, country, LKR FROM currency ORDER BY id ASC");
$currencies = [];
while ($c = $currency_rs->fetch_assoc()) {
    $currencies[] = $c;
}
?>
<div class="content-page mt-5 fade-in" id="PayoutContainer">
    <div class="row justify-content-center mt-2">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title text-center">All Payouts List</h4>
                    <!-- Add PayNow Section -->
                    <div class="mb-4 d-flex justify-content-between align-items-end flex-wrap gap-3">
                        <div>
                            <h4 class="mb-2">Manual Payment</h4>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPaynowModal">
                                <i class="fas fa-plus"></i> Create
                            </button>
                        </div>
                        <div style="min-width: 220px;">
                            <label for="payoutStatusSelect" class="form-label mb-1">Status Filter</label>
                            <select id="payoutStatusSelect" class="form-select" onchange="filterPayoutRowsByStatus(this.value)">
                                <option value="all">All</option>
                                <option value="success" selected>Success</option>
                                <option value="failed">Failed</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                    </div>

                    <!-- Add PayNow Modal -->
                    <div class="modal fade" id="addPaynowModal" tabindex="-1" aria-labelledby="addPaynowModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form id="addPaynowForm" class="modal-content" onsubmit="return false;">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addPaynowModalLabel">Create PayNow Record</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="paynow-form-errors" class="alert alert-danger d-none"></div>

                                    <div class="mb-3">
                                        <label for="pn_email" class="form-label">Email (optional)</label>
                                        <input type="email" id="pn_email" name="email" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label for="pn_description" class="form-label">Description</label>
                                        <textarea id="pn_description" name="description" class="form-control" rows="2" placeholder="Description (required)" required></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="pn_currency" class="form-label">Currency</label>
                                        <select id="pn_currency" name="currency_id" class="form-select" required>
                                            <?php foreach ($currencies as $c): ?>
                                                <option value="<?= htmlspecialchars($c['id']) ?>"
                                                    data-code="<?= htmlspecialchars($c['currency']) ?>"
                                                    data-rate="<?= htmlspecialchars($c['LKR']) ?>"
                                                    <?= ($c['currency'] === 'LKR') ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($c['currency'] . ' - ' . $c['country']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="pn_amount" class="form-label">Amount (selected currency)</label>
                                        <input type="number" id="pn_amount" name="amount" class="form-control" required min="0.01" step="any">
                                    </div>

                                    <div class="mb-3">
                                        <label for="pn_final" class="form-label">Final Amount (LKR)</label>
                                        <input type="text" id="pn_final" class="form-control" readonly value="LKR 0.00" aria-readonly="true">
                                        <input type="hidden" id="pn_final_value" name="lkr_amount" value="0">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" id="pn_submit" class="btn btn-primary">Add PayNow</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive mt-3">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>Amount (LKR)</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="payoutTableBody">
                                <!-- rows injected by assets/js/Payout.js -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Details modal (Bootstrap 5) -->
<div class="modal fade" id="payoutDetailsModal" tabindex="-1" aria-labelledby="payoutDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="payoutDetailsModalLabel">Payout Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <dl class="row">
                    <dt class="col-sm-4">ID</dt>
                    <dd class="col-sm-8" id="pd_id">-</dd>

                    <dt class="col-sm-4">Email</dt>
                    <dd class="col-sm-8" id="pd_email">-</dd>

                    <dt class="col-sm-4">Description</dt>
                    <dd class="col-sm-8" id="pd_description">-</dd>

                    <dt class="col-sm-4">Currency</dt>
                    <dd class="col-sm-8" id="pd_currency">-</dd>

                    <dt class="col-sm-4">Amount</dt>
                    <dd class="col-sm-8" id="pd_amount">-</dd>

                    <dt class="col-sm-4">Amount (LKR)</dt>
                    <dd class="col-sm-8" id="pd_lkr_amount">-</dd>

                    <dt class="col-sm-4">Status</dt>
                    <dd class="col-sm-8" id="pd_status">-</dd>

                    <dt class="col-sm-4">Created At</dt>
                    <dd class="col-sm-8" id="pd_createdAt">-</dd>
                </dl>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <!-- optional: actions like mark-paid can be added here -->
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 CDN (if not already included site-wide) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="assets/js/Payout.js?v=<?= filemtime(__DIR__ . '/assets/js/Payout.js') ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const currencySelect = document.getElementById('pn_currency');
    const amountInput = document.getElementById('pn_amount');
    const finalDisplay = document.getElementById('pn_final');
    const finalHidden = document.getElementById('pn_final_value');
    const form = document.getElementById('addPaynowForm');
    const submitBtn = document.getElementById('pn_submit');
    const errorBox = document.getElementById('paynow-form-errors');

    function parseRate(opt) {
        if (!opt) return 0;
        const r = parseFloat(opt.getAttribute('data-rate'));
        return isFinite(r) ? r : 0;
    }

    function updateFinal() {
        const opt = currencySelect.options[currencySelect.selectedIndex];
        const rate = parseRate(opt);
        const amt = parseFloat(amountInput.value) || 0;
        const final = amt * rate;
        finalDisplay.value = 'LKR ' + final.toFixed(2);
        finalHidden.value = final.toFixed(2);
    }

    currencySelect.addEventListener('change', updateFinal);
    amountInput.addEventListener('input', updateFinal);

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        errorBox.classList.add('d-none');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Processing...';

        const payload = new FormData(form);

        fetch('addNewPaynow.php', {
            method: 'POST',
            body: payload
        }).then(r => r.json())
        .then(res => {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Add PayNow';
            if (res.success) {
                // close modal and show success
                var modalEl = document.getElementById('addPaynowModal');
                bootstrap.Modal.getInstance(modalEl).hide();

                Swal.fire({
                    icon: 'success',
                    title: 'Created',
                    text: 'PayNow record created (ID: ' + res.id + ').',
                    timer: 2000
                }).then(() => {
                    // reload payout table or page
                    location.reload();
                });
            } else {
                errorBox.textContent = res.message || 'Failed to create record';
                errorBox.classList.remove('d-none');
                Swal.fire({ icon: 'error', title: 'Error', text: res.message || 'Failed to create record' });
            }
        }).catch(err => {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Add PayNow';
            console.error(err);
            Swal.fire({ icon: 'error', title: 'Error', text: 'Request failed' });
        });
    });
});
</script>