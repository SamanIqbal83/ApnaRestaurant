<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Add Product
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    mysqli_query($conn, "INSERT INTO products (name, price, stock) VALUES ('$name', '$price', '$stock')");
}

// Delete Product
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE products_id = $id");
    header("Location: manage_products.php");
}

// Fetch Products
$products = mysqli_query($conn, "SELECT * FROM products");
?>

<h2>Manage Products</h2>
<form method="POST">
    <input type="text" name="name" placeholder="Product Name" required>
    <input type="number" name="price" placeholder="Price" required>
    <input type="number" name="stock" placeholder="Stock Quantity" required>
    <button type="submit">Add Product</button>
</form>

<table border="1">
    <tr><th>ID</th><th>Name</th><th>Price</th><th>Stock</th><th>Action</th></tr>
    <?php while ($product = mysqli_fetch_assoc($products)) : ?>
    <tr>
        <td><?= $product['products_id'] ?></td>
        <td><?= $product['name'] ?></td>
        <td>$<?= $product['price'] ?></td>
        <td><?= $product['stock'] ?></td>
        <td><a href="?delete=<?= $product['products_id'] ?>">Delete</a></td>
    </tr>
    <?php endwhile; ?>
</table>
<a href="admin_dashboard.php">Back to Dashboard</a>
