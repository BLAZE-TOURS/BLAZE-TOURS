<?php
require "../connection.php";
Database::setUpConnection();

$id = Database::escape_string($_GET['id']);
$result = Database::search("SELECT * FROM company WHERE id = '$id'");
echo json_encode($result->fetch_assoc());
?>