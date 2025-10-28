<?php
require_once "fetchCloseDays.php";
?>

<div class="content-page mt-5 fade-in" id="AdvanceRateContainer">
    <div class="row justify-content-center mt-2">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-center">Advance Rate</h3>

                    <div class="row mt-4">
                        <div class="col-md-6 mx-auto">
                            <div class="form-group">
                                <label for="rateValue" class="form-label">Advance Rate (%)</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="rateValue" 
                                           min="0" max="100" required>
                                    <button class="btn btn-primary" onclick="updateRate()">
                                        Update Rate
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/AdvanceRate.js"></script>

