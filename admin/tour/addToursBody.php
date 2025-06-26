<div class="content-page mt-5 fade-in">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-body p-5">
                    <h3 class="card-title text-center mb-4">Add Tour</h3>
                    <div id="validation-errors1" class="alert alert-danger d-none" role="alert"></div>
                    <div id="success-message1" class="alert alert-success d-none" role="alert"></div>

                    <form id="email-form">
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Tour Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="cc-email" class="form-label">Description</label>
                            <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="bcc-email" class="form-label">Duration</label>
                            <input type="number" class="form-control" id="Duration" name="Duration">
                        </div>
                        <div class="form-group mb-3">
                            <label for="subject" class="form-label">Kids Price:</label>
                            <input type="number" class="form-control" id="subject" name="subject" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="body-title" class="form-label">Maximum People Count</label>
                            <input type="number" class="form-control" id="body-title" name="body-title" required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="message" class="form-label">Tour Type</label>
                            <section>
                                <select class="form-select" id="tourType" name="tourType" required>
                                    <option value="" disabled selected>Select Tour Type</option>
                                    <?php
                                    include '../tour/fetchToursTypeForAdd.php';
                                    foreach ($toursType as $type) {
                                        echo "<option value='{$type['id']}'>{$type['name']}</option>";
                                    }
                                    ?>
                                </select>
                            </section>
                        </div>

                        <div id="loading-spinner1" class="d-none">
                            <div class="d-flex justify-content-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <button type="button" onclick="" class="btn btn-primary col-12 mt-3 mx-auto d-block btn-animate">Add Tour</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .content-page {
        animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .btn-animate {
        transition: background-color 0.3s, transform 0.3s;
    }

    .btn-animate:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    .card {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    }

    .form-control {
        border-radius: 0.25rem;
    }

    .form-label {
        font-weight: bold;
    }
</style>



