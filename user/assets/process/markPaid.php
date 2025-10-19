<?php

require_once __DIR__ . '/connection.php';
require_once __DIR__ . '/logger.php';

// Load email helpers if available
$emailHelpersLoaded = false;
try {
    $emailFile = __DIR__ . '/sendBookingEmails.php';
    if (file_exists($emailFile)) {
        require_once $emailFile;
        $emailHelpersLoaded = true;
    }
} catch (Throwable $e) {
    BlazeLogger::error('markPaid: email helper load error', ['error' => $e->getMessage()]);
}

header('Content-Type: application/json; charset=utf-8');

function respond($ok, $data = [], $code = 200) {
    http_response_code($ok ? 200 : $code);
    echo json_encode(array_merge(['success' => $ok], $data), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    // Accept both form-encoded POST and JSON body (some integrations send JSON)
    $inputOrderId = null;
    $payment_id = null;
    $payment_method = null;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        respond(false, ['message' => 'Method not allowed'], 405);
    }

    // Try form-data first
    if (!empty($_POST['order_id'])) {
        $inputOrderId = trim($_POST['order_id']);
        $payment_id = isset($_POST['payment_id']) ? trim($_POST['payment_id']) : null;
        $payment_method = isset($_POST['method']) ? trim($_POST['method']) : null;
    } else {
        // Try JSON body
        $raw = file_get_contents('php://input');
        if ($raw) {
            $decoded = json_decode($raw, true);
            if (json_last_error() === JSON_ERROR_NONE && !empty($decoded['order_id'])) {
                $inputOrderId = trim($decoded['order_id']);
                $payment_id = $decoded['payment_id'] ?? null;
                $payment_method = $decoded['method'] ?? null;
            }
        }
    }

    if ($inputOrderId === null || $inputOrderId === '') {
        respond(false, ['message' => 'Missing order_id'], 400);
    }

    BlazeLogger::info('markPaid: start', ['order_id' => $inputOrderId, 'payment_id' => $payment_id, 'method' => $payment_method]);
    $orderIdEsc = Database::escape_string($inputOrderId);

    // Verify booking exists
    $resCheck = Database::search("SELECT id, email, status_id FROM booking WHERE id = '$orderIdEsc' LIMIT 1");
    if (!$resCheck || $resCheck->num_rows === 0) {
        BlazeLogger::error('markPaid: booking not found', ['order_id' => $inputOrderId]);
        respond(false, ['message' => 'Booking not found'], 404);
    }

    $bookingRow = $resCheck->fetch_assoc();
    $currentStatus = (int)$bookingRow['status_id'];

    // Build update SQL - set status to PAID (1) and set payment_id/method if provided
    $setParts = ["status_id = 1"];
    if (!empty($payment_id)) {
        $paymentIdEsc = Database::escape_string($payment_id);
        $setParts[] = "payment_id = '$paymentIdEsc'";
    }
    if (!empty($payment_method)) {
        $methodEsc = Database::escape_string($payment_method);
        $setParts[] = "payment_method = '$methodEsc'";
    }

    $setSql = implode(', ', $setParts);

    // Only update if not already paid
    Database::iud("UPDATE booking SET $setSql WHERE id = '$orderIdEsc' AND status_id <> 1");
    $affected = Database::$connection->affected_rows ?? null;
    BlazeLogger::info('markPaid: update attempted', ['order_id' => $inputOrderId, 'affected_rows' => $affected]);

    // Fetch booking to prepare emails
    $res = Database::search("SELECT b.*, t.name AS tour_name FROM booking b LEFT JOIN tour t ON t.id = b.tour_id WHERE b.id = '$orderIdEsc' LIMIT 1");
    if ($res && $res->num_rows > 0) {
        $booking = $res->fetch_assoc();
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
            'booking_id' => $booking['id'],
        ];

        // Attempt emails only if email helper loaded
        if ($emailHelpersLoaded) {
            try {
                $customerOk = @sendBookingConfirmationEmail($bookingData);
                $adminOk = @sendAdminNotificationEmail($bookingData);
                BlazeLogger::info('markPaid: emails attempted', ['customer_ok' => $customerOk, 'admin_ok' => $adminOk]);
            } catch (Throwable $e) {
                BlazeLogger::error('markPaid: send email exception', ['error' => $e->getMessage()]);
            }
        } else {
            BlazeLogger::info('markPaid: email helper not loaded, skipping emails', ['order_id' => $inputOrderId]);
        }
    }

    respond(true, ['message' => 'Marked as PAID', 'affected_rows' => $affected]);
} catch (Throwable $e) {
    BlazeLogger::error('markPaid: exception', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
    respond(false, ['message' => 'Server error'], 500);
}
