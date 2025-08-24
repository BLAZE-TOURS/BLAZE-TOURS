
<?php
require 'connection.php';

$data = json_decode(file_get_contents("php://input"), true);

$name = Database::escape_string($data['name'] ?? '');
$email = Database::escape_string($data['email'] ?? '');
$mobile = Database::escape_string($data['mobile'] ?? '');
$message = Database::escape_string($data['message'] ?? '');

if (!$name || !$email || !$mobile || !$message) {
    echo json_encode(['success' => false, 'error' => 'All fields required']);
    exit;
}

$dateTime = date('Y-m-d H:i:s');
$status_id = 1;

$sql = "INSERT INTO massage (fullName, email, mobile, massage, dateTime, status_id) VALUES ('$name', '$email', '$mobile', '$message', '$dateTime', $status_id)";

try {
    Database::iud($sql);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}