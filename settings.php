<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$admin_id = $_SESSION['user_id'];
$message = "";

// Fetch Admin Info
$result = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$admin_id'");
$admin = mysqli_fetch_assoc($result);

// Update Admin Details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $business_name = mysqli_real_escape_string($conn, $_POST['business_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $update_query = "UPDATE users SET name = '$business_name', email = '$email', password = '$password' WHERE user_id = '$admin_id'";
    } else {
        $update_query = "UPDATE users SET name = '$business_name', email = '$email' WHERE user_id = '$admin_id'";
    }

    if (mysqli_query($conn, $update_query)) {
        $message = "Settings updated successfully!";
    } else {
        $message = "Error updating settings.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Settings</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Admin Settings</h2>

<?php if (!empty($message)) { echo "<p style='color: green;'>$message</p>"; } ?>

<form method="POST">
    <label>Business Name:</label>
    <input type="text" name="business_name" value="<?= htmlspecialchars($admin['name']) ?>" required>

    <label>Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($admin['email']) ?>" required>

    <label>New Password (optional):</label>
    <input type="password" name="password">

    <button type="submit">Update Settings</button>
</form>

<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>
