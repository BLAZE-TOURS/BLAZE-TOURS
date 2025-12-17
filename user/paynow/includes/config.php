<?php
// includes/config.php

define('MERCHANT_ID', '1232435'); // ඔබේ Merchant ID
define('MERCHANT_SECRET', 'MzMxMzgwNzM4NDIwOTA4NTMwNzAxMDg3MjQxODc4MjY4ODQ2Njkz'); // ඔබේ Secret Code
define('PayHere_URL', 'https://sandbox.payhere.lk/pay/checkout'); // Live යන විට මෙය වෙනස් කරන්න (https://www.payhere.lk/pay/checkout)

// Notify URL එක හරියටම දෙන්න (Localhost නම් Ngrok හෝ Live Domain එකක් විය යුතුයි)
define('NOTIFY_URL', 'https://747ad1195453.ngrok-free.app/BLAZE-TOURS/user/paynow/notify.php');

// ආපසු එන URL (index.php එකටම එන විදියට හදමු)
define('RETURN_URL', 'http://localhost/BLAZE-TOURS/user/paynow/return.php');
define('CANCEL_URL', 'http://localhost/BLAZE-TOURS/user/paynow/cancel.php');
