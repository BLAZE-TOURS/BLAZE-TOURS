<?php
// notify.php
require_once '../assets/process/connection.php';
require_once 'includes/config.php';

// 1. PayHere එවන Data ගැනීම
$merchant_id         = $_POST['merchant_id'];
$order_id            = $_POST['order_id'];
$payhere_amount      = $_POST['payhere_amount']; // PayHere Process කළ LKR ගාන
$payhere_currency    = $_POST['payhere_currency'];
$status_code         = $_POST['status_code'];
$md5sig              = $_POST['md5sig'];
$payment_id          = isset($_POST['payment_id']) ? $_POST['payment_id'] : "0";

// Error Message එක (Insufficient Funds, Do Not Honor වගේ දේවල් එන්නේ මෙතනට)
$status_message      = isset($_POST['status_message']) ? $_POST['status_message'] : "Unknown Status";

// 2. Hash Validation (Security)
$local_md5sig = strtoupper(md5($merchant_id . $order_id . $payhere_amount . $payhere_currency . $status_code . strtoupper(md5(MERCHANT_SECRET))));

if ($local_md5sig === $md5sig) {

    // Status අනුව Database Update කිරීම
    if ($status_code == 2) {
        // --- SUCCESS ---
        $q = "UPDATE paynow SET 
                status = 'Success', 
                status_code = '$status_code',
                status_message = 'Payment Completed Successfully',
                transaction_id = '$payment_id'
              WHERE order_id = '$order_id'";
        Database::iud($q);

    } else if ($status_code == -1) {
        // --- CANCELED ---
        $q = "UPDATE paynow SET 
                status = 'Canceled', 
                status_code = '$status_code',
                status_message = 'User Canceled Payment'
              WHERE order_id = '$order_id'";
        Database::iud($q);

    } else if ($status_code == -2) {
        // --- FAILED / BANK ERRORS ---
        // (Insufficient Funds, Limit Exceeded, etc.)
        
        $clean_msg = Database::escape_string($status_message); // SQL Injection වලක්වා ගැනීම
        
        $q = "UPDATE paynow SET 
                status = 'Failed', 
                status_code = '$status_code',
                status_message = '$clean_msg' 
              WHERE order_id = '$order_id'";
        Database::iud($q);

    } else {
        // Other Statuses (Pending, Chargeback)
        $q = "UPDATE paynow SET status_code = '$status_code' WHERE order_id = '$order_id'";
        Database::iud($q);
    }

    echo "Update Success"; // PayHere වෙත යවන පිළිතුර

} else {
    // Hash වරදිනම්
    echo "Hash Mismatch";
}
?>