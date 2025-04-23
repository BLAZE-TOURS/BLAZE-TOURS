<?php

require "../connection.php";

if (isset($_GET['id'])) {
    $id = Database::escape_string($_GET['id']);

    $sql = "SELECT c.id, c.name, c.website, c.location, c.contact1, c.contact2, c.email, c.copywrite, c.facebook, c.insta, c.yt, l.url AS logo 
            FROM company c 
            LEFT JOIN logo l ON c.id = l.company_id 
            WHERE c.id = '$id'";

    $result = Database::search($sql);

    if ($result->num_rows > 0) {
        $company = $result->fetch_assoc();
        echo json_encode($company);
    } else {
        echo json_encode(["error" => "Company not found"]);
    }
} else {
    echo json_encode(["error" => "No company ID provided"]);
}

?>