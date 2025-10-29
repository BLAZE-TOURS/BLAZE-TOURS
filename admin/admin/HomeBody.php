<?php
require_once '../connection.php';

// Prepare dashboard data (last 12 months)
$now = new DateTime('first day of this month');
$start = (clone $now)->modify('-11 months'); // 12 months window: start -> now

// initialize months array (YYYY-MM-01 for datetime categories) and map keys YYYY-MM
$months = [];
$monthKeys = []; // keys like "2025-10"
$iter = clone $start;
for ($i = 0; $i < 12; $i++) {
    $monthKeys[] = $iter->format('Y-m');
    // use first day so Apex treats as month datetime
    $months[] = $iter->format('Y-m-01');
    $iter->modify('+1 month');
}

// bookings totals grouped by year/month (status 1 & 4)
$startDate = $start->format('Y-m-01') . ' 00:00:00';
$booking_rs = Database::search(
    "SELECT YEAR(created_at) AS y, MONTH(created_at) AS m, IFNULL(SUM(total_price_lkr),0) AS s
     FROM booking
     WHERE status_id IN (1,4)
       AND created_at >= '$startDate'
     GROUP BY y, m"
);
$bookingMap = [];
if ($booking_rs) {
    while ($r = $booking_rs->fetch_assoc()) {
        $key = sprintf('%04d-%02d', intval($r['y']), intval($r['m']));
        $bookingMap[$key] = (float)$r['s'];
    }
}

// paynow totals grouped by year/month (status 1) — createdAt stored as string, convert
$paynow_rs = Database::search(
    "SELECT YEAR(STR_TO_DATE(createdAt, '%Y-%m-%d %H:%i:%s')) AS y,
            MONTH(STR_TO_DATE(createdAt, '%Y-%m-%d %H:%i:%s')) AS m,
            IFNULL(SUM(lkr_amount),0) AS s
     FROM paynow
     WHERE status_id = 1
       AND STR_TO_DATE(createdAt, '%Y-%m-%d %H:%i:%s') >= '$startDate'
     GROUP BY y, m"
);
$paynowMap = [];
if ($paynow_rs) {
    while ($r = $paynow_rs->fetch_assoc()) {
        $key = sprintf('%04d-%02d', intval($r['y']), intval($r['m']));
        $paynowMap[$key] = (float)$r['s'];
    }
}

// Add after building $bookingMap / $paynowMap and before $monthlyTotals build

// booking counts grouped by year/month (status 1 & 4)
$bookingCount_rs = Database::search(
    "SELECT YEAR(created_at) AS y, MONTH(created_at) AS m, COUNT(*) AS cnt
     FROM booking
     WHERE status_id IN (1,4)
       AND created_at >= '$startDate'
     GROUP BY y, m"
);
$bookingCountMap = [];
if ($bookingCount_rs) {
    while ($r = $bookingCount_rs->fetch_assoc()) {
        $key = sprintf('%04d-%02d', intval($r['y']), intval($r['m']));
        $bookingCountMap[$key] = (int)$r['cnt'];
    }
}

// Build monthly totals aligning to months array
$monthlyTotals = [];
$monthlyBookingCounts = [];
foreach ($monthKeys as $k) {
    $b = $bookingMap[$k] ?? 0.0;
    $p = $paynowMap[$k] ?? 0.0;
    $monthlyTotals[] = round($b + $p, 2);

    $monthlyBookingCounts[] = $bookingCountMap[$k] ?? 0;
}

// Get today's date in Y-m-d format
$today = date('Y-m-d');

// Today's Bookings (status 1 and 4)
$today_booking_rs = Database::search("
    SELECT COUNT(*) AS c 
    FROM booking 
    WHERE status_id IN (1,4) 
    AND DATE(created_at) = '$today'
");
$today_booking_row = $today_booking_rs->fetch_assoc();
$todayBookings = (int)($today_booking_row['c'] ?? 0);

// Total Bookings (status 1 and 4)
$total_booking_rs = Database::search("
    SELECT COUNT(*) AS c 
    FROM booking 
    WHERE status_id IN (1,4)
");
$total_booking_row = $total_booking_rs->fetch_assoc();
$totalBookings = (int)($total_booking_row['c'] ?? 0);

// Today's Earnings
// From bookings (advance_paid_lkr where status 1,4)
$today_booking_earn_rs = Database::search("
    SELECT IFNULL(SUM(advance_paid_lkr), 0) AS s 
    FROM booking 
    WHERE status_id IN (1,4) 
    AND DATE(created_at) = '$today'
");
$today_booking_earn = (float)($today_booking_earn_rs->fetch_assoc()['s'] ?? 0);

// From paynow (lkr_amount where status 1)
$today_paynow_earn_rs = Database::search("
    SELECT IFNULL(SUM(lkr_amount), 0) AS s 
    FROM paynow 
    WHERE status_id = 1 
    AND DATE(STR_TO_DATE(createdAt, '%Y-%m-%d %H:%i:%s')) = '$today'
");
$today_paynow_earn = (float)($today_paynow_earn_rs->fetch_assoc()['s'] ?? 0);

$todayEarnings = $today_booking_earn + $today_paynow_earn;

// Total Earnings
// From bookings (advance_paid_lkr where status 1,4)
$total_booking_earn_rs = Database::search("
    SELECT IFNULL(SUM(advance_paid_lkr), 0) AS s 
    FROM booking 
    WHERE status_id IN (1,4)
");
$total_booking_earn = (float)($total_booking_earn_rs->fetch_assoc()['s'] ?? 0);

// From paynow (lkr_amount where status 1)
$total_paynow_earn_rs = Database::search("
    SELECT IFNULL(SUM(lkr_amount), 0) AS s 
    FROM paynow 
    WHERE status_id = 1
");
$total_paynow_earn = (float)($total_paynow_earn_rs->fetch_assoc()['s'] ?? 0);

$totalEarnings = $total_booking_earn + $total_paynow_earn;

// Update the dashboard data array
$dashboard_json = json_encode([
    'todayBookings' => $todayBookings,
    'totalBookings' => $totalBookings,
    'todayEarnings' => round($todayEarnings, 2),
    'totalEarnings' => round($totalEarnings, 2),
    'categories' => $months,
    'monthlyTotals' => $monthlyTotals,
    'monthlyBookingCounts' => $monthlyBookingCounts,
    'today' => date('Y-m-d')
]);
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Blaze Tours (Pvt) Ltd | Colombo City & Sri Lanka Tours</title>
    <meta name="author" content="Blaze Tours (Pvt) Ltd">
    <meta name="description" content="Blaze Tours (Pvt) Ltd is a Colombo-based travel company offering unforgettable city tours, cultural trips, and scenic getaways across Sri Lanka. Explore paradise with us!">
    <meta name="keywords" content="Colombo tours, Sri Lanka travel, Blaze Tours, day trips Colombo, Sri Lanka sightseeing, private tours, cultural tours, beach tours">
    <meta name="robots" content="INDEX,FOLLOW">
    <!-- meta tags... -->
</head>

<body>
<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0" onclick=" changeDashboardView();">Dashboard</h4>
                </div>
            </div>

            <!-- start row -->
            <div class="row">
                <div class="col-md-12 col-xl-12">
                    <div class="row g-3">
                        <!-- Today's Bookings -->
                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="fs-14 mb-1">Today's Bookings</div>
                                    </div>
                                    <div class="d-flex align-items-baseline mb-2">
                                        <div class="fs-22 mb-0 me-2 fw-semibold text-black" id="todayBookingsValue">
                                            <?= $todayBookings ?>
                                        </div>
                                    </div>
                                    <div id="today-bookings-chart" class="apex-charts"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Bookings -->
                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="fs-14 mb-1">Total Bookings</div>
                                    </div>
                                    <div class="d-flex align-items-baseline mb-2">
                                        <div class="fs-22 mb-0 me-2 fw-semibold text-black" id="totalBookingsValue">
                                            <?= $totalBookings ?>
                                        </div>
                                    </div>
                                    <div id="total-bookings-chart" class="apex-charts"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Today's Earnings -->
                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="fs-14 mb-1">Today's Earnings</div>
                                    </div>
                                    <div class="d-flex align-items-baseline mb-2">
                                        <div class="fs-22 mb-0 me-2 fw-semibold text-black" id="todayEarningsValue">
                                            LKR <?= number_format($todayEarnings, 2) ?>
                                        </div>
                                    </div>
                                    <div id="today-earnings-chart" class="apex-charts"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Earnings -->
                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="fs-14 mb-1">Total Earnings</div>
                                    </div>
                                    <div class="d-flex align-items-baseline mb-2">
                                        <div class="fs-22 mb-0 me-2 fw-semibold text-black" id="totalEarningsValue">
                                            LKR <?= number_format($totalEarnings, 2) ?>
                                        </div>
                                    </div>
                                    <div id="total-earnings-chart" class="apex-charts"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- end sales -->
            </div> <!-- end row -->

            <!-- Start Monthly Sales -->
            <div class="row">
                <div class="col-md-6 col-xl-12">
                    <div class="card">

                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <div class="border border-dark rounded-2 me-2 widget-icons-sections">
                                    <i data-feather="bar-chart" class="widgets-icons"></i>
                                </div>
                                <h5 class="card-title mb-0">Monthly Sales</h5>
                            </div>
                        </div>

                        <div class="card-body">
                            <div id="monthly-sales" class="apex-charts"></div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- End Monthly Sales -->

            <div class="row">
                <div class="col-md-6 col-xl-12">
                    <div class="card">

                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <div class="border border-dark rounded-2 me-2 widget-icons-sections">
                                    <i data-feather="users" class="widgets-icons"></i>
                                </div>
                                <h5 class="card-title mb-0">Monthly Booking Overview</h5>
                            </div>
                        </div>

                        <div class="card-body">
                            <div id="audiences-daily" class="apex-charts mt-n3"></div>
                        </div>

                    </div>
                </div>
            </div>

        </div> <!-- container-fluid -->
    </div>
    <!-- content -->
</div>

<script>
window.DASHBOARD = <?= $dashboard_json ?>;
</script>

<!-- ensure ApexCharts is loaded before the init script -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="assets/js/pages/analytics-dashboard.init.js"></script>
</body>
</html>