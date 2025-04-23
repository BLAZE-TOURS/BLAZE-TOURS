<?php
session_start();
require "connection.php";
require_once "PHPMailer.php";
require_once "SMTP.php";
require_once "Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_GET["e"])) {
    $e = trim($_GET["e"]); // Remove whitespace

    if (empty($e)) {
        echo "Please enter your email address";
    } else if (!filter_var($e, FILTER_VALIDATE_EMAIL)) {
        echo "Please enter a valid email address";
    } else {
        $user_check = Database::search("SELECT * FROM `user` WHERE `email`='" . $e . "'");
        $num = $user_check->num_rows;

        if ($num == 1) {
            echo "You have already subscribed";
        } else {
            // Default values
            $mobile = "0000000000";
            $first_name = "Guest";
            $last_name = "User";
            $review = "No review yet";
            $date = date("Y-m-d H:i:s");
            $rating_star_id = 1;

            // Insert into database
            Database::iud("INSERT INTO `user`(`email`, `mobile`, `first_name`, `last_name`, `review`, `date`, `rating_star_id`) 
            VALUES ('" . $e . "', '" . $mobile . "', '" . $first_name . "', '" . $last_name . "', '" . $review . "', '" . $date . "', '" . $rating_star_id . "')");

            echo "Success";

            // Send email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'mail.blaze-tours.com'; // Use your domain's SMTP
                $mail->SMTPAuth   = true;
                $mail->Username   = 'info@blaze-tours.com'; // Domain email
                $mail->Password   = 'UU68On8u.8;Yfl'; // Use environment variable instead!
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;

                // Set sender & recipient
                $mail->setFrom('info@blaze-tours.com', 'Blaze Tours');
                $mail->addReplyTo('info@blaze-tours.com', 'Blaze Tours');
                $mail->addAddress($e);

                // Email content
                $mail->isHTML(true);
                $mail->Subject = 'Subscription Confirmation';
                $mail->Body = '
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
                            <p>We appreciate you joining our community.</p>
                            <p>Stay tuned for the latest updates and exclusive content.</p>
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

                if (!$mail->send()) {
                    echo "Verification email sending failed";
                }
            } catch (Exception $e) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            }
        }
    }
} else {
    echo "Please enter your email address";
}
?>
