<?php
session_start();
include('db_connection.php'); 

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch User Details
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$user_id'"));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];

    mysqli_query($conn, "UPDATE users SET name='$name', email='$email' WHERE user_id='$user_id'");
    header("Location: profile.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>My Profile</h2>

<form method="POST">
    <label>Name:</label>
    <input type="text" name="name" value="<?= $user['name'] ?>" required>

    <label>Email:</label>
    <input type="email" name="email" value="<?= $user['email'] ?>" required>

    <button type="submit">Update Profile</button>
</form>

</body>
</html>
