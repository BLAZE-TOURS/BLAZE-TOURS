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

<script src="assets/js/Payout.js"></script>