<?php
// PayHere server-to-server notify handler
// Docs: https://support.payhere.lk/api-&-mobile-sdk/payhere-checkout

// Log errors
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/assets/process/php_errors.log');

require_once __DIR__ . '/assets/process/connection.php';

// Required fields from PayHere
$merchant_id      = $_POST['merchant_id'] ?? '';
$order_id         = $_POST['order_id'] ?? ''; // e.g., ORD-123
$payhere_amount   = $_POST['payhere_amount'] ?? '';
$payhere_currency = $_POST['payhere_currency'] ?? '';
$status_code      = $_POST['status_code'] ?? '';
$md5sig           = $_POST['md5sig'] ?? '';

// Merchant secret (KEEP SECRET, do not expose to client)
$merchant_secret = 'MzMxMzgwNzM4NDIwOTA4NTMwNzAxMDg3MjQxODc4MjY4ODQ2Njkz'; // replace with your secret

// Verify signature as per PayHere docs
$local_md5sig = strtoupper(md5(
    $merchant_id . $order_id . $payhere_amount . $payhere_currency . $status_code . strtoupper(md5($merchant_secret))
));

if ($local_md5sig !== $md5sig) {
    http_response_code(400);
    echo 'Invalid signature';
    exit;
}

// Extract booking id - now using custom booking ID format
$customBookingId = $order_id; // order_id is now the custom booking ID

if (empty($customBookingId)) {
    http_response_code(400);
    echo 'Invalid order id';
    exit;
}

// Validate that the booking exists
try {
    $orderIdEsc = Database::escape_string($customBookingId);
    $res = Database::search("SELECT id FROM booking WHERE id = '$orderIdEsc' LIMIT 1");
    if (!$res || $res->num_rows == 0) {
        http_response_code(400);
        echo 'Booking not found';
        exit;
    }
} catch (Throwable $e) {
    error_log("Error fetching booking ID: " . $e->getMessage());
    http_response_code(400);
    echo 'Database error';
    exit;
}

// Status code 2 = success
if ((string)$status_code === '2') {
    try {
        // Mark as COMPLETE/PAID (status_id = 1) and save payment reference
        $paymentId = Database::escape_string($_POST['payment_id'] ?? '');
        $method = Database::escape_string($_POST['method'] ?? 'PayHere');
        Database::iud("UPDATE booking SET status_id = 1, payment_id = '$paymentId', payment_method = '$method' WHERE id = '$orderIdEsc'");

        // Fetch booking for email
        $res = Database::search("SELECT b.*, t.name AS tour_name FROM booking b LEFT JOIN tour t ON t.id = b.tour_id WHERE b.id = '$orderIdEsc' LIMIT 1");
        if ($res && $res->num_rows > 0) {
            $booking = $res->fetch_assoc();
            // Send emails
            $emailHelpers = __DIR__ . '/assets/process/sendBookingEmails.php';
            if (file_exists($emailHelpers)) {
                require_once $emailHelpers;
                $bookingData = [
                    'email' => $booking['email'],
                    'tourName' => $booking['tour_name'] ?? 'Tour',
                    'fullName' => $booking['name'],
                    'date' => $booking['tourDate'],
                    'timeSlot' => $booking['time_slot'],
                    'pickup' => $booking['pickup_location'],
                    'adults' => (int)$booking['numberOfAdultCount'],
                    'children' => (int)$booking['numberOfKidsCount'],
                    'totalPriceUSD' => (float)$booking['total_price_usd'],
                    'totalPriceLKR' => (float)$booking['total_price_lkr'],
                    'phone' => $booking['mobile'],
                    'booking_id' => $booking['id'], // Use the id as booking_id
                ];
                @sendBookingConfirmationEmail($bookingData);
                @sendAdminNotificationEmail($bookingData);
            }
        }

        echo 'OK';
        exit;
    } catch (Throwable $e) {
        error_log('Notify error: ' . $e->getMessage());
        http_response_code(500);
        echo 'Server error';
        exit;
    }
}

// For non-success, optionally mark as failed (status_id = 2)
try {
    Database::iud("UPDATE booking SET status_id = 2 WHERE id = '$orderIdEsc' AND status_id <> 1");
} catch (Throwable $e) {}
echo 'IGNORED';
exit;
?>



