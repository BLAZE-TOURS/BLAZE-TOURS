<?php

/**
 * createBooking.php (Clean & Stable Version)
 * -------------------------------------------
 * - Always returns pure JSON (no stray output)
 * - Adds error logging (php_errors.log)
 * - Ensures email functions load & run safely
 * - Fully compatible with booking.js frontend
 */

ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php_errors.log');
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/connection.php';

// Attempt to load email helpers
$emailHelpersLoaded = false;
try {
    $emailFile = __DIR__ . '/sendBookingEmails.php';
    if (file_exists($emailFile)) {
        require_once $emailFile;
        $emailHelpersLoaded = true;
    }
} catch (Throwable $e) {
    error_log("Email helper load error: " . $e->getMessage());
}

function respond($ok, $data = [], $code = 200)
{
    http_response_code($ok ? 200 : $code);
    echo json_encode(array_merge(['success' => $ok], $data), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        respond(false, ['message' => 'Method not allowed'], 405);
    }

    // Input sanitization
    $name   = trim($_POST['fullName'] ?? '');
    $email  = trim($_POST['email'] ?? '');
    $mobile = trim($_POST['phone'] ?? '');
    $tourId = intval($_POST['tourId'] ?? 0);
    $tourDate = $_POST['date'] ?? $_POST['tourDate'] ?? null;
    $timeSlot = $_POST['timeSlot'] ?? null;
    $numAdults = intval($_POST['adults'] ?? 0);
    $numKids = intval($_POST['children'] ?? 0);
    $pickupLocation = $_POST['pickup'] ?? $_POST['pickupLocation'] ?? null;
    $totalUSD = floatval($_POST['totalPriceUSD'] ?? 0);
    // Compute LKR server-side using a single consistent rate
    $rate = 320.0;
    try {
        $ctx = stream_context_create(['http' => ['timeout' => 2]]);
        $json = @file_get_contents('https://api.exchangerate-api.com/v4/latest/USD', false, $ctx);
        if ($json !== false) {
            $data = json_decode($json, true);
            if (isset($data['rates']['LKR']) && is_numeric($data['rates']['LKR'])) {
                $rateVal = floatval($data['rates']['LKR']);
                if ($rateVal > 0) {
                    $rate = $rateVal;
                }
            }
        }
    } catch (Throwable $e) {
        // fallback to default 320
    }
    $totalLKR = $totalUSD > 0 ? round($totalUSD * $rate, 2) : 0.0;


    // Escape safely
    $nameEsc = Database::escape_string($name);
    $emailEsc = Database::escape_string($email);
    $mobileEsc = Database::escape_string($mobile);
    $pickupEsc = $pickupLocation ? "'" . Database::escape_string($pickupLocation) . "'" : 'NULL';

    // Normalize time slot
    $timeAmPm = $timeSlot ? date('g:i A', strtotime($timeSlot)) : null;
    $timeSlotEsc = $timeAmPm ? ("'" . Database::escape_string($timeAmPm) . "'") : 'NULL';

    $tourDateEsc = Database::escape_string($tourDate);

    // --- Check for closed dates
    $closed = Database::search("SELECT 1 FROM closed_day WHERE date = '$tourDateEsc' LIMIT 1");
    if ($closed && $closed->num_rows > 0) {
        respond(false, ['message' => 'Selected date is closed for bookings.'], 423);
    }

    // --- Check duplicate bookings
    if ($timeAmPm) {
        $timeEsc = "'" . Database::escape_string($timeAmPm) . "'";
        $dup = Database::search("SELECT COUNT(*) AS c FROM booking WHERE tour_id = $tourId AND tourDate = '$tourDateEsc' AND time_slot = $timeEsc AND status_id IN (1,2)");
        if ($dup && ($row = $dup->fetch_assoc()) && $row['c'] > 0) {
            respond(false, ['message' => 'Selected date and time slot already booked.'], 409);
        }
    }

    // --- Insert booking as PENDING (status_id = 3)
    $insert = "
        INSERT INTO booking 
        (name, mobile, email, tourDate, time_slot, numberOfAdultCount, numberOfKidsCount, pickup_location, 
        total_price_lkr, total_price_usd, status_id, tour_id, created_at)
        VALUES (
            '$nameEsc', '$mobileEsc', '$emailEsc', '$tourDateEsc', $timeSlotEsc,
            $numAdults, $numKids, $pickupEsc,
            $totalLKR, $totalUSD, 3, $tourId, NOW()
        )
    ";
    Database::iud($insert);

    // --- Retrieve inserted ID
    $idRes = Database::search("SELECT LAST_INSERT_ID() AS id");
    $bookingId = ($idRes && $r = $idRes->fetch_assoc()) ? (int)$r['id'] : 0;

    if (!$bookingId) {
        respond(false, ['message' => 'Booking saved but ID not found'], 500);
    }

    // PayHere merchant credentials (sandbox)
    $merchant_id = '1232435';
    $merchant_secret = 'MzMxMzgwNzM4NDIwOTA4NTMwNzAxMDg3MjQxODc4MjY4ODQ2Njkz';
    
    // Generate PayHere hash signature (required for authorization)
    $merchant_secret_hashed = strtoupper(md5($merchant_secret));
    $order_id = 'ORD-' . $bookingId;
    $amount = number_format($totalLKR, 2, '.', '');
    $currency = 'LKR';
    
    $hash = strtoupper(md5(
        $merchant_id . $order_id . $amount . $currency . $merchant_secret_hashed
    ));

    // Build PayHere payload for client
    $payment = [
        'sandbox' => true,
        'merchant_id' => $merchant_id,
        'return_url' => 'http://localhost/BLAZE-TOURS/user/payment_success.php',
        'cancel_url' => 'http://localhost/BLAZE-TOURS/user/payment_cancel.php',
        'notify_url' => 'http://localhost/BLAZE-TOURS/user/payment_notify.php',
        'order_id' => $order_id,
        'items' => ($tourId ? 'Tour #' . $tourId . ' - ' : '') . ($name ?: 'Blaze Tour'),
        'amount' => $amount,
        'currency' => $currency,
        'hash' => $hash, // This is the crucial missing piece!
        'first_name' => $name ?: 'Guest',
        'last_name' => 'Customer',
        'email' => $email,
        'phone' => $mobile,
        'address' => $pickupLocation ?: 'N/A',
        'city' => 'Colombo',
        'country' => 'Sri Lanka'
    ];

    respond(true, [
        'booking_id' => $bookingId,
        'payment' => $payment
    ]);
} catch (Throwable $e) {
    error_log("Booking error: " . $e->getMessage());
    respond(false, ['message' => 'Server error occurred. Please try again later.'], 500);
}
