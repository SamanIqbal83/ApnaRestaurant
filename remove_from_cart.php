<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$cart_id = $_GET['id'];
mysqli_query($conn, "DELETE FROM cart WHERE cart_id = '$cart_id'");

header("Location: cart.php");
exit();
