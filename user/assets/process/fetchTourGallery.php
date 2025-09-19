
<?php
require 'connection.php';

$tour_id = isset($_GET['tour_id']) ? intval($_GET['tour_id']) : 0;

Database::setUpConnection();

$sql = "SELECT url, title FROM gallary WHERE tour_id = $tour_id LIMIT 4";
$result = Database::search($sql);

$gallery = [];
while ($row = $result->fetch_assoc()) {
    // Path fix if needed
    $row['url'] = str_replace('../admin/images/gallry/', '../admin/admin/images/gallry/', $row['url']);
    $gallery[] = $row;
}

// Fill up to 4 items with default images if less than 4
$default_images = [
    ['url' => 'assets/img/gallery/gallery_6_1.jpg', 'title' => 'Default 1'],
    ['url' => 'assets/img/gallery/gallery_6_2.jpg', 'title' => 'Default 2'],
    ['url' => 'assets/img/gallery/gallery_6_3.jpg', 'title' => 'Default 3'],
    ['url' => 'assets/img/gallery/gallery_6_4.jpg', 'title' => 'Default 4'],
];

for ($i = count($gallery); $i < 4; $i++) {
    $gallery[] = $default_images[$i];
}

header('Content-Type: application/json');
echo json_encode($gallery);