<?php
// After PayHere returns user here. We expect order_id in GET (now using custom booking ID)
$orderId = $_GET['order_id'] ?? '';

require_once __DIR__ . '/assets/process/logger.php';

if (!empty($orderId)) {
	// Update booking status to PAID and send emails
	require_once __DIR__ . '/assets/process/connection.php';
	require_once __DIR__ . '/assets/process/sendBookingEmails.php';

	BlazeLogger::info('payment_success: start', ['order_id' => $orderId]);

	try {
		// Update booking status to PAID (status_id = 1)
		$orderIdEsc = Database::escape_string($orderId);
		Database::iud("UPDATE booking SET status_id = 1 WHERE id = '$orderIdEsc' AND status_id = 3");
		BlazeLogger::info('payment_success: status updated to PAID', ['order_id' => $orderId]);

		// Fetch booking data for email
		$res = Database::search("SELECT b.*, t.name AS tour_name FROM booking b LEFT JOIN tour t ON t.id = b.tour_id WHERE b.id = '$orderIdEsc' LIMIT 1");

		if ($res && $res->num_rows > 0) {
			$booking = $res->fetch_assoc();
			BlazeLogger::info('payment_success: booking fetched', ['id' => $orderId, 'email' => $booking['email']]);

			// Prepare email data
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

			// Send emails
			$customerOk = @sendBookingConfirmationEmail($bookingData);
			$adminOk = @sendAdminNotificationEmail($bookingData);
			BlazeLogger::info('payment_success: emails sent', ['customer_ok' => $customerOk, 'admin_ok' => $adminOk]);
		}

		// Redirect to invoice
		BlazeLogger::info('payment_success: redirecting to invoice', ['order_id' => $orderId]);
		header('Location: invoice.php?order_id=' . urlencode($orderId));
		exit;

	} catch (Exception $e) {
		BlazeLogger::error('payment_success: exception', ['error' => $e->getMessage()]);
		// Still redirect to invoice even if email fails
		header('Location: invoice.php?order_id=' . urlencode($orderId));
		exit;
	}
}

// Fallback
BlazeLogger::error('payment_success: missing order_id');
header('Location: index.php');
exit;
?>



