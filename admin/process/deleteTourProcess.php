
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

// Check if tour exists
$res = Database::search("SELECT id FROM tour WHERE id = $id");
if ($res->num_rows == 0) {
    echo json_encode(['success' => false, 'message' => 'Tour not found']);
    exit();
}

// Delete tour
Database::iud("DELETE FROM tour WHERE id = $id");

echo json_encode(['success' => true, 'message' => 'Tour deleted successfully']);
?>