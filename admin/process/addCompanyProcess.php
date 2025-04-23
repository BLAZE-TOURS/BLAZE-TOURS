<?php

require "../connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate required fields
    $required_fields = ['company_name', 'website', 'location', 'contact1', 'email', 'copywrite', 'facebook', 'insta', 'yt'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            die("All fields are required.");
        }
    }

    if (empty($_FILES['logo'])) {
        die("Logo is required.");
    }

    // Validate email
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    $company_name = Database::escape_string($_POST['company_name']);
    $website = Database::escape_string($_POST['website']);
    $location = Database::escape_string($_POST['location']);
    $contact1 = Database::escape_string($_POST['contact1']);
    $contact2 = Database::escape_string($_POST['contact2']);
    $email = Database::escape_string($_POST['email']);
    $copywrite = Database::escape_string($_POST['copywrite']);
    $facebook = Database::escape_string($_POST['facebook']);
    $insta = Database::escape_string($_POST['insta']);
    $yt = Database::escape_string($_POST['yt']);
    $logo = $_FILES['logo'];

    // Handle file upload
    $target_dir = "../admin/images/logos/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $imageFileType = strtolower(pathinfo($logo["name"], PATHINFO_EXTENSION));
    $target_file = $target_dir . basename($company_name) . "." . $imageFileType;

    // Check if image file is an actual image or fake image
    $check = getimagesize($logo["tmp_name"]);
    if ($check === false) {
        die("File is not an image.");
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
        die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
    }

    // Move the uploaded file to the target directory
    if (!move_uploaded_file($logo["tmp_name"], $target_file)) {
        die("Sorry, there was an error uploading your file.");
    }

    // Insert data into the database
    Database::setUpConnection();
    $sql = "INSERT INTO company(`name`, `website`, `location`, `contact1`, `contact2`, `email`, `copywrite`, `facebook`, `insta`, `yt`)
            VALUES ('$company_name', '$website', '$location', '$contact1', '$contact2', '$email', '$copywrite', '$facebook', '$insta', '$yt')";

    if (Database::$connection->query($sql) === TRUE) {
        $company_id = Database::$connection->insert_id;
        $logo_sql = "INSERT INTO logo (`company_id`, `url`) VALUES ('$company_id', '$target_file')";
        if (Database::$connection->query($logo_sql) === TRUE) {
            echo "New company added successfully";
        } else {
            echo "Error: " . $logo_sql . "<br>" . Database::$connection->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . Database::$connection->error;
    }
}
?>