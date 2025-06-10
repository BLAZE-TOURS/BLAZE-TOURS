<?php
require_once "../connection.php";

if (isset($_SESSION["adminuser"])) {
    // Pagination logic
    $limit = 20; // Number of entries to show in a page.
    if (isset($_GET["page"])) {
        $page  = $_GET["page"];
    } else {
        $page = 1;
    }
    $start_from = ($page - 1) * $limit;

    $mediType_rs = Database::search("SELECT meditation_type.*, meditation_category.name AS category FROM meditation_type INNER JOIN meditation_category ON meditation_type.meditation_category_id = meditation_category.id LIMIT $start_from, $limit");
    $mediType_n = $mediType_rs->num_rows;
    $total_mediType_records = Database::search("SELECT COUNT(*) FROM `meditation_type`")->fetch_row()[0];
    $total_mediType_pages = ceil($total_mediType_records / $limit);
} else {
    echo ("You are not a valid user");
    header("Refresh: 2; URL=adminSignIn.php"); // Refresh the page after 2 seconds
    exit();
}
