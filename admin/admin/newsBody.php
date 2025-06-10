<div class="content-page mt-5 fade-in">

    <div class="row justify-content-center mt-2">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-center">News List</h3>

                    <!-- Add New Company Section -->
                    <div class="mb-4">
                        <h4>Add New News Schedule</h4>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNewsModal">
                            <i class="fas fa-plus"></i> Create
                        </button>
                    </div>

                    <!-- Add Meditation Type Modal -->
                    <div class="modal fade" id="addNewsModal" tabindex="-1" aria-labelledby="addNewsModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addNewsModalLabel">Add New News Schedule</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="validation-errors-news" class="alert alert-danger d-none" role="alert"></div>
                                    <div id="success-message-news" class="alert alert-success d-none" role="alert"></div>
                                    <form id="addNewsForm" enctype="multipart/form-data">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label for="news_name" class="form-label">News Schedule Name</label>
                                                <input type="text" class="form-control" name="news_name" id="news_name" required>
                                            </div>

                                            <div class="col-12">
                                                <label for="news_start_date" class="form-label">Start Date</label>
                                                <input type="date" class="form-control" name="news_start_date" id="news_start_date" required>
                                            </div>
                                            <div class="col-12">
                                                <label for="news_end_date" class="form-label">End Date</label>
                                                <input type="date" class="form-control" name="news_end_date" id="news_end_date" required>
                                            </div>
                                            <div class="col-12">
                                                <label for="news_description" class="form-label">Description</label>
                                                <textarea class="form-control" name="news_description" id="news_description" rows="3" required></textarea>
                                            </div>
                                            <div class="col-12">
                                                <label for="news_image" class="form-label">Image</label>
                                                <input type="file" class="form-control" name="news_image" id="news_image" accept="image/*" onchange="previewImage(event, 'news_image_preview')" required>
                                                <img id="news_image_preview" src="#" alt="Image Preview" style="display:none;max-width:100px;margin-top:10px;" />
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div id="loading-spinner-news" class="d-none">
                                    <div class="d-flex justify-content-center">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="addNews();" form="addNewsTypeForm">Add Schedule</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Update Meditation Type Modal -->
                    <div class="modal fade" id="updateNewsModal" tabindex="-1" aria-labelledby="updateNewsModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateNewsModalLabel">Update News Schedule</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="validation-errors-news-update" class="alert alert-danger d-none" role="alert"></div>
                                    <div id="success-message-news-update" class="alert alert-success d-none" role="alert"></div>
                                    <form id="updateNewsTypeForm" enctype="multipart/form-data">
                                        <input type="hidden" name="id" id="update_news_id">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label for="update_news_name" class="form-label">News Schedule Name</label>
                                                <input type="text" class="form-control" name="news_name" id="update_news_name" required>
                                            </div>

                                            <div class="col-12">
                                                <label for="update_news_start_date" class="form-label">Start Date</label>
                                                <input type="date" class="form-control" name="news_start_date" id="update_news_start_date" required>
                                            </div>
                                            <div class="col-12">
                                                <label for="update_news_end_date" class="form-label">End Date</label>
                                                <input type="date" class="form-control" name="news_end_date" id="update_news_end_date" required>
                                            </div>
                                            <div class="col-12">
                                                <label for="update_news_description" class="form-label">Description</label>
                                                <textarea class="form-control" name="news_description" id="update_news_description" rows="3" required></textarea>
                                            </div>
                                            <div class="col-12">
                                                <label for="update_news_image" class="form-label">Image</label>
                                                <input type="file" class="form-control" name="news_image" id="update_news_image" accept="image/*" onchange="previewImage(event, 'update_news_image_preview')">
                                                <img id="update_news_image_preview" src="#" alt="Image Preview" style="display:none;max-width:100px;margin-top:10px;" />
                                                <div id="current-image-container" class="mt-2"></div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div id="loading-spinner-news-update" class="d-none">
                                    <div class="d-flex justify-content-center">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="submitUpdateNews();">Update Meditation Schedule</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Existing Company List Table -->
                    <div class="table-responsive col-12 mx-auto">
                        <table id="datatable-news" class="table table-striped table-bordered dt-responsive nowrap">
                            <thead>
                                <tr class="Table-header">
                                    <th>#ID</th>
                                    <th>News Name</th>
                                    <th>Description</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($mediType_n > 0) {
                                    while ($row = $mediType_rs->fetch_assoc()) {
                                ?>
                                        <tr class="text-center">
                                            <td><?php echo $row["id"]; ?></td>
                                            <td><?php echo $row["title"]; ?></td>
                                            <td>
                                                <?php
                                                $desc = $row["description"];
                                                $desc_lines = wordwrap($desc, 40, "<br>", true);
                                                echo $desc_lines;
                                                ?>
                                            </td>
                                            <td><?php echo $row["date_time_start"]; ?></td>
                                            <td><?php echo $row["date_time_end"]; ?></td>
                                            <td>
                                                <?php
                                                $fileUrl = $row["img_url"];
                                                $filePath = "images/news/" . $fileUrl; // Corrected path
                                                $fileExt = strtolower(pathinfo($fileUrl, PATHINFO_EXTENSION));
                                                if (in_array($fileExt, ['jpg', 'jpeg', 'png'])) {
                                                    // Show image thumbnail, clickable to open full image
                                                    echo '<a href="' . $filePath . '" target="_blank">';
                                                    echo '<img src="' . $filePath . '" alt="img" style="max-width:70px;max-height:70px;border-radius:4px;border:1px solid #ccc;box-shadow:0 2px 6px rgba(0,0,0,0.1);">';
                                                    echo '</a><br>';
                                                } elseif ($fileExt === 'pdf') {
                                                    // Show PDF icon, clickable to open PDF
                                                    echo '<a href="' . $filePath . '" target="_blank" style="display:inline-block;">';
                                                    echo '<img src="https://cdn.jsdelivr.net/gh/edent/SuperTinyIcons/images/svg/pdf.svg" alt="PDF" style="width:32px;height:32px;vertical-align:middle;">';
                                                    echo '</a><br>';
                                                    echo '<small>' . htmlspecialchars($fileUrl) . '</small>';
                                                } else {
                                                    // Just show the file name as fallback
                                                    echo htmlspecialchars($fileUrl);
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-success edit-btn" onclick="updateNews(<?php echo $row['id']; ?>);">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger delete-btn" onclick="deleteNews(<?php echo $row['id']; ?>);">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                <?php
                                    }
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

<!-- 
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
</script> -->
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

    function submitUpdateNews() {
        // Gather form data
        var formData = new FormData(document.getElementById("updateNewsTypeForm"));

        // Show loading spinner
        document.getElementById("loading-spinner-news-update").classList.remove("d-none");

        // Send AJAX request to server
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "your_update_news_endpoint.php", true); // Replace with your server endpoint
        xhr.onload = function() {
            // Hide loading spinner
            document.getElementById("loading-spinner-news-update").classList.add("d-none");

            if (xhr.status === 200) {
                // Success - parse and handle the response
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    // Update successful, show success message
                    document.getElementById("success-message-news-update").innerText = response.message;
                    document.getElementById("success-message-news-update").classList.remove("d-none");

                    // Optionally, update the table row with new data
                    // updateTableRow(response.data);

                    // Close the modal after a short delay
                    setTimeout(function() {
                        // Before hiding the modal, blur the focused element
                        document.activeElement.blur();
                        var modal = bootstrap.Modal.getInstance(document.getElementById('updateNewsModal'));
                        modal.hide();
                    }, 1000);
                } else {
                    // Update failed, show error message
                    document.getElementById("validation-errors-news-update").innerText = response.message;
                    document.getElementById("validation-errors-news-update").classList.remove("d-none");
                }
            } else {
                // Server error, show generic error message
                document.getElementById("validation-errors-news-update").innerText = "An error occurred. Please try again.";
                document.getElementById("validation-errors-news-update").classList.remove("d-none");
            }
        };
        xhr.send(formData);
    }
</script>