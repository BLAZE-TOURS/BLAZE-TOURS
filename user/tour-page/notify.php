<?php
// tour-page/notify.php
require_once '../assets/process/connection.php'; // Connection from outside
require_once 'includes/config.php'; // Config from inside

$merchant_id         = $_POST['merchant_id'];
$order_id            = $_POST['order_id'];
$payhere_amount      = $_POST['payhere_amount'];
$payhere_currency    = $_POST['payhere_currency'];
$status_code         = $_POST['status_code'];
$md5sig              = $_POST['md5sig'];
$status_message      = isset($_POST['status_message']) ? $_POST['status_message'] : "Unknown";
$payment_id          = isset($_POST['payment_id']) ? $_POST['payment_id'] : "0";

$local_md5sig = strtoupper(md5($merchant_id . $order_id . $payhere_amount . $payhere_currency . $status_code . strtoupper(md5(MERCHANT_SECRET))));

if ($local_md5sig === $md5sig) {
    if ($status_code == 2) {
        $q = "UPDATE booking SET status = 'Success', status_code = '$status_code', status_message = 'Payment Received', transaction_id = '$payment_id' WHERE order_id = '$order_id'";
        Database::iud($q);
    } else if ($status_code == -1) {
        $q = "UPDATE booking SET status = 'Canceled', status_code = '$status_code', status_message = 'User Canceled' WHERE order_id = '$order_id'";
        Database::iud($q);
    } else if ($status_code == -2) {
        $clean_msg = Database::escape_string($status_message);
        $q = "UPDATE booking SET status = 'Failed', status_code = '$status_code', status_message = '$clean_msg' WHERE order_id = '$order_id'";
        Database::iud($q);
    }
}
?>