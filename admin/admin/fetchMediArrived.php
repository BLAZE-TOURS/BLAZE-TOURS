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

    $medi_rs = Database::search("SELECT meditation.*, tours_type.name AS tours_type_name FROM `meditation` INNER JOIN `tours_type` ON meditation.tours_type_id = tours_type.id WHERE meditation.status_id = 2 LIMIT $start_from, $limit");
    $medi_n = $medi_rs->num_rows;
    $total_medi_records = Database::search("SELECT COUNT(*) FROM `meditation` INNER JOIN `tours_type` ON `meditation`.tours_type_id=`tours_type`.id WHERE meditation.status_id = 2")->fetch_row()[0];
    $total_medi_pages = ceil($total_medi_records / $limit);
} else {
    echo ("You are not a valid user");
    header("Refresh: 2; URL=adminSignIn.php"); // Refresh the page after 2 seconds
    exit();
}
