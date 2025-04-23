
<div class="content-page mt-5 fade-in">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-body p-5">
                    <h3 class="card-title text-center mb-4">Send Email</h3>
                    <div id="validation-errors1" class="alert alert-danger d-none" role="alert"></div>
                    <div id="success-message1" class="alert alert-success d-none" role="alert"></div>

                    <form id="email-form">
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email Address:</label>
                            <input type="email" class="form-control" id="email1" name="email" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="cc-email" class="form-label">CC:</label>
                            <input type="email" class="form-control" id="cc-email" name="cc-email">
                        </div>
                        <div class="form-group mb-3">
                            <label for="bcc-email" class="form-label">BCC:</label>
                            <input type="email" class="form-control" id="bcc-email" name="bcc-email">
                        </div>
                        <div class="form-group mb-3">
                            <label for="subject" class="form-label">Subject:</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="body-title" class="form-label">Body Title:</label>
                            <input type="text" class="form-control" id="body-title" name="body-title" required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="message" class="form-label">Message:</label>
                            <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                        </div>

                        <div id="loading-spinner1" class="d-none">
                            <div class="d-flex justify-content-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <button type="button" onclick="SendEmail();" class="btn btn-primary col-12 mt-3 mx-auto d-block btn-animate">Send Email</button>
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



