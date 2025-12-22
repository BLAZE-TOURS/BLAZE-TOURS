<?php
header('Content-Type: application/json');
require_once 'connection.php';

$tourId = isset($_GET['tour_id']) ? (int)$_GET['tour_id'] : 0;
$date = $_GET['date'] ?? '';
$timeSlot = $_GET['timeSlot'] ?? '';

if ($tourId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Tour ID is required']);
    exit;
}

if (!$date || !$timeSlot) {
    echo json_encode(['success' => false, 'message' => 'Date and time slot are required']);
    exit;
}

// Validate date format (YYYY-MM-DD)
$dateObj = DateTime::createFromFormat('Y-m-d', $date);
if (!$dateObj || $dateObj->format('Y-m-d') !== $date) {
    echo json_encode(['success' => false, 'message' => 'Invalid date format']);
    exit;
}

// Validate time slot (HH:MM or HH:MM:SS)
$timeObj = DateTime::createFromFormat('H:i', $timeSlot);
$timeObjFull = DateTime::createFromFormat('H:i:s', $timeSlot);
if (!$timeObj && !$timeObjFull) {
    echo json_encode(['success' => false, 'message' => 'Invalid time format']);
    exit;
}

$dateSafe = Database::escape_string($date);
$timeSafe = Database::escape_string($timeSlot);
$tourSafe = (int)$tourId;

$query = "SELECT id FROM booking WHERE tour_id = '$tourSafe' AND tourDate = '$dateSafe' AND time_slot = '$timeSafe' AND status = 'Success' LIMIT 1";
$result = Database::search($query);

if ($result && $result->num_rows > 0) {
    echo json_encode([
        'success' => true,
        'isAvailable' => false,
        'message' => 'This time slot is already booked for the selected date.'
    ]);
} else {
    echo json_encode([
        'success' => true,
        'isAvailable' => true,
        'message' => 'Time slot is available.'
    ]);
}
