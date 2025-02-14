<?php
session_start();
include('db_connection.php'); 

// Check if user is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Check if user ID is provided
if (!isset($_GET['id'])) {
    die("Error: User ID not provided!");
}

$user_id = $_GET['id'];

// Prevent admin from deleting themselves
if ($user_id == $_SESSION['user_id']) {
    die("Error: You cannot delete your own account!");
}
// Pehle order_items delete karen
$order_items_delete_query = "DELETE FROM order_items WHERE id IN (SELECT id FROM orders WHERE customer_id='$user_id')";
mysqli_query($conn, $order_items_delete_query);

// Phir orders delete karen
$order_delete_query = "DELETE FROM orders WHERE customer_id='$user_id'";
mysqli_query($conn, $order_delete_query);

// Phir customer delete karen
$delete_query = "DELETE FROM customers WHERE customer_id='$user_id'";
if (mysqli_query($conn, $delete_query)) {
    header("Location: users.php");
    exit();
} else {
    die("Error deleting user: " . mysqli_error($conn));
}

?>
