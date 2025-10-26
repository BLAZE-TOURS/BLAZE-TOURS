<?php
require_once 'assets/process/connection.php';

// Simple input helper
function field($key, $default = '')
{
    return isset($_POST[$key]) ? htmlspecialchars(trim((string)$_POST[$key])) : $default;
}

// Check if this is a booking from database (via order_id)
$order_id = $_GET['order_id'] ?? '';
$bookingData = null;

if ($order_id) {
    try {
        $orderIdEsc = Database::escape_string($order_id);

        // Only load booking when it's present and status_id = 1 (PAID)
        $query = "
            SELECT b.*, t.name AS tour_name, t.adult_price, t.kids_price
            FROM booking b
            LEFT JOIN tour t ON t.id = b.tour_id
            WHERE b.id = '{$orderIdEsc}' AND b.status_id = 1
            LIMIT 1
        ";
        $result = Database::search($query);

        if ($result && $result->num_rows > 0) {
            $bookingData = $result->fetch_assoc();
        } else {
            // Not found or not paid → redirect to home
            header('Location: index.php');
            exit;
        }
    } catch (Throwable $e) {
        error_log("invoice.php: error fetching booking: " . $e->getMessage());
        header('Location: index.php');
        exit;
    }
}

// If no order_id was provided, continue with fallback (form-submitted invoice)
if (!$order_id) {
    $tourId = field('tourId');
    $tourName = field('tourName', 'Tour');
    $date = field('tourDate') ?: field('date');
    $timeSlot = field('timeSlot');
    $fullName = field('fullName');
    $email = field('email');
    $phone = field('phone');
    $pickup = field('pickup') ?: field('pickupLocation');
    $adults = (int)($_POST['adults'] ?? 0);
    $children = (int)($_POST['children'] ?? 0);
    $adultPrice = (float)($_POST['adultPrice'] ?? 0);
    $childPrice = (float)($_POST['childPrice'] ?? 0);
    $totalPrice = (float)($_POST['totalPrice'] ?? 0);
    $totalPriceLKR = 0;
    $invoiceNo = 'INV-' . date('Ymd-His') . '-' . substr(md5(($tourId ?: '0') . microtime()), 0, 6);
} else {
    if ($bookingData) {
        $tourId = $bookingData['tour_id'];
        $tourName = $bookingData['tour_name'] ?? 'Tour';
        $date = $bookingData['tourDate'];
        $timeSlot = $bookingData['time_slot'] ?? '';
        $fullName = $bookingData['name'];
        $email = $bookingData['email'];
        $phone = $bookingData['mobile'];
        $pickup = $bookingData['pickup_location'] ?? '';
        $adults = (int)$bookingData['numberOfAdultCount'];
        $children = (int)$bookingData['numberOfKidsCount'];
        $totalPrice = isset($bookingData['total_price_usd']) ? (float)$bookingData['total_price_usd'] : 0;
        $totalPriceLKR = isset($bookingData['total_price_lkr']) ? (float)$bookingData['total_price_lkr'] : 0;
        $effectiveRate = ($totalPrice > 0 && $totalPriceLKR > 0) ? ($totalPriceLKR / $totalPrice) : Database::getLKRRate();
        $invoiceNo = $bookingData['id'];

        // Use actual tour prices from database
        $adultPrice = isset($bookingData['adult_price']) ? (float)$bookingData['adult_price'] : 0;
        $childPrice = isset($bookingData['kids_price']) ? (float)$bookingData['kids_price'] : 0;
    }
}

// Fallback calculations for form-submitted invoices (if prices not provided)
if ($adultPrice == 0 && $childPrice == 0 && $totalPrice > 0) {
    $totalPeople = $adults + $children;
    if ($totalPeople > 0) {
        $adultPrice = $totalPrice / $totalPeople;
        $childPrice = $totalPrice / $totalPeople;
    }
}
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Invoice | Blaze Tours</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="assets/img/logo.png">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        .invoice-card {
            border: 1px solid #e9ecef;
            border-radius: 12px;
            background: #fff;
            position: relative; /* required for absolute seal/image */
        }
        /* Paid stamp image (low opacity on screen, stronger on print) */
        .paid-seal-img {
            position: absolute;
            left: 50%;
            top: 40px;
            transform: translateX(-50%) rotate(-18deg);
            width: 220px;
            height: auto;
            opacity: 0.15; /* reduced opacity for screen */
            pointer-events: none;
            z-index: 50;
            filter: drop-shadow(0 6px 12px rgba(0,0,0,0.08));
        }
        @media print {
            /* shift the stamp slightly to the right and make it more visible on print */
            .paid-seal-img {
                left: 78%;                      /* move origin to the right */
                top: 36px;                      /* small vertical tweak for print */
                transform: translateX(-40%) rotate(-18deg); /* smaller negative translate -> moves right */
                opacity: 0.40;                  /* stronger on paper */
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
        @media print {
            .no-print {
                display: none !important;
            }

            .invoice-card {
                border: none;
            }

            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                margin: 0;
            }
        }

        /* ජංගම දුරකථන ප්‍රතිචාරාත්මක වෙනස්කම් (Mobile Responsiveness Adjustments) */
        @media (max-width: 768px) {
            .invoice-header,
            .invoice-footer {
                flex-direction: column !important;
                text-align: center;
                gap: 10px;
            }

            .invoice-body {
                padding: 15px;
            }

            table th,
            table td {
                font-size: 0.9rem;
            }

            /* ඉතා කුඩා තිරවලදී LKR තීරුව සැඟවීම (Hide LKR column on small screens) */
            .table thead tr th:nth-child(5),
            .table tbody tr td:nth-child(5) {
                display: none;
            }

            /* Total (LKR) පේළිය වෙනස් කිරීම: colspan 4 වෙනුවට 3 දක්වා අඩු කරන්න */
            .table tfoot tr:last-child td:first-child {
                /* Total (LKR) සඳහා colspan 3ක් යොදා ගැනීමට, පළමු තීරුව තීරු 3ක් ආවරණය කරයි */
                /* Bootstrap හි colspan="4" ජංගම දුරකථන සඳහා colspan="3" විය යුතුය. */
                /* මෙහිදී colspan="4" (HTML) භාවිත කර ඇති නිසා, අපි CSS මගින් 4th column එකට display: none; යොදා,
                   අවසාන තීරුවේ display: block; ඇති බවට සහතික කරමු.
                   නැතහොත්, වඩා හොඳ ප්‍රතිඵල සඳහා HTML වල colspan වෙනස් කළ යුතුය. */
                /* දැනට ඇති colspan="4" තබමින්, LKR තීරුව සැඟවූ විට එය ස්වයංක්‍රීයව අනුගත වීමට ඉඩ දෙමු. */
            }

            .table tfoot tr:last-child td:nth-child(5) {
                /* LKR තීරුව සැඟවීමෙන් පසු, මෙම අඩි තීරුවේ LKR අගය පෙන්වන තීරුව,
                   පළමු පේළියේ ඇති colspan="3" සමග නොගැලපෙන බැවින්,
                   මධ්‍යම තිරයට වඩා කුඩා තිරවලදී LKR මුළු අගය නව පේළියක පෙන්වීමට සුදුසු වනු ඇත.
                   නමුත් දැනට, 'table-responsive' එක පවත්වා ගනිමු. */
                display: inline-block !important; /* LKR මුදල තවමත් පෙන්වීමට */
                width: auto;
            }

            /* Total (LKR) row එකේ ඇති colspan="4" කුඩා තිරවලදී තීරු 3ක් ආවරණය කිරීමට */
            .table tfoot tr:nth-child(2) td:first-child {
                /* මෙය ඉතා සංකීර්ණ බැවින්, HTML වෙතින් colspan="4" නොව colspan="3" ලෙස වෙනස් කිරීම වඩාත් නිවැරදියි.
                   නැතහොත්, table-responsive මත විශ්වාසය තබන්න.
                   දැනට අපි 'table-responsive' මත විශ්වාසය තබා LKR තීරුව පමණක් සැඟවීම ප්‍රමාණවත් යැයි සලකමු. */
            }
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <section class="space">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10">

                    <div id="invoiceArea">
                        <div class="invoice-card shadow-sm">
                            <?php
                                // Show paid stamp image for paid bookings
                                $isPaid = ($bookingData && ( !empty($bookingData['payment_id']) || (isset($bookingData['status_id']) && (int)$bookingData['status_id'] === 1) ));
                                if ($isPaid) {
                                    // place your stamp image at assets/img/paid-stamp.png (add file if missing)
                                    echo '<img src="./assets/img/paid.png" alt="PAID" class="paid-seal-img" />';
                                }
                            ?>
                            <div class="invoice-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                                <div class="text-start">
                                    <div class="company-name">BLAZE TOURS (PVT) LTD</div>
                                    <div>68/29, Sri Sidhartha road, Kirulapane, Colombo-6</div>
                                    <div>+94 71 334 4399</div>
                                </div>
                                <div class="text-start text-md-end mt-3 mt-md-0">
                                    <div class="inv-title">Invoice</div>
                                    <div><strong>No:</strong> <?php echo $invoiceNo; ?></div>
                                    <div><strong>Date:</strong> <?php echo date('Y-m-d'); ?></div>
                                </div>
                            </div>

                            <div class="invoice-body">
                                <div class="row g-3 mb-3">
                                    <div class="col-12 col-md-6">
                                        <div class="card bg-light border-0">
                                            <div class="card-body">
                                                <div class="fw-bold mb-2">Booking Details</div>
                                                <div><strong>Tour:</strong> <?php echo $tourName; ?><?php if ($tourId) {
                                                                                                        echo ' (#' . (int)$tourId . ')';
                                                                                                    } ?></div>
                                                <div><strong>Date:</strong> <?php echo $date ?: '-'; ?></div>
                                                <div><strong>Time:</strong> <?php echo $timeSlot ? date('g:i A', strtotime($timeSlot)) : '-'; ?></div>
                                                <div><strong>Pickup:</strong> <?php echo $pickup ?: '-'; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="card bg-light border-0 h-100">
                                            <div class="card-body">
                                                <div class="fw-bold mb-2">Customer</div>
                                                <div><strong>Name:</strong> <?php echo $fullName ?: '-'; ?></div>
                                                <div><strong>Email:</strong> <?php echo $email ?: '-'; ?></div>
                                                <div><strong>Phone:</strong> <?php echo $phone ?: '-'; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Item</th>
                                                <th class="text-center">People</th>
                                                <th class="text-end">One Preson Price (USD)</th>
                                                <th class="text-end">Amount (USD)</th>
                                                <th class="text-end">Amount (LKR)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Adults</td>
                                                <td class="text-center"><?php echo $adults; ?></td>
                                                <td class="text-end">$<?php echo number_format($adultPrice, 2); ?></td>
                                                <td class="text-end">$<?php echo number_format($adults * $adultPrice, 2); ?></td>
                                                <td class="text-end">Rs. <?php echo number_format(($adults * $adultPrice) * $effectiveRate, 2); ?></td>
                                            </tr>
                                            <?php if ($children > 0) { ?>
                                                <tr>
                                                    <td>Children</td>
                                                    <td class="text-center"><?php echo $children; ?></td>
                                                    <td class="text-end">$<?php echo number_format($childPrice, 2); ?></td>
                                                    <td class="text-end">$<?php echo number_format($children * $childPrice, 2); ?></td>
                                                    <td class="text-end">Rs. <?php echo number_format(($children * $childPrice) * $effectiveRate, 2); ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" class="text-end totals-row">Total (USD)</td>
                                                <td class="text-end totals-row">$<?php echo number_format($totalPrice, 2); ?></td>
                                                <td class="text-end"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-end totals-row">Total (LKR)</td>
                                                <td class="text-end totals-row">Rs. <?php echo number_format($totalPriceLKR > 0 ? $totalPriceLKR : $totalPrice * $effectiveRate, 2); ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <div class="invoice-footer d-flex flex-column flex-sm-row gap-2 justify-content-between align-items-stretch align-items-sm-center">
                                <div>
                                    <div class="text-muted">Thank you for choosing Blaze Tours.</div>
                                    <?php if ($bookingData && isset($bookingData['payment_id'])) { ?>
                                        <div class="text-success small mt-1">
                                            <i class="fas fa-check-circle me-1"></i>
                                            Payment Completed (ID: <?php echo htmlspecialchars($bookingData['payment_id']); ?>)
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4 no-print">
                        <button id="printBtn" type="button" class="th-btn"><i class="fa fa-print me-2"></i>Print Invoice</button>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script src="assets/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <script>
      // Print the invoice by cloning #invoiceArea into a new window with page styles.
      (function () {
        function gatherStyles() {
          // include external stylesheets and inline <style> blocks
          const nodes = Array.from(document.querySelectorAll('link[rel="stylesheet"], style'));
          return nodes.map(n => n.outerHTML).join('\n');
        }

        function openPrintWindow(html) {
          const w = window.open('', '_blank', 'width=900,height=700');
          if (!w) {
            alert('Popup blocked — please allow popups for this site or use your browser menu to print.');
            return;
          }
          w.document.write(html);
          w.document.close();
          w.focus();
          // wait a bit for CSS/fonts to apply
          setTimeout(() => { w.print(); }, 350);
        }

        function buildPrintHtml(contentHtml) {
          const styles = gatherStyles();
          return `<!doctype html><html><head><meta charset="utf-8"><title>Invoice</title>${styles}<meta name="viewport" content="width=device-width, initial-scale=1"></head><body style="background:#fff;margin:0;padding:20px;">${contentHtml}</body></html>`;
        }

        function printInvoiceArea() {
          // කුඩා තිරවලදී (ජංගම උපාංග) කෙලින්ම window.print() භාවිතා කරන්න.
          // මෙය popup block වීම වළක්වයි.
          if (window.innerWidth < 768) {
              window.print();
              return;
          }

          const area = document.getElementById('invoiceArea');
          if (!area) {
            window.print();
            return;
          }
          // Clone the node so any IDs remain safe
          const clone = area.cloneNode(true);
          // Remove elements we don't want printed
          clone.querySelectorAll('.no-print').forEach(n => n.remove());
          // Build HTML with styles
          const html = buildPrintHtml(clone.outerHTML);
          openPrintWindow(html);
        }

        document.addEventListener('DOMContentLoaded', function () {
          const btn = document.getElementById('printBtn');
          if (btn) btn.addEventListener('click', printInvoiceArea);
          // expose for backward compatibility
          window.printInvoice = printInvoiceArea;
        });
      })();
    </script>
</body>

</html>