
<?php
require 'connection.php';
require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$name = Database::escape_string($data['name'] ?? '');
$email = Database::escape_string($data['email'] ?? '');
$mobile = Database::escape_string($data['mobile'] ?? '');
$message = Database::escape_string($data['message'] ?? '');

if (!$name || !$email || !$mobile || !$message) {
    echo json_encode(['success' => false, 'error' => 'All fields required']);
    exit;
}

$dateTime = date('Y-m-d H:i:s');
$status_id = 1;

$sql = "INSERT INTO massage (fullName, email, mobile, massage, dateTime, status_id) VALUES ('$name', '$email', '$mobile', '$message', '$dateTime', $status_id)";

try {
    Database::iud($sql);

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'mail.blaze-tours.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'contact@blaze-tours.com';
    $mail->Password = 'UU68On8u.8;Yfl';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('contact@blaze-tours.com', 'BLAZE TOURS');
    $mail->addReplyTo($email, $name);
    $mail->addAddress('toursblaze@gmail.com');
    $mail->isHTML(true);
    $mail->Subject = 'New Message Recerver - BLAZE TOURS';

    $body = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body {
                font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                padding: 20px;
                margin: 0;
            }
            .email-container {
                max-width: 600px;
                background: #ffffff;
                margin: 0 auto;
                border-radius: 12px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
                overflow: hidden;
            }
            .header {
                background: linear-gradient(135deg, rgb(90, 5, 8) 0%, rgb(150, 20, 30) 100%);
                color: white;
                padding: 30px 20px;
                text-align: center;
            }
            .header h1 {
                margin: 0;
                font-size: 28px;
                font-weight: bold;
                letter-spacing: 0.5px;
            }
            .header p {
                margin: 8px 0 0 0;
                font-size: 14px;
                opacity: 0.9;
            }
            .content {
                padding: 30px 25px;
            }
            .welcome-text {
                font-size: 16px;
                color: #333333;
                margin: 0 0 25px 0;
                line-height: 1.6;
            }
            .info-box {
                background: #f8f9fb;
                border-left: 4px solid rgb(90, 5, 8);
                padding: 15px 20px;
                margin: 15px 0;
                border-radius: 4px;
            }
            .info-label {
                font-size: 12px;
                color: rgb(90, 5, 8);
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                margin: 0 0 5px 0;
            }
            .info-value {
                font-size: 15px;
                color: #222222;
                word-break: break-all;
                margin: 0;
            }
            .message-box {
                background: #f0f4f9;
                border: 1px solid #e0e8f0;
                border-radius: 8px;
                padding: 20px;
                margin: 20px 0;
            }
            .message-title {
                font-size: 13px;
                color: rgb(90, 5, 8);
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                margin: 0 0 12px 0;
            }
            .message-content {
                font-size: 14px;
                color: #333333;
                line-height: 1.8;
                white-space: pre-wrap;
                word-wrap: break-word;
                margin: 0;
            }
            .footer {
                background: #f5f5f5;
                padding: 20px 25px;
                text-align: center;
                border-top: 1px solid #e0e0e0;
            }
            .footer-text {
                font-size: 12px;
                color: #666666;
                margin: 0;
                line-height: 1.6;
            }
            .footer-link {
                color: rgb(90, 5, 8);
                text-decoration: none;
                font-weight: 600;
            }
            .footer-link:hover {
                text-decoration: underline;
            }
            .divider {
                height: 1px;
                background: #e0e0e0;
                margin: 20px 0;
            }
        </style>
    </head>
    <body>
        <div class="email-container">
            <div class="header">
                <h1>New Message Received</h1>
                <p>From BLAZE TOURS Contact Form</p>
            </div>
            
            <div class="content">
                <p class="welcome-text">Hello BLAZE TOURS Team,</p>
                <p class="welcome-text">You have received a new message from your contact form. Here are the details:</p>
                
                <div class="info-box">
                    <div class="info-label">Full Name</div>
                    <div class="info-value">' . htmlspecialchars($name) . '</div>
                </div>
                
                <div class="info-box">
                    <div class="info-label">Email Address</div>
                    <div class="info-value"><a href="mailto:' . htmlspecialchars($email) . '" style="color: rgb(90, 5, 8); text-decoration: none;">' . htmlspecialchars($email) . '</a></div>
                </div>
                
                <div class="info-box">
                    <div class="info-label">WhatsApp Number</div>
                    <div class="info-value"><a href="https://wa.me/' . preg_replace("/[^0-9]/", "", $mobile) . '" style="color: rgb(90, 5, 8); text-decoration: none;">' . htmlspecialchars($mobile) . '</a></div>
                </div>
                
                <div class="message-box">
                    <div class="message-title">Message</div>
                    <div class="message-content">' . htmlspecialchars($message) . '</div>
                </div>
                
                <div class="divider"></div>
                
                <p style="font-size: 13px; color: #888888; margin: 15px 0 0 0; text-align: right;">
                    <strong style="color: #333;">Received:</strong> ' . date('Y-m-d H:i:s') . '
                </p>
            </div>
            
            <div class="footer">
                <p class="footer-text">
                    <strong style="color: #333;">BLAZE TOURS (PVT) LTD</strong><br>
                    68/29, Sri Sidhartha Road, Kirulapane, Colombo-6<br>
                    <a href="tel:+94713344399" class="footer-link">+94 71 334 4399</a> | 
                    <a href="mailto:booking@blaze-tours.com" class="footer-link">booking@blaze-tours.com</a><br>
                    <br>
                    <small>&copy; ' . date("Y") . ' BLAZE TOURS (PVT) LTD | All Rights Reserved</small>
                </p>
            </div>
        </div>
    </body>
    </html>';

    $mail->Body = $body;
    $mail->AltBody = "New Message Recerver\n\n"
        . "Name: {$name}\n"
        . "Email: {$email}\n"
        . "Whatsapp: {$mobile}\n"
        . "Message: {$message}\n";

    $mail->send();

    echo json_encode(['success' => true, 'message' => 'Message saved and email sent']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}