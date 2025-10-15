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
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
                .email-container { max-width: 650px; background: #fff; margin: auto; padding: 30px; border-radius: 10px; box-shadow: 0 4px 16px rgba(0,0,0,0.10); }
                .header { background: #bd3838; color: #fff; padding: 24px; font-size: 28px; font-weight: bold; border-radius: 10px 10px 0 0; text-align: center; }
                .success { color: #28a745; font-size: 18px; font-weight: bold; margin: 20px 0 10px 0; text-align: center; }
                .details-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                .details-table th, .details-table td { padding: 10px 12px; border-bottom: 1px solid #eee; text-align: left; }
                .details-table th { background: #f8f8f8; font-weight: 600; }
                .price-row { font-weight: bold; }
                .footer { background: #f4f4f4; padding: 18px; font-size: 14px; color: #777; border-radius: 0 0 10px 10px; text-align: center; }
            </style>
        </head>
        <body>
            <div class="email-container">
                <div class="header">Booking Invoice & Confirmation</div>
                <div class="success">✅ Payment Successful</div>
                <p>Dear <strong>' . htmlspecialchars($bookingData['fullName']) . '</strong>,</p>
                <p>Thank you for your payment and booking with <strong>Blaze Tours!</strong> Your reservation is confirmed. Please find your invoice and booking details below.</p>
                <table class="details-table">
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
                        <th>Total (LKR)</th>
                        <td>Rs. ' . number_format($bookingData['totalPriceLKR'], 2) . '</td>
                    </tr>
                    <tr>
                        <th>Total (USD)</th>
                        <td>$' . number_format($bookingData['totalPriceUSD'], 2) . '</td>
                    </tr>
                </table>
                <p>If you have any questions or need to change your booking, please contact us at <a href="mailto:booking@blaze-tours.com">booking@blaze-tours.com</a> or call +94 77 123 4567.</p>
                <div class="footer">&copy; ' . date("Y") . ' Blaze Tours (Pvt) Ltd | Thank you for choosing us!</div>
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
                        <th>Total (LKR)</th>
                        <td>Rs. ' . number_format($bookingData['totalPriceLKR'], 2) . '</td>
                    </tr>
                    <tr>
                        <th>Total (USD)</th>
                        <td>$' . number_format($bookingData['totalPriceUSD'], 2) . '</td>
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
