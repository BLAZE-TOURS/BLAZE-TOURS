<?php
// PayHere server-to-server notify handler
// Docs: https://support.payhere.lk/api-&-mobile-sdk/payhere-checkout

// Log errors
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/assets/process/php_errors.log');

require_once __DIR__ . '/assets/process/connection.php';
require_once __DIR__ . '/assets/process/logger.php';

// Required fields from PayHere
$merchant_id      = $_POST['merchant_id'] ?? '';
$order_id         = $_POST['order_id'] ?? '';
$payhere_amount   = $_POST['payhere_amount'] ?? '';
$payhere_currency = $_POST['payhere_currency'] ?? '';
$status_code      = $_POST['status_code'] ?? '';
$md5sig           = $_POST['md5sig'] ?? '';

BlazeLogger::info('notify: received', [
	'order_id' => $order_id,
	'amount' => $payhere_amount,
	'currency' => $payhere_currency,
	'status_code' => $status_code
]);

// Merchant secret (KEEP SECRET, do not expose to client)
$merchant_secret = 'MzMxMzgwNzM4NDIwOTA4NTMwNzAxMDg3MjQxODc4MjY4ODQ2Njkz';

// Verify signature as per PayHere docs
$local_md5sig = strtoupper(md5(
	$merchant_id . $order_id . $payhere_amount . $payhere_currency . $status_code . strtoupper(md5($merchant_secret))
));

if ($local_md5sig !== $md5sig) {
	BlazeLogger::error('notify: invalid signature', ['order_id' => $order_id]);
	http_response_code(400);
	echo 'Invalid signature';
	exit;
}

// Extract booking id - now using custom booking ID format
$customBookingId = $order_id; // order_id is now the custom booking ID

if (empty($customBookingId)) {
	BlazeLogger::error('notify: empty order_id');
	http_response_code(400);
	echo 'Invalid order id';
	exit;
}

// Validate that the booking exists
try {
	$orderIdEsc = Database::escape_string($customBookingId);
	$res = Database::search("SELECT id FROM booking WHERE id = '$orderIdEsc' LIMIT 1");
	if (!$res || $res->num_rows == 0) {
		BlazeLogger::error('notify: booking not found', ['order_id' => $customBookingId]);
		http_response_code(400);
		echo 'Booking not found';
		exit;
	}
} catch (Throwable $e) {
	BlazeLogger::error('notify: db error', ['error' => $e->getMessage()]);
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
		Database::iud("UPDATE booking SET status_id = 1, payment_id = '$paymentId', payment_method = '$method' WHERE id = '$orderIdEsc' AND status_id = 3");
		BlazeLogger::info('notify: status set to PAID', ['order_id' => $customBookingId, 'payment_id' => $paymentId]);

		echo 'OK';
		exit;
	} catch (Throwable $e) {
		BlazeLogger::error('notify: exception', ['error' => $e->getMessage()]);
		http_response_code(500);
		echo 'Server error';
		exit;
	}
}

// For non-success, optionally mark as failed (status_id = 2)
try {
	Database::iud("UPDATE booking SET status_id = 2 WHERE id = '$orderIdEsc' AND status_id <> 1");
	BlazeLogger::info('notify: set to CANCELLED/FAILED', ['order_id' => $customBookingId]);
} catch (Throwable $e) {
	BlazeLogger::error('notify: set failed error', ['error' => $e->getMessage()]);
}
echo 'IGNORED';
exit;
?>



