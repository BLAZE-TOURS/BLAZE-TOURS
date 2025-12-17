
<?php
require_once "../connection.php";

try {
    // Fetch bookings with status 1 or 4
    $booking_query = "SELECT 
        id,
        advance_paid_lkr AS amount,
        'Booking' AS locate,
        DATE(created_at) AS created_date
        FROM booking 
        WHERE status_id IN (1,4) 
        AND advance_paid_lkr > 0";
    
    // Fetch paynow entries with status 1
    $paynow_query = "SELECT 
            id,
            lkr_amount AS amount,
            'Payout' AS locate,
            DATE(createdAt) AS created_date
        FROM paynow
        WHERE status = 'Success'
        AND lkr_amount > 0
    ";


    // Combine both queries with UNION and order by date
    $final_query = "
        ($booking_query)
        UNION ALL
        ($paynow_query)
        ORDER BY created_date DESC";

    $result = Database::search($final_query);
    
    $transactions = array();
    while ($row = $result->fetch_assoc()) {
        $transactions[] = array(
            'id' => $row['id'],
            'amount' => number_format($row['amount'], 2),
            'locate' => $row['locate'],
            'created_date' => $row['created_date']
        );
    }

    echo json_encode([
        'status' => 'success',
        'data' => $transactions
    ]);

} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>