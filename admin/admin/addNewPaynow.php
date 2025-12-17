<?php
require_once '../connection.php';
header('Content-Type: application/json');

// --------------------
// INPUT
// --------------------
$email       = trim($_POST['email'] ?? '') ?: 'NO EMAIL';
$description = trim($_POST['description'] ?? '');
$currency_id = (int)($_POST['currency_id'] ?? 0);
$amount      = (float)($_POST['amount'] ?? 0);
$lkr_amount  = (float)($_POST['lkr_amount'] ?? 0);

// --------------------
// VALIDATION
// --------------------
if (!$description || $currency_id <= 0 || $amount <= 0 || $lkr_amount <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid input'
    ]);
    exit;
}

// --------------------
// ORDER ID
// --------------------
$order_id = 'BLAZE-PAY-' . date('YmdHis') . '-' . random_int(100, 999);

// --------------------
// ESCAPE
// --------------------
$order_id   = Database::escape_string($order_id);
$email      = Database::escape_string($email);
$description= Database::escape_string($description);

// --------------------
// INSERT (DON’T TRUST BOOLEAN)
// --------------------
$query = "
INSERT INTO paynow (
    order_id,
    email,
    description,
    currency_id,
    amount,
    lkr_amount,
    status,
    createdAt
) VALUES (
    '$order_id',
    '$email',
    '$description',
    $currency_id,
    $amount,
    $lkr_amount,
    'Success',
    NOW()
)";

Database::iud($query);

// --------------------
// VERIFY USING AFFECTED ROWS (REAL TRUTH)
// --------------------
if (Database::$connection->affected_rows <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Database insert failed'
    ]);
    exit;
}

// --------------------
// SUCCESS RESPONSE
// --------------------
echo json_encode([
    'success'  => true,
    'order_id' => $order_id
]);
exit;
