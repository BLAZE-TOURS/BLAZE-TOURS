<?php
error_reporting(E_ALL);
ini_set('display_errors', 0); // Don't display errors in production

require_once __DIR__ . '/../../assets/process/connection.php';

// Configuration - Replace with your actual values
$merchant_id = '1232435'; // Your PayHere Merchant ID
$merchant_secret = 'MzMxMzgwNzM4NDIwOTA4NTMwNzAxMDg3MjQxODc4MjY4ODQ2Njkz'; // Your PayHere Merchant Secret (from dashboard)

header('Content-Type: text/plain; charset=utf-8');

// Only handle POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Method not allowed';
    exit;
}

try {
    // Get POST parameters
    $order_id = trim($_POST['order_id'] ?? '');
    $status_code = intval($_POST['status_code'] ?? 0);
    $payhere_amount = floatval($_POST['payhere_amount'] ?? 0);
    $payhere_currency = trim($_POST['payhere_currency'] ?? '');
    $md5sig = trim($_POST['md5sig'] ?? '');
    $payment_id = trim($_POST['payment_id'] ?? '');
    $method = trim($_POST['method'] ?? '');

    // Validate required fields
    if (empty($order_id) || empty($md5sig)) {
        echo 'Invalid notification';
        exit;
    }

    // Verify MD5 signature
    $local_md5sig = md5($merchant_id . $order_id . $payhere_amount . $payhere_currency . $status_code . $merchant_secret);
    if (strtolower($local_md5sig) !== strtolower($md5sig)) {
        // Invalid signature - log and ignore
        error_log("PayHere IPN: Invalid MD5 signature for order_id: $order_id");
        echo 'Invalid signature';
        exit;
    }

    // Determine new status_id based on status_code (Updated to match your DB: 1=success, 2=failed, 3=pending)
    $new_status_id = 3; // default pending
    if ($status_code == 2) {
        $new_status_id = 1; // success
    } elseif ($status_code == -1 || $status_code == -2) {
        $new_status_id = 2; // failed
    }

    // Update database
    $order_id_esc = Database::escape_string($order_id);
    $payment_id_esc = Database::escape_string($payment_id);
    $status_code_esc = Database::escape_string($status_code);
    $amount_esc = Database::escape_string($payhere_amount);
    $method_esc = Database::escape_string($method);

    $update_query = "UPDATE paynow 
                     SET status_id = $new_status_id, 
                         payment_id = '$payment_id_esc', 
                         payhere_status_code = $status_code_esc,
                         payhere_amount = $amount_esc,
                         payhere_method = '$method_esc',
                         updatedAt = '" . date('Y-m-d H:i:s') . "'
                     WHERE id = '$order_id_esc' 
                     AND status_id = 3"; // Only update if pending

    $result = Database::iud($update_query);

    if ($result) {
        // Log success (optional, if you have logger)
        error_log("PayHere IPN: Updated order_id: $order_id to status: $new_status_id");
    } else {
        error_log("PayHere IPN: Failed to update order_id: $order_id");
    }

    // Acknowledge the notification
    echo 'OK';

} catch (Throwable $e) {
    error_log("PayHere IPN Error: " . $e->getMessage());
    echo 'Error';
    exit;
}
?>