<?php
session_start();
include('db_connection.php'); 

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$order_id = $_GET['id']; // Get the order ID from the URL

// Check if the order exists for the user
$order_check = mysqli_query($conn, "SELECT * FROM orders WHERE order_id = '$order_id' AND customer_id = '$user_id'");
if (mysqli_num_rows($order_check) == 0) {
    header("Location: cart.php"); // Redirect if order doesn't exist
    exit();
}

// Handle Payment Method Selection
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_method = $_POST['payment_method'];

    if ($payment_method == 'cod') {
        // Handle Cash on Delivery (COD) Payment Logic
        mysqli_query($conn, "UPDATE orders SET payment_method = 'Cash on Delivery', status = 'pending' WHERE order_id = '$order_id'");
        header("Location: order_confirmation.php?id=$order_id");
        exit();
    } elseif ($payment_method == 'jazzcash') {
        // Handle JazzCash Payment Logic
        mysqli_query($conn, "UPDATE orders SET payment_method = 'JazzCash', status = 'pending' WHERE order_id = '$order_id'");
        // You can integrate JazzCash API here if needed
        header("Location: order_confirmation.php?id=$order_id");
        exit();
    } else {
        $error = "Please select a valid payment method!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Method</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Select Payment Method</h2>

<?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>

<form method="POST">
    <label>
        <input type="radio" name="payment_method" value="cod" required>
        Cash on Delivery
    </label><br><br>
    <label>
        <input type="radio" name="payment_method" value="jazzcash">
        JazzCash
    </label><br><br>

    <button type="submit">Proceed to Confirmation</button>
</form>

</body>
</html>
