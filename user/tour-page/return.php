<?php
require_once '../assets/process/connection.php'; 

// 1. Order ID එක ලබා ගැනීම
$order_id = isset($_GET['order_id']) ? Database::escape_string($_GET['order_id']) : '';

if (empty($order_id)) {
    header("Location: index.php");
    exit();
}

// 2. Database එකෙන් විස්තර ගන්න (Booking Table + Tour Table JOIN කිරීම)
// වෙනස්කම: t.main_image කොටස අයින් කළා Error එක නැති කරන්න.
$sql = "SELECT 
            b.*, 
            t.name AS tour_name
        FROM booking b 
        INNER JOIN tour t ON b.tour_id = t.id 
        WHERE b.order_id = '$order_id'";

$result = Database::search($sql);

if ($result->num_rows == 0) {
    echo "Invalid Order ID";
    exit();
}

$booking_data = $result->fetch_assoc();
$status = $booking_data['status']; // Success, Failed, Canceled, or Pending
?>

<!doctype html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <title>Payment Status | Blaze Tours</title>

     <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons - Place favicon.ico in the root directory -->
    <link rel="icon" type="image/png" href="../assets/img/logo.png">

    <!--==============================
	  Google Fonts
	============================== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Manrope:wght@200..800&family=Montez&display=swap" rel="stylesheet">

    <!--==============================
	    All CSS File
	============================== -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <!-- Fontawesome Icon -->
    <link rel="stylesheet" href="../assets/css/fontawesome.min.css">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="../assets/css/magnific-popup.min.css">

    <!-- Swiper css -->
    <link rel="stylesheet" href="../assets/css/swiper-bundle.min.css">

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <style>
        .details-table th { width: 40%; color: #666; font-weight: 500; text-align: left; }
        .details-table td { font-weight: 600; color: #333; text-align: left;}
        .payment-summary { background-color: #f8f9fa; border-radius: 10px; padding: 20px; }
        .sec-title { font-weight: 700; }
        /* Mobile responsiveness tweaks */
        @media (max-width: 576px) {
            #payment-status { margin-top: 40px !important; margin-bottom: 40px !important; }
            .card { padding: 1rem !important; }
            .sec-title { font-size: 1.25rem; }
            .sub-title { font-size: 0.95rem; }
            .details-table th { width: 100%; display: block; margin-bottom: 4px; }
            .details-table td { width: 100%; display: block; margin-bottom: 10px; }
            .details-table tr { display: block; border-bottom: 1px solid #eee; padding-bottom: 8px; margin-bottom: 8px; }
            .payment-summary { padding: 12px; }
            .payment-summary .d-flex { flex-direction: column; align-items: flex-start; }
            .payment-summary .d-flex span:last-child { margin-top: 4px; }
            .fa-check-circle, .fa-times-circle, .fa-ban, .fa-spinner { font-size: 56px !important; }
        }
    </style>
</head>
<body>

<div class="overflow-hidden space" id="payment-status" style="margin-top: 80px; margin-bottom: 80px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-9 col-sm-12">
                <div class="card shadow-lg border-0 rounded-3 p-4 p-md-5 text-center">

                    <?php if ($status == 'Success') : ?>
                        <div class="mb-4">
                            <i class="fas fa-check-circle text-success" style="font-size: 70px;"></i>
                        </div>
                        <h2 class="sec-title mb-2 text-success">Booking Confirmed!</h2>
                        <span class="sub-title mb-4 d-block">Thank you, <?php echo htmlspecialchars($booking_data['name']); ?></span>
                        
                        <div class="text-start mb-4 border rounded p-3">
                            <h4 class="h5 mb-3 text-primary border-bottom pb-2">
                                <i class="fas fa-map-marker-alt me-2"></i> 
                                <?php echo htmlspecialchars($booking_data['tour_name']); ?>
                            </h4>
                            
                            <table class="table table-borderless table-sm details-table mb-0">
                                <tr>
                                    <th><i class="far fa-calendar-alt me-2"></i>Tour Date:</th>
                                    <td><?php echo $booking_data['tourDate']; ?></td>
                                </tr>
                                <tr>
                                    <th><i class="far fa-clock me-2"></i>Time Slot:</th>
                                    <td><?php echo date('g:i A', strtotime($booking_data['time_slot'])); ?></td>
                                </tr>
                                <tr>
                                    <th><i class="fas fa-users me-2"></i>Guests:</th>
                                    <td>
                                        <?php echo $booking_data['numberOfAdultCount']; ?> Adults
                                        <?php if($booking_data['numberOfKidsCount'] > 0) echo ', ' . $booking_data['numberOfKidsCount'] . ' Children'; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><i class="fas fa-taxi me-2"></i>Pickup:</th>
                                    <td><?php echo htmlspecialchars($booking_data['pickup_location']); ?></td>
                                </tr>
                                <tr>
                                    <th><i class="fas fa-envelope me-2"></i>Email:</th>
                                    <td><?php echo htmlspecialchars($booking_data['email']); ?></td>
                                </tr>
                                 <tr>
                                    <th><i class="fas fa-phone me-2"></i>Mobile:</th>
                                    <td><?php echo htmlspecialchars($booking_data['mobile']); ?></td>
                                </tr>
                            </table>
                        </div>

                        <div class="payment-summary text-start mb-4">
                            <h5 class="h6 mb-3 text-dark border-bottom pb-2">Payment Summary</h5>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Cost (USD):</span>
                                <span class="fw-bold">$<?php echo number_format($booking_data['total_price_usd'], 2); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 text-success">
                                <span>Paid Amount (LKR):</span>
                                <span class="fw-bold">Rs. <?php echo number_format($booking_data['advance_paid_lkr'], 2); ?></span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between text-danger">
                                <span>Balance Due (USD):</span>
                                <span class="fw-bold fs-5">$<?php echo number_format($booking_data['balance_due_usd'], 2); ?></span>
                            </div>
                            <small class="text-muted d-block mt-2 text-center">* Please pay the balance amount upon arrival.</small>
                        </div>
                        
                        <div class="alert alert-success py-2">
                            <small><i class="fas fa-info-circle me-1"></i> A confirmation email has been sent to you.</small>
                        </div>

                    <?php elseif ($status == 'Failed') : ?>
                        <div class="mb-4">
                            <i class="fas fa-times-circle text-danger" style="font-size: 80px;"></i>
                        </div>
                        <h2 class="sec-title mb-2 text-danger">Payment Failed!</h2>
                        <span class="sub-title mb-3 d-block">Transaction could not be completed.</span>

                        <div class="alert alert-danger">
                            <strong>Reason:</strong> <?php echo htmlspecialchars($booking_data['status_message']); ?>
                        </div>
                        <p>Order ID: <?php echo $booking_data['order_id']; ?></p>

                    <?php elseif ($status == 'Canceled') : ?>
                        <div class="mb-4">
                            <i class="fas fa-ban text-warning" style="font-size: 80px;"></i>
                        </div>
                        <h2 class="sec-title mb-2 text-warning">Payment Canceled</h2>
                        <span class="sub-title mb-3 d-block">You canceled the transaction.</span>

                    <?php else : ?>
                        <div class="mb-4">
                            <i class="fas fa-spinner fa-spin text-info" style="font-size: 80px;"></i>
                        </div>
                        <h2 class="sec-title mb-2 text-info">Processing...</h2>
                        <p>Verifying payment status...</p>
                        <script>setTimeout(function(){ window.location.reload(); }, 5000);</script>
                    <?php endif; ?>

                    <div class="mt-4">
                        <a href="index.php" class="th-btn style3 btn btn-primary">
                            <i class="fas fa-home me-2"></i> Back to Home
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>