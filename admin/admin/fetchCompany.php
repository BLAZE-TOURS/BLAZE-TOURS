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
    $company_rs = Database::search("SELECT company.*, logo.url FROM `company` LEFT JOIN `logo` ON company.id = logo.company_id LIMIT $start_from, $limit");
    $company_n = $company_rs->num_rows;
    $total_company_records = Database::search("SELECT COUNT(*) FROM `company`")->fetch_row()[0];
    $total_company_pages = ceil($total_company_records / $limit);
} else {
    echo ("You are not a valid user");
    header("Refresh: 2; URL=adminSignIn.php"); // Refresh the page after 2 seconds
    exit();
}
?>