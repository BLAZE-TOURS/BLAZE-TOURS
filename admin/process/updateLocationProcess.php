<?php
require_once '../connection.php';

header('Content-Type: application/json');

$id = intval($_POST['id'] ?? 0);
$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');
$stop_duration_time = intval($_POST['stop_duration_time'] ?? 0);

if ($id <= 0 || $name == '') {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
    exit;
}

Database::setUpConnection();
$id_escaped = Database::escape_string($id);
$name_escaped = Database::escape_string($name);
$description_escaped = Database::escape_string($description);
$stop_duration_time_escaped = Database::escape_string($stop_duration_time);

$query = "UPDATE location SET name='$name_escaped', description='$description_escaped', stop_duration_time='$stop_duration_time_escaped' WHERE id='$id_escaped'";

try {
    Database::iud($query);
    echo json_encode(['success' => true, 'message' => 'Location updated successfully']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Update failed']);
}
?>