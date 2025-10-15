<?php
$orderId = $_GET['order_id'] ?? '';
// Optionally mark booking as cancelled (status_id = 2) if needed
require_once __DIR__ . '/assets/process/connection.php';
if (preg_match('/ORD-(\d+)/', $orderId, $m)) {
    $bookingId = (int)$m[1];
    try {
        Database::iud("UPDATE booking SET status_id = 2 WHERE id = $bookingId AND status_id = 3");
    } catch (Throwable $e) {}
}
header('Location: index.php');
exit;
?>



