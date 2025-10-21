<style>
  .review-wrapper {
    position: relative;
    overflow: hidden;
    height: auto;
  }
  .review-text {
    display: block;
    transition: max-height 0.28s ease;
    white-space: normal;
    max-height: 50px;      /* collapsed */
    overflow: hidden;
    margin-right: 40px;
    word-break: break-word;
    line-height: 1.35;
  }
  .review-text.expanded { /* when expanded we remove the clamp via inline style or class */
    /* no fixed max-height here; JS will set exact px value to allow smooth animation */
  }
  .toggle-review-btn {
    position: absolute;
    top: 6px;
    right: 6px;
    background: transparent;
    border: none;
    font-size: 1rem;
    color: #007bff;
    cursor: pointer;
    z-index: 2;
  }

  /* Table cell adjustments so long text fits and rows grow vertically */
  .table-responsive { overflow-x: hidden !important; }
  #datatable-Message th, #datatable-Message td {
    white-space: normal !important;
    vertical-align: top !important; /* align to top so long messages don't center vertically */
    word-break: break-word !important;
    padding: 8px 10px;
  }
  /* Make message column wider where possible (6th column) */
  #datatable-Message td:nth-child(6), #datatable-Message th:nth-child(6) {
    max-width: 540px;
    min-width: 220px;
  }

  @media (max-width: 992px) {
    #datatable-Message td:nth-child(6), #datatable-Message th:nth-child(6) {
      max-width: 300px;
    }
    .review-text { max-height: 80px; }
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
            <table id="datatable-Message" class="table table-striped table-bordered table-sm">
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
                        <a href="https://wa.me/<?php echo $row["mobile"]; ?>?text=Hello%20<?php echo urlencode($row["fullName"]); ?>,%0A%0AThank%20you%20for%20reaching%20out.%20We%20have%20received%20your%20message%20and%20will%20get%20back%20to%20you%20shortly.%0A%0ABest%20regards,%0ABlaze Tours (Pvt) Ltd."
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
    try {
      const reviewText = document.getElementById('review-text-' + id);
      const button = document.querySelector('[data-id="' + id + '"]');
      if (!reviewText || !button) return;

      const isExpanded = reviewText.classList.contains('expanded');

      if (isExpanded) {
        // collapse
        reviewText.style.maxHeight = '50px';
        reviewText.classList.remove('expanded');
        button.innerHTML = '<i class="fas fa-plus"></i>';
      } else {
        // expand to full content height (smooth animation)
        // set maxHeight to scrollHeight px then mark expanded
        const fullHeight = reviewText.scrollHeight;
        reviewText.style.maxHeight = fullHeight + 'px';
        reviewText.classList.add('expanded');
        button.innerHTML = '<i class="fas fa-minus"></i>';

        // After animation ends, remove inline maxHeight to allow printing / responsive reflow
        reviewText.addEventListener('transitionend', function cleanup() {
          // Only remove if still expanded (prevents shrinking removal)
          if (reviewText.classList.contains('expanded')) {
            reviewText.style.maxHeight = 'none';
          }
          reviewText.removeEventListener('transitionend', cleanup);
        });
      }
    } catch (e) {
      console.error('toggleReview error', e);
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