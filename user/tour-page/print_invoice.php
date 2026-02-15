<?php
require_once '../assets/process/connection.php';

$order_id = Database::escape_string($_GET['order_id'] ?? '');
if (!$order_id) die("Invalid request");

$sql = "SELECT b.*, t.name AS tour_name
        FROM booking b
        INNER JOIN tour t ON b.tour_id = t.id
        WHERE b.order_id = '$order_id'";

$result = Database::search($sql);
$data = $result->fetch_assoc();
if (!$data) die("Order not found");

// Check if status is Success, otherwise redirect to home
if ($data['status'] != 'Success') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Booking Confirmation</title>

<style>
    body {
        font-family: Arial, sans-serif;
        background:#f4f6f8;
        padding:20px;
    }

    .invoice {
        max-width:720px;
        margin:auto;
        background:#fff;
        padding:35px;
        border-radius:12px;
    }

    .success {
        width:70px;
        height:70px;
        background:#28a745 !important;
        color:#fff !important;
        border-radius:50%;
        display:flex;
        align-items:center;
        justify-content:center;
        margin:0 auto 15px;
        font-size:38px;
        font-weight:700;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    h1 {
        text-align:center;
        color:#28a745;
        margin:0;
    }

    .thank {
        text-align:center;
        font-family:'Segoe Script', cursive;
        margin-bottom:30px;
    }

    .section {
        border:1px solid #ddd;
        padding:15px;
        border-radius:10px;
        margin-bottom:20px;
    }

    .section h3 {
        margin-top:0;
        border-bottom:1px solid #eee;
        padding-bottom:8px;
    }

    table {
        width:100%;
        border-collapse:collapse;
    }

    td {
        padding:6px 0;
    }

    .label {
        color:#666;
        width:40%;
    }

    .value {
        font-weight:600;
    }

    .summary {
        background:#f1f3f5;
        padding:15px;
        border-radius:10px;
    }

    .green { color:#28a745; }
    .red { color:#dc3545; font-weight:700; }

    footer {
        text-align:center;
        margin-top:25px;
        font-size:12px;
        color:#555;
    }

    /* ===== PRINT FIXES ===== */
    @media print {
        @page {
            margin: 0;
        }

        body {
            background:#fff;
            padding:0;
            margin:0;
        }

        header, footer {
            display:none !important;
        }
    }
</style>
</head>

<body onload="window.print()">

<div class="invoice">

    <div class="success">✔</div>

    <h1>Booking Confirmed!</h1>
    <div class="thank">Thank you, <?php echo htmlspecialchars($data['name']); ?></div>

    <div class="section">
        <h3><?php echo htmlspecialchars($data['tour_name']); ?></h3>
        <table>
            <tr>
                <td class="label">Tour Date</td>
                <td class="value"><?php echo $data['tourDate']; ?></td>
            </tr>
            <tr>
                <td class="label">Time Slot</td>
                <td class="value"><?php echo date('g:i A', strtotime($data['time_slot'])); ?></td>
            </tr>
            <tr>
                <td class="label">Guests</td>
                <td class="value">
                    <?php echo $data['numberOfAdultCount']; ?> Adults
                    <?php if($data['numberOfKidsCount'] > 0) echo ', '.$data['numberOfKidsCount'].' Children'; ?>
                </td>
            </tr>
            <tr>
                <td class="label">Pickup</td>
                <td class="value"><?php echo htmlspecialchars($data['pickup_location']); ?></td>
            </tr>
            <tr>
                <td class="label">Email</td>
                <td class="value"><?php echo htmlspecialchars($data['email']); ?></td>
            </tr>
            <tr>
                <td class="label">Mobile</td>
                <td class="value"><?php echo htmlspecialchars($data['mobile']); ?></td>
            </tr>
            <tr>
                <td class="label">Order ID</td>
                <td class="value"><?php echo htmlspecialchars($data['order_id']); ?></td>
            </tr>
            <tr>
                <td class="label">Status</td>
                <td class="value green"><?php echo htmlspecialchars($data['status']); ?></td>
            </tr>
        </table>
    </div>

    <div class="summary">
        <table>
            <tr>
                <td>Total Cost (USD)</td>
                <td style="text-align:right;">
                    $<?php echo number_format($data['total_price_usd'],2); ?>
                </td>
            </tr>
            <tr class="green">
                <td>Paid Amount (LKR)</td>
                <td style="text-align:right;">
                    Rs. <?php echo number_format($data['advance_paid_lkr'],2); ?>
                </td>
            </tr>
            <tr class="red">
                <td>Balance Due (USD)</td>
                <td style="text-align:right;">
                    $<?php echo number_format($data['balance_due_usd'],2); ?>
                </td>
            </tr>
        </table>
    </div>

    <div style="text-align:center; margin-top:20px;">
        Developed by <strong>Tecxone</strong>
    </div>

</div>

</body>
</html>
