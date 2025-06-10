<style>.review-wrapper {
  position: relative;
  overflow: hidden;
  height: auto; /* Allow expansion based on content */
}

.review-text {
  display: block;
  transition: height 0.3s ease;
  white-space: normal;
  height: 50px; /* Limit height for collapsed state */
  overflow: hidden;
  margin-right: 30px; /* Add some space to the right for the button */
}

.toggle-review-btn {
  position: absolute;
  top: 0;
  right: 0; /* Align it to the right side */
  background: transparent;
  border: none;
  font-size: 1rem;
  color: #007bff;
  cursor: pointer;
  z-index: 1; /* Ensure the button stays above the text */
}


</style>


<div class="content-page mt-5 fade-in">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card shadow-sm">
        <div class="card-body">
          <h3 class="card-title text-center">Send Email for All</h3>
          <div id="validation-errors" class="alert alert-danger d-none" role="alert"></div>
          <div id="success-message" class="alert alert-success d-none" role="alert"></div>

          <div class="form-group">
            <label for="subject">Subject:</label>
            <input type="text" class="form-control" id="subjectAll" name="subject" required>
          </div>
          <div class="form-group">
            <label for="message">Message:</label>
            <textarea class="form-control" id="messageAll" name="message" rows="4" required></textarea>
          </div>

          <div id="loading-spinner" class="card-body d-none">
            <div class="d-flex justify-content-center">
              <div class="spinner-border m-2" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>
          </div>
          <button type="button" onclick="SendEmailForAll();" class="btn btn-primary col-12 mt-3 mx-auto d-block btn-animate">Send Email For All Subscribers...</button>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Subscribers List</h5>
        </div><!-- end card header -->

        <div class="card-body">
          <div class="table-responsive">
            <table id="datatable-subscribe" class="table table-striped table-bordered dt-responsive nowrap">
              <thead>
                <tr class="Table-header">
                  <th>#ID</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Mobile</th>
                  <th>Email</th>
                  <th>Review</th>
                  <th>Rating</th>
                  <th>DateTime</th>
                  <th>Send Whatsapp Message</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($subscriber_n > 0) {
                  while ($row = $subscriber_rs->fetch_assoc()) {
                ?>
                    <tr class="text-center">
                      <td><?php echo $row["id"]; ?></td>
                      <td><?php echo $row["first_name"]; ?></td>
                      <td><?php echo $row["last_name"]; ?></td>
                      <td><?php echo $row["mobile"]; ?></td>
                      <td><?php echo $row["email"]; ?></td>
                      <td>
                        <div class="review-wrapper">
                          <!-- Button to toggle the review visibility -->
                          <button type="button" class="btn btn-link toggle-review-btn" data-id="<?php echo $row['id']; ?>" onclick="toggleReview(<?php echo $row['id']; ?>)">
                            <i class="fas fa-plus"></i> <!-- Initial "+" icon -->
                          </button>

                          <!-- Review Text -->
                          <span id="review-text-<?php echo $row['id']; ?>" class="review-text">
                            <?php echo nl2br(htmlspecialchars($row['review'])); ?>
                          </span>
                        </div>
                      </td>

                      <td><?php echo $row["rating_star_id"]; ?></td>
                      <td><?php echo $row["date"]; ?></td>
                      <td>
                        <a href="https://wa.me/<?php echo $row["mobile"]; ?>?text=Namo%20Buddhaya%20<?php echo urlencode($row["first_name"]); ?>,%20Thank%20you%20for%20joining%20with%20Rakkithtakanda%20Rajamaha%20Viharaya!"
                          target="_blank"
                          class="btn btn-success btn-sm">
                          Send Message
                        </a>
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
</div>

<script>
function toggleReview(id) {
  const reviewText = document.getElementById('review-text-' + id);
  const button = document.querySelector('[data-id="' + id + '"]');
  
  // Check the current state of the review text and toggle visibility
  if (reviewText.style.height === "auto") {
    reviewText.style.height = "50px"; // Collapse to the original height
    button.innerHTML = '<i class="fas fa-plus"></i>'; // Change to "+" icon
  } else {
    reviewText.style.height = "auto"; // Expand to show full review
    button.innerHTML = '<i class="fas fa-minus"></i>'; // Change to "-" icon
  }
}


</script>

<script>
  $(document).ready(function() {
    $('#datatable-buttons').DataTable({
      responsive: true, // Enable responsiveness
      dom: 'Bfrtip',
      buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    });
  });
</script>
<script src="../admin/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
