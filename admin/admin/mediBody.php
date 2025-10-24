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

  /* ---- NEW: responsive table without horizontal scrollbar ---- */
  /* Allow wrapping of cell content and reduce padding to fit more columns */
  .table-responsive {
    overflow-x: visible !important;
  }

  #datatable-Medi {
    table-layout: auto !important;
    width: 100% !important;
  }

  #datatable-Medi th,
  #datatable-Medi td {
    white-space: normal !important;
    word-break: break-word !important;
    vertical-align: middle;
    padding: 6px 8px;
    font-size: 0.92rem;
  }

  /* Optional: reduce font slightly on smaller screens */
  @media (max-width: 1280px) {

    #datatable-Medi th,
    #datatable-Medi td {
      font-size: 0.86rem;
      padding: 5px 6px;
    }
  }

  /* If you want specific columns to be narrower, set max-widths */
  #datatable-Medi td:nth-child(1),
  #datatable-Medi th:nth-child(1) {
    max-width: 120px;
  }

  #datatable-Medi td:nth-child(5),
  #datatable-Medi th:nth-child(5) {
    max-width: 110px;
  }

  /* tourDate */
  #datatable-Medi td:nth-child(11),
  #datatable-Medi th:nth-child(11) {
    max-width: 140px;
  }

  /* total price */

  /* Ensure badges / buttons wrap nicely */
  #datatable-Medi .btn,
  #datatable-Medi .badge {
    white-space: normal;
    display: inline-block;
  }

  /* Add spacing between buttons in button groups */
  .btn-group {
    gap: 5px !important;
  }

  /* Ensure buttons don't have rounded corners on either side when spaced */
  .btn-group > .btn {
    border-radius: 4px !important;
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
          <h5 class="card-title mb-0">Received Booking List</h5>
        </div><!-- end card header -->

        <div class="card-body">
          <div class="table-responsive">
            <table id="datatable-Medi" class="table table-striped table-bordered table-sm">
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
                <?php
                if ($medi_n > 0) {
                  while ($row = $medi_rs->fetch_assoc()) {
                ?>
                    <tr class="text-center">
                      <td><?php echo $row["name"]; ?></td>
                      <td><?php echo $row["mobile"]; ?></td>
                      <td><?php echo $row["tours_type_name"]; ?></td>
                      <td class="booking-date"><?php echo $row["tourDate"]; ?></td>
                      <td>$ <?php echo $row["total_price_usd"]; ?> (Rs. <?php echo $row["total_price_lkr"]; ?>)</td>
                      <td>
                        <div class="btn-group" role="group" style="gap: 5px;">
                          <button type="button" class="btn btn-info btn-sm" onclick="showDetails(<?php echo htmlspecialchars(json_encode($row)); ?>)">
                            <i class="fas fa-info-circle"></i> More
                          </button>
                          <a href="https://wa.me/<?php echo $row["mobile"]; ?>?text=Thank%20You%20<?php echo urlencode($row["name"]); ?>,Thank%20you%20for%20booking%20your%20tour%20experience%20with%20Blaze%20Tours%20%28Pvt%29%20Ltd%21"
                            target="_blank"
                            class="btn btn-success btn-sm">
                            <i class="fab fa-whatsapp"></i> Send
                          </a>
                          <button type="button" class="btn btn-primary btn-sm" onclick="confirmArrival('<?php echo $row['id']; ?>');">
                            <i class="fas fa-check"></i> Confirm
                          </button>
                        </div>
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

<!-- Details Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Booking Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <p><strong>ID:</strong> <span id="modal-id"></span></p>
            <p><strong>Name:</strong> <span id="modal-name"></span></p>
            <p><strong>Mobile:</strong> <span id="modal-mobile"></span></p>
            <p><strong>Email:</strong> <span id="modal-email"></span></p>
            <p><strong>Tour Date:</strong> <span id="modal-tourDate"></span></p>
            <p><strong>Time Slot:</strong> <span id="modal-timeSlot"></span></p>
          </div>
          <div class="col-md-6">
            <p><strong>Adult Count:</strong> <span id="modal-adultCount"></span></p>
            <p><strong>Kids Count:</strong> <span id="modal-kidsCount"></span></p>
            <p><strong>Pickup Location:</strong> <span id="modal-pickup"></span></p>
            <p><strong>Tour Name:</strong> <span id="modal-tourName"></span></p>
            <p><strong>Total Price:</strong> <span id="modal-price"></span></p>
            <p><strong>Created At:</strong> <span id="modal-createdAt"></span></p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

  // Replace the previous confirmArrival implementation with this
  function confirmArrival(id) {
    console.log('confirmArrival called, id=' + id);

    Swal.fire({
      title: 'Are you sure?',
      text: "Has the guest arrived?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, guest arrived!',
      cancelButtonText: 'No'
    }).then((result) => {
      if (result.isConfirmed) {
        fetch('updateTourStatus.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'id=' + encodeURIComponent(id)
          })
          .then(response => response.text())
          .then(data => {
            console.log('updateTourStatus response:', data);
            Swal.fire('Updated!', 'Guest arrival has been confirmed.', 'success')
              .then(() => {
                location.reload();
              });
          })
          .catch(err => {
            console.error('updateTourStatus error:', err);
            Swal.fire('Error', 'Request failed', 'error');
          });
      }
    });
  }

  // Add this function to handle showing details in modal
  function showDetails(data) {
    document.getElementById('modal-id').textContent = data.id;
    document.getElementById('modal-name').textContent = data.name;
    document.getElementById('modal-mobile').textContent = data.mobile;
    document.getElementById('modal-email').textContent = data.email;
    document.getElementById('modal-tourDate').textContent = data.tourDate;
    document.getElementById('modal-timeSlot').textContent = data.time_slot;
    document.getElementById('modal-adultCount').textContent = data.numberOfAdultCount;
    document.getElementById('modal-kidsCount').textContent = data.numberOfKidsCount;
    document.getElementById('modal-pickup').textContent = data.pickup_location;
    document.getElementById('modal-tourName').textContent = data.tours_type_name;
    document.getElementById('modal-price').textContent = `$ ${data.total_price_usd} (Rs. ${data.total_price_lkr})`;
    document.getElementById('modal-createdAt').textContent = data.created_at;

    // Show the modal
    const modal = new bootstrap.Modal(document.getElementById('detailsModal'));
    modal.show();
  }
</script>