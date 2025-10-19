<?php
require_once 'assets/process/connection.php';

// Simple input helper
function field($key, $default = '') {
    return isset($_POST[$key]) ? htmlspecialchars(trim((string)$_POST[$key])) : $default;
}

// Check if this is a booking from database (via order_id)
$order_id = $_GET['order_id'] ?? '';
$bookingData = null;

if ($order_id) {
    // Fetch booking data from database by id (which is now the custom booking ID)
    try {
        $orderIdEsc = Database::escape_string($order_id);
        $query = "SELECT b.*, t.name AS tour_name FROM booking b LEFT JOIN tour t ON t.id = b.tour_id WHERE b.id = '$orderIdEsc'";
        $result = Database::search($query);
        
        if ($result && $result->num_rows > 0) {
            $booking = $result->fetch_assoc();
            $bookingData = $booking;
        }
    } catch (Exception $e) {
        error_log("Error fetching booking data: " . $e->getMessage());
    }
}

if ($bookingData) {
    // Use data from database
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
    $effectiveRate = ($totalPrice > 0 && $totalPriceLKR > 0) ? ($totalPriceLKR / $totalPrice) : 320.0;
    $invoiceNo = $bookingData['id']; // Use the id as invoice number

    // Price breakdown (if you have unit price fields in DB, use them)
    $adultPrice = $adults > 0 ? $totalPrice / ($adults + $children) : 0;
    $childPrice = $children > 0 ? $totalPrice / ($adults + $children) : 0;
} else {
    // Use POST data (fallback)
    $tourId = field('tourId');
    $tourName = field('tourName', 'Tour');
    $date = field('tourDate');
    if (!$date) { $date = field('date'); }
    $timeSlot = field('timeSlot');
    $fullName = field('fullName');
    $email = field('email');
    $phone = field('phone');
    $pickup = field('pickup');
    if (!$pickup) { $pickup = field('pickupLocation'); }

    $adults = (int)($_POST['adults'] ?? 0);
    $children = (int)($_POST['children'] ?? 0);
    $adultPrice = (float)($_POST['adultPrice'] ?? 0);
    $childPrice = (float)($_POST['childPrice'] ?? 0);
    $totalPrice = (float)($_POST['totalPrice'] ?? 0);
    $totalPriceLKR = 0;
    $invoiceNo = 'INV-' . date('Ymd-His') . '-' . substr(md5(($tourId ?: '0').microtime()), 0, 6);
}

// Calculate prices if not available
if ($adultPrice == 0 && $adults > 0) {
    $adultPrice = $totalPrice / $adults;
}
if ($childPrice == 0 && $children > 0) {
    $childPrice = $totalPrice / $children;
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
                        <div class="d-flex gap-2 no-print">
                            <button class="th-btn" onclick="window.print()"><i class="fa fa-print me-2"></i>Print</button>
                            <a href="index.php" class="th-btn th-icon">
                                <i class="fas fa-home me-2"></i>Back to Home
                            </a>
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
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
</body>
</html>


