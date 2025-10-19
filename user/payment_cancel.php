<?php
$orderId = $_GET['order_id'] ?? '';
// Optionally mark booking as cancelled (status_id = 2) if needed
require_once __DIR__ . '/assets/process/connection.php';

if (!empty($orderId)) {
    try {
        // Update booking status to cancelled using id (which is now the custom booking ID)
        $orderIdEsc = Database::escape_string($orderId);
        Database::iud("UPDATE booking SET status_id = 2 WHERE id = '$orderIdEsc' AND status_id = 3");
    } catch (Throwable $e) {
        error_log("Error updating booking status: " . $e->getMessage());
    }
}
header('Location: index.php');
exit;
?>



