<?php
require_once "../connection.php";
// header('Content-Type: application/json; charset=utf-8');

$query = "
    SELECT 
        p.id,
        p.order_id,
        p.email,
        p.description,
        p.amount,
        p.lkr_amount,
        p.createdAt,
        p.status,
        p.status_code,
        p.status_message,
        p.transaction_id,
        c.currency AS currency_code,
        c.country AS currency_name
    FROM paynow p
    INNER JOIN currency c ON p.currency_id = c.id
    ORDER BY p.createdAt DESC
";


$result = Database::search($query);

$paynow_list = [];
while ($row = $result->fetch_assoc()) {
    $paynow_list[] = $row;
}

echo json_encode($paynow_list);
