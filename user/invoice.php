<?php
// Simple input helper
function field($key, $default = '') {
    return isset($_POST[$key]) ? htmlspecialchars(trim((string)$_POST[$key])) : $default;
}

$tourId = field('tourId');
$tourName = field('tourName', 'Tour');
$date = field('tourDate'); // if not posted, also try 'date'
if (!$date) { $date = field('date'); }
$timeSlot = field('timeSlot');
$fullName = field('fullName');
$email = field('email');
$phone = field('phone');
$pickup = field('pickup'); // if not posted, also try 'pickupLocation'
if (!$pickup) { $pickup = field('pickupLocation'); }

$adults = (int)($_POST['adults'] ?? 0);
$children = (int)($_POST['children'] ?? 0);
$adultPrice = (float)($_POST['adultPrice'] ?? 0);
$childPrice = (float)($_POST['childPrice'] ?? 0);
$totalPrice = (float)($_POST['totalPrice'] ?? 0);

$invoiceNo = 'INV-' . date('Ymd-His') . '-' . substr(md5(($tourId ?: '0').microtime()), 0, 6);
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
        .invoice-card { border: 1px solid #e9ecef; border-radius: 12px; background: #fff; }
        .invoice-header { border-bottom: 1px solid #e9ecef; padding: 20px; }
        .invoice-body { padding: 20px; }
        .invoice-footer { border-top: 1px solid #e9ecef; padding: 20px; }
        .inv-title { font-weight: 700; }
        .company-name { font-weight: 800; font-size: 1.1rem; }
        .totals-row { font-weight: 700; font-size: 1.05rem; }
        @media print {
            .no-print { display: none !important; }
            .invoice-card { border: none; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>

<section class="space">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="invoice-card shadow-sm">
                    <div class="invoice-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                        <div>
                            <div class="company-name">BLAZE TOURS (PVT) LTD</div>
                            <div>68/29, Sri Sidhartha road, Kirulapane, Colombo-6</div>
                            <div>+94 71 334 4399</div>
                        </div>
                        <div class="text-md-end mt-3 mt-md-0">
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
                                        <div><strong>Tour:</strong> <?php echo $tourName; ?><?php if ($tourId) { echo ' (#' . (int)$tourId . ')'; } ?></div>
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
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Unit Price (USD)</th>
                                        <th class="text-end">Amount (USD)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Adults</td>
                                        <td class="text-center"><?php echo $adults; ?></td>
                                        <td class="text-end"><?php echo number_format($adultPrice, 2); ?></td>
                                        <td class="text-end"><?php echo number_format($adults * $adultPrice, 2); ?></td>
                                    </tr>
                                    <?php if ($children > 0) { ?>
                                    <tr>
                                        <td>Children</td>
                                        <td class="text-center"><?php echo $children; ?></td>
                                        <td class="text-end"><?php echo number_format($childPrice, 2); ?></td>
                                        <td class="text-end"><?php echo number_format($children * $childPrice, 2); ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end totals-row">Total</td>
                                        <td class="text-end totals-row"><?php echo number_format($totalPrice, 2); ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="invoice-footer d-flex flex-column flex-sm-row gap-2 justify-content-between align-items-stretch align-items-sm-center">
                        <div class="text-muted">Thank you for choosing Blaze Tours.</div>
                        <div class="d-flex gap-2 no-print">
                            <button class="th-btn" onclick="window.print()"><i class="fa fa-print me-2"></i>Print</button>
                            <button id="payNowBtn" class="th-btn th-icon">
                                Pay Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="shape-mockup shape1 d-none d-xxl-block" data-bottom="35%" data-right="12%">
        <img src="assets/img/shape/shape_1.png" alt="shape">
    </div>
    <div class="shape-mockup shape2 d-none d-xl-block" data-bottom="31%" data-right="8%">
        <img src="assets/img/shape/shape_2.png" alt="shape">
    </div>
    <div class="shape-mockup shape3 d-none d-xxl-block" data-bottom="33%" data-right="5%">
        <img src="assets/img/shape/shape_3.png" alt="shape">
    </div>
</section>

<?php include 'footer.php'; ?>

<script src="assets/js/bootstrap.min.js"></script>
<script>
    document.getElementById('payNowBtn').addEventListener('click', function(e) {
        e.preventDefault();
        // Placeholder: integrate payment gateway here
        alert('Payment processing is not configured yet.');
    });
</script>
</body>
</html>


