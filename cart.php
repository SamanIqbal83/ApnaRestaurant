<?php
session_start();
include('db_connection.php');

$user_id = $_SESSION['user_id'];

$cart_items = mysqli_query($conn, "SELECT cart.*, products.name, products.price 
                                   FROM cart 
                                   JOIN products ON cart.products_id = products.products_id 
                                   WHERE cart.customer_id = '$user_id'");

$total_price = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Your Cart</h2>

<table>
    <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total</th>
        <th>Action</th>
    </tr>
    <?php while ($item = mysqli_fetch_assoc($cart_items)) { 
        $item_total = $item['price'] * $item['quantity'];
        $total_price += $item_total;
    ?>
    <tr>
        <td><?= htmlspecialchars($item['name']) ?></td>
        <td>$<?= number_format($item['price'], 2) ?></td>
        <td>
            <form method="POST" action="update_cart.php">
                <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1">
                <button type="submit">Update</button>
            </form>
        </td>
        <td>$<?= number_format($item_total, 2) ?></td>
        <td>
            <a href="remove_from_cart.php?id=<?= $item['cart_id'] ?>">Remove</a>
        </td>
    </tr>
    <?php } ?>
</table>

<h3>Total Price: $<?= number_format($total_price, 2) ?></h3>

<a href="checkout.php"><button>Proceed to Checkout</button></a>

</body>
</html>
