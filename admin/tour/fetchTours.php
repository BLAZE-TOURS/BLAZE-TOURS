<?php
require_once "../connection.php";
session_start();

if (isset($_SESSION["adminuser"])) {
    // Pagination logic
    $limit = 20; // Number of entries to show in a page.
    $page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
    $start_from = ($page - 1) * $limit;

    // Fetch tours with JOINs for tours_type and status (location removed)
    $query = "SELECT 
    t.id, 
    t.name, 
    t.description, 
    t.duration, 
    t.kids_price, 
    t.adult_price, 
    t.maximum_adult_count, 
    t.maximum_kids_count, 
    tt.name AS tours_type_name, 
    s.id AS status_id, 
    s.name AS status_name,
    GROUP_CONCAT(DISTINCT time.timeslot ORDER BY time.timeslot ASC) as time_slots,
    GROUP_CONCAT(DISTINCT h.name ORDER BY h.name ASC) as highlights,
    GROUP_CONCAT(DISTINCT CONCAT(l.name, '|', l.stop_duration_time) ORDER BY l.id ASC) as locations
FROM tour t
INNER JOIN tours_type tt ON t.tours_type_id = tt.id
INNER JOIN status s ON t.status_id = s.id
LEFT JOIN idx_time it ON t.id = it.tour_id
LEFT JOIN time ON it.time_id = time.id
LEFT JOIN idx_highlight ih ON t.id = ih.tour_id
LEFT JOIN highlight h ON ih.highlight_id = h.id
LEFT JOIN location l ON t.id = l.tour_id
GROUP BY t.id
LIMIT $start_from, $limit";
    $tours_rs = Database::search($query);
    $tours_n = $tours_rs->num_rows;

    $total_tours_records = Database::search("SELECT COUNT(*) FROM `tour`")->fetch_row()[0];
    $total_tours_pages = ceil($total_tours_records / $limit);
} else {
    echo ("You are not a valid user");
    header("Refresh: 2; URL=adminSignIn.php");
    exit();
}
