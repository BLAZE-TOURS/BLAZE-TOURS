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
                s.name AS status_name
            FROM tour t
            INNER JOIN tours_type tt ON t.tours_type_id = tt.id
            INNER JOIN status s ON t.status_id = s.id
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
