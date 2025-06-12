<?php
require "../connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['id']) || empty($_POST['tours_name'])) {
        die("All fields are required.");
    }

    $id = Database::escape_string($_POST['id']);
    $tours_name = Database::escape_string($_POST['tours_name']);

    Database::setUpConnection();
    $sql = "UPDATE tours_type SET name='$tours_name' WHERE id='$id'";

    if (Database::$connection->query($sql) === TRUE) {
        echo "Tour type updated successfully";
    } else {
        echo "Error: " . Database::$connection->error;
    }
}
?>