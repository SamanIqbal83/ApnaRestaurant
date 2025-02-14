<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit();
}

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

if ($order_id == 0) {
    header("Location: index.php"); // Redirect if no order ID is provided
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2>✅ Order Placed Successfully!</h2>
    <p>Thank you for your purchase! Your order number is <strong>#<?= htmlspecialchars($order_id) ?></strong>.</p>
    
    <p>You will receive a confirmation email with your order details shortly.</p>

    <a href="orders.php"><button>View My Orders</button></a>
    <a href="index.php"><button>Go to Home</button></a>

</body>
</html>
