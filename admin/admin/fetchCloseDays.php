
<?php
require_once "../connection.php";
header('Content-Type: application/json');

$result = Database::search("SELECT * FROM closed_day ORDER BY date DESC");
$days = [];
while ($row = $result->fetch_assoc()) {
    $days[] = $row;
}
echo json_encode($days);
?>