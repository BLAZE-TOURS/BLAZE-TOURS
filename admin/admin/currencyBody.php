<div class="content-page mt-5 fade-in" id="CurrencyContainer">
    <div class="row justify-content-center mt-2">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-center">Currency Exchange List</h3>

                    <div class="modal fade" id="updateCurrencyModal" tabindex="-1" aria-labelledby="updateCurrencyModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateCurrencyModalLabel">Update Currency Rate</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="update-message-currency" class="alert d-none" role="alert"></div>
                                    <form id="updateCurrencyForm">
                                        <input type="hidden" id="currency_id" name="id">

                                        <div class="mb-3">
                                            <label for="currency_name" class="form-label">Currency Code</label>
                                            <input type="text" class="form-control" name="currency" id="currency_name" readonly>
                                        </div>

                                        <div class="mb-3">
                                            <label for="currency_country" class="form-label">Country</label>
                                            <input type="text" class="form-control" name="country" id="currency_country" readonly>
                                        </div>

                                        <div class="mb-3">
                                            <label for="currency_rate" class="form-label">1 LKR =</label>
                                            <input type="number" step="0.0001" class="form-control" name="LKR" id="currency_rate" required>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="updateCurrency();" form="updateCurrencyForm">Update Rate</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive col-12 mx-auto mt-4">
                        <table id="dataTableCurrency" class="table table-striped table-bordered dt-responsive nowrap">
                            <thead>
                                <tr class="Table-header">
                                    <th>#ID</th>
                                    <th>Currency</th>
                                    <th>Country</th>
                                    <th>1 LKR =</th>
                                    <th>Updated On</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="currencyTableBody">
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/Currency.js"></script>