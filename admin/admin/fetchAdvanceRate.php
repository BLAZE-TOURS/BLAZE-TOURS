
<?php
require_once "../connection.php";
header('Content-Type: application/json');

$result = Database::search("SELECT * FROM advance ORDER BY id DESC LIMIT 1");
$rate = ['value' => 0]; // Default value

if ($result && $result->num_rows > 0) {
    $rate = $result->fetch_assoc();
}

echo json_encode($rate);
?>