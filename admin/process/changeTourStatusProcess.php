
<?php
require_once "../connection.php";
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION["adminuser"])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

if (!isset($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit();
}

$id = intval($_POST['id']);

// Get current status
$res = Database::search("SELECT status_id FROM tour WHERE id = $id");
if ($res->num_rows == 0) {
    echo json_encode(['success' => false, 'message' => 'Tour not found']);
    exit();
}
$current = $res->fetch_assoc()['status_id'];
$newStatus = ($current == 1) ? 2 : 1;

// Update status
Database::iud("UPDATE tour SET status_id = $newStatus WHERE id = $id");

echo json_encode(['success' => true, 'message' => 'Tour status updated successfully']);
?>
