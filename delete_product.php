<?php
session_start();
include('db_connection.php'); 

// Check if user is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Check if product_id is provided
if (!isset($_GET['id'])) {
    die("Error: Product ID is missing.");
}

$product_id = mysqli_real_escape_string($conn, $_GET['id']);

// Delete product query
$delete_query = "DELETE FROM products WHERE products_id = '$product_id'";

if (mysqli_query($conn, $delete_query)) {
    header("Location: products.php?msg=Product deleted successfully");
} else {
    die("Error deleting product: " . mysqli_error($conn));
}
?>
