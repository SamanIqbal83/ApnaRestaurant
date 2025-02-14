<?php
session_start();
include('db_connection.php');

$user_id = $_SESSION['user_id'];

$cart_items = mysqli_query($conn, "SELECT cart.*, products.name, products.price 
                                   FROM cart 
                                   JOIN products ON cart.products_id = products.products_id 
                                   WHERE cart.customer_id = '$user_id'");

$total_price = 0;

while ($item = mysqli_fetch_assoc($cart_items)) {
    $total_price += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Checkout</h2>

<form method="POST" action="place_order.php">
    <h3>Order Summary</h3>
    <p>Total Price: <strong>$<?= number_format($total_price, 2) ?></strong></p>

    <h3>Shipping Address</h3>
    <textarea name="shipping_address" required></textarea>

    <h3>Payment Method</h3>
    <label>
        <input type="radio" name="payment_method" value="COD" required> Cash on Delivery
    </label>
    <label>
        <input type="radio" name="payment_method" value="Credit Card"> Credit Card
    </label>

    <button type="submit">Place Order</button>
</form>

</body>
</html>
