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

    $story_rs = Database::search("SELECT * FROM `story` LIMIT $start_from, $limit");
    $story_n = $story_rs->num_rows;
    $total_story_records = Database::search("SELECT COUNT(*) FROM `story`")->fetch_row()[0];
    $total_story_pages = ceil($total_story_records / $limit);
} else {
    echo ("You are not a valid user");
    header("Refresh: 2; URL=adminSignIn.php"); // Refresh the page after 2 seconds
    exit();
}
