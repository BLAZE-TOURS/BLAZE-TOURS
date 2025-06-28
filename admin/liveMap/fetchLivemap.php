<?php
    require '../connection.php';

    Database::setUpConnection();

    $sql = "SELECT location.*, tour.name AS tour_name FROM `location` INNER JOIN `tour` ON location.tour_id = tour.id";
    $result = Database::search($sql);

    $markers = [];

    while ($row = $result->fetch_assoc()) {
        $markers[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($markers);
?>