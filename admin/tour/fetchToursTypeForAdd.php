<
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

    $toursType_rs = Database::search("SELECT * FROM `tours_type` LIMIT $start_from, $limit");
    $toursType_n = $toursType_rs->num_rows;
    $total_toursType_records = Database::search("SELECT COUNT(*) FROM `tours_type`")->fetch_row()[0];
    $total_toursType_pages = ceil($total_toursType_records / $limit);

    // Fetch all rows into $toursType array
    $toursType = [];
    while ($row = $toursType_rs->fetch_assoc()) {
        $toursType[] = $row;
    }
} else {
    echo ("You are not a valid user");
    header("Refresh: 2; URL=adminSignIn.php"); // Refresh the page after 2 seconds
    exit();
}
?>