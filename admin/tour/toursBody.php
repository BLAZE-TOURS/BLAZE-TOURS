<?php
include_once "fetchTours.php";
?>
<style>
  /* Prevent horizontal scrollbar by allowing wrapping and tighter spacing */
  .table-responsive { overflow-x: visible !important; }
  #datatable-tourType { table-layout: auto !important; width: 100% !important; }
  #datatable-tourType th, #datatable-tourType td {
    white-space: normal !important;
    word-break: break-word !important;
    vertical-align: middle;
    padding: 6px 8px;
    font-size: 0.92rem;
  }
  /* Smaller font / padding on smaller screens */
  @media (max-width: 1280px) {
    #datatable-tourType th, #datatable-tourType td { font-size: 0.84rem; padding: 5px 6px; }
  }

  /* Description expand/collapse styles */
  .review-wrapper {
    position: relative;
    overflow: hidden;
  }
  .review-text {
    display: block;
    transition: max-height 0.28s ease;
    white-space: normal;
    max-height: 48px; /* collapsed height */
    overflow: hidden;
    line-height: 1.35;
    word-break: break-word;
    padding-right: 36px; /* space for button */
    text-align: left;
  }
  .review-text.expanded { /* expanded state handled by JS */ }

  .toggle-review-btn {
    position: absolute;
    top: 6px;
    right: 6px;
    background: transparent;
    border: none;
    font-size: 0.9rem;
    color: #007bff;
    cursor: pointer;
    padding: 4px;
    z-index: 2;
  }

  /* Column width hints (adjust indices as needed) */
  #datatable-tourType td:nth-child(1), #datatable-tourType th:nth-child(1) { max-width: 90px; }
  /* Make Tours Name (2nd column) narrower */
  #datatable-tourType td:nth-child(2), #datatable-tourType th:nth-child(2) {
    max-width: 140px;
    min-width: 120px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
  /* Make Description (3rd column) wider */
  #datatable-tourType td:nth-child(3), #datatable-tourType th:nth-child(3) {
    max-width: 620px;
    min-width: 320px;
    white-space: normal;
    word-break: break-word;
  }
  #datatable-tourType td:nth-child(6), #datatable-tourType th:nth-child(6) { max-width: 120px; } /* adult price */
  #datatable-tourType .btn, #datatable-tourType .badge { white-space: normal; display: inline-block; }
</style>

<div class="content-page mt-5 fade-in">

    <div class="row justify-content-center mt-2">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-center">Tour List</h3>
                    <div class="table-responsive col-12 mx-auto mb-5">
                        <table id="datatable-tourType" class="table table-striped table-bordered table-sm">
                            <thead>
                                <tr class="Table-header">
                                    <th>#ID</th>
                                    <th>Tours Name</th>
                                    <th>Description</th>
                                    <th>Duration</th>
                                    <th>Kids Price</th>
                                    <th>Adult Price</th>
                                    <th>Maximum Adult Count</th>
                                    <th>Maximum Kids Count</th>
                                    <th>Tours Type</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($tours_n > 0) {
                                    while ($row = $tours_rs->fetch_assoc()) {
                                        // Status badge color
                                        $status_badge = '';
                                        if ($row['status_id'] == 1) {
                                            $status_badge = '<span class="badge bg-success">Active</span>';
                                        } else if ($row['status_id'] == 2) {
                                            $status_badge = '<span class="badge bg-danger">Inactive</span>';
                                        } else if ($row['status_id'] == 3) {
                                            $status_badge = '<span class="badge bg-warning">Processing</span>';
                                        }
                                ?>
                                        <tr class="text-center">
                                            <td><?php echo $row["id"]; ?></td>
                                            <td><?php echo htmlspecialchars($row["name"]); ?></td>
                                            <td class="text-start">
                                              <div class="review-wrapper">
                                                <span class="review-text" id="desc-text-<?php echo $row['id']; ?>">
                                                  <?php echo nl2br(htmlspecialchars($row["description"])); ?>
                                                </span>
                                                <button class="toggle-review-btn" type="button" data-id="<?php echo $row['id']; ?>" onclick="toggleDescription(<?php echo $row['id']; ?>)">
                                                  <i class="fas fa-plus"></i>
                                                </button>
                                              </div>
                                            </td>
                                            <td><?php echo htmlspecialchars($row["duration"]); ?></td>
                                            <td><?php echo htmlspecialchars($row["kids_price"]); ?></td>
                                            <td><?php echo htmlspecialchars($row["adult_price"]); ?></td>
                                            <td><?php echo htmlspecialchars($row["maximum_adult_count"]); ?></td>
                                            <td><?php echo htmlspecialchars($row["maximum_kids_count"]); ?></td>
                                            <td><?php echo htmlspecialchars($row["tours_type_name"]); ?></td>
                                            <td><?php echo $status_badge; ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-primary edit-btn" onclick="changeStatusTours(<?php echo $row['id']; ?>);" <?php echo ($row['status_id'] == 3) ? 'disabled' : ''; ?>>
                                                    <i class="fas fa-eye"></i>
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

<!-- Safe DataTables init: enable responsive behavior, disable horizontal scrolling -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    try {
      if (window.jQuery && $.fn.dataTable) {
        if ($('#datatable-tourType').length) {
          $('#datatable-tourType').DataTable({
            responsive: true,
            scrollX: false,
            autoWidth: false,
            lengthChange: false,
            pageLength: 20,
            columnDefs: [
              { orderable: false, targets: -1 }, // disable ordering on Action column
              { targets: 1, width: '140px' },     // Tours Name (2nd col) narrower
              { targets: 2, width: '420px' }      // Description (3rd col) wider
            ]
          });
        }
      }
    } catch (e) {
      console.warn('DataTable init skipped or failed:', e);
    }
  });
</script>
<script>
  // Expand / collapse Description text smoothly
  function toggleDescription(id) {
    try {
      const el = document.getElementById('desc-text-' + id);
      const btn = document.querySelector('[data-id="' + id + '"]');
      if (!el || !btn) return;
      const expanded = el.classList.contains('expanded');

      if (expanded) {
        // collapse
        el.style.maxHeight = '48px';
        el.classList.remove('expanded');
        btn.innerHTML = '<i class="fas fa-plus"></i>';
      } else {
        // expand smoothly to full height then remove maxHeight to allow reflow
        const full = el.scrollHeight;
        el.style.maxHeight = full + 'px';
        el.classList.add('expanded');
        btn.innerHTML = '<i class="fas fa-minus"></i>';
        el.addEventListener('transitionend', function cleanup() {
          if (el.classList.contains('expanded')) el.style.maxHeight = 'none';
          el.removeEventListener('transitionend', cleanup);
        });
      }
    } catch (e) {
      console.error('toggleDescription error', e);
    }
  }
</script>