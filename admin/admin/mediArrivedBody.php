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
      <!-- Date Selector -->
      <!-- <div class="mb-3">
        <label for="filter-date" class="form-label"></label>
        <input type="date" id="filter-date" class="form-control" style="max-width: 250px;">
        <button type="button" id="clear-filter" class="btn btn-secondary ms-2">Clear</button>
      </div> -->
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Arrived Booking List</h5>
        </div><!-- end card header -->

        <div class="card-body">
          <div class="table-responsive">
            <table id="datatableMedi" class="table table-striped table-bordered table-sm">
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
                <?php if ($medi_n > 0) {
                  while ($row = $medi_rs->fetch_assoc()) { ?>
                    <tr class="text-center">
                      <td class="text-start"><?php echo htmlspecialchars($row["name"]); ?></td>
                      <td><?php echo htmlspecialchars($row["mobile"]); ?></td>
                      <td class="text-start"><?php echo htmlspecialchars($row["tours_type_name"]); ?></td>
                      <td class="booking-date"><?php echo htmlspecialchars($row["tourDate"]); ?></td>
                      <td>$ <?php echo htmlspecialchars($row["total_price_usd"]); ?> (Rs. <?php echo htmlspecialchars($row["total_price_lkr"]); ?>)</td>
                      <td>
                        <div class="btn-group" role="group" style="gap:8px;">
                          <button type="button" class="btn btn-info btn-sm"
                            onclick='showDetailsArrived(<?php echo htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8'); ?>)'>
                            <i class="fas fa-info-circle"></i> More
                          </button>
                          <a href="https://wa.me/<?php echo urlencode($row["mobile"]); ?>?text=<?php echo urlencode('We hope you enjoyed your tour! Please share your experience on our website — https://blaze-tours.com/user/tours'); ?>"
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

<!-- Details Modal (Arrived) -->
<div class="modal fade" id="detailsModalArrived" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Booking Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-md-6">
            <p><strong>Booking ID:</strong> <span id="arr-id"></span></p>
            <p><strong>Name:</strong> <span id="arr-name"></span></p>
            <p><strong>Mobile:</strong> <span id="arr-mobile"></span></p>
            <p><strong>Email:</strong> <span id="arr-email"></span></p>
            <p><strong>Tour Date:</strong> <span id="arr-tourDate"></span></p>
            <p><strong>Time Slot:</strong> <span id="arr-timeSlot"></span></p>
            <p><strong>Pickup:</strong> <span id="arr-pickup"></span></p>
          </div>
          <div class="col-md-6">
            <p><strong>Adults:</strong> <span id="arr-adults"></span></p>
            <p><strong>Kids:</strong> <span id="arr-kids"></span></p>
            <p><strong>Tour:</strong> <span id="arr-tourName"></span></p>
            <p><strong>Total Price:</strong> <span id="arr-price"></span></p>
            <p><strong>Advance Paid:</strong> <span id="arr-advance"></span></p>
            <p><strong>Balance Due:</strong> <span id="arr-balance"></span></p>
            <p><strong>Payment Status:</strong> <span id="arr-paymentStatus"></span></p>
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

  function showDetailsArrived(data) {
    // populate modal fields
    document.getElementById('arr-id').textContent = data.id || '-';
    document.getElementById('arr-name').textContent = data.name || '-';
    document.getElementById('arr-mobile').textContent = data.mobile || '-';
    document.getElementById('arr-email').textContent = data.email || '-';
    document.getElementById('arr-tourDate').textContent = data.tourDate || '-';
    document.getElementById('arr-timeSlot').textContent = data.time_slot || '-';
    document.getElementById('arr-adults').textContent = data.numberOfAdultCount ?? '-';
    document.getElementById('arr-kids').textContent = data.numberOfKidsCount ?? '-';
    document.getElementById('arr-pickup').textContent = data.pickup_location || '-';
    document.getElementById('arr-tourName').textContent = data.tours_type_name || '-';
    document.getElementById('arr-price').textContent = ('$ ' + (data.total_price_usd ?? '-') + ' (Rs. ' + (data.total_price_lkr ?? '-') + ')');
    document.getElementById('arr-advance').textContent = `$ ${data.advance_paid_usd} (Rs. ${data.advance_paid_lkr})`;
    document.getElementById('arr-balance').textContent = `$ ${data.balance_due_usd} (Rs. ${data.balance_due_lkr})`;

    let paymentStatus = (data.balance_due_lkr == 0 || data.balance_due_usd == 0) ?
      "Fully Paid" :
      "Partial Payment";

    document.getElementById('arr-paymentStatus').textContent = paymentStatus;

    const modal = new bootstrap.Modal(document.getElementById('detailsModalArrived'));
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