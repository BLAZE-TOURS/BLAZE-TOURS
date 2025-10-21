<style>
  .review-wrapper {
    position: relative;
    overflow: hidden;
    height: auto;
    /* Allow expansion based on content */
  }

  .review-text {
    display: block;
    transition: height 0.3s ease;
    white-space: normal;
    height: 50px;
    /* Limit height for collapsed state */
    overflow: hidden;
    margin-right: 30px;
    /* Add some space to the right for the button */
  }

  .toggle-review-btn {
    position: absolute;
    top: 0;
    right: 0;
    /* Align it to the right side */
    background: transparent;
    border: none;
    font-size: 1rem;
    color: #007bff;
    cursor: pointer;
    z-index: 1;
    /* Ensure the button stays above the text */
  }
</style>


<div class="content-page mt-5 fade-in">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Closed Booking List</h5>
        </div><!-- end card header -->

        <div class="card-body">
          <div class="table-responsive">
            <table id="datatableMedi" class="table table-striped table-bordered table-sm">
              <thead>
                <tr class="Table-header">
                  <th>#ID</th>
                  <th>Full Name</th>
                  <th>Mobile</th>
                  <th>Email</th>
                  <th>Tour Date</th>
                  <th>Time Slot</th>
                  <th>Adult Count</th>
                  <th>Kids Count</th>
                  <th>Pickup Location</th>
                  <th>Tour Name</th>
                  <th>Total Price</th>
                  <th>Created At</th>
                  <th>Status</th>
                  <th>Send Whatsapp Message</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // use variables from fetchBookingClosed.php
                if (isset($booking_n) && $booking_n > 0) {
                  while ($row = $booking_rs->fetch_assoc()) {
                ?>
                    <tr class="text-center">
                      <td><?php echo htmlspecialchars($row["id"]); ?></td>
                      <td><?php echo htmlspecialchars($row["name"]); ?></td>
                      <td><?php echo htmlspecialchars($row["mobile"]); ?></td>
                      <td><?php echo htmlspecialchars($row["email"]); ?></td>
                      <td class="booking-date"><?php echo htmlspecialchars($row["tourDate"]); ?></td>
                      <td><?php echo htmlspecialchars($row["time_slot"]); ?></td>
                      <td><?php echo (int)$row["numberOfAdultCount"]; ?></td>
                      <td><?php echo (int)$row["numberOfKidsCount"]; ?></td>
                      <td><?php echo htmlspecialchars($row["pickup_location"]); ?></td>
                      <td><?php echo htmlspecialchars($row["tours_type_name"]); ?></td>
                      <td>$ <?php echo htmlspecialchars($row["total_price_usd"]); ?> (Rs. <?php echo htmlspecialchars($row["total_price_lkr"]); ?>)</td>
                      <td><?php echo htmlspecialchars($row["created_at"]); ?></td>
                      <td>
                        <?php
                          $s = (int)$row['status_id'];
                          if ($s === 2) {
                              echo '<span class="badge bg-danger">Closed</span>';
                          } elseif ($s === 3) {
                              echo '<span class="badge bg-warning">Processing</span>';
                          } else {
                              echo '<span class="badge bg-light text-dark">#' . $s . '</span>';
                          }
                        ?>
                      </td>
                      <td>
                        <a href="https://wa.me/<?php echo urlencode($row["mobile"]); ?>?text=Namo%20Buddhaya%20<?php echo urlencode($row["name"]); ?>,Thank%20you%20for%20booking%20the%20Meditation%20program%20at%20Rakkittakanda%20Raja%20Maha%20Viharaya."
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

  // // Date filter for the booking table
  // document.getElementById('filter-date').addEventListener('change', function() {
  //   const selectedDate = this.value;
  //   const rows = document.querySelectorAll('#datatable-buttons tbody tr');
  //   rows.forEach(row => {
  //     const dateCell = row.querySelector('.booking-date');
  //     if (!selectedDate || (dateCell && dateCell.textContent.trim() === selectedDate)) {
  //       row.style.display = '';
  //     } else {
  //       row.style.display = 'none';
  //     }
  //   });
  // });

  // // Clear filter button functionality
  // document.getElementById('clear-filter').addEventListener('click', function() {
  //   document.getElementById('filter-date').value = '';
  //   const rows = document.querySelectorAll('#datatable-buttons tbody tr');
  //   rows.forEach(row => {
  //     row.style.display = '';
  //   });
  // });
</script>