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

    // Fetch messages from the massage table with status_id = 1 (unread/new)
    $msg_rs = Database::search("SELECT massage.*, status.name AS status_name FROM `massage` INNER JOIN `status` ON massage.status_id = status.id WHERE massage.status_id = 2 ORDER BY massage.dateTime DESC LIMIT $start_from, $limit");
    $msg_n = $msg_rs->num_rows;
    $total_msg_records = Database::search("SELECT COUNT(*) FROM `massage` WHERE status_id = 2")->fetch_row()[0];
    $total_msg_pages = ceil($total_msg_records / $limit);
} else {
    echo ("You are not a valid user");
    header("Refresh: 2; URL=adminSignIn.php"); // Refresh the page after 2 seconds
    exit();
}
