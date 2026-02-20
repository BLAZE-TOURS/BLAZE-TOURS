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
    max-height: 50px;
    /* collapsed */
    overflow: hidden;
    margin-right: 40px;
    word-break: break-word;
    line-height: 1.35;
  }

  .review-text.expanded {
    /* expanded state; JS will manage max-height */
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

  /* Table: allow wrapping and remove horizontal scrollbar */
  .table-responsive {
    overflow-x: hidden !important;
  }

  #datatable-reply {
    table-layout: auto !important;
    width: 100% !important;
  }

  #datatable-reply th,
  #datatable-reply td {
    white-space: normal !important;
    vertical-align: top !important;
    word-break: break-word !important;
    padding: 8px 10px;
    font-size: 0.95rem;
  }

  /* Make message column wider where possible (6th column) */
  #datatable-reply td:nth-child(6),
  #datatable-reply th:nth-child(6) {
    max-width: 540px;
    min-width: 220px;
  }

  @media (max-width: 992px) {

    #datatable-reply td:nth-child(6),
    #datatable-reply th:nth-child(6) {
      max-width: 300px;
    }

    .review-text {
      max-height: 80px;
    }
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
                        <?php
                        $waText = urlencode("Hello " . $row["fullName"] . ", Your inquiry has been resolved by Blaze Tours (Pvt) Ltd! Thank you for reaching out to us.");
                        ?>

                        <div class="btn-group" role="group" style="gap: 8px;">
                          <button type="button" class="btn btn-info btn-sm" onclick='showRepliedMessageDetails(<?php echo json_encode($row); ?>)'>
                            <i class="fas fa-eye"></i> View
                          </button>

                          <a href="https://wa.me/<?php echo $row["mobile"]; ?>?text=<?php echo $waText; ?>"
                            target="_blank"
                            class="btn btn-success btn-sm">
                            <i class="fab fa-whatsapp"></i> Send
                          </a>
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

<!-- Message Only Modal -->
<div class="modal fade" id="repliedMessageModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-sm">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title"><i class="fas fa-envelope-open-text me-2"></i>Message</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="review-wrapper position-relative">
          <div id="replied-msg-text" class="review-text bg-light rounded p-3" style="max-height: 200px; overflow-y: auto;">
            <!-- message content goes here -->
          </div>
        </div>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fas fa-times"></i> Close
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  function showRepliedMessageDetails(data) {
    // Display only the message
    document.getElementById('replied-msg-text').innerHTML = data.massage ?
      data.massage.replace(/\n/g, '<br>') :
      '<em>No message content</em>';

    const modal = new bootstrap.Modal(document.getElementById('repliedMessageModal'));
    modal.show();
  }
</script>