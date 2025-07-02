
<?php
require_once __DIR__ . '/../../connection.php';

$tour_id = isset($_POST['tour_id']) ? intval($_POST['tour_id']) : 0;

$where = $tour_id ? "WHERE tour_id = $tour_id" : "";

$query = "SELECT * FROM location $where";
$result = Database::search($query);

$locations = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $locations[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode(['success' => true, 'data' => $locations]);
?>