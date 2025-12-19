<?php $order_id = isset($_GET['order_id']) ? $_GET['order_id'] : ''; ?>
<!doctype html>
<html>
<head>
    <title>Canceled</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="container text-center mt-5">
    <h1 class="text-danger">Payment Canceled</h1>
    <p>Order ID: <?php echo htmlspecialchars($order_id); ?></p>
    <a href="index.php" class="btn btn-dark">Try Again</a>
</div>
</body>
</html>