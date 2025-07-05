
<?php
require_once 'connection.php';

$tour_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($tour_id <= 0) {
    die('Invalid tour id');
}

// Fetch tour main info
$tour = null;
$q = "SELECT t.*, ti.main_image, ti.second_image 
      FROM tour t 
      LEFT JOIN tour_image ti ON t.id = ti.tour_id 
      WHERE t.id = $tour_id";
$res = Database::search($q);
if ($res && $res->num_rows > 0) {
    $tour = $res->fetch_assoc();
}

// Fetch highlights
$highlights = [];
$q = "SELECT h.name 
      FROM idx_highlight ih 
      INNER JOIN highlight h ON ih.highlight_id = h.id 
      WHERE ih.tour_id = $tour_id";
$res = Database::search($q);
while ($row = $res->fetch_assoc()) {
    $highlights[] = $row['name'];
}

// Fetch locations
$locations = [];
$q = "SELECT name, stop_duration_time 
      FROM location 
      WHERE tour_id = $tour_id";
$res = Database::search($q);
while ($row = $res->fetch_assoc()) {
    $locations[] = $row;
}

// Fetch times
$times = [];
$q = "SELECT tm.timeslot 
      FROM idx_time it 
      INNER JOIN time tm ON it.time_id = tm.id 
      WHERE it.tour_id = $tour_id";
$res = Database::search($q);
while ($row = $res->fetch_assoc()) {
    $times[] = $row['timeslot'];
}

?>