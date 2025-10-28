
<?php
require_once '../connection.php';
header('Content-Type: application/json');

if (!isset($_POST['value'])) {
    echo json_encode(['success' => false, 'message' => 'No value provided']);
    exit;
}

$value = intval($_POST['value']);

if ($value < 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid value']);
    exit;
}

// Update or insert if not exists
$query = "INSERT INTO advance (id, value) VALUES (1, $value) 
          ON DUPLICATE KEY UPDATE value = $value";

try {
    $result = Database::iud($query);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
?>