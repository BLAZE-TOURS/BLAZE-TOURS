<?php
header('Content-Type: application/json');
include '../connection.php';

// Helper to send JSON response and exit
function send_response($success, $message)
{
    echo json_encode(['success' => $success, 'message' => $message]);
    exit;
}

// Validate POST data
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$description = isset($_POST['description']) ? trim($_POST['description']) : '';
$duration = isset($_POST['duration']) ? intval($_POST['duration']) : 0;
$kids_price = isset($_POST['kids_price']) ? floatval($_POST['kids_price']) : 0;
$adult_price = isset($_POST['adult_price']) ? floatval($_POST['adult_price']) : 0;
$max_adult = isset($_POST['maximum_adult_count']) ? intval($_POST['maximum_adult_count']) : 0;
$max_kids = isset($_POST['maximum_kids_count']) ? intval($_POST['maximum_kids_count']) : 0;
$tours_type_id = isset($_POST['tours_type_id']) ? intval($_POST['tours_type_id']) : 0;
$status_id = 3; // Always set to 3

$errors = [];
if ($name === '') $errors[] = 'Tour Name is required.';
if ($description === '') $errors[] = 'Description is required.';
if ($duration <= 0) $errors[] = 'Duration must be a positive number.';
if ($kids_price < 0) $errors[] = 'Kids Price must be a non-negative number.';
if ($adult_price < 0) $errors[] = 'Adult Price must be a non-negative number.';
if ($max_adult <= 0) $errors[] = 'Maximum Adult Count must be a positive number.';
if ($max_kids <= 0) $errors[] = 'Maximum Kids Count must be a positive number.';
if ($tours_type_id <= 0) $errors[] = 'Tour Type is required.';

if (!empty($errors)) {
    send_response(false, implode(' ', $errors));
}

// Escape strings
$name_esc = Database::escape_string($name);
$description_esc = Database::escape_string($description);

// Insert into DB
$query = "INSERT INTO tour (name, description, duration, kids_price, adult_price, maximum_adult_count, maximum_kids_count, tours_type_id, status_id) VALUES ('{$name_esc}', '{$description_esc}', {$duration}, {$kids_price}, {$adult_price}, {$max_adult}, {$max_kids}, {$tours_type_id}, {$status_id})";

try {
    Database::iud($query);
    send_response(true, 'Tour added successfully!');
} catch (Exception $e) {
    send_response(false, 'Database error: ' . $e->getMessage());
}
