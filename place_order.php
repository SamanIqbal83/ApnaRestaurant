<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items
$cart_query = mysqli_query($conn, "SELECT c.*, p.products_id, p.name, p.price, p.stock 
                                   FROM cart c 
                                   JOIN products p ON c.products_id = p.products_id 
                                   WHERE c.customer_id = '$user_id'");

if (mysqli_num_rows($cart_query) == 0) {
    echo "Your cart is empty!";
    exit();
}

// Calculate total price and check stock
$total_price = 0;
$cart_items = [];

while ($cart_item = mysqli_fetch_assoc($cart_query)) {
    $cart_items[] = $cart_item;
    $total_price += $cart_item['price'] * $cart_item['quantity'];

    // Check stock availability
    if ($cart_item['quantity'] > $cart_item['stock']) {
        echo "Error: Not enough stock for " . htmlspecialchars($cart_item['name']);
        exit();
    }
}

// Handle order placement
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // $payment_method = $_POST['payment_method'];

    // Insert into orders (DO NOT insert products_id here)
    $order_query = "INSERT INTO orders (customer_id, total_price, status, order_date) 
                    VALUES ('$user_id', '$total_price', 'Pending', NOW())";

    if (mysqli_query($conn, $order_query)) {
        $order_id = mysqli_insert_id($conn); // Get the new order ID

        // Insert each cart item into order_items
        foreach ($cart_items as $cart_item) {
            $product_id = $cart_item['products_id'];
            $quantity = $cart_item['quantity'];
            $price = $cart_item['price'];

            // Insert into order_items (NOT orders)
            mysqli_query($conn, "INSERT INTO order_items (id, products_id, quantity, price) 
                                 VALUES ('$order_id', '$product_id', '$quantity', '$price')");

            // Reduce stock in `products`
            mysqli_query($conn, "UPDATE products SET stock = stock - $quantity WHERE products_id = '$product_id'");
        }

        // Clear the customer's cart
        mysqli_query($conn, "DELETE FROM cart WHERE customer_id = '$user_id'");

        // Redirect to order confirmation
        header("Location: order_confirmation.php?order_id=" . $order_id);
        exit();
    } else {
        echo "Error placing order: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Place Your Order</h2>

<form method="POST">
    <label><strong>Payment Method:</strong></label><br>
    <input type="radio" name="payment_method" value="COD" required> Cash on Delivery (COD)<br>
    <input type="radio" name="payment_method" value="Credit Card"> Credit Card<br><br>

    <p><strong>Total Price: </strong>$<?= number_format($total_price, 2) ?></p>

    <button type="submit">Confirm Order</button>
</form>

<a href="cart.php"><button>Back to Cart</button></a>

</body>
</html>
