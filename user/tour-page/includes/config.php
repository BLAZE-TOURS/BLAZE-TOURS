<?php
// tour-page/includes/config.php

// PayHere Sandbox Credentials
define('MERCHANT_ID', '1232435'); 
define('MERCHANT_SECRET', 'MzMxMzgwNzM4NDIwOTA4NTMwNzAxMDg3MjQxODc4MjY4ODQ2Njkz'); 
define('PayHere_URL', 'https://sandbox.payhere.lk/pay/checkout');

// Base URL (ඔයාගේ ෆෝල්ඩර් එකට අදාල path එක මෙතන දාන්න)
// උදා: http://localhost/BLAZE-TOURS/tour-page/
define('BASE_PATH', 'http://localhost/BLAZE-TOURS/user/tour-page/');

// URLs
define('NOTIFY_URL', 'https://2fcfa6fcfc8f.ngrok-free.app/BLAZE-TOURS/user/tour-page/notify.php'); // Live Server
define('RETURN_URL', BASE_PATH . 'return.php');
define('CANCEL_URL', BASE_PATH . 'cancel.php');
?>