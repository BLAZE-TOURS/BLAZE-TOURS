<?php

require_once "connection.php";

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set JSON response header
header('Content-Type: application/json');

$response = ["status" => "error", "message" => "An unexpected error occurred"];

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Invalid request method");
    }

    // Retrieve and sanitize inputs
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mobile = trim($_POST['mobile'] ?? '');
    $review = trim($_POST['review'] ?? '');
    $ratingStar = trim($_POST['rating_star'] ?? '');

    // Validate required fields
    if (empty($firstName)) {
        throw new Exception("First name cannot be empty");
    } elseif (empty($lastName)) {
        throw new Exception("Last name cannot be empty");
    } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Please enter a valid email");
    } elseif (empty($mobile)) {
        throw new Exception("Mobile number cannot be empty");
    } elseif (empty($review)) {
        throw new Exception("Review cannot be empty");
    } elseif (empty($ratingStar) || $ratingStar < 1 || $ratingStar > 5) {
        throw new Exception("Please enter a valid rating");
    }

    // Check if email already exists
    $email = Database::escape_string($email);
    $checkEmailQuery = "SELECT * FROM user WHERE email = '$email'";
    $result = Database::search($checkEmailQuery);

    if ($result->num_rows > 0) {
        throw new Exception("Email address already exists");
    }

    // Insert review into database
    $date = date('Y-m-d H:i:s');
    $firstName = Database::escape_string($firstName);
    $lastName = Database::escape_string($lastName);
    $mobile = Database::escape_string($mobile);
    $review = Database::escape_string($review);
    $ratingStar = Database::escape_string($ratingStar);

    $insertQuery = "INSERT INTO user (`email`, `mobile`, `first_name`, `last_name`, `review`, `date`, `rating_star_id`)
                    VALUES ('$email', '$mobile', '$firstName', '$lastName', '$review', '$date', '$ratingStar')";
    Database::iud($insertQuery);

    // Prepare email content
    $bodyContent = '
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
            .email-container { max-width: 600px; background: #ffffff; margin: auto; padding: 20px; border-radius: 8px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); text-align: center; }
            .header { background:rgb(90, 5, 8); color: white; padding: 15px; font-size: 24px; font-weight: bold; border-radius: 8px 8px 0 0; }
            .content { padding: 20px; font-size: 18px; color: #333333; }
            .footer { background: #f4f4f4; padding: 10px; font-size: 14px; color: #777777; border-radius: 0 0 8px 8px; }
            .button { background:rgb(90, 5, 8); color: #ffffff; text-decoration: none; padding: 10px 20px; font-size: 16px; border: none; cursor: pointer; font-weight: bold; }
        </style>
    </head>
    <body>
        <div class="email-container">
            <div class="header">Namo Buddaya !</div>
            <div class="content">
                <p>Thank you, <strong>' . htmlspecialchars($firstName) . ' ' . htmlspecialchars($lastName) . '</strong>, for taking the time to review us.</p>
                <p>Your feedback helps us improve our services. We truly appreciate your support!</p>
                </br>
                <a href="https://rakkithtakandatemple.com/" target="_blank">
                    <button class="button">Visit Our Website</button>
                </a>
            </div>
            <div class="footer">
                &copy; ' . date("Y") . ' Rakkithtakanda Temple | All Rights Reserved
            </div>
        </div>
    </body>
    </html>';

    // Send email
    $mail = new PHPMailer(true);
    try {
        $mail->IsSMTP();
        $mail->Host = 'mail.rakkithtakandatemple.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'subscribe@rakkithtakandatemple.com';
        $mail->Password = '4Mdujq2AhndB@EP';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        $mail->setFrom('subscribe@rakkithtakandatemple.com', 'rakkithtakandatemple');
        $mail->addReplyTo('subscribe@rakkithtakandatemple.com', 'rakkithtakandatemple');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Thank You for Your Review';
        $mail->Body = $bodyContent;

        if ($mail->send()) {
            $response = ["status" => "success", "message" => "Review submitted"];
        } else {
            error_log("Email sending failed: " . $mail->ErrorInfo);
            throw new Exception("Review submitted, but email sending failed");
        }
    } catch (PHPMailerException $e) {
        error_log("PHPMailer Error: " . $e->getMessage());
        throw new Exception("Review submitted, but email sending failed");
    }
} catch (Exception $e) {
    $response = ["status" => "error", "message" => $e->getMessage()];
}

// Return JSON response
echo json_encode($response);
exit();
?>
