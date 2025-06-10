<?php
require "../connection.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    Database::setUpConnection();
    $sql = "DELETE FROM news WHERE id = $id";
    if (Database::$connection->query($sql) === TRUE) {
        echo "News deleted successfully";
    } else {
        echo "Error: " . Database::$connection->error;
    }
}
?>