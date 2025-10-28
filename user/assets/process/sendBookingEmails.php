<?php
require_once "connection.php";
require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;


function sendBookingConfirmationEmail($bookingData)
{
    try {
        $bodyContent = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation - Blaze Tours</title>
    <style>
        body {
            font-family: "Poppins", Arial, sans-serif;
            background-color: #f6f7fb;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 680px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 4px 30px rgba(0,0,0,0.08);
        }
        .header {
            background: linear-gradient(135deg, #e63a3a, #bd3838);
            padding: 40px 20px;
            text-align: center;
            color: #fff;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .header .status {
            margin-top: 10px;
            background: #fff;
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            color: #28a745;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .content {
            padding: 30px;
            line-height: 1.7;
        }
        .content h2 {
            color: #222;
            margin-bottom: 10px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
        }
        .details-table th, .details-table td {
            text-align: left;
            padding: 12px 15px;
            border-bottom: 1px solid #f1f1f1;
        }
        .details-table th {
            background-color: #fafafa;
            font-weight: 600;
            color: #555;
        }
        .details-table td {
            color: #333;
        }
        .price {
            font-weight: bold;
            font-size: 16px;
            color: #bd3838;
        }
        .highlight {
            background: #fef5f5;
            border-left: 4px solid #bd3838;
            padding: 15px 20px;
            border-radius: 10px;
            margin: 20px 0;
            font-size: 15px;
        }
        .footer {
            background: #fafafa;
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #777;
            border-top: 1px solid #eee;
        }
        a {
            color: #bd3838;
            text-decoration: none;
        }
        @media (max-width: 600px) {
            .content { padding: 20px; }
            .header h1 { font-size: 22px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Booking Confirmed!</h1>
            <div class="status">✅ Payment Successful</div>
        </div>
        <div class="content">
            <h2>Hi ' . htmlspecialchars($bookingData['fullName']) . ',</h2>
            <p>Thank you for choosing <strong>Blaze Tours</strong>! Your booking has been successfully confirmed, and payment has been received. Below are your invoice and booking details:</p>
            
            <table class="details-table">
                <tr>
                    <th>Booking ID</th>
                    <td><strong>' . htmlspecialchars($bookingData['booking_id'] ?? 'N/A') . '</strong></td>
                </tr>
                <tr>
                    <th>Tour</th>
                    <td>' . htmlspecialchars($bookingData['tourName']) . '</td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td>' . date('M d, Y', strtotime($bookingData['date'])) . '</td>
                </tr>
                <tr>
                    <th>Time Slot</th>
                    <td>' . (!empty($bookingData['timeSlot']) ? date('g:i A', strtotime($bookingData['timeSlot'])) : '-') . '</td>
                </tr>
                <tr>
                    <th>Pickup Location</th>
                    <td>' . htmlspecialchars($bookingData['pickup'] ?? '-') . '</td>
                </tr>
                <tr>
                    <th>Adults</th>
                    <td>' . intval($bookingData['adults'] ?? 0) . '</td>
                </tr>
                <tr>
                    <th>Children</th>
                    <td>' . intval($bookingData['children'] ?? 0) . '</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>' . htmlspecialchars($bookingData['phone'] ?? '-') . '</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>' . htmlspecialchars($bookingData['email']) . '</td>
                </tr>
                <tr>
                    <th>Total (USD)</th>
                    <td class="price">$' . number_format($bookingData['totalPriceUSD'], 2) . '</td>
                </tr>
                <tr>
                    <th>Total (LKR)</th>
                    <td class="price">Rs. ' . number_format($bookingData['totalPriceLKR'], 2) . '</td>
                </tr>
                <tr>
                    <th>Paid Amount (USD)</th>
                    <td>$' . number_format($bookingData['advance_paid_usd'] ?? 0, 2) . '</td>
                </tr>
                <tr>
                    <th>Paid Amount (LKR)</th>
                    <td>Rs. ' . number_format($bookingData['advance_paid_lkr'] ?? 0, 2) . '</td>
                </tr>
                <tr>
                    <th>Balance Due (USD)</th>
                    <td class="price">$' . number_format($bookingData['balance_due_usd'] ?? 0, 2) . '</td>
                </tr>
                <tr>
                    <th>Balance Due (LKR)</th>
                    <td class="price">Rs. ' . number_format($bookingData['balance_due_lkr'] ?? 0, 2) . '</td>
                </tr>
            </table>

            <div class="highlight">
                ✳️ Need to modify your booking? Contact our support team at 
                <a href="mailto:booking@blaze-tours.com">booking@blaze-tours.com</a> or call us at <strong>+94 71 334 4399</strong>.
            </div>

            <p>We’re thrilled to have you on board and can’t wait for you to experience an unforgettable journey with us 🌴🚐</p>
        </div>

        <div class="footer">
            &copy; ' . date("Y") . ' <strong>Blaze Tours (Pvt) Ltd</strong> | All Rights Reserved
        </div>
    </div>
</body>
</html>';


        // ✅ Live server mail settings
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'mail.blaze-tours.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'booking@blaze-tours.com';
        $mail->Password = 'UU68On8u.8;Yfl';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        $mail->setFrom('booking@blaze-tours.com', 'Blaze Tours (Pvt) Ltd');
        $mail->addAddress($bookingData['email']);
        $mail->isHTML(true);
        $mail->Subject = 'Booking Invoice & Confirmation - ' . htmlspecialchars($bookingData['tourName']);
        $mail->Body = $bodyContent;
        $mail->SMTPOptions = [
            'ssl' => ['verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true]
        ];
        $mail->send();

        error_log("✅ Booking confirmation email sent to: " . $bookingData['email']);
        return true;
    } catch (PHPMailerException $e) {
        error_log("❌ PHPMailer Error (Customer): " . $e->getMessage());
        return false;
    }
}

function sendAdminNotificationEmail($bookingData)
{
    try {
        $bodyContent = '
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
                .email-container { max-width: 650px; background: #fff; margin: auto; padding: 30px; border-radius: 10px; box-shadow: 0 4px 16px rgba(0,0,0,0.10); }
                .header { background: #28a745; color: #fff; padding: 24px; font-size: 26px; font-weight: bold; border-radius: 10px 10px 0 0; text-align: center; }
                .details-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                .details-table th, .details-table td { padding: 10px 12px; border-bottom: 1px solid #eee; text-align: left; }
                .details-table th { background: #f8f8f8; font-weight: 600; }
                .price-row { font-weight: bold; }
                .footer { background: #f4f4f4; padding: 18px; font-size: 14px; color: #777; border-radius: 0 0 10px 10px; text-align: center; }
            </style>
        </head>
        <body>
            <div class="email-container">
                <div class="header">New Booking Received</div>
                <table class="details-table">
                    <tr>
                        <th>Booking ID</th>
                        <td><strong>' . htmlspecialchars($bookingData['booking_id'] ?? 'N/A') . '</strong></td>
                    </tr>
                    <tr>
                        <th>Tour</th>
                        <td>' . htmlspecialchars($bookingData['tourName']) . '</td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td>' . date('M d, Y', strtotime($bookingData['date'])) . '</td>
                    </tr>
                    <tr>
                        <th>Time Slot</th>
                        <td>' . (!empty($bookingData['timeSlot']) ? date('g:i A', strtotime($bookingData['timeSlot'])) : '-') . '</td>
                    </tr>
                    <tr>
                        <th>Pickup Location</th>
                        <td>' . htmlspecialchars($bookingData['pickup'] ?? '-') . '</td>
                    </tr>
                    <tr>
                        <th>Adults</th>
                        <td>' . intval($bookingData['adults'] ?? 0) . '</td>
                    </tr>
                    <tr>
                        <th>Children</th>
                        <td>' . intval($bookingData['children'] ?? 0) . '</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>' . htmlspecialchars($bookingData['phone'] ?? '-') . '</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>' . htmlspecialchars($bookingData['email']) . '</td>
                    </tr>
                    <tr class="price-row">
                        <th>Total (USD)</th>
                        <td>$' . number_format($bookingData['totalPriceUSD'], 2) . '</td>
                    </tr>
                    <tr>
                        <th>Total (LKR)</th>
                        <td>Rs. ' . number_format($bookingData['totalPriceLKR'], 2) . '</td>
                    </tr>
                    <tr>
                        <th>Paid Amount (USD)</th>
                        <td>$' . number_format($bookingData['advance_paid_usd'] ?? 0, 2) . '</td>
                    </tr>
                    <tr>
                        <th>Paid Amount (LKR)</th>
                        <td>Rs. ' . number_format($bookingData['advance_paid_lkr'] ?? 0, 2) . '</td>
                    </tr>
                    <tr>
                        <th>Balance Due (USD)</th>
                        <td>$' . number_format($bookingData['balance_due_usd'] ?? 0, 2) . '</td>
                    </tr>
                    <tr>
                        <th>Balance Due (LKR)</th>
                        <td>Rs. ' . number_format($bookingData['balance_due_lkr'] ?? 0, 2) . '</td>
                    </tr>
                </table>
                <div class="footer">&copy; ' . date("Y") . ' Blaze Tours (Pvt) Ltd | New booking notification</div>
            </div>
        </body>
        </html>';

        // ✅ Live server mail settings
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'mail.blaze-tours.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'booking@blaze-tours.com';
        $mail->Password = 'UU68On8u.8;Yfl';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        $mail->setFrom('booking@blaze-tours.com', 'Blaze Tours System');
        $mail->addAddress('toursblaze@gmail.com');
        $mail->isHTML(true);
        $mail->Subject = 'New Booking - ' . htmlspecialchars($bookingData['tourName']);
        $mail->Body = $bodyContent;
        $mail->SMTPOptions = [
            'ssl' => ['verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true]
        ];
        $mail->send();

        error_log("✅ Admin notification email sent.");
        return true;
    } catch (PHPMailerException $e) {
        error_log("❌ PHPMailer Error (Admin): " . $e->getMessage());
        return false;
    }
}
