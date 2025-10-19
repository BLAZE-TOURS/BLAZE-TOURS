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
	if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
		respond(false, ['message' => 'Method not allowed'], 405);
	}

	$orderId = trim($_POST['order_id'] ?? '');
	if ($orderId === '') {
		respond(false, ['message' => 'Missing order_id'], 400);
	}

	BlazeLogger::info('markPaid: start', ['order_id' => $orderId]);
	$orderIdEsc = Database::escape_string($orderId);

	// Update to PAID only if currently PENDING (3)
	Database::iud("UPDATE booking SET status_id = 1 WHERE id = '$orderIdEsc' AND status_id = 3");
	BlazeLogger::info('markPaid: status set to PAID (if was pending)', ['order_id' => $orderId]);

	// Fetch booking for email
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

		$customerOk = $emailHelpersLoaded ? @sendBookingConfirmationEmail($bookingData) : false;
		$adminOk = $emailHelpersLoaded ? @sendAdminNotificationEmail($bookingData) : false;
		BlazeLogger::info('markPaid: emails attempted', ['customer_ok' => $customerOk, 'admin_ok' => $adminOk]);
	}

	respond(true, ['message' => 'Marked as PAID']);
} catch (Throwable $e) {
	BlazeLogger::error('markPaid: exception', ['error' => $e->getMessage()]);
	respond(false, ['message' => 'Server error'], 500);
}
