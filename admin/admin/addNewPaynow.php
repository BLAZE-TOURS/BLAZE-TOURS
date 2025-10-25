<?php
require_once '../connection.php';
header('Content-Type: application/json');

// simple input fetch
$email = trim($_POST['email'] ?? '');
$currency_id = intval($_POST['currency_id'] ?? 0);
$amount = floatval($_POST['amount'] ?? 0);
$lkr_amount = floatval($_POST['lkr_amount'] ?? 0);

if (empty($email) || $currency_id <= 0 || $amount <= 0 || $lkr_amount <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

// generate id
$now = new DateTime();
$order_id = 'PAY' . $now->getTimestamp() . rand(1000,9999);
$createdAt = $now->format('Y-m-d H:i:s');

// escape
$e = Database::escape_string($email);
$cid = Database::escape_string($currency_id);
$amt = Database::escape_string($amount);
$lkr = Database::escape_string($lkr_amount);
$created = Database::escape_string($createdAt);
$idEsc = Database::escape_string($order_id);

// status_id = 1 (as requested)
$query = "INSERT INTO paynow (id,email,currency_id,amount,lkr_amount,status_id,createdAt)
          VALUES ('$idEsc', '$e', $cid, $amt, $lkr, 1, '$created')";

try {
    $ok = Database::iud($query);

    // Robust verification: check if row actually exists (handles cases where iud returns false but insert happened)
    $check = Database::search("SELECT id FROM paynow WHERE id = '$idEsc' LIMIT 1");
    if ($check && $check->num_rows > 0) {
        echo json_encode(['success' => true, 'id' => $order_id]);
        exit;
    }

    // If we get here, insert not found — return DB error if available
    $dbError = (isset(Database::$connection) && Database::$connection->error) ? Database::$connection->error : 'Database insert failed';
    echo json_encode(['success' => false, 'message' => $dbError]);
    exit;
} catch (Throwable $t) {
    error_log($t->getMessage());
    echo json_encode(['success' => false, 'message' => 'Server error']);
    exit;
}
?>