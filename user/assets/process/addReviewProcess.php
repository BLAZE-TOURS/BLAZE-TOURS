<?php
// filepath: c:\xampp\htdocs\BLAZE-TOURS\user\assets\process\addReviewProcess.php
require 'connection.php';

$data = json_decode(file_get_contents("php://input"), true);

$name = Database::escape_string($data['name'] ?? '');
$email = Database::escape_string($data['email'] ?? '');
$comment = Database::escape_string($data['comment'] ?? '');
$rating = intval($data['rating'] ?? 5);
$tour_id = intval($data['tour_id'] ?? 0);

if (!$name || !$email || !$comment || !$rating || !$tour_id) {
    echo json_encode(['success' => false, 'error' => 'All fields required']);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'error' => 'Invalid email']);
    exit;
}

// Check if email already reviewed for this tour
$sqlCheck = "SELECT id FROM review WHERE email='$email' AND tour_id=$tour_id";
$resCheck = Database::search($sqlCheck);
if ($resCheck->num_rows > 0) {
    echo json_encode(['success' => false, 'error' => 'You have already submitted a review for this tour.']);
    exit;
}

// Insert review
$date = date('Y-m-d H:i:s');
$sqlInsert = "INSERT INTO review (name, email, comment, tour_id, rating_star_id, submit_at) 
              VALUES ('$name', '$email', '$comment', $tour_id, $rating, '$date')";
try {
    Database::iud($sqlInsert);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}