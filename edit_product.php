<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("Error: Product ID is missing!");
}

$product_id = $_GET['id'];
$product_query = mysqli_query($conn, "SELECT * FROM products WHERE products_id = '$product_id'");
$product = mysqli_fetch_assoc($product_query);

if (!$product) {
    die("Error: Product not found!");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $price = (float)$_POST['price'];
    $stock = (int)$_POST['stock'];

    $update_query = "UPDATE products SET name='$name', category_id='$category', price='$price', stock='$stock' WHERE products_id='$product_id'";

    if (mysqli_query($conn, $update_query)) {
        header("Location: products.php?message=Product updated successfully");
        exit();
    } else {
        $error = "Failed to update product: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Edit Product</h2>
    <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
    <form method="POST">
        <label>Product Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
        
        <label>Category:</label>
        <input type="text" name="category" value="<?= htmlspecialchars($product['category_id']) ?>" required>
        
        <label>Price:</label>
        <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required>
        
        <label>Stock:</label>
        <input type="number" name="stock" value="<?= $product['stock'] ?>" required>
        
        <button type="submit">Update Product</button>
    </form>
    <a href="products.php">Back to Products</a>
</body>
</html>
