<?php

require "../connection.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

require '../Exception.php';
require '../PHPMailer.php';
require '../SMTP.php';

$subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// Validate form data
if (empty($subject)) {
    echo "Subject cannot be empty.";
    http_response_code(400);
    exit;
} else if (empty($message)) {
    echo "Message cannot be empty.";
    http_response_code(400);
    exit;
} else {
    // Escape user inputs
    $subject = Database::escape_string($subject);
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
                background:#bd3838;
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
                background:#bd3838;
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
            <div class="header">' . $subject . '</div>
            <div class="content">
                <p>' . $message . '</p>
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

    // Correct SQL query
    $query = "SELECT email FROM user";
    $result = Database::search($query);

    if ($result) {
        $successCount = 0;
        $failureCount = 0;
        while ($row = $result->fetch_assoc()) {
            $to = $row['email'];

            $mail = new PHPMailer(true);

            try {
                $mail->IsSMTP();
                $mail->Host = 'mail.blaze-tours.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'info@blaze-tours.com';
                $mail->Password = 'UU68On8u.8;Yfl';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;
                $mail->setFrom('info@blaze-tours.com', 'Blaze Tours');
                $mail->addReplyTo('info@blaze-tours.com', 'Blaze Tours');
                $mail->addAddress($to);
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body = $bodyContent;

                if ($mail->send()) {
                    $successCount++;
                } else {
                    $failureCount++;
                    error_log("Failed to send email to $to", 3, "/Applications/XAMPP/xamppfiles/htdocs/Rakkithtakanda_backend/logs/email_errors.log");
                }
            } catch (PHPMailerException $e) {
                $failureCount++;
                error_log("Email sending failed to $to: " . $e->getMessage(), 3, "/Applications/XAMPP/xamppfiles/htdocs/Rakkithtakanda_backend/logs/email_errors.log");
            }
        }
        echo "Emails sent successfully to $successCount recipients. Failed to send to $failureCount recipients.";
    } else {
        echo "Failed to fetch subscribers.";
        error_log("Failed to fetch subscribers: " . Database::$connection->error, 3, "/Applications/XAMPP/xamppfiles/htdocs/Rakkithtakanda_backend/logs/email_errors.log");
        http_response_code(500);
    }
}
