<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Update stock
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_stock'])) {
    $product_id = (int) $_POST['product_id'];
    $new_stock = (int) $_POST['stock'];

    mysqli_query($conn, "UPDATE products SET stock = '$new_stock' WHERE products_id = '$product_id'");
}

// Fetch products
$products = mysqli_query($conn, "SELECT * FROM products ORDER BY name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Inventory Management</h2>

<table>
    <tr>
        <th>Product Name</th>
        <th>Category</th>
        <th>Stock</th>
        <th>Update Stock</th>
    </tr>
    <?php while ($product = mysqli_fetch_assoc($products)) { ?>
    <tr>
        <td><?= htmlspecialchars($product['name']) ?></td>
        <td><?= htmlspecialchars($product['category']) ?></td>
        <td><?= $product['stock'] ?></td>
        <td>
            <form method="POST">
                <input type="hidden" name="product_id" value="<?= $product['products_id'] ?>">
                <input type="number" name="stock" value="<?= $product['stock'] ?>" min="0">
                <button type="submit" name="update_stock">Update</button>
            </form>
        </td>
    </tr>
    <?php } ?>
</table>

<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>
