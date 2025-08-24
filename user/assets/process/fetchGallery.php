<?php
require 'connection.php';

Database::setUpConnection();

$sql = "SELECT * FROM gallary";
$result = Database::search($sql);

$gallery = [];
while ($row = $result->fetch_assoc()) {
    // Fix path: replace '../admin/images/gallry/' with '../admin/admin/images/gallry/'
    $row['url'] = str_replace('../admin/images/gallry/', '../admin/admin/images/gallry/', $row['url']);
    $gallery[] = $row;
}

header('Content-Type: application/json');
echo json_encode($gallery);