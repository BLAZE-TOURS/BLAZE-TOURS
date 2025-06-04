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

    // Modified query to join toure_type and status tables
    $Tour_rs = Database::search("
        SELECT 
            t.*, 
            tt.name AS toure_type_name, 
            s.name AS status_name 
        FROM toure t
        JOIN toure_type tt ON t.toure_type_id = tt.id
        JOIN status s ON t.status_id = s.id
        LIMIT $start_from, $limit
    ");
    $Tour_n = $Tour_rs->num_rows;
    $total_Tour_records = Database::search("SELECT COUNT(*) FROM `toure`")->fetch_row()[0];
    $total_Tour_pages = ceil($total_Tour_records / $limit);
} else {
    echo ("You are not a valid user");
    header("Refresh: 2; URL=adminSignIn.php"); // Refresh the page after 2 seconds
    exit();
}
?>