<?php
include 'db_connection.php';

// Handle purchase
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['buy_product'])) {
    $productId = $_POST['product_id'];
    $stmt = $conn->prepare("UPDATE products SET quantity = quantity - 1 WHERE id = ? AND quantity > 0");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
}

// Get products
$stmt = $conn->prepare("SELECT * FROM products WHERE quantity > 0");
$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);
?>