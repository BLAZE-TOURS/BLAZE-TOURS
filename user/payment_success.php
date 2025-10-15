<?php
// After PayHere returns user here. We expect order_id in GET like ORD-<bookingId>
$orderId = $_GET['order_id'] ?? '';
// Extract numeric booking id
$bookingId = 0;
if (preg_match('/ORD-(\d+)/', $orderId, $m)) {
    $bookingId = (int)$m[1];
}
// Redirect to invoice; notify handler is authoritative for DB/email
if ($bookingId > 0) {
    header('Location: invoice.php?order_id=' . $bookingId);
    exit;
}
// Fallback
header('Location: index.php');
exit;
?>



