<?php
require_once '../connection.php';
if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'ID required']);
    exit;
}
$id = Database::escape_string($_GET['id']);
$rs = Database::search("SELECT * FROM meditation_type WHERE id='$id'");
if ($row = $rs->fetch_assoc()) {
    echo json_encode($row);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Not found']);
}
?>