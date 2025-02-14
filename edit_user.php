<?php
session_start();
include('db_connection.php'); 

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("User ID missing!");
}

$user_id = $_GET['id'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM customers WHERE customer_id = '$user_id'"));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    mysqli_query($conn, "UPDATE customers SET name = '$name', email = '$email' WHERE customer_id = '$user_id'");

    header("Location: users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Edit User</h2>

<form method="POST">
    <label>Name:</label>
    <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>

    <label>Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

    <label>Role:</label>
    <input value="customer">
    <!-- <select name="role"> -->
        <!-- <option value="customer" <?= $user['role'] == 'customer' ? 'selected' : '' ?>>Customer</option> -->
        <!-- <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option> -->
    <!-- </select> -->

    <button type="submit">Update</button>
</form>

<a href="users.php">Back to Users</a>

</body>
</html>
