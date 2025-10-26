"use strict";

// Wait until DOM+dashboard data available
document.addEventListener('DOMContentLoaded', function () {
    var data = window.DASHBOARD || null;
    if (!data) {
        console.error('No DASHBOARD data found on window.DASHBOARD');
        return;
    }

    console.info('analytics-dashboard.init.js loaded. DASHBOARD keys:', Object.keys(data));

    // helper to safely render a chart once per container
    function renderOnce(containerSelector, createChartFn) {
        var el = document.querySelector(containerSelector);
        if (!el) {
            console.warn('Container not found for', containerSelector);
            return;
        }
        if (el.dataset.apexRendered === "1") {
            console.info('Chart already rendered for', containerSelector);
            return;
        }
        try {
            var chart = createChartFn(el);
            if (chart && typeof chart.render === 'function') {
                chart.render().then(function() {
                    el.dataset.apexRendered = "1";
                }).catch(function(err){
                    console.error('ApexCharts render error for', containerSelector, err);
                });
            } else {
                console.warn('createChartFn did not return an ApexCharts instance for', containerSelector);
            }
        } catch (err) {
            console.error('Error creating chart for', containerSelector, err);
        }
    }

    // Monthly Sales chart (last 12 months) - show earnings per month (LKR)
    (function() {
        var categories = Array.isArray(data.categories) ? data.categories.slice() : [];
        // Use monthlyTotals (earnings) here
        var seriesData = Array.isArray(data.monthlyTotals) ? data.monthlyTotals.map(function(v){ return Number(v) || 0; }) : [];
        console.info('Monthly Sales categories length:', categories.length, 'series length:', seriesData.length);

        // guard lengths
        if (categories.length !== seriesData.length) {
            var minLen = Math.min(categories.length, seriesData.length);
            categories = categories.slice(0, minLen);
            seriesData = seriesData.slice(0, minLen);
            console.warn('Adjusted categories/series to same length:', minLen);
        }
        if (!categories.length) {
            console.warn('No data to show for Monthly Sales');
            return;
        }

        var today = String(data.today || '');
        // color per month, highlight current month
        var colorsArr = categories.map(function(cat){
            var catYM = cat.slice(0,7);
            var todayYM = today.slice(0,7);
            return (catYM === todayYM) ? "#FF6B6B" : "#537AEF";
        });

        renderOnce('#monthly-sales', function(el) {
            var options = {
                chart: { type: "bar", height: 320, toolbar: { show: false } },
                series: [{ name: "Earnings (LKR)", data: seriesData }],
                colors: colorsArr,
                plotOptions: { bar: { columnWidth: "55%", borderRadius: 6, distributed: true } },
                xaxis: { type: "datetime", categories: categories },
                yaxis: { labels: { formatter: function (val) { return Math.round(val).toLocaleString(); } }, title: { text: "LKR" } },
                tooltip: { y: { formatter: function (val) { return 'LKR ' + Number(val).toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2}); } } },
                dataLabels: { enabled: false }
            };
            return new ApexCharts(el, options);
        });
    })();

    // Monthly Booking Overview (area) - show booking counts per month
    (function() {
        var categories = Array.isArray(data.categories) ? data.categories.slice() : [];
        // Use monthlyBookingCounts here
        var seriesData = Array.isArray(data.monthlyBookingCounts) ? data.monthlyBookingCounts.map(function(v){ return Number(v) || 0; })
                          : (Array.isArray(data.monthlyTotals) ? data.monthlyTotals.map(function(v){ return Number(v) || 0; }) : []);

        if (categories.length !== seriesData.length) {
            var minLen = Math.min(categories.length, seriesData.length);
            categories = categories.slice(0, minLen);
            seriesData = seriesData.slice(0, minLen);
        }
        if (!categories.length) {
            console.warn('No data to show for Monthly Booking Overview');
            return;
        }

        renderOnce('#audiences-daily', function(el) {
            var opts = {
                chart: { type: "area", height: 160, toolbar: { show: false }, zoom: { enabled: false } },
                series: [{ name: "Bookings", data: seriesData }],
                stroke: { curve: "smooth" },
                xaxis: { type: "datetime", categories: categories },
                tooltip: { y: { formatter: function (val) { return Number(val).toLocaleString(); } } },
                dataLabels: { enabled: false },
                colors: ["#537AEF"]
            };
            return new ApexCharts(el, opts);
        });
    })();

    // update widgets (values already printed server-side; keep JS sync)
    var tbEl = document.getElementById('totalBookingsValue');
    if (tbEl) tbEl.textContent = data.totalBookings;

    var beEl = document.getElementById('bookingEarningsValue');
    if (beEl) beEl.textContent = 'LKR ' + Number(data.bookingEarnings).toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2});

    var pyEl = document.getElementById('paynowEarningsValue');
    if (pyEl) pyEl.textContent = 'LKR ' + Number(data.paynowEarnings).toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2});

    var teEl = document.getElementById('totalEarningsValue');
    if (teEl) teEl.textContent = 'LKR ' + Number(data.totalEarnings).toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2});
});