<?php
require_once '../connection.php';

header('Content-Type: application/json');

$id = intval($_POST['id'] ?? 0);

if ($id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid ID']);
    exit;
}

Database::setUpConnection();
$id_escaped = Database::escape_string($id);
$result = Database::search("SELECT * FROM location WHERE id = $id_escaped LIMIT 1");

if ($row = $result->fetch_assoc()) {
    echo json_encode(['success' => true, 'data' => $row]);
} else {
    echo json_encode(['success' => false, 'message' => 'Location not found']);
}
?>