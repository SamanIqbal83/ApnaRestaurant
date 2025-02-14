<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$cart_id = $_POST['cart_id'];
$quantity = $_POST['quantity'];

mysqli_query($conn, "UPDATE cart SET quantity = '$quantity' WHERE cart_id = '$cart_id'");

header("Location: cart.php");
exit();
