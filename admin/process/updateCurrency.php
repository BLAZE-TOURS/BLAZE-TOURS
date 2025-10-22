<?php
require_once __DIR__ . "/../connection.php";

header('Content-Type: application/json; charset=utf-8');

try {
    $id = $_POST['id'] ?? null;
    $LKR = $_POST['LKR'] ?? null;

    if (!$id || $LKR === null || $LKR === '') {
        echo json_encode(["success" => false, "message" => "Missing required fields."]);
        exit;
    }elseif (!is_numeric($LKR) || $LKR <= 0) {
        echo json_encode(["success" => false, "message" => "Invalid LKR value."]);
        exit;
    }

    $idEsc = Database::escape_string($id);
    $lkrEsc = Database::escape_string($LKR);

    // set updatedAt to server date (YYYY-MM-DD)
    $updatedAt = date('Y-m-d');

    Database::iud("UPDATE currency SET LKR = '$lkrEsc', updatedAt = '$updatedAt' WHERE id = '$idEsc'");

    echo json_encode(["success" => true, "message" => "Currency rate updated successfully!"]);
} catch (Throwable $e) {
    error_log("updateCurrency.php error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Server error"]);
}
