<?php
require_once '../connection.php';
header('Content-Type: application/json');

// simple input fetch
$email = trim($_POST['email'] ?? '');
$description = trim($_POST['description'] ?? '');
$currency_id = intval($_POST['currency_id'] ?? 0);
$amount = floatval($_POST['amount'] ?? 0);
$lkr_amount = floatval($_POST['lkr_amount'] ?? 0);

if (empty($email) || empty($description) || $currency_id <= 0 || $amount <= 0 || $lkr_amount <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid input — description is required and amounts must be > 0']);
    exit;
}

// generate id and timestamps
$now = new DateTime();
$order_id = 'BLAZE-PAY-' . rand(10000, 99999);
$createdAt = $now->format('Y-m-d H:i:s');

// escape
$e = Database::escape_string($email);
$desc = Database::escape_string($description);
$cid = Database::escape_string($currency_id);
$amt = Database::escape_string($amount);
$lkr = Database::escape_string($lkr_amount);
$created = Database::escape_string($createdAt);
$idEsc = Database::escape_string($order_id);

// status_id = 1 (as requested)
// ensure paynow table has `description` column
$query = "INSERT INTO paynow (id,email,description,currency_id,amount,lkr_amount,status_id,createdAt)
          VALUES ('$idEsc', '$e', '$desc', $cid, $amt, $lkr, 1, '$created')";

try {
    $ok = Database::iud($query);

    // Robust verification: check if row actually exists
    $check = Database::search("SELECT id FROM paynow WHERE id = '$idEsc' LIMIT 1");
    if ($check && $check->num_rows > 0) {
        echo json_encode(['success' => true, 'id' => $order_id]);
        exit;
    }

    $dbError = (isset(Database::$connection) && Database::$connection->error) ? Database::$connection->error : 'Database insert failed';
    echo json_encode(['success' => false, 'message' => $dbError]);
    exit;
} catch (Throwable $t) {
    error_log($t->getMessage());
    echo json_encode(['success' => false, 'message' => 'Server error']);
    exit;
}
?>