<?php
/**
 * getCurrencyRate.php
 * Returns the LKR rate from the currency table for frontend use
 */

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/connection.php';

try {
    $rate = Database::getLKRRate();
    echo json_encode([
        'success' => true,
        'rate' => $rate
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to fetch currency rate',
        'rate' => 320.0 // Fallback rate
    ]);
}

