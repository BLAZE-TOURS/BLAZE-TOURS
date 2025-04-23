<?php

session_start();

require "../connection.php";

$email = isset($_POST["e"]) ? trim($_POST["e"]) : '';
$password = isset($_POST["p"]) ? trim($_POST["p"]) : '';
$rememberme = isset($_POST["r"]) ? $_POST["r"] : '';

// Validation for Email
if (empty($email)) {
    echo json_encode(["status" => "error", "message" => "Please enter your Email"]);
    exit();
} else if (strlen($email) > 100) {
    echo json_encode(["status" => "error", "message" => "Email must have less than 100 characters"]);
    exit();
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["status" => "error", "message" => "Invalid Email Format"]);
    exit();
}
// Validation for Password
else if (empty($password)) {
    echo json_encode(["status" => "error", "message" => "Please enter your Password"]);
    exit();
} else if (strlen($password) < 8 || strlen($password) > 20) {
    echo json_encode(["status" => "error", "message" => "Password must have between 8-20 characters"]);
    exit();
} else if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
    echo json_encode(["status" => "error", "message" => "Password must include an uppercase letter, lowercase letter, number, and special character."]);
    exit();
} else {
    $email = Database::escape_string($email);
    $password = Database::escape_string($password);

    // Search for User
    $rs = Database::search("SELECT * FROM `admin` WHERE `email`='" . $email . "' AND `password`='" . $password . "'");

    // Get the number of rows
    $nr = $rs->num_rows;

    if ($nr == 1) {
        $data = $rs->fetch_assoc();
        $_SESSION["adminuser"] = $data;

        if ($data["status_id"] == 0) {
            echo json_encode(["status" => "error", "message" => "You can't Sign in to Blaze Tuk Tuk because the Super Admin has blocked you."]);
        } else {
            echo json_encode(["status" => "success", "message" => "success"]);
        }

        if ($rememberme === "true") {
            setcookie("email", $email, time() + (60 * 60 * 24 * 365), "/");
            setcookie("password", $password, time() + (60 * 60 * 24 * 365), "/");
        } else {
            setcookie("email", "", time() - 3600, "/");
            setcookie("password", "", time() - 3600, "/");
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid Email or Password"]);
    }
}
?>