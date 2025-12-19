<?php
require_once "../connection.php";

if (isset($_SESSION["adminuser"])) {
    // Pagination logic
    $limit = 20; // Number of entries to show in a page.
    if (isset($_GET["page"])) {
        $page  = (int) $_GET["page"];
    } else {
        $page = 1;
    }
    $start_from = ($page - 1) * $limit;

    // get bookings with status 2 (Closed) or 3 (Processing)
    $booking_rs = Database::search("
        SELECT 
    booking.*,
    tour.name AS tours_type_name
FROM booking
INNER JOIN tour ON booking.tour_id = tour.id
WHERE booking.status IN ('Pending', 'Failed')
ORDER BY booking.created_at DESC
LIMIT $start_from, $limit;

    ");
    $booking_n = $booking_rs->num_rows;

    $total_booking_records = Database::search("
        SELECT COUNT(*)
FROM booking
INNER JOIN tour ON booking.tour_id = tour.id
WHERE booking.status IN ('Pending', 'Failed');

    ")->fetch_row()[0];
    $total_booking_pages = ceil($total_booking_records / $limit);
} else {
    echo ("You are not a valid user");
    header("Refresh: 2; URL=adminSignIn.php"); // Refresh the page after 2 seconds
    exit();
}
