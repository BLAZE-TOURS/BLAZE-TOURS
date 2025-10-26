<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Invoice | Blaze Tours</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="../../user/assets/img/logo.png">
    <link rel="stylesheet" href="../../user/assets/bootstrap.min.css">
    <link rel="stylesheet" href="../../user/assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="../../user/assets/css/style.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: "Poppins", sans-serif;
        }

        .invoice-card {
            border: 1px solid #e9ecef;
            border-radius: 12px;
            background: #fff;
            position: relative;
            padding: 30px;
        }

        .paid-seal-img {
            position: absolute;
            left: 50%;
            top: 40px;
            transform: translateX(-50%) rotate(-18deg);
            width: 220px;
            height: auto;
            opacity: 0.15;
            pointer-events: none;
            z-index: 50;
            filter: drop-shadow(0 6px 12px rgba(0, 0, 0, 0.08));
        }

        @media print {
            .no-print {
                display: none !important;
            }

            .paid-seal-img {
                left: 78%;
                top: 36px;
                transform: translateX(-40%) rotate(-18deg);
                opacity: 0.4;
            }

            .invoice-card {
                border: none;
            }

            body {
                background: #fff;
                margin: 0;
            }

            .invoice-header img {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

        .invoice-header,
        .invoice-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .company-name {
            font-size: 20px;
            font-weight: 600;
        }

        .inv-title {
            font-size: 26px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .totals-row {
            font-weight: 600;
            background-color: #f1f3f5;
        }

        .th-btn {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            transition: 0.3s;
        }

        .th-btn:hover {
            background: #0056b3;
        }

        @media (max-width: 768px) {

            .invoice-header,
            .invoice-footer {
                flex-direction: column;
                text-align: center;
            }

            table th,
            table td {
                font-size: 0.9rem;
            }

            .table thead tr th:nth-child(5),
            .table tbody tr td:nth-child(5) {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <div class="invoice-card shadow-sm">
            <!-- Paid -->
            <?php
            // Get POST data with fallbacks
            $tour_name = $_POST['tour_name'] ?? '-';
            $tour_id = $_POST['tour_id'] ?? '0';
            $date = $_POST['date'] ?? date('Y-m-d');
            $time = $_POST['time_text'] ?? '-';
            $payment_status = isset($_POST['payment_status']) ? (int)$_POST['payment_status'] : 0;

            // Customer details
            $full_name = $_POST['full_name'] ?? '-';
            $email = $_POST['email'] ?? '-';
            $phone = $_POST['phone'] ?? '-';

            // Pricing details
            $adults = (int)($_POST['adults'] ?? 0);
            $kids = (int)($_POST['kids'] ?? 0);
            $subtotal_usd = $_POST['subtotal_usd'] ?? '$0.00';
            $subtotal_lkr = $_POST['subtotal_lkr'] ?? 'Rs. 0.00';
            $discount_lkr = $_POST['discount_lkr'] ?? '0.00';
            $final_total_lkr = $_POST['final_total_lkr'] ?? '0.00';

            // Generate invoice number (you may want to get this from your database)
            $invoice_number = 'BLAZE' . date('ymd') . sprintf('%03d', rand(1, 999));
            ?>
            <?php if ($payment_status == 1): ?>
                <img src="images/paid.png" alt="PAID" class="paid-seal-img">
            <?php else: ?>
                <img src="images/unpaid.png" alt="UNPAID" class="paid-seal-img">
            <?php endif; ?>

            <!-- Header -->
            <div class="invoice-header">
                <div>
                    <img src="images/logo-main.png" alt="Blaze Tours Logo" style="height:60px; margin-bottom:10px;">
                    <div class="company-name">BLAZE TOURS (PVT) LTD</div>
                    <div>68/29, Sri Sidhartha Road, Kirulapane, Colombo-6</div>
                    <div>+94 71 334 4399</div>
                </div>
                <div class="text-end">
                    <div class="inv-title">Invoice</div>
                    <div><strong>No:</strong> <?= htmlspecialchars($invoice_number) ?></div>
                    <div><strong>Date:</strong> <?= date('Y-m-d') ?></div>
                </div>
            </div>

            <!-- Booking + Customer Details -->
            <div class="mt-4 row g-3">
                <div class="col-md-6">
                    <div class="card bg-light border-0">
                        <div class="card-body">
                            <div class="fw-bold mb-2">Booking Details</div>
                            <div><strong>Tour:</strong> <?= htmlspecialchars($tour_name) ?> (#<?= htmlspecialchars($tour_id) ?>)</div>
                            <div><strong>Date:</strong> <?= htmlspecialchars($date) ?></div>
                            <div><strong>Time:</strong> <?= htmlspecialchars($time) ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-light border-0 h-100">
                        <div class="card-body">
                            <div class="fw-bold mb-2">Customer</div>
                            <div><strong>Name:</strong> <?= htmlspecialchars($full_name) ?></div>
                            <div><strong>Email:</strong> <?= htmlspecialchars($email) ?></div>
                            <div><strong>Phone:</strong> <?= htmlspecialchars($phone) ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive mt-4">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Item</th>
                            <th class="text-center">People</th>
                            <th class="text-end">Amount (USD)</th>
                            <th class="text-end">Amount (LKR)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($adults > 0): ?>
                            <tr>
                                <td>Adults</td>
                                <td class="text-center"><?= $adults ?></td>
                                <td class="text-end" colspan="2"><?= htmlspecialchars($subtotal_usd) ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if ($kids > 0): ?>
                            <tr>
                                <td>Children</td>
                                <td class="text-center"><?= $kids ?></td>
                                <td class="text-end" colspan="2"><?= htmlspecialchars($subtotal_lkr) ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-end totals-row">Subtotal</td>
                            <td class="text-end totals-row"><?= htmlspecialchars($subtotal_usd) ?></td>
                            <td class="text-end totals-row"><?= htmlspecialchars($subtotal_lkr) ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end">Discount (LKR)</td>
                            <td class="text-end">Rs. <?= number_format((float)$discount_lkr, 2) ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end totals-row fw-bold">Final Total (LKR)</td>
                            <td class="text-end totals-row fw-bold" style="font-size: 1.1rem; color: #0d6efd;">
                                Rs. <?= number_format((float)$final_total_lkr, 2) ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Footer -->
            <div class="invoice-footer mt-3">
                <div>
                    <div class="text-muted">Thank you for choosing Blaze Tours.</div>

                    <div class="small text-muted mt-2">
                        ~ Develop and Design by Tecxone ~
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end mt-4 no-print">
            <button onclick="window.print()" class="th-btn">
                <i class="fa fa-print me-2"></i> Print Invoice
            </button>
        </div>
    </div>
</body>

</html>