<?php
include_once "fetchTours.php";
?>
<style>
  /* Prevent horizontal scrollbar by allowing wrapping and tighter spacing */
  .table-responsive {
    overflow-x: visible !important;
  }

  #datatable-tourType {
    table-layout: auto !important;
    width: 100% !important;
  }

  #datatable-tourType th,
  #datatable-tourType td {
    white-space: normal !important;
    word-break: break-word !important;
    vertical-align: middle;
    padding: 6px 8px;
    font-size: 0.92rem;
  }

  /* Smaller font / padding on smaller screens */
  @media (max-width: 1280px) {

    #datatable-tourType th,
    #datatable-tourType td {
      font-size: 0.84rem;
      padding: 5px 6px;
    }
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
    max-height: 48px;
    /* collapsed height */
    overflow: hidden;
    line-height: 1.35;
    word-break: break-word;
    padding-right: 36px;
    /* space for button */
    text-align: left;
  }

  .review-text.expanded {
    /* expanded state handled by JS */
  }

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
  /* Remove the tour name width restrictions and allow it to expand */
  #datatable-tourType td:nth-child(2),
  #datatable-tourType th:nth-child(2) {
    min-width: 200px;
    /* minimum width */
    white-space: normal;
    /* allow text wrapping */
    word-break: break-word;
    text-overflow: initial;
  }

  /* Adjust other column widths */
  #datatable-tourType td:nth-child(1),
  #datatable-tourType th:nth-child(1) {
    width: 80px;
  }

  /* ID column */
  #datatable-tourType td:nth-child(3),
  #datatable-tourType th:nth-child(3) {
    width: 100px;
  }

  /* Status column */
  #datatable-tourType td:nth-child(4),
  #datatable-tourType th:nth-child(4) {
    width: 180px;
  }

  /* Action column */

  #datatable-tourType td:nth-child(6),
  #datatable-tourType th:nth-child(6) {
    max-width: 120px;
  }

  /* adult price */
  #datatable-tourType .btn,
  #datatable-tourType .badge {
    white-space: normal;
    display: inline-block;
  }
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
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($tours_n > 0) {
                  while ($row = $tours_rs->fetch_assoc()) {
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
                      <td><?php echo $status_badge; ?></td>
                      <td>
                        <div class="btn-group" role="group" style="gap: 8px;">
                          <button type="button" class="btn btn-info btn-sm"
                            onclick='showTourDetails(<?php echo htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8'); ?>)'>
                            <i class="fas fa-eye"></i> View
                          </button>
                          <button type="button" class="btn btn-warning btn-sm"
                            onclick='openUpdateTourModal(<?php echo htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8'); ?>)'>
                            <i class="fas fa-edit"></i> Update
                          </button>
                          <button class="btn btn-sm btn-primary"
                            onclick="changeStatusTours(<?php echo $row['id']; ?>);"
                            <?php echo ($row['status_id'] == 3) ? 'disabled' : ''; ?>>
                            <i class="fas fa-sync-alt"></i> Change Status
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

<!-- Update Tour Modal (Status and Tour Type are intentionally excluded) -->
<div class="modal fade" id="updateTourModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Tour</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div id="update-tour-errors" class="alert alert-danger d-none" role="alert"></div>
        <form id="updateTourForm">
          <input type="hidden" id="update-tour-id" name="id">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label" for="update-tour-name">Tour Name</label>
              <input type="text" class="form-control" id="update-tour-name" name="name" required>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="update-tour-duration">Duration (Hours)</label>
              <input type="number" min="1" class="form-control" id="update-tour-duration" name="duration" required>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="update-tour-kids-price">Kids Price</label>
              <input type="number" min="0" step="0.01" class="form-control" id="update-tour-kids-price" name="kids_price" required>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="update-tour-adult-price">Adult Price</label>
              <input type="number" min="0" step="0.01" class="form-control" id="update-tour-adult-price" name="adult_price" required>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="update-tour-max-adults">Maximum Adult Count</label>
              <input type="number" min="1" class="form-control" id="update-tour-max-adults" name="maximum_adult_count" required>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="update-tour-max-kids">Maximum Kids Count</label>
              <input type="number" min="1" class="form-control" id="update-tour-max-kids" name="maximum_kids_count" required>
            </div>
            <div class="col-12">
              <label class="form-label" for="update-tour-description">Description</label>
              <textarea class="form-control" id="update-tour-description" name="description" rows="4" required></textarea>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="submit-update-tour-btn" onclick="submitTourUpdate();">Update</button>
      </div>
    </div>
  </div>
</div>

<!-- Tour Details Modal -->
<div class="modal fade" id="tourDetailsModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tour Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-md-6">
            <p><strong>Tour ID:</strong> <span id="tour-id"></span></p>
            <p><strong>Name:</strong> <span id="tour-name"></span></p>
            <p><strong>Type:</strong> <span id="tour-type"></span></p>
            <p><strong>Duration:</strong> <span id="tour-duration"></span> Hours</p>
          </div>
          <div class="col-md-6">
            <p><strong>Adult Price:</strong> $<span id="tour-adult-price"></span></p>
            <p><strong>Kids Price:</strong> $<span id="tour-kids-price"></span></p>
            <p><strong>Max Adults:</strong> <span id="tour-max-adults"></span></p>
            <p><strong>Max Kids:</strong> <span id="tour-max-kids"></span></p>
          </div>
          <div class="col-12">
            <p><strong>Description:</strong></p>
            <div class="border rounded p-3 bg-light mb-3">
              <span id="tour-description"></span>
            </div>
          </div>

          <!-- Time Slots Section -->
          <div class="col-12">
            <p><strong>Time Slots:</strong></p>
            <div id="tour-timeslots" class="d-flex flex-wrap gap-2"></div>
          </div>

          <!-- Highlights Section -->
          <div class="col-12">
            <p><strong>Highlights:</strong></p>
            <div id="tour-highlights" class="d-flex flex-wrap gap-2"></div>
          </div>

          <!-- Locations Section -->
          <div class="col-12">
            <p><strong>Locations & Duration:</strong></p>
            <div id="tour-locations" class="list-group list-group-flush border rounded"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Consolidated script block for Tour Details and DataTable initialization -->
<script>
  let updateTourModalInstance = null;

  function openUpdateTourModal(data) {
    const errorsDiv = document.getElementById('update-tour-errors');
    errorsDiv.classList.add('d-none');
    errorsDiv.innerHTML = '';

    document.getElementById('update-tour-id').value = data.id || '';
    document.getElementById('update-tour-name').value = data.name || '';
    document.getElementById('update-tour-description').value = data.description || '';
    document.getElementById('update-tour-duration').value = data.duration || '';
    document.getElementById('update-tour-kids-price').value = data.kids_price || '';
    document.getElementById('update-tour-adult-price').value = data.adult_price || '';
    document.getElementById('update-tour-max-adults').value = data.maximum_adult_count || '';
    document.getElementById('update-tour-max-kids').value = data.maximum_kids_count || '';

    const modalEl = document.getElementById('updateTourModal');
    updateTourModalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
    updateTourModalInstance.show();
  }

  function submitTourUpdate() {
    const id = document.getElementById('update-tour-id').value;
    const name = document.getElementById('update-tour-name').value.trim();
    const description = document.getElementById('update-tour-description').value.trim();
    const duration = document.getElementById('update-tour-duration').value.trim();
    const kidsPrice = document.getElementById('update-tour-kids-price').value.trim();
    const adultPrice = document.getElementById('update-tour-adult-price').value.trim();
    const maxAdults = document.getElementById('update-tour-max-adults').value.trim();
    const maxKids = document.getElementById('update-tour-max-kids').value.trim();

    const errors = [];
    if (!id || isNaN(id) || Number(id) <= 0) errors.push('Invalid tour id.');
    if (!name) errors.push('Tour Name is required.');
    if (!description) errors.push('Description is required.');
    if (!duration || isNaN(duration) || Number(duration) <= 0) errors.push('Duration must be a positive number.');
    if (!kidsPrice || isNaN(kidsPrice) || Number(kidsPrice) < 0) errors.push('Kids Price must be a non-negative number.');
    if (!adultPrice || isNaN(adultPrice) || Number(adultPrice) < 0) errors.push('Adult Price must be a non-negative number.');
    if (!maxAdults || isNaN(maxAdults) || Number(maxAdults) <= 0) errors.push('Maximum Adult Count must be a positive number.');
    if (!maxKids || isNaN(maxKids) || Number(maxKids) <= 0) errors.push('Maximum Kids Count must be a positive number.');

    const errorsDiv = document.getElementById('update-tour-errors');
    errorsDiv.innerHTML = '';
    errorsDiv.classList.add('d-none');

    if (errors.length > 0) {
      errorsDiv.innerHTML = errors.join('<br>');
      errorsDiv.classList.remove('d-none');
      return;
    }

    const submitBtn = document.getElementById('submit-update-tour-btn');
    submitBtn.disabled = true;

    fetch('../process/updateTourProcess.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
          id: id,
          name: name,
          description: description,
          duration: duration,
          kids_price: kidsPrice,
          adult_price: adultPrice,
          maximum_adult_count: maxAdults,
          maximum_kids_count: maxKids
        })
      })
      .then(response => response.json())
      .then(data => {
        submitBtn.disabled = false;
        if (data.success) {
          if (updateTourModalInstance) {
            updateTourModalInstance.hide();
          }
          if (typeof Swal !== 'undefined') {
            Swal.fire('Updated!', data.message, 'success').then(() => {
              location.reload();
            });
          } else {
            alert(data.message);
            location.reload();
          }
        } else {
          errorsDiv.innerHTML = data.message || 'Failed to update tour.';
          errorsDiv.classList.remove('d-none');
        }
      })
      .catch(() => {
        submitBtn.disabled = false;
        errorsDiv.innerHTML = 'An error occurred while updating the tour.';
        errorsDiv.classList.remove('d-none');
      });
  }

  // Tour details modal handler
  function showTourDetails(data) {
    // Initialize modal if needed
    const modal = new bootstrap.Modal(document.getElementById('tourDetailsModal'));

    // Populate basic fields
    document.getElementById('tour-id').textContent = data.id;
    document.getElementById('tour-name').textContent = data.name;
    document.getElementById('tour-type').textContent = data.tours_type_name;
    document.getElementById('tour-duration').textContent = data.duration;
    document.getElementById('tour-adult-price').textContent = data.adult_price;
    document.getElementById('tour-kids-price').textContent = data.kids_price;
    document.getElementById('tour-max-adults').textContent = data.maximum_adult_count;
    document.getElementById('tour-max-kids').textContent = data.maximum_kids_count;
    document.getElementById('tour-description').innerHTML = data.description ? data.description.replace(/\n/g, '<br>') : '';

    // Populate Time Slots
    const timeSlotsDiv = document.getElementById('tour-timeslots');
    timeSlotsDiv.innerHTML = '';
    if (data.time_slots) {
      data.time_slots.split(',').forEach(time => {
        const badge = document.createElement('span');
        badge.className = 'badge bg-info';
        badge.textContent = time;
        timeSlotsDiv.appendChild(badge);
      });
    } else {
      timeSlotsDiv.innerHTML = '<em>No time slots available</em>';
    }

    // Populate Highlights
    const highlightsDiv = document.getElementById('tour-highlights');
    highlightsDiv.innerHTML = '';
    if (data.highlights) {
      data.highlights.split(',').forEach(highlight => {
        const badge = document.createElement('span');
        badge.className = 'badge bg-success';
        badge.textContent = highlight;
        highlightsDiv.appendChild(badge);
      });
    } else {
      highlightsDiv.innerHTML = '<em>No highlights available</em>';
    }

    // Populate Locations
    const locationsDiv = document.getElementById('tour-locations');
    locationsDiv.innerHTML = '';
    if (data.locations) {
      data.locations.split(',').forEach(loc => {
        const [name, duration] = loc.split('|');
        const item = document.createElement('div');
        item.className = 'list-group-item d-flex justify-content-between align-items-center';
        item.innerHTML = `
          <span>${name}</span>
          <span class="badge bg-info">${duration} mins</span>
        `;
        locationsDiv.appendChild(item);
      });
    } else {
      locationsDiv.innerHTML = '<em>No locations available</em>';
    }

    // Show modal
    modal.show();
  }

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

  // Single DataTable initialization
  document.addEventListener('DOMContentLoaded', function() {
    try {
      if (window.jQuery && $.fn.dataTable) {
        if ($('#datatable-tourType').length) {
          $('#datatable-tourType').DataTable({
            responsive: true,
            scrollX: false,
            autoWidth: true, // changed to true
            lengthChange: false,
            pageLength: 20,
            columnDefs: [{
                orderable: false,
                targets: -1
              }, // disable ordering on Action column
              {
                targets: 1,
                width: null
              }, // removed fixed width for Tours Name
              {
                targets: 2,
                width: '100px'
              } // Status column width
            ]
          });
        }
      }
    } catch (e) {
      console.warn('DataTable init failed:', e);
    }
  });
</script>