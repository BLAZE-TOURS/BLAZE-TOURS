<?php
header('Content-Type: application/json');
require_once "../connection.php";
session_start();

function send_response($success, $message)
{
    echo json_encode([
        "success" => $success,
        "message" => $message
    ]);
    exit();
}

if (!isset($_SESSION["adminuser"])) {
    send_response(false, "Unauthorized access.");
}

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$description = isset($_POST['description']) ? trim($_POST['description']) : '';
$duration = isset($_POST['duration']) ? intval($_POST['duration']) : 0;
$kids_price = isset($_POST['kids_price']) ? floatval($_POST['kids_price']) : -1;
$adult_price = isset($_POST['adult_price']) ? floatval($_POST['adult_price']) : -1;
$maximum_adult_count = isset($_POST['maximum_adult_count']) ? intval($_POST['maximum_adult_count']) : 0;
$maximum_kids_count = isset($_POST['maximum_kids_count']) ? intval($_POST['maximum_kids_count']) : 0;

$errors = [];

if ($id <= 0) $errors[] = "Invalid tour id.";
if ($name === '') $errors[] = "Tour Name is required.";
if ($description === '') $errors[] = "Description is required.";
if ($duration <= 0) $errors[] = "Duration must be a positive number.";
if ($kids_price < 0) $errors[] = "Kids Price must be a non-negative number.";
if ($adult_price < 0) $errors[] = "Adult Price must be a non-negative number.";
if ($maximum_adult_count <= 0) $errors[] = "Maximum Adult Count must be a positive number.";
if ($maximum_kids_count <= 0) $errors[] = "Maximum Kids Count must be a positive number.";

if (!empty($errors)) {
    send_response(false, implode(' ', $errors));
}

try {
    $existing = Database::search("SELECT id FROM tour WHERE id = {$id} LIMIT 1");
    if ($existing->num_rows === 0) {
        send_response(false, "Tour not found.");
    }

    $name_esc = Database::escape_string($name);
    $description_esc = Database::escape_string($description);

    $query = "UPDATE tour SET 
        name = '{$name_esc}',
        description = '{$description_esc}',
        duration = {$duration},
        kids_price = {$kids_price},
        adult_price = {$adult_price},
        maximum_adult_count = {$maximum_adult_count},
        maximum_kids_count = {$maximum_kids_count}
        WHERE id = {$id}";

    Database::iud($query);
    send_response(true, "Tour updated successfully.");
} catch (Exception $e) {
    send_response(false, "Database error: " . $e->getMessage());
}
