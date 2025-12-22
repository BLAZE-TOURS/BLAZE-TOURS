<?php
// tour-page/submit_booking.php
session_start();
header('Content-Type: application/json');

// 1. Connection එක එළියෙන් ගැනීම
require_once '../assets/process/connection.php'; 
// 2. Config එක ඇතුලෙන් ගැනීම
require_once 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Input Data
    $tour_id = Database::escape_string($_POST['tour_id']);
    $tourDate = Database::escape_string($_POST['tourDate']);
    $name = Database::escape_string($_POST['fullName']);
    $email = Database::escape_string($_POST['email']);
    $mobile = Database::escape_string($_POST['number3']); 
    $pickup = Database::escape_string($_POST['pickup']);
    $timeSlot = Database::escape_string($_POST['timeSlot']);
    
    $adultCount = (int)$_POST['adultCount'];
    $childCount = (int)$_POST['childCount'];
    $advance_usd = (float)$_POST['paidAmount']; 

    // Block double bookings for the same tour/date/time (only when status is Success)
    $availabilityQuery = "SELECT id FROM booking WHERE tour_id = '$tour_id' AND tourDate = '$tourDate' AND time_slot = '$timeSlot' AND status = 'Success' LIMIT 1";
    $availabilityRes = Database::search($availabilityQuery);
    if ($availabilityRes && $availabilityRes->num_rows > 0) {
        echo json_encode([
            'success' => false,
            'message' => 'That time slot is already booked. Please select another one.'
        ]);
        exit;
    }

    // Tour & Currency Details
    $tour_res = Database::search("SELECT * FROM tour WHERE id = '$tour_id'");
    $tour_data = $tour_res->fetch_assoc();
    
    $rate_res = Database::search("SELECT LKR FROM currency WHERE currency='USD' LIMIT 1");
    $rate_row = $rate_res->fetch_assoc();
    $usd_to_lkr = ($rate_row) ? (float)$rate_row['LKR'] : 320.00; 

    // Calculations
    $adult_price = (float)$tour_data['adult_price'];
    $kids_price = (float)$tour_data['kids_price'];

    $total_usd = ($adult_price * $adultCount) + ($kids_price * $childCount);
    $total_lkr = $total_usd * $usd_to_lkr;

    $advance_lkr = $advance_usd * $usd_to_lkr; // PayHere Amount

    $balance_usd = $total_usd - $advance_usd;
    $balance_lkr = $total_lkr - $advance_lkr;

    // Save to DB
    $booking_id = uniqid(); 
    $order_id = 'ORD-' . time() . rand(100, 999); 

    $q = "INSERT INTO booking 
    (id, order_id, name, mobile, email, tourDate, time_slot, numberOfAdultCount, numberOfKidsCount, pickup_location, 
    total_price_lkr, total_price_usd, advance_paid_usd, advance_paid_lkr, balance_due_usd, balance_due_lkr, 
    tour_id, status, status_code, created_at) 
    VALUES 
    ('$booking_id', '$order_id', '$name', '$mobile', '$email', '$tourDate', '$timeSlot', '$adultCount', '$childCount', '$pickup', 
    '$total_lkr', '$total_usd', '$advance_usd', '$advance_lkr', '$balance_usd', '$balance_lkr', 
    '$tour_id', 'Pending', 0, NOW())";

    Database::iud($q);

    // Hash Generation
    $pay_amount = number_format($advance_lkr, 2, '.', '');
    $currency = 'LKR';
    
    $hash_str = MERCHANT_ID . $order_id . $pay_amount . $currency . strtoupper(md5(MERCHANT_SECRET));
    $hash = strtoupper(md5($hash_str));

    // Return JSON
    echo json_encode([
        'success' => true,
        'payhere_data' => [
            'merchant_id' => MERCHANT_ID,
            'return_url' => RETURN_URL . '?order_id=' . $order_id,
            'cancel_url' => CANCEL_URL . '?order_id=' . $order_id,
            'notify_url' => NOTIFY_URL,
            'order_id' => $order_id,
            'items' => $tour_data['name'],
            'currency' => $currency,
            'amount' => $pay_amount,
            'first_name' => $name,
            'last_name' => '',
            'email' => $email,
            'phone' => $mobile,
            'address' => $pickup,
            'city' => 'Colombo',
            'country' => 'Sri Lanka',
            'hash' => $hash
        ]
    ]);
}
?>