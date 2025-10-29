<style>
  .review-wrapper {
    position: relative;
    overflow: hidden;
    height: auto;
  }

  .review-text {
    display: block;
    transition: height 0.3s ease;
    white-space: normal;
    height: 50px;
    overflow: hidden;
    margin-right: 30px;
  }

  .toggle-review-btn {
    position: absolute;
    top: 0;
    right: 0;
    background: transparent;
    border: none;
    font-size: 1rem;
    color: #007bff;
    cursor: pointer;
    z-index: 1;
  }

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

  @media (max-width: 1280px) {

    #datatable-Medi th,
    #datatable-Medi td {
      font-size: 0.86rem;
      padding: 5px 6px;
    }
  }

  .btn-group {
    gap: 5px !important;
  }

  .btn-group>.btn {
    border-radius: 4px !important;
  }
</style>

<div class="content-page mt-5 fade-in">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Received Booking List</h5>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table id="datatable-Medi" class="table table-striped table-bordered table-sm">
              <thead>
                <tr class="Table-header text-center">
                  <th>Full Name</th>
                  <th>Mobile</th>
                  <th>Tour Name</th>
                  <th>Tour Date</th>
                  <th>Total Price</th>
                  <td>Payment Status</td>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($booking_rc > 0) {
                  while ($row = $booking_rs->fetch_assoc()) { ?>
                    <tr class="text-center">
                      <td><?= htmlspecialchars($row["name"]) ?></td>
                      <td><?= htmlspecialchars($row["mobile"]) ?></td>
                      <td><?= htmlspecialchars($row["tours_type_name"]) ?></td>
                      <td class="booking-date"><?= htmlspecialchars($row["tourDate"]) ?></td>
                      <td>$ <?= htmlspecialchars($row["total_price_usd"]) ?> (Rs. <?= htmlspecialchars($row["total_price_lkr"]) ?>)</td>
                      <?php
                      $balanceUsd = floatval($row['balance_due_usd']);
                      $balanceLkr = floatval($row['balance_due_lkr']);
                      $status = ($balanceUsd == 0 || $balanceLkr == 0) ? 'Fully Paid' : 'Partial Payment';
                      $badgeClass = ($status === 'Fully Paid') ? 'bg-success' : 'bg-warning';
                      ?>
                      <td><span class="badge <?= htmlspecialchars($badgeClass, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($status, ENT_QUOTES, 'UTF-8') ?></span></td>
                      <td>
                        <div class="btn-group" role="group" style="gap:8px;">
                          <button type="button" class="btn btn-info btn-sm"
                            onclick='bookedDetails(<?php echo htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8'); ?>)'>
                            <i class="fas fa-info-circle"></i> More
                          </button>
                          <a href="https://wa.me/<?= $row["mobile"]; ?>?text=Thank%20You%20<?= urlencode($row["name"]); ?>,%20for%20booking%20your%20tour%20experience%20with%20Blaze%20Tours!"
                            target="_blank" class="btn btn-success btn-sm">
                            <i class="fab fa-whatsapp"></i> Send
                          </a>
                          <button type="button" class="btn btn-primary btn-sm"
                            onclick="confirmArrival('<?= $row['id']; ?>');">
                            <i class="fas fa-check"></i> Confirm
                          </button>
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
            <p><strong>ID:</strong> <span id="booked-id"></span></p>
            <p><strong>Name:</strong> <span id="booked-name"></span></p>
            <p><strong>Mobile:</strong> <span id="booked-mobile"></span></p>
            <p><strong>Email:</strong> <span id="booked-email"></span></p>
            <p><strong>Tour Date:</strong> <span id="booked-tourDate"></span></p>
            <p><strong>Time Slot:</strong> <span id="booked-timeSlot"></span></p>
          </div>
          <div class="col-md-6">
            <p><strong>Adult Count:</strong> <span id="booked-adultCount"></span></p>
            <p><strong>Kids Count:</strong> <span id="booked-kidsCount"></span></p>
            <p><strong>Pickup Location:</strong> <span id="booked-pickup"></span></p>
            <p><strong>Tour Name:</strong> <span id="booked-tourName"></span></p>
            <p><strong>Total Price:</strong> <span id="booked-price"></span></p>
            <p><strong>Advance Paid:</strong> <span id="booked-advance"></span></p>
            <p><strong>Balance Due:</strong> <span id="booked-balance"></span></p>
            <p><strong>Payment Status:</strong> <span id="booked-paymentStatus"></span></p>
            <p><strong>Created At:</strong> <span id="booked-createdAt"></span></p>
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
  function confirmArrival(id) {
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

  // Replace the showDetails function with bookedDetails
  function bookedDetails(data) {
    console.log("bookedDetails data:", data);

    document.getElementById('booked-id').textContent = data.id;
    document.getElementById('booked-name').textContent = data.name;
    document.getElementById('booked-mobile').textContent = data.mobile;
    document.getElementById('booked-email').textContent = data.email;
    document.getElementById('booked-tourDate').textContent = data.tourDate;
    document.getElementById('booked-timeSlot').textContent = data.time_slot;
    document.getElementById('booked-adultCount').textContent = data.numberOfAdultCount;
    document.getElementById('booked-kidsCount').textContent = data.numberOfKidsCount;
    document.getElementById('booked-pickup').textContent = data.pickup_location;
    document.getElementById('booked-tourName').textContent = data.tours_type_name;
    document.getElementById('booked-price').textContent = `$ ${data.total_price_usd} (Rs. ${data.total_price_lkr})`;
    document.getElementById('booked-advance').textContent = `$ ${data.advance_paid_usd} (Rs. ${data.advance_paid_lkr})`;
    document.getElementById('booked-balance').textContent = `$ ${data.balance_due_usd} (Rs. ${data.balance_due_lkr})`;

    // ✅ Auto calculate payment status
    let paymentStatus = (data.balance_due_lkr == 0 || data.balance_due_usd == 0) ?
      "Fully Paid" :
      "Partial Payment";

    document.getElementById('booked-paymentStatus').textContent = paymentStatus;
    document.getElementById('booked-createdAt').textContent = data.created_at;

    const modal = new bootstrap.Modal(document.getElementById('detailsModal'));
    modal.show();
  }
</script>