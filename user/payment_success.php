<?php
// After PayHere returns user here. We expect order_id in GET (now using custom booking ID)
$orderId = $_GET['order_id'] ?? '';

// Redirect to invoice with the order_id (which is now the custom booking ID)
if (!empty($orderId)) {
    header('Location: invoice.php?order_id=' . urlencode($orderId));
    exit;
}
// Fallback
header('Location: index.php');
exit;
?>



