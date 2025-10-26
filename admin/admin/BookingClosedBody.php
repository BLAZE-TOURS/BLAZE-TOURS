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
            <table id="datatableMediClosed" class="table table-striped table-bordered table-sm">
              <thead>
                <tr class="Table-header">
                  <th>Full Name</th>
                  <th>Mobile</th>
                  <th>Tour Name</th>
                  <th>Tour Date</th>
                  <th>Total Price</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if (isset($booking_n) && $booking_n > 0) {
                  while ($row = $booking_rs->fetch_assoc()) { ?>
                    <tr class="text-center">
                      <td class="text-start"><?php echo htmlspecialchars($row["name"]); ?></td>
                      <td><?php echo htmlspecialchars($row["mobile"]); ?></td>
                      <td class="text-start"><?php echo htmlspecialchars($row["tours_type_name"]); ?></td>
                      <td class="booking-date"><?php echo htmlspecialchars($row["tourDate"]); ?></td>
                      <td>$ <?php echo htmlspecialchars($row["total_price_usd"]); ?> (Rs. <?php echo htmlspecialchars($row["total_price_lkr"]); ?>)</td>
                      <td>
                        <div class="btn-group" role="group" style="gap:8px;">
                          <button type="button" class="btn btn-info btn-sm"
                            onclick='showDetailsClosed(<?php echo htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8'); ?>)'>
                            <i class="fas fa-info-circle"></i> More
                          </button>
                          <a href="https://wa.me/<?php echo urlencode($row["mobile"]); ?>?text=<?php echo urlencode("Hello ".$row["name"]); ?>"
                            target="_blank" class="btn btn-success btn-sm">
                            <i class="fab fa-whatsapp"></i> Send
                          </a>
                        </div>
                      </td>
                    </tr>
                <?php }
                } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<!-- Details Modal (Closed) -->
<div class="modal fade" id="detailsModalClosed" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Booking Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-md-6">
            <p><strong>Booking ID:</strong> <span id="cl-id"></span></p>
            <p><strong>Name:</strong> <span id="cl-name"></span></p>
            <p><strong>Mobile:</strong> <span id="cl-mobile"></span></p>
            <p><strong>Email:</strong> <span id="cl-email"></span></p>
            <p><strong>Tour Date:</strong> <span id="cl-tourDate"></span></p>
            <p><strong>Time Slot:</strong> <span id="cl-timeSlot"></span></p>
          </div>
          <div class="col-md-6">
            <p><strong>Adults:</strong> <span id="cl-adults"></span></p>
            <p><strong>Kids:</strong> <span id="cl-kids"></span></p>
            <p><strong>Pickup:</strong> <span id="cl-pickup"></span></p>
            <p><strong>Tour:</strong> <span id="cl-tourName"></span></p>
            <p><strong>Total Price:</strong> <span id="cl-price"></span></p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

  function showDetailsClosed(data) {
    document.getElementById('cl-id').textContent = data.id || '-';
    document.getElementById('cl-name').textContent = data.name || '-';
    document.getElementById('cl-mobile').textContent = data.mobile || '-';
    document.getElementById('cl-email').textContent = data.email || '-';
    document.getElementById('cl-tourDate').textContent = data.tourDate || '-';
    document.getElementById('cl-timeSlot').textContent = data.time_slot || '-';
    document.getElementById('cl-adults').textContent = data.numberOfAdultCount ?? '-';
    document.getElementById('cl-kids').textContent = data.numberOfKidsCount ?? '-';
    document.getElementById('cl-pickup').textContent = data.pickup_location || '-';
    document.getElementById('cl-tourName').textContent = data.tours_type_name || '-';
    document.getElementById('cl-price').textContent = ('$ ' + (data.total_price_usd ?? '-') + ' (Rs. ' + (data.total_price_lkr ?? '-') + ')');

    const modal = new bootstrap.Modal(document.getElementById('detailsModalClosed'));
    modal.show();
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