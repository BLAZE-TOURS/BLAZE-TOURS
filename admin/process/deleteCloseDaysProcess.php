<?php
require "../connection.php";
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? '';
    if (empty($id)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid close day ID']);
        exit();
    }

    $id = Database::escape_string($id);

    try {
        Database::iud("DELETE FROM closed_day WHERE id = '$id'");
        echo json_encode(['status' => 'success', 'message' => 'Closed day deleted successfully']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
