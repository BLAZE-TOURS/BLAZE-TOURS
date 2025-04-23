<?php

require_once "connection.php";
require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

// Log the start of the script
error_log("sendEmails.php script started\n", 3, __DIR__ . "\\..\\logs\\sendEmails.log");

try {
    $query = "SELECT email FROM user";
    $result = Database::search($query);

    if ($result) {
        $successCount = 0;
        $failureCount = 0;
        $subject = "Thank you for your review!";
        $bodyContent = "<p>Dear Subscriber,</p><p>Thank you for submitting your review. We appreciate your feedback.</p><p>Best regards,<br>Rakkithtakanda Temple</p>";

        while ($row = $result->fetch_assoc()) {
            $to = $row['email'];

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
                $mail->addAddress($to);
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body = $bodyContent;

                if ($mail->send()) {
                    $successCount++;
                } else {
                    $failureCount++;
                    error_log("Failed to send email to $to\n", 3, __DIR__ . "\\..\\logs\\sendEmails.log");
                }
            } catch (PHPMailerException $e) {
                $failureCount++;
                error_log("Email sending failed to $to: " . $e->getMessage() . "\n", 3, __DIR__ . "\\..\\logs\\sendEmails.log");
            }
        }
        error_log("Emails sent successfully to $successCount recipients. Failed to send to $failureCount recipients.\n", 3, __DIR__ . "\\..\\logs\\sendEmails.log");
    } else {
        error_log("Failed to fetch subscribers: " . Database::$connection->error . "\n", 3, __DIR__ . "\\..\\logs\\sendEmails.log");
    }
} catch (Exception $e) {
    error_log("An error occurred: " . $e->getMessage() . "\n", 3, __DIR__ . "\\..\\logs\\sendEmails.log");
}

// Log the end of the script
error_log("sendEmails.php script ended\n", 3, __DIR__ . "\\..\\logs\\sendEmails.log");
?>