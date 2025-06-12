<?php
require_once '../connection.php';

if (isset($_GET['id'])) {
    $id = Database::escape_string($_GET['id']);
    Database::setUpConnection();
    $result = Database::$connection->query("SELECT * FROM tours_type WHERE id='$id'");
    if ($result && $row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode([]);
    }
}
?>