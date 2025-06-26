
<?php
require "../connection.php";
$tours = [];
$rs = Database::search("SELECT id, name FROM tour");
while ($row = $rs->fetch_assoc()) {
    $tours[] = $row;
}
echo json_encode($tours);
?>