<?php
require "../connection.php";
header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = Database::search("SELECT * FROM `shorts` WHERE `id` = $id LIMIT 1");
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['success' => true, 'shorts' => $row]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Shorts not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>