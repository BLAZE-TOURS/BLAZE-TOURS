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

    // Modified query to join company and logo tables
    $pod_rs = Database::search("SELECT * FROM `pod` LIMIT $start_from, $limit");
    $pod_n = $pod_rs->num_rows;
    $total_pod_records = Database::search("SELECT COUNT(*) FROM `pod`")->fetch_row()[0];
    $total_pod_pages = ceil($total_pod_records / $limit);
} else {
    echo ("You are not a valid user");
    header("Refresh: 2; URL=adminSignIn.php"); // Refresh the page after 2 seconds
    exit();
}
?>  