<?php
header('Content-Type: application/json');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo json_encode(['error' => 'Invalid ID']);
    exit;
}

$id = intval($_GET['id']);

require_once '../connection.php';
Database::setUpConnection();

// Use prepared statement for security
$stmt = Database::$connection->prepare('SELECT id, name, description, duration, kids_price, adult_price, maximum_adult_count,maximum_kids_count, tours_type_id FROM tour WHERE id = ? LIMIT 1');
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(['error' => 'Tour not found']);
}

$stmt->close();
Database::$connection->close();
