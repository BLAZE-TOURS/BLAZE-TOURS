<?php

require "../connection.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

require '../Exception.php';
require '../PHPMailer.php';
require '../SMTP.php';

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$ccEmail = isset($_POST['cc-email']) ? trim($_POST['cc-email']) : '';
$bccEmail = isset($_POST['bcc-email']) ? trim($_POST['bcc-email']) : '';
$subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
$bodyTitle = isset($_POST['body-title']) ? trim($_POST['body-title']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// Validate form data
if (empty($email)) {
    echo "Email address cannot be empty.";
    http_response_code(400);
    exit;
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email address.";
    http_response_code(400);
    exit;
} else if (!empty($ccEmail) && !filter_var($ccEmail, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid CC email address.";
    http_response_code(400);
    exit;
} else if (!empty($bccEmail) && !filter_var($bccEmail, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid BCC email address.";
    http_response_code(400);
    exit;
} else if (empty($subject)) {
    echo "Subject cannot be empty.";
    http_response_code(400);
    exit;
} else if (empty($bodyTitle)) {
    echo "Body title cannot be empty.";
    http_response_code(400);
    exit;
} else if (empty($message)) {
    echo "Message cannot be empty.";
    http_response_code(400);
    exit;
} else {
    // Escape user inputs
    $email = Database::escape_string($email);
    $ccEmail = Database::escape_string($ccEmail);
    $bccEmail = Database::escape_string($bccEmail);
    $subject = Database::escape_string($subject);
    $bodyTitle = Database::escape_string($bodyTitle);
    $message = Database::escape_string($message);

    // Create the email body content
    $bodyContent = '
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                padding: 20px;
            }
            .email-container {
                max-width: 600px;
                background: #ffffff;
                margin: auto;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
                text-align: center;
            }
            .header {
                background:rgb(90, 5, 8);
                color: white;
                padding: 15px;
                font-size: 24px;
                font-weight: bold;
                border-radius: 8px 8px 0 0;
            }
            .content {
                padding: 20px;
                font-size: 18px;
                color: #333333;
            }
            .footer {
                background: #f4f4f4;
                padding: 10px;
                font-size: 14px;
                color: #777777;
                border-radius: 0 0 8px 8px;
            }
            .button {
                background:rgb(90, 5, 8);
                color: #ffffff;
                text-decoration: none;
                padding: 10px 20px;
                font-size: 16px;
                border: none;
                cursor: pointer;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div class="email-container">
            <div class="header">' . $bodyTitle . '</div>
            <div class="content">
                <p>' . $message . '</p>
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

    $mail = new PHPMailer(true);

    try {
        $mail->IsSMTP();
        $mail->Host = 'mail.rakkithtakandatemple.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'booking@rakkithtakandatemple.com';
        $mail->Password = '07NeYMcm-:a43R';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        $mail->setFrom('booking@rakkithtakandatemple.com', 'Rakkithtakanda Temple');
        $mail->addReplyTo('booking@rakkithtakandatemple.com', 'Rakkithtakanda Temple');
        $mail->addAddress($email);

        if (!empty($ccEmail)) {
            $mail->addCC($ccEmail);
        }

        if (!empty($bccEmail)) {
            $mail->addBCC($bccEmail);
        }

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $bodyContent;

        if ($mail->send()) {
            echo "Email sent successfully.";
        } else {
            echo "Failed to send email.";
            error_log("Failed to send email to $email", 3, "/Applications/XAMPP/xamppfiles/htdocs/Rakkithtakanda_backend/logs/email_errors.log");
        }
    } catch (PHPMailerException $e) {
        echo "Email sending failed: " . $e->getMessage();
        error_log("Email sending failed to $email: " . $e->getMessage(), 3, "/Applications/XAMPP/xamppfiles/htdocs/Rakkithtakanda_backend/logs/email_errors.log");
    }
}
?>