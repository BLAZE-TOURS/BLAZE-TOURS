
<?php
    require 'connection.php';
    Database::setUpConnection();

    $tour_id = isset($_GET['tour_id']) ? intval($_GET['tour_id']) : 0;

    $sql = "SELECT location.*, tour.name AS tour_name FROM `location` INNER JOIN `tour` ON location.tour_id = tour.id";
    if ($tour_id > 0) {
        $sql .= " WHERE location.tour_id = $tour_id";
    }
    $result = Database::search($sql);

    $markers = [];
    while ($row = $result->fetch_assoc()) {
        $markers[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($markers);
?>