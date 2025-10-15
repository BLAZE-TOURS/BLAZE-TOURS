<?php
require "../connection.php";
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'] ?? '';
    if (empty($date)) {
        echo json_encode(['status' => 'error', 'message' => 'Date is required.']);
        exit();
    }

    // Check for duplicates
    $check = Database::search("SELECT * FROM closed_day WHERE date = '$date'");
    if ($check->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'This date is already closed.']);
        exit();
    }

    try {
        Database::iud("INSERT INTO closed_day (`date`) VALUES ('$date')");
        echo json_encode(['status' => 'success', 'message' => 'Closed day added successfully']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
