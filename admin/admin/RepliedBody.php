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
  .review-text.expanded { /* expanded state; JS will manage max-height */ }
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

  /* Table: allow wrapping and remove horizontal scrollbar */
  .table-responsive { overflow-x: hidden !important; }
  #datatable-reply { table-layout: auto !important; width:100% !important; }
  #datatable-reply th, #datatable-reply td {
    white-space: normal !important;
    vertical-align: top !important;
    word-break: break-word !important;
    padding: 8px 10px;
    font-size: 0.95rem;
  }

  /* Make message column wider where possible (6th column) */
  #datatable-reply td:nth-child(6), #datatable-reply th:nth-child(6) {
    max-width: 540px;
    min-width: 220px;
  }

  @media (max-width: 992px) {
    #datatable-reply td:nth-child(6), #datatable-reply th:nth-child(6) {
      max-width: 300px;
    }
    .review-text { max-height: 80px; }
  }
</style>

<div class="content-page mt-5 fade-in">
  <div class="row">
    <div class="col-12">
      <!-- Date Selector -->
      
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Replied Message List</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="datatable-reply" class="table table-striped table-bordered table-sm">
              <thead>
                <tr class="Table-header">
                  <th>#ID</th>
                  <th>Full Name</th>
                  <th>Mobile</th>
                  <th>Email</th>
                  <th>Date & Time</th>
                  <th>Message</th>
                  <th>Send Messages</th>
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
                        <a href="https://wa.me/<?php echo htmlspecialchars($row["mobile"]); ?>?text=Namo%20Buddhaya%20<?php echo urlencode($row["fullName"]); ?>,We%20appreciate%20your%20message%20to%20Rakkithtakanda%20Rajamaha%20Viharaya%21"
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

<script>
  // Smooth expand/collapse for long messages
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
        // expand to full content height smoothly
        // set maxHeight to scrollHeight px then mark expanded
        const fullHeight = reviewText.scrollHeight;
        reviewText.style.maxHeight = fullHeight + 'px';
        reviewText.classList.add('expanded');
        button.innerHTML = '<i class="fas fa-minus"></i>';

        // after animation, remove inline maxHeight to allow reflow/responsive
        reviewText.addEventListener('transitionend', function cleanup() {
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

  // Safe DataTables init (if DataTables is available)
  document.addEventListener('DOMContentLoaded', function () {
    try {
      if (window.jQuery && $.fn.dataTable) {
        if ($('#datatable-reply').length) {
          $('#datatable-reply').DataTable({
            responsive: true,
            scrollX: false,
            autoWidth: false,
            lengthChange: false,
            pageLength: 25
          });
        }
      }
    } catch (e) {
      console.warn('DataTable init skipped or failed:', e);
    }
  });
</script>