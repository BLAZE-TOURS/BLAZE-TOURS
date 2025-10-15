<?php
require_once "fetchCloseDays.php";
?>

<div class="content-page mt-5 fade-in" id="CloseDaysContainer">
    <div class="row justify-content-center mt-2">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-center">Close Day List</h3>

                    <!-- Add New Close Day Section -->
                    <div class="mb-4">
                        <h4>Close a Day</h4>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCloseDayModal">
                            <i class="fas fa-plus"></i> Create
                        </button>
                    </div>

                    <!-- Add Close Day Modal -->
                    <div class="modal fade" id="addCloseDayModal" tabindex="-1" aria-labelledby="addCloseDayModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addCloseDayModalLabel">Add Close Day</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="validation-errors-close-day" class="alert alert-danger d-none" role="alert"></div>
                                    <div id="success-message-close-day" class="alert alert-success d-none" role="alert"></div>
                                    <form id="addCloseDayForm">
                                        <div class="mb-3">
                                            <label for="close_day_date" class="form-label">Date</label>
                                            <input type="date" class="form-control" name="date" id="close_day_date" required>
                                        </div>
                                    </form>
                                </div>
                                <div id="loading-spinner-close-day" class="d-none">
                                    <div class="d-flex justify-content-center">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="addCloseDay();" form="addCloseDayForm">Add Close Day</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Existing Close Days Table -->
                    <div class="table-responsive col-12 mx-auto mt-4">
                        <table id="dataTableCloseDays" class="table table-striped table-bordered dt-responsive nowrap">
                            <thead>
                                <tr class="Table-header">
                                    <th>#ID</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="closeDaysTableBody">
                                <!-- Data will be loaded by JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/CloseDays.js"></script>

