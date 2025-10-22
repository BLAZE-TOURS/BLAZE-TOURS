<?php
require_once "../connection.php";
// header('Content-Type: application/json; charset=utf-8');

$query = "
    SELECT 
        p.id,
        p.email,
        p.amount,
        p.lkr_amount,
        p.createdAt,
        p.status_id,
        c.currency AS currency_code,
        c.country AS currency_name,
        s.name AS status_name
    FROM paynow p
    INNER JOIN currency c ON p.currency_id = c.id
    INNER JOIN status s ON p.status_id = s.id
    ORDER BY p.createdAt DESC
";

$result = Database::search($query);

$paynow_list = [];
while ($row = $result->fetch_assoc()) {
    $paynow_list[] = $row;
}

echo json_encode($paynow_list);
?>
