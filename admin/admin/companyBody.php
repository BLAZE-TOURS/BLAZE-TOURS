<div class="content-page mt-5 fade-in">

    <div class="row justify-content-center mt-2">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-center">Company List</h3>

                    <!-- Add New Company Section -->
                    <div class="mb-4">
                        <h4>Add New Company</h4>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCompanyModal">
                            <i class="fas fa-plus"></i> Create
                        </button>
                    </div>

                    <!-- Add Company Modal -->
                    <div class="modal fade" id="addCompanyModal" tabindex="-1" aria-labelledby="addCompanyModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addCompanyModalLabel">Add New Company</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="validation-errors-company" class="alert alert-danger d-none" role="alert"></div>
                                    <div id="success-message-company" class="alert alert-success d-none" role="alert"></div>
                                    <form id="addCompanyForm">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label for="company_name" class="form-label">Company Name</label>
                                                <input type="text" class="form-control" placeholder="Company Name" name="company_name" id="company_name" required>
                                            </div>
                                            <div class="col-12">
                                                <label for="website" class="form-label">Website</label>
                                                <input type="text" class="form-control" placeholder="Website" name="website" id="website" required>
                                            </div>
                                            <div class="col-12">
                                                <label for="location" class="form-label">Location</label>
                                                <input type="text" class="form-control" placeholder="Location" name="location" id="location" required>
                                            </div>
                                            <div class="col-6 mt-2">
                                                <label for="contact1" class="form-label">Contact1</label>
                                                <input type="text" class="form-control" placeholder="Contact1" name="contact1" id="contact1" required>
                                            </div>
                                            <div class="col-6 mt-2">
                                                <label for="contact2" class="form-label">Contact2</label>
                                                <input type="text" class="form-control" placeholder="Contact2" name="contact2" id="contact2" required>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" placeholder="Email" name="email" id="email" required>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <label for="copywrite" class="form-label">Copywrite</label>
                                                <textarea class="form-control" placeholder="Copywrite" name="copywrite" id="copywrite" required></textarea>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <label for="facebook" class="form-label">Facebook</label>
                                                <input type="text" class="form-control" placeholder="Facebook" name="facebook" id="facebook" required>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <label for="insta" class="form-label">Instagram</label>
                                                <input type="text" class="form-control" placeholder="Instagram" name="insta" id="insta" required>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <label for="yt" class="form-label">YouTube</label>
                                                <input type="text" class="form-control" placeholder="YouTube" name="yt" id="yt" required>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <label for="logo" class="form-label">Logo</label>
                                                <input type="file" class="form-control" name="logo" id="logo" onchange="previewImage(event, 'logo-preview')">
                                                <img id="logo-preview" src="#" alt="Logo Preview" style="width: 100px; height: auto; margin-top: 10px; display: none;">
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div id="loading-spinner-company" class="d-none">
                                    <div class="d-flex justify-content-center">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="addCompany();" form="addCompanyForm">Add Company</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Update Company Modal -->
                    <div class="modal fade" id="updateCompanyModal" tabindex="-1" aria-labelledby="updateCompanyModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateCompanyModalLabel">Update Company</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="validation-errors-company-update" class="alert alert-danger d-none" role="alert"></div>
                                    <div id="success-message-company-update" class="alert alert-success d-none" role="alert"></div>
                                    <form id="updateCompanyForm">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label for="company_name_update" class="form-label">Company Name</label>
                                                <input type="text" class="form-control" placeholder="Company Name" name="company_name" id="company_name_update" required>
                                            </div>
                                            <div class="col-12">
                                                <label for="website_update" class="form-label">Website</label>
                                                <input type="text" class="form-control" placeholder="Website" name="website" id="website_update" required>
                                            </div>
                                            <div class="col-12">
                                                <label for="location_update" class="form-label">Location</label>
                                                <input type="text" class="form-control" placeholder="Location" name="location" id="location_update" required>
                                            </div>
                                            <div class="col-6 mt-2">
                                                <label for="contact1_update" class="form-label">Contact1</label>
                                                <input type="text" class="form-control" placeholder="Contact1" name="contact1" id="contact1_update" required>
                                            </div>
                                            <div class="col-6 mt-2">
                                                <label for="contact2_update" class="form-label">Contact2</label>
                                                <input type="text" class="form-control" placeholder="Contact2" name="contact2" id="contact2_update" required>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <label for="email_update" class="form-label">Email</label>
                                                <input type="email" class="form-control" placeholder="Email" name="email" id="email_update" required>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <label for="copywrite_update" class="form-label">Copywrite</label>
                                                <textarea class="form-control" placeholder="Copywrite" name="copywrite" id="copywrite_update" required></textarea>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <label for="facebook_update" class="form-label">Facebook</label>
                                                <input type="text" class="form-control" placeholder="Facebook" name="facebook" id="facebook_update" required>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <label for="insta_update" class="form-label">Instagram</label>
                                                <input type="text" class="form-control" placeholder="Instagram" name="insta" id="insta_update" required>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <label for="yt_update" class="form-label">YouTube</label>
                                                <input type="text" class="form-control" placeholder="YouTube" name="yt" id="yt_update" required>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <label for="logo_update" class="form-label">Logo</label>
                                                <input type="file" class="form-control" name="logo" id="logo_update" onchange="previewImage(event, 'logo-preview-update')">
                                                <img id="logo-preview-update" src="#" alt="Logo Preview" style="width: 100px; height: auto; margin-top: 10px; display: none;">
                                            </div>

                                        </div>
                                    </form>
                                </div>

                                <div id="loading-spinner-company-update" class="d-none">
                                    <div class="d-flex justify-content-center">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="updateCompanyButton" disabled>Update Company</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Existing Company List Table -->
                    <div class="table-responsive col-12 mx-auto">
                        <table id="fixed-header-datatable" class="table table-striped table-bordered dt-responsive nowrap">
                            <thead>
                                <tr class="Table-header">
                                    <th>#ID</th>
                                    <th>Company Name</th>
                                    <th>Logo</th>
                                    <th>Website</th>
                                    <th>Location</th>
                                    <th>Contact</th>
                                    <th>Contact2</th>
                                    <th>Email</th>
                                    <th>Copywrite</th>
                                    <th>Facebook</th>
                                    <th>Instagram</th>
                                    <th>YouTube</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($company_n > 0) {
                                    while ($row = $company_rs->fetch_assoc()) {
                                ?>
                                        <tr class="text-center">
                                            <td><?php echo $row["id"]; ?></td>
                                            <td><?php echo $row["name"]; ?></td>
                                            <td><img src="<?php echo $row["url"]; ?>" alt="Company Logo" style="width: 50px; height: auto;"></td>
                                            <td><?php echo $row["website"]; ?></td>
                                            <td><?php echo $row["location"]; ?></td>
                                            <td><?php echo $row["contact1"]; ?></td>
                                            <td><?php echo $row["contact2"]; ?></td>
                                            <td><?php echo $row["email"]; ?></td>
                                            <td><?php echo $row["copywrite"]; ?></td>
                                            <td><?php echo $row["facebook"]; ?></td>
                                            <td><?php echo $row["insta"]; ?></td>
                                            <td><?php echo $row["yt"]; ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-success edit-btn" onclick="updateCompany(<?php echo $row['id']; ?>);">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger delete-btn" onclick="deleteCompany(<?php echo $row['id']; ?>);">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='12' class='text-center'>No Company found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(event, previewId) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById(previewId);
            output.src = reader.result;
            output.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>