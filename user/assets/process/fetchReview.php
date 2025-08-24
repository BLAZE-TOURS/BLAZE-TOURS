<?php
// filepath: c:\xampp\htdocs\BLAZE-TOURS\user\assets\process\fetchReview.php
require 'connection.php';

$tour_id = isset($_GET['tour_id']) ? intval($_GET['tour_id']) : 0;

Database::setUpConnection();

$sql = "SELECT r.*, rs.value AS rating_value 
        FROM review r 
        INNER JOIN rating_star rs ON r.rating_star_id = rs.id 
        WHERE r.tour_id = $tour_id 
        ORDER BY r.submit_at DESC";
$result = Database::search($sql);

$reviews = [];
while ($row = $result->fetch_assoc()) {
    $reviews[] = [
        'name' => $row['name'],
        'email' => $row['email'],
        'comment' => $row['comment'],
        'date' => date('d M, Y', strtotime($row['submit_at'])),
        'time' => date('h:ia', strtotime($row['submit_at'])),
        'stars' => intval($row['rating_value'])
    ];
}

header('Content-Type: application/json');
echo json_encode($reviews);