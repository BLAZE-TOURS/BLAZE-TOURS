<?php

require "../connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate required fields
    $required_fields = ['id', 'company_name', 'website', 'location', 'contact1', 'email', 'copywrite', 'facebook', 'insta', 'yt'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            die("All fields are required.");
        }
    }

    // Validate email
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    $id = Database::escape_string($_POST['id']);
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

    // Update company details in the database
    Database::setUpConnection();
    $sql = "UPDATE company SET 
            `name` = '$company_name', 
            `website` = '$website', 
            `location` = '$location', 
            `contact1` = '$contact1', 
            `contact2` = '$contact2', 
            `email` = '$email', 
            `copywrite` = '$copywrite', 
            `facebook` = '$facebook', 
            `insta` = '$insta', 
            `yt` = '$yt' 
            WHERE `id` = '$id'";

    if (Database::$connection->query($sql) === TRUE) {
        // Handle logo upload if a new logo is provided
        if (!empty($_FILES['logo']['name'])) {
            $logo = $_FILES['logo'];
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

            // Check if a record already exists for the company_id
            $logo_check_sql = "SELECT * FROM logo WHERE company_id = '$id'";
            $logo_check_result = Database::search($logo_check_sql);

            if ($logo_check_result->num_rows > 0) {
                // Update the existing logo record
                $logo_sql = "UPDATE logo SET `url` = '$target_file' WHERE `company_id` = '$id'";
            } else {
                // Insert a new logo record
                $logo_sql = "INSERT INTO logo (`company_id`, `url`) VALUES ('$id', '$target_file')";
            }

            if (Database::$connection->query($logo_sql) !== TRUE) {
                die("Error: " . $logo_sql . "<br>" . Database::$connection->error);
            }
        }

        echo "Company updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . Database::$connection->error;
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = Database::escape_string($_GET['id']);
    $sql = "SELECT * FROM company WHERE `id` = '$id'";
    $result = Database::search($sql);

    if ($result->num_rows > 0) {
        $company = $result->fetch_assoc();

        // Prepend the base path to the logo URL if necessary
        if (!empty($company['logo'])) {
            $company['logo'] = "../admin/images/logos/" . basename($company['logo']);
        }

        echo json_encode($company);
    } else {
        echo json_encode(["error" => "Company not found"]);
    }
}
?>