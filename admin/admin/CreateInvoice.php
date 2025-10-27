<?php
require_once '../connection.php';

// AJAX endpoint: return time slots for a tour (used by JS)
if (isset($_GET['action']) && $_GET['action'] === 'get_times' && isset($_GET['tour_id'])) {
    $tourId = intval($_GET['tour_id']);
    $times = [];
    if ($tourId > 0) {
        $rs = Database::search(
            "SELECT t.id AS time_id, t.timeslot
             FROM idx_time ix
             JOIN `time` t ON ix.time_id = t.id
             WHERE ix.tour_id = $tourId
             ORDER BY t.timeslot ASC"
        );
        if ($rs) {
            while ($r = $rs->fetch_assoc()) $times[] = $r;
        }
    }
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'times' => $times]);
    exit;
}

// Fetch active tours (status_id = 1)
$tours = [];
$t_rs = Database::search("SELECT id, name, duration, kids_price, adult_price, maximum_adult_count, maximum_kids_count FROM tour  ORDER BY id DESC");
if ($t_rs) {
    while ($t = $t_rs->fetch_assoc()) $tours[] = $t;
}

// Get USD rate from currency table
$usd_rate = 320.0; // fallback default
$rate_rs = Database::search("SELECT LKR FROM currency WHERE id = 1 AND currency = 'USD' LIMIT 1");
if ($rate_rs && $rate_rs->num_rows > 0) {
    $rate_row = $rate_rs->fetch_assoc();
    $usd_rate = (float)$rate_row['LKR'];
}
?>

<div class="content-page mt-5 fade-in" id="CreateInvoiceContainer">
    <div class="row justify-content-center mt-2">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">

                    <style>
                        .counter {
                            display: flex;
                            gap: 8px;
                            align-items: center;
                        }

                        .counter button {
                            width: 36px;
                        }

                        .summary-row {
                            display: flex;
                            justify-content: space-between;
                            padding: 6px 0;
                        }

                        .card-inner {
                            border-radius: 8px;
                        }
                    </style>

                    <div class="card-inner">
                        <h4 class="mb-3">Create Document</h4>

                        <form id="invoiceForm" onsubmit="return false;" novalidate>
                            <!-- Document Type -->
                            <div class="mb-3">
                                <label class="form-label">Document Type *</label>
                                <div class="d-flex gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="documentType" id="documentInvoice" value="0" checked>
                                        <label class="form-check-label" for="documentInvoice">
                                            Invoice
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="documentType" id="documentCotention" value="1">
                                        <label class="form-check-label" for="documentCotention">
                                            Cotention Note
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Tour selector -->
                            <div class="mb-3">
                                <label class="form-label">Select Tour</label>
                                <select id="tourSelect" class="form-select" required>
                                    <option value="">-- Select tour --</option>
                                    <?php foreach ($tours as $t): ?>
                                        <option value="<?= (int)$t['id'] ?>"
                                            data-duration="<?= (int)$t['duration'] ?>"
                                            data-adult="<?= (float)$t['adult_price'] ?>"
                                            data-kids="<?= (float)$t['kids_price'] ?>"
                                            data-maxadult="<?= (int)$t['maximum_adult_count'] ?>"
                                            data-maxkids="<?= (int)$t['maximum_kids_count'] ?>">
                                            <?= htmlspecialchars($t['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- dynamic fields -->
                            <div id="tourFields" style="display:none;">

                                <!-- Date -->
                                <div class="mb-3">
                                    <label class="form-label">Select Date *</label>
                                    <input type="date" id="tourDate" class="form-control" required>
                                </div>

                                <!-- Counters -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Adults *</label>
                                        <div class="counter">
                                            <button type="button" id="adultMinus" class="btn btn-outline-secondary">-</button>
                                            <input type="number" id="adultCount" class="form-control text-center" value="1" min="1" readonly style="max-width:100px;">
                                            <button type="button" id="adultPlus" class="btn btn-outline-secondary">+</button>
                                            <small class="text-muted ms-2" id="adultLimitText"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Children</label>
                                        <div class="counter">
                                            <button type="button" id="childMinus" class="btn btn-outline-secondary">-</button>
                                            <input type="number" id="childCount" class="form-control text-center" value="0" min="0" readonly style="max-width:100px;">
                                            <button type="button" id="childPlus" class="btn btn-outline-secondary">+</button>
                                            <small class="text-muted ms-2" id="childLimitText"></small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Time slots -->
                                <div class="mb-3">
                                    <label class="form-label">Time Slot *</label>
                                    <div id="timeSlots" class="row gy-2"></div>
                                    <div id="noTimes" class="text-muted small mt-2" style="display:none;">No time slots configured for this tour.</div>
                                </div>

                                <!-- Contact -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Full Name *</label>
                                        <input type="text" id="fullName" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email *</label>
                                        <input type="text" id="Cutomeremail" class="form-control" required autocomplete="off">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Phone *</label>
                                    <input id="phoneInput" type="tel" class="form-control" required>
                                </div>

                                <!-- Payment Status -->
                                <div class="mb-3">
                                    <label class="form-label">Payment Status *</label>
                                    <div class="d-flex gap-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="paymentStatus" id="statusUnpaid" value="0" checked>
                                            <label class="form-check-label" for="statusUnpaid">
                                                Unpaid
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="paymentStatus" id="statusPaid" value="1">
                                            <label class="form-check-label" for="statusPaid">
                                                Paid
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Summary -->
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h6>Summary</h6>
                                        <div class="summary-row">
                                            <div>Subtotal (USD)</div>
                                            <div id="subtotalUSD">$0.00</div>
                                        </div>
                                        <div class="summary-row">
                                            <div>Subtotal (LKR)</div>
                                            <div id="subtotalLKR">Rs. 0.00</div>
                                        </div>

                                        <!-- Discount (LKR) -->
                                        <div class="mb-2" style="max-width:240px;">
                                            <label class="form-label small">Discount (LKR)</label>
                                            <input type="number" id="discountLKR" class="form-control" value="0" min="0" step="0.01" />
                                        </div>

                                        <!-- Final total highlighted -->
                                        <div class="summary-row" style="font-size:1.25rem; font-weight:700; margin-top:8px;">
                                            <div>Final Total (LKR)</div>
                                            <div id="finalTotalLKR" style="color:#0d6efd;">Rs. 0.00</div>
                                        </div>

                                        <div class="summary-row">
                                            <div>Tour</div>
                                            <div id="summaryTour">-</div>
                                        </div>
                                        <div class="summary-row">
                                            <div>Date</div>
                                            <div id="summaryDate">-</div>
                                        </div>
                                        <div class="summary-row">
                                            <div>Time</div>
                                            <div id="summaryTime">-</div>
                                        </div>
                                        <div class="summary-row">
                                            <div>Guests</div>
                                            <div id="summaryGuests">1 adult, 0 children</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button id="createInvoiceBtn" class="btn btn-primary">Create Document</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <script>
                        (function() {
                            const tourSelect = document.getElementById('tourSelect');
                            const tourFields = document.getElementById('tourFields');
                            const tourDate = document.getElementById('tourDate');
                            const adultMinus = document.getElementById('adultMinus');
                            const adultPlus = document.getElementById('adultPlus');
                            const childMinus = document.getElementById('childMinus');
                            const childPlus = document.getElementById('childPlus');
                            const adultCount = document.getElementById('adultCount');
                            const childCount = document.getElementById('childCount');
                            const adultLimitText = document.getElementById('adultLimitText');
                            const childLimitText = document.getElementById('childLimitText');
                            const timeSlots = document.getElementById('timeSlots');
                            const noTimes = document.getElementById('noTimes');
                            const subtotalUSD = document.getElementById('subtotalUSD');
                            const subtotalLKR = document.getElementById('subtotalLKR');
                            const discountInput = document.getElementById('discountLKR');
                            const finalTotalEl = document.getElementById('finalTotalLKR');
                            const summaryTour = document.getElementById('summaryTour');
                            const summaryDate = document.getElementById('summaryDate');
                            const summaryTime = document.getElementById('summaryTime');
                            const summaryGuests = document.getElementById('summaryGuests');
                            const createInvoiceBtn = document.getElementById('createInvoiceBtn');
                            const phoneInput = document.getElementById('phoneInput');

                            const iti = window.intlTelInput ? window.intlTelInput(phoneInput, {
                                initialCountry: 'lk',
                                separateDialCode: true,
                                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.5.1/build/js/utils.js"
                            }) : null;

                            const today = new Date().toISOString().split('T')[0];
                            tourDate.setAttribute('min', today);

                            let usdToLkrRate = <?= $usd_rate ?>;

                            function showTourFields(show) {
                                tourFields.style.display = show ? '' : 'none';
                            }

                            // ===== UPDATE SUMMARY =====
                            function updateSummary() {
                                const adult = parseInt(adultCount.value) || 0;
                                const kids = parseInt(childCount.value) || 0;
                                const opt = tourSelect.options[tourSelect.selectedIndex];
                                const adultPrice = opt ? parseFloat(opt.getAttribute('data-adult') || 0) : 0;
                                const kidsPrice = opt ? parseFloat(opt.getAttribute('data-kids') || 0) : 0;
                                const tourName = opt ? opt.text : '-';
                                const dateVal = tourDate.value || '-';
                                // works with checkbox: pick first checked timeslot if any
                                const timeEl = document.querySelector('input[name="timeSlot"]:checked');
                                const timeText = timeEl ? timeEl.dataset.timeslot : '-';
                                const usdTotal = (adult * adultPrice) + (kids * kidsPrice);
                                const lkrTotal = usdTotal * usdToLkrRate;

                                let ValidateLKR = lkrTotal;

                                // discount handling
                                const discount = Math.max(0, parseFloat(discountInput ? discountInput.value : 0) || 0);
                                const finalLkr = Math.max(0, lkrTotal - discount);

                                // update UI
                                subtotalUSD.textContent = '$' + usdTotal.toFixed(2);
                                subtotalLKR.textContent = 'Rs. ' + lkrTotal.toFixed(2);
                                finalTotalEl.textContent = 'Rs. ' + finalLkr.toFixed(2);

                                summaryTour.textContent = tourName;
                                summaryDate.textContent = dateVal;
                                summaryTime.textContent = timeText;
                                summaryGuests.textContent = adult + ' adult(s), ' + kids + ' child(ren)';
                            }

                            // ===== DISCOUNT INPUT LISTENER =====
                            if (discountInput) {
                                discountInput.addEventListener('input', function() {
                                    if (this.value === '') return updateSummary();
                                    if (parseFloat(this.value) < 0) this.value = '0';
                                    updateSummary();
                                });
                            }

                            // ===== LOAD TIMES =====
                            function loadTimeSlots(tourId) {
                                timeSlots.innerHTML = '';
                                noTimes.style.display = 'none';
                                if (!tourId) {
                                    noTimes.style.display = 'block';
                                    return;
                                }

                                var endpoint = window.location.origin + '/BLAZE-TOURS/admin/admin/CreateInvoice.php?action=get_times&tour_id=' + encodeURIComponent(tourId);
                                fetch(endpoint, {
                                        method: 'GET',
                                        cache: 'no-store'
                                    })
                                    .then(res => res.json())
                                    .then(j => {
                                        if (!j || !j.success || !Array.isArray(j.times) || j.times.length === 0) {
                                            noTimes.style.display = '';
                                            return;
                                        }
                                        j.times.forEach(function(t, idx) {
                                            var col = document.createElement('div');
                                            col.className = 'col-6';
                                            var id = 'ts_' + t.time_id;
                                            // Changed to checkbox (works if zero times too). No required attribute.
                                            col.innerHTML = `
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="timeSlot" id="${id}" 
                                value="${t.time_id}" data-timeslot="${t.timeslot}" ${(idx===0?'checked':'')}>
                            <label class="form-check-label" for="${id}">${t.timeslot}</label>
                        </div>`;
                                            timeSlots.appendChild(col);
                                        });
                                        updateSummary();
                                    })
                                    .catch(() => {
                                        noTimes.style.display = '';
                                    });
                            }

                            // ===== TOUR SELECT =====
                            tourSelect.addEventListener('change', function() {
                                const val = this.value;
                                if (!val) {
                                    showTourFields(false);
                                    return;
                                }
                                showTourFields(true);
                                const opt = this.options[this.selectedIndex];
                                const maxAdult = parseInt(opt.getAttribute('data-maxadult') || 0);
                                const maxKids = parseInt(opt.getAttribute('data-maxkids') || 0);
                                adultCount.value = 1;
                                childCount.value = 0;
                                adultLimitText.textContent = maxAdult > 0 ? `max ${maxAdult}` : '';
                                childLimitText.textContent = maxKids > 0 ? `max ${maxKids}` : '';
                                loadTimeSlots(val);
                                updateSummary();
                            });

                            // ===== COUNTERS =====
                            adultPlus.addEventListener('click', function() {
                                const opt = tourSelect.options[tourSelect.selectedIndex];
                                const maxAdult = parseInt(opt ? opt.getAttribute('data-maxadult') || 0 : 0);
                                let cur = parseInt(adultCount.value) || 1;
                                if (maxAdult > 0 && cur >= maxAdult) return;
                                adultCount.value = cur + 1;
                                updateSummary();
                            });

                            adultMinus.addEventListener('click', function() {
                                let cur = parseInt(adultCount.value) || 1;
                                if (cur > 1) adultCount.value = cur - 1;
                                updateSummary();
                            });

                            childPlus.addEventListener('click', function() {
                                const opt = tourSelect.options[tourSelect.selectedIndex];
                                const maxKids = parseInt(opt ? opt.getAttribute('data-maxkids') || 0 : 0);
                                let cur = parseInt(childCount.value) || 0;
                                if (maxKids > 0 && cur >= maxKids) return;
                                childCount.value = cur + 1;
                                updateSummary();
                            });

                            childMinus.addEventListener('click', function() {
                                let cur = parseInt(childCount.value) || 0;
                                if (cur > 0) childCount.value = cur - 1;
                                updateSummary();
                            });

                            // ===== CREATE INVOICE BTN =====
                            createInvoiceBtn.addEventListener('click', function(e) {
                                e.preventDefault();

                                const email = document.getElementById('Cutomeremail').value.trim();
                                const fullName = document.getElementById('fullName').value.trim();

                                // basic validations (existing)
                                if (!tourSelect.value)
                                    return Swal.fire({
                                        icon: 'warning',
                                        title: 'Required',
                                        text: 'Please select a tour'
                                    });
                                if (!tourDate.value)
                                    return Swal.fire({
                                        icon: 'warning',
                                        title: 'Required',
                                        text: 'Please select a date'
                                    });

                                // get first checked timeslot if present (works when none too)
                                const timeChecked = document.querySelector('input[name="timeSlot"]:checked');

                                if (!fullName)
                                    return Swal.fire({
                                        icon: 'warning',
                                        title: 'Required',
                                        text: 'Please enter full name'
                                    });
                                if (!email)
                                    return Swal.fire({
                                        icon: 'warning',
                                        title: 'Required',
                                        text: 'Please enter email'
                                    });
                                if (!/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/.test(email))
                                    return Swal.fire({
                                        icon: 'warning',
                                        title: 'Invalid Email',
                                        text: 'Please enter a valid email address'
                                    });
                                if (!phoneInput.value.trim())
                                    return Swal.fire({
                                        icon: 'warning',
                                        title: 'Required',
                                        text: 'Please enter phone number'
                                    });

                                // Recompute numeric subtotal (LKR) and discount to validate
                                const adult = parseInt(adultCount.value) || 0;
                                const kids = parseInt(childCount.value) || 0;
                                const opt = tourSelect.options[tourSelect.selectedIndex];
                                const adultPrice = opt ? parseFloat(opt.getAttribute('data-adult') || 0) : 0;
                                const kidsPrice = opt ? parseFloat(opt.getAttribute('data-kids') || 0) : 0;
                                const usdTotal = (adult * adultPrice) + (kids * kidsPrice);
                                const lkrTotal = Number((usdTotal * usdToLkrRate).toFixed(2));

                                const discount = Math.max(0, parseFloat(discountInput ? discountInput.value : 0) || 0);

                                // VALIDATION: discount must not exceed subtotal LKR
                                if (discount > lkrTotal) {
                                    return Swal.fire({
                                        icon: 'error',
                                        title: 'Invalid Discount',
                                        text: 'Discount cannot be greater than subtotal LKR (' + lkrTotal.toFixed(2) + ')'
                                    });
                                }

                                const finalTotal = Number((lkrTotal - discount).toFixed(2));

                                const payload = {
                                    tour_id: tourSelect.value,
                                    tour_name: tourSelect.options[tourSelect.selectedIndex].text,
                                    date: tourDate.value,
                                    // if no timeslot checked, send empty values (document should still be created)
                                    time_id: timeChecked ? timeChecked.value : '',
                                    time_text: timeChecked ? timeChecked.dataset.timeslot : '-',
                                    adults: adultCount.value,
                                    kids: childCount.value,
                                    full_name: fullName,
                                    email: email,
                                    phone: iti ? iti.getNumber() : phoneInput.value.trim(),
                                    subtotal_usd: subtotalUSD.textContent,
                                    subtotal_lkr: 'Rs. ' + lkrTotal.toFixed(2),
                                    discount_lkr: discount.toFixed(2),
                                    final_total_lkr: finalTotal.toFixed(2),

                                    // per-unit prices + rate so invoice can show per-line USD and LKR
                                    adult_unit_price: (opt ? parseFloat(opt.getAttribute('data-adult') || 0) : 0),
                                    kids_unit_price: (opt ? parseFloat(opt.getAttribute('data-kids') || 0) : 0),
                                    usd_rate: usdToLkrRate
                                };

                                Swal.fire({
                                    title: 'Create Document?',
                                    html: `<div class="text-start">
                <p><strong>Tour:</strong> ${payload.tour_name}</p>
                <p><strong>Date:</strong> ${payload.date}</p>
                <p><strong>Time:</strong> ${payload.time_text}</p>
                <p><strong>Guests:</strong> ${payload.adults} adult(s), ${payload.kids} child(ren)</p>
                <p><strong>Subtotal:</strong> ${payload.subtotal_usd} (${payload.subtotal_lkr})</p>
                <p><strong>Discount (LKR):</strong> Rs. ${payload.discount_lkr}</p>
                <p style="font-weight:700; font-size:1.1rem;"><strong>Final Total (LKR):</strong> Rs. ${payload.final_total_lkr}</p>
            </div>`,
                                    icon: 'question',
                                    showCancelButton: true,
                                    confirmButtonText: 'Create',
                                    cancelButtonText: 'Cancel'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Add payment status to payload
                                        payload.payment_status = document.querySelector('input[name="paymentStatus"]:checked').value;
                                        payload.document_type = document.querySelector('input[name="documentType"]:checked').value;

                                        // Create form and submit to invoice.php
                                        const form = document.createElement('form');
                                        form.method = 'POST';
                                        form.action = 'document.php';
                                        form.target = '_blank'; // Open in new window

                                        // Add hidden fields with data
                                        Object.entries(payload).forEach(([key, value]) => {
                                            const input = document.createElement('input');
                                            input.type = 'hidden';
                                            input.name = key;
                                            input.value = value;
                                            form.appendChild(input);
                                        });

                                        // Submit form
                                        document.body.appendChild(form);
                                        form.submit();
                                        document.body.removeChild(form);

                                        if (window.Swal) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Document Created',
                                                text: 'Document opened in a new window.',
                                                confirmButtonText: 'OK'
                                            }).then(function() {
                                                location.reload();
                                            });
                                        } else {
                                            alert('Document created');
                                            location.reload();
                                        }

                                    }

                                });
                            });

                            window.updateInvoiceSummary = updateSummary;
                            updateSummary();
                        })();
                    </script>


                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>