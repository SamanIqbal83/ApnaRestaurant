<?php
session_start();
include('db_connection.php'); 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// ✅ Debugging: Check if POST data is received
if (!isset($_POST['products_id']) || !isset($_POST['quantity'])) {
    die("Error: Product ID or quantity not set!"); 
}

// ✅ Sanitize input
$user_id = $_SESSION['user_id'];
$products_id = isset($_POST['products_id']) ? (int) $_POST['products_id'] : 0;
$quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 1;

if ($products_id <= 0 || $quantity <= 0) {
    die("Error: Invalid product ID or quantity!");
}

// ✅ Check if the product exists
$product_check = mysqli_query($conn, "SELECT * FROM products WHERE products_id = '$products_id'");
if (mysqli_num_rows($product_check) == 0) {
    die("Error: Product does not exist!");
}

// ✅ Check if the product is already in the cart
$check_cart = mysqli_query($conn, "SELECT * FROM cart WHERE customer_id = '$user_id' AND products_id = '$products_id'");

if (mysqli_num_rows($check_cart) > 0) {
    // ✅ Update quantity if already in cart
    $update_query = "UPDATE cart SET quantity = quantity + $quantity WHERE customer_id = '$user_id' AND products_id = '$products_id'";
    if (!mysqli_query($conn, $update_query)) {
        die("Error updating cart: " . mysqli_error($conn));
    }
} else {
    // ✅ Insert new item into cart
    $insert_query = "INSERT INTO cart (customer_id, products_id, quantity) VALUES ('$user_id', '$products_id', '$quantity')";
    if (!mysqli_query($conn, $insert_query)) {
        die("Error adding to cart: " . mysqli_error($conn));
    }
}

header("Location: cart.php"); // Redirect to cart page
exit();
?>
