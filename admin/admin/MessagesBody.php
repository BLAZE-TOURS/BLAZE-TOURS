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
          <h5 class="card-title mb-0">Message List</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="datatable-Message" class="table table-striped table-bordered dt-responsive nowrap">
              <thead>
                <tr class="Table-header">
                  <th>#ID</th>
                  <th>Full Name</th>
                  <th>Mobile</th>
                  <th>Email</th>
                  <th>Date & Time</th>
                  <th>Message</th>
                  <th>Send Messages</th>
                  <th>Mark as Read</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // Make sure $msg_rs and $msg_n are available from fetchMessages.php
                if (isset($msg_n) && $msg_n > 0) {
                  while ($row = $msg_rs->fetch_assoc()) {
                ?>
                    <tr class="text-center">
                      <td><?php echo $row["id"]; ?></td>
                      <td><?php echo htmlspecialchars($row["fullName"]); ?></td>
                      <td><?php echo htmlspecialchars($row["mobile"]); ?></td>
                      <td><?php echo htmlspecialchars($row["email"]); ?></td>
                      <td class="message-date"><?php echo $row["dateTime"]; ?></td>
                      <td>
                        <div class="review-wrapper">
                          <span class="review-text" id="review-text-<?php echo $row["id"]; ?>">
                            <?php echo nl2br(htmlspecialchars($row["massage"])); ?>
                          </span>
                          <button class="toggle-review-btn" type="button" data-id="<?php echo $row["id"]; ?>" onclick="toggleReview(<?php echo $row['id']; ?>)">
                            <i class="fas fa-plus"></i>
                          </button>
                        </div>
                      </td>
                      <td>
                        <a href="https://wa.me/<?php echo $row["mobile"]; ?>?text=Namo%20Buddhaya%20<?php echo urlencode($row["fullName"]); ?>,We%20appreciate%20your%20message%20to%20Rakkithtakanda%20Rajamaha%20Viharaya%21"
                          target="_blank"
                          class="btn btn-success btn-sm">
                          Send Message
                        </a>
                      </td>
                      <td>
                        <button class="btn btn-sm btn-primary" onclick="markAsRead(<?php echo $row['id']; ?>);">
                          Mark as Read
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function toggleReview(id) {
    const reviewText = document.getElementById('review-text-' + id);
    const button = document.querySelector('[data-id="' + id + '"]');
    if (reviewText.style.height === "auto") {
      reviewText.style.height = "50px";
      button.innerHTML = '<i class="fas fa-plus"></i>';
    } else {
      reviewText.style.height = "auto";
      button.innerHTML = '<i class="fas fa-minus"></i>';
    }
  }

  // // Date filter for the message table
  // document.getElementById('filter-date').addEventListener('change', function() {
  //   const selectedDate = this.value;
  //   const rows = document.querySelectorAll('#datatable-buttons tbody tr');
  //   rows.forEach(row => {
  //     const dateCell = row.querySelector('.message-date');
  //     if (!selectedDate || (dateCell && dateCell.textContent.trim().startsWith(selectedDate))) {
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

  function markAsRead(id) {
    Swal.fire({
      title: 'Are you sure?',
      text: "Mark this message as read?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, mark as read!',
      cancelButtonText: 'No'
    }).then((result) => {
      if (result.isConfirmed) {
        fetch('updateMessageStatus.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: 'id=' + encodeURIComponent(id)
        })
        .then(response => response.text())
        .then(data => {
          Swal.fire(
            'Updated!',
            'Message has been marked as read.',
            'success'
          ).then(() => {
            location.reload();
          });
        });
      }
    });
  }
</script>