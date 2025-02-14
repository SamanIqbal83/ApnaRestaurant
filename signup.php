<?php
session_start();
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

    // Check if email already exists
    $check_email = mysqli_query($conn, "SELECT * FROM customers WHERE email='$email'");
    if (mysqli_num_rows($check_email) > 0) {
        echo "Error: Email already exists!";
        exit();
    }

    // Insert into database
    $query = "INSERT INTO customers (name, email, phone, address, password) 
              VALUES ('$name', '$email', '$phone', '$address', '$password')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Customer Signup</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Customer Signup</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone" placeholder="Phone (Optional)">
        <input type="password" name="password" placeholder="Password" required>
        <input name="address" placeholder="Address (Optional)">
        <button type="submit">Signup</button>
    </form>
    <p>Already have an account? <a href="login.php">Login</a></p>
</body>
</html>
