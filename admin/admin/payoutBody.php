<div class="content-page mt-5 fade-in" id="PayoutContainer">
    <div class="row justify-content-center mt-2">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-center">Payment Payout List</h3>

                    <!-- Table Section -->
                    <div class="table-responsive col-12 mx-auto mt-4">
                        <table id="dataTablePayout" class="table table-striped table-bordered dt-responsive nowrap">
                            <thead>
                                <tr class="Table-header">
                                    <th>#ID</th>
                                    <th>Email</th>
                                    <th>Currency</th>
                                    <th>Amount</th>
                                    <th>LKR Amount</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody id="payoutTableBody">
                                <!-- Data will be loaded by JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/Payout.js"></script>
