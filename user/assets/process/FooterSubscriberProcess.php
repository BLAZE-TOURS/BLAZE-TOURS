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

    // Retrieve and sanitize email input
    $email = trim($_POST['email'] ?? '');

    // Validate email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Please enter a valid email");
    }

    // Assign example values to other fields
    $firstName = "Unknown";
    $lastName = "Contributor";
    $mobile = "0000000000";
    $review = "No review has been posted.";
    $ratingStar = 5;

    // Check if email already exists
    $email = Database::escape_string($email);
    $checkEmailQuery = "SELECT * FROM user WHERE email = '$email'";
    $result = Database::search($checkEmailQuery);

    if ($result->num_rows > 0) {
        throw new Exception("Email address already exists");
    }

    // Insert data into the database
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
            .header { background:#bd3838; color: white; padding: 15px; font-size: 24px; font-weight: bold; border-radius: 8px 8px 0 0; }
            .content { padding: 20px; font-size: 18px; color: #333333; }
            .footer { background: #f4f4f4; padding: 10px; font-size: 14px; color: #777777; border-radius: 0 0 8px 8px; }
            .button { background:#bd3838; color: #ffffff; text-decoration: none; padding: 10px 20px; font-size: 16px; border: none; cursor: pointer; font-weight: bold; }
        </style>
    </head>
    <body>
        <div class="email-container">
            <div class="header">Thank You!</div>
            <div class="content">
                <p>Thank you for subscribing to our newsletter!</p>
                <p>We truly appreciate your support and will keep you updated with our latest news.</p>
                </br>
                <a href="https://blaze-tours.com/" target="_blank">
                    <button class="button">Visit Our Website</button>
                </a>
            </div>
            <div class="footer">
                &copy; ' . date("Y") . ' BLAZE TOURS (PVT) LTD | All Rights Reserved
            </div>
        </div>
    </body>
    </html>';

    // Send email
    $mail = new PHPMailer(true);
    try {
        $mail->IsSMTP();
        $mail->Host = 'mail.blaze-tours.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'subscribe@blaze-tours.com';
        $mail->Password = 'UU68On8u.8;Yfl';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        $mail->setFrom('subscribe@blaze-tours.com', 'blaze-tours');
        $mail->addReplyTo('subscribe@blaze-tours.com', 'blaze-tours');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Thank You for Subscribing';
        $mail->Body = $bodyContent;

        if ($mail->send()) {
            $response = ["status" => "success", "message" => "Subscription successful"];
        } else {
            error_log("Email sending failed: " . $mail->ErrorInfo);
            throw new Exception("Subscription successful, but email sending failed");
        }
    } catch (PHPMailerException $e) {
        error_log("PHPMailer Error: " . $e->getMessage());
        throw new Exception("Subscription successful, but email sending failed");
    }
} catch (Exception $e) {
    $response = ["status" => "error", "message" => $e->getMessage()];
}

// Return JSON response
echo json_encode($response);
exit();
?>
