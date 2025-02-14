<?php
session_start();
include('db_connection.php'); 

// Check if the user is an admin or manager
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Handle product addition
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);

    $query = "INSERT INTO products (name, category_id, price, stock) VALUES ('$name', '$category', '$price', '$stock')";
    if (mysqli_query($conn, $query)) {
        $message = "Product added successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

// Fetch products
$products = mysqli_query($conn, "SELECT * FROM products");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Products Management</h2>

    <?php if (isset($message)) echo "<p style='color: green;'>$message</p>"; ?>

    <h3>Add New Product</h3>
    <form method="POST">
        <input type="text" name="name" placeholder="Product Name" required>
        <input type="text" name="category" placeholder="Category" required>
        <input type="number" step="0.01" name="price" placeholder="Price" required>
        <input type="number" name="stock" placeholder="Stock Quantity" required>
        <button type="submit" name="add_product">Add Product</button>
    </form>

    <h3>Product List</h3>
    <table>
        <tr>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Actions</th>
        </tr>
        <?php while ($product = mysqli_fetch_assoc($products)) { ?>
            <tr>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= htmlspecialchars($product['category_id']) ?></td>
                <td>$<?= number_format($product['price'], 2) ?></td>
                <td><?= $product['stock'] ?></td>
                <td>
                    <a href="edit_product.php?id=<?= $product['products_id'] ?>">Edit</a> |
                    <a href="delete_product.php?id=<?= $product['products_id'] ?>" class="btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
