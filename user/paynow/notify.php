<?php
// notify.php
require "connection.php";

// 1. PayHere එකෙන් එවන දත්ත ලබා ගැනීම
$merchant_id         = $_POST['merchant_id'];
$order_id            = $_POST['order_id'];
$payhere_amount      = $_POST['payhere_amount'];
$payhere_currency    = $_POST['payhere_currency'];
$status_code         = $_POST['status_code'];
$md5sig              = $_POST['md5sig'];

// Error Message එක ලබා ගැනීම (Insufficient Funds, etc.)
$status_message      = isset($_POST['status_message']) ? $_POST['status_message'] : "Unknown Status";
$payment_id          = isset($_POST['payment_id']) ? $_POST['payment_id'] : "0"; // PayHere Transaction ID

// 2. Local Secret එක (index.php එකේ දුන් එකම විය යුතුයි)
$merchant_secret = "MzMxMzgwNzM4NDIwOTA4NTMwNzAxMDg3MjQxODc4MjY4ODQ2Njkz"; 

// 3. Security Check: Validate MD5 Signature
// PayHere notify එකේ hash හදන විදිය වෙනස්:
// Formula: merchant_id + order_id + payhere_amount + payhere_currency + status_code + strtoupper(md5(merchant_secret))
$local_md5sig = strtoupper(md5($merchant_id . $order_id . $payhere_amount . $payhere_currency . $status_code . strtoupper(md5($merchant_secret))));

if (($local_md5sig === $md5sig) AND ($status_code == 2) ) {
    
    // --- PAYMENT SUCCESS (Code 2) ---
    // මෙතනදි තමයි සල්ලි ලැබුනා කියලා update කරන්නේ
    
    $q = "UPDATE payments SET 
            status = 'Success', 
            status_code = '$status_code',
            status_message = 'Payment Completed Successfully',
            transaction_id = '$payment_id'
          WHERE order_id = '$order_id'";
          
    Database::iud($q);

} else if ($status_code == -1) {

    // --- CANCELED (Code -1) ---
    // User payment එක cancel කළා
    
    $q = "UPDATE payments SET 
            status = 'Canceled', 
            status_code = '$status_code',
            status_message = 'User canceled the payment'
          WHERE order_id = '$order_id'";
          
    Database::iud($q);

} else if ($status_code == -2) {

    // --- FAILED / ERROR (Code -2) ---
    // මෙතනදි තමයි Bank Errors අල්ලගන්නේ.
    // PayHere විසින් $status_message එකේ එවනවා "Insufficient Funds", "Do Not Honor" වගේ දේවල්.
    
    $clean_msg = Database::escape_string($status_message);
    
    $q = "UPDATE payments SET 
            status = 'Failed', 
            status_code = '$status_code',
            status_message = '$clean_msg' 
          WHERE order_id = '$order_id'";
          
    Database::iud($q);

} else {
    // Other statuses (Pending / Chargeback)
    $q = "UPDATE payments SET status_code = '$status_code' WHERE order_id = '$order_id'";
    Database::iud($q);
}

?>