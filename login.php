<?php
session_start();
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Check in customers table
    $query = mysqli_query($conn, "SELECT * FROM customers WHERE email='$email'");
    $customer = mysqli_fetch_assoc($query);

    if ($customer && password_verify($password, $customer['password'])) {
        $_SESSION['user_id'] = $customer['customer_id'];
        $_SESSION['role'] = 'customer';
        $_SESSION['name'] = $customer['name'];
        header("Location: customer_dashboard.php");
        exit();
    }

    // Check in users table (for admin/staff)
    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $user = mysqli_fetch_assoc($query);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['name'] = $user['username'];

        if ($user['role'] == 'admin') {
            header("Location: dashboard.php");
        } else {
            header("Location: staff_dashboard.php");
        }
        exit();
    }

    echo "Invalid email or password!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Login</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="signup.php">Signup</a></p>
</body>
</html>
