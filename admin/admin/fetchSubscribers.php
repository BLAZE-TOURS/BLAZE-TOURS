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

    $subscriber_rs = Database::search("SELECT * FROM `user` LIMIT $start_from, $limit");
    $subscriber_n = $subscriber_rs->num_rows;
    $total_subscriber_records = Database::search("SELECT COUNT(*) FROM `user`")->fetch_row()[0];
    $total_subscriber_pages = ceil($total_subscriber_records / $limit);
} else {
    echo ("You are not a valid user");
    header("Refresh: 2; URL=adminSignIn.php"); // Refresh the page after 2 seconds
    exit();
}
?>