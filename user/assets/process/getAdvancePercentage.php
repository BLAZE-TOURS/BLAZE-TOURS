
<?php
require_once 'connection.php';

header('Content-Type: application/json');

try {
    $result = Database::search("SELECT value FROM advance WHERE id = 1 LIMIT 1");
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['success' => true, 'value' => (int)$row['value']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Advance percentage not found']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
?>