<?php
require_once "../connection.php";
// header('Content-Type: application/json');

$result = Database::search("SELECT * FROM currency ORDER BY updatedAt DESC");
$currencies = [];
while ($row = $result->fetch_assoc()) {
    $currencies[] = $row;
}
echo json_encode($currencies);
?>