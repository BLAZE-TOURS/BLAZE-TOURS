<?php
header('Content-Type: application/json');
require_once 'connection.php';

if (!isset($_GET['date'])) {
    echo json_encode(['success' => false, 'message' => 'Date parameter is required']);
    exit;
}

$date = $_GET['date'];

// Validate date format
$dateObj = DateTime::createFromFormat('Y-m-d', $date);
if (!$dateObj || $dateObj->format('Y-m-d') !== $date) {
    echo json_encode(['success' => false, 'message' => 'Invalid date format']);
    exit;
}

// Escape the date for SQL
$date_safe = Database::escape_string($date);

// Check if the date exists in closed_day table
$query = "SELECT id FROM closed_day WHERE date = '$date_safe' LIMIT 1";
$result = Database::search($query);

if ($result && $result->num_rows > 0) {
    // Date is closed
    echo json_encode([
        'success' => true,
        'isClosed' => true,
        'message' => 'This date is not available for bookings'
    ]);
} else {
    // Date is available
    echo json_encode([
        'success' => true,
        'isClosed' => false,
        'message' => 'Date is available'
    ]);
}
?>
