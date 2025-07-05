
<?php
require "../connection.php";

header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'No tour id provided']);
    exit;
}

$tour_id = Database::escape_string($_GET['id']);
$tour_rs = Database::search("SELECT * FROM tour WHERE id='$tour_id'");
$tourData = $tour_rs->fetch_assoc();

if (!$tourData) {
    echo json_encode(['error' => 'Tour not found']);
    exit;
}

// Images
$img_rs = Database::search("SELECT * FROM tour_image WHERE tour_id='$tour_id'");
$tourData['images'] = $img_rs->fetch_assoc();

// Times
$time_rs = Database::search("SELECT t.timeslot FROM idx_time it JOIN time t ON it.time_id = t.id WHERE it.tour_id='$tour_id'");
$tourData['times'] = [];
while ($row = $time_rs->fetch_assoc()) $tourData['times'][] = $row['timeslot'];

// Highlights
$hl_rs = Database::search("SELECT h.name FROM idx_highlight ih JOIN highlight h ON ih.highlight_id = h.id WHERE ih.tour_id='$tour_id'");
$tourData['highlights'] = [];
while ($row = $hl_rs->fetch_assoc()) $tourData['highlights'][] = $row['name'];

// Locations
$loc_rs = Database::search("SELECT * FROM location WHERE tour_id='$tour_id'");
$tourData['locations'] = [];
while ($row = $loc_rs->fetch_assoc()) $tourData['locations'][] = $row;

echo json_encode($tourData);


?>