<?php
session_start();
include('db_connection.php');

if (!isset($_GET['id'])) {
    header("Location: shop.php");
    exit();
}

$order_id = $_GET['id'];
$order_query = mysqli_query($conn, "SELECT * FROM orders WHERE id = '$order_id' AND customer_id = '" . $_SESSION['user_id'] . "'");

if (mysqli_num_rows($order_query) == 0) {
    echo "Order not found!";
    exit();
}

$order = mysqli_fetch_assoc($order_query);
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

<h2>Order Confirmation</h2>
<p>Thank you for your order! Your order ID is <strong>#<?= $order['id'] ?></strong>.</p>
<p><strong>Total Price:</strong> $<?= number_format($order['total_price'], 2) ?></p>
<p><strong>Payment Method:</strong> <?= htmlspecialchars($order['payment_method']) ?></p>
<p><strong>Shipping Address:</strong> <?= htmlspecialchars($order['shipping_address']) ?></p>

<a href="orders.php"><button>View My Orders</button></a>

</body>
</html>
