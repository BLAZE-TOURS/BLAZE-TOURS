<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../assets/process/connection.php';

header('Content-Type: application/json; charset=utf-8');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Method not allowed']);
        exit;
    }

    $email = trim($_POST['email'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $currency_id = intval($_POST['currency_id'] ?? 0);
    $amount = floatval($_POST['amount'] ?? 0);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
        exit;
    }
    if (empty($description)) {
        echo json_encode(['success' => false, 'message' => 'Description is required.']);
        exit;
    }
    if ($currency_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid currency selected.']);
        exit;
    }
    if ($amount <= 0) {
        echo json_encode(['success' => false, 'message' => 'Amount must be greater than zero.']);
        exit;
    }

    // Check currency rate
    $cid = Database::escape_string($currency_id);
    $res = Database::search("SELECT LKR FROM currency WHERE id = $cid LIMIT 1");
    if (!$res || $res->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Currency not found.']);
        exit;
    }

    $row = $res->fetch_assoc();
    $rate = floatval($row['LKR'] ?? 0);
    $lkr_amount = $rate > 0 ? round($amount * $rate, 2) : 0.0;

    // Insert payment
    $id = 'BLAZE-PAY-' . rand(10000, 99999);
    $emailEsc = Database::escape_string($email);
    $descEsc = Database::escape_string($description);
    $createdAt = date('Y-m-d H:i:s');
    $status_id = 3; // pending

    $q = "INSERT INTO paynow (id, email, description, currency_id, amount, lkr_amount, status_id, createdAt)
          VALUES ('$id', '$emailEsc', '$descEsc', $currency_id, $amount, $lkr_amount, $status_id, '" . Database::escape_string($createdAt) . "')";
    Database::iud($q);

    echo json_encode([
        'success' => true,
        'message' => 'Payment request saved successfully!',
        'id' => $id,
        'lkr' => $lkr_amount
    ]);
    exit;

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Internal server error: ' . $e->getMessage()]);
    exit;
}
?>