<?php
require "../connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['tours_name'])) {
        die("Tour type name is required.");
    }

    $tours_name = Database::escape_string($_POST['tours_name']);

    Database::setUpConnection();
    $sql = "INSERT INTO tours_type(`name`) VALUES ('$tours_name')";

    if (Database::$connection->query($sql) === TRUE) {
        echo "Tour type added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . Database::$connection->error;
    }
}
?>