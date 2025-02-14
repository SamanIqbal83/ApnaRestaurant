<?php
session_start();
include('db_connection.php');

$products = mysqli_query($conn, "SELECT * FROM products WHERE stock > 0");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Shop Products</h2>
<table>
    <tr>
        <th>Name</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Action</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($products)) { ?>
    <tr>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td>$<?= number_format($row['price'], 2) ?></td>
        <td><?= $row['stock'] ?></td>
        <td>
            <form action="add_to_cart.php" method="POST">
                <input type="hidden" name="products_id" value="<?= $row['products_id'] ?>">
                <input type="number" name="quantity" value="1" min="1" max="<?= $row['stock'] ?>">
                <button type="submit">Add to Cart</button>
            </form>
        </td>
    </tr>
    <?php } ?>
</table>

<a href="cart.php">Go to Cart</a>

</body>
</html>
