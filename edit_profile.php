<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch customer details
$customer_query = mysqli_query($conn, "SELECT * FROM customers WHERE customer_id = '$user_id'");
$customer = mysqli_fetch_assoc($customer_query);

if (!$customer) {
    echo "Error: Customer not found!";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    
    // Handle password update only if entered
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $password_query = ", password='$password'";
    } else {
        $password_query = "";
    }

    // Update customer details
    $update_query = "UPDATE customers SET name='$name', email='$email', phone='$phone', address='$address' $password_query WHERE customer_id='$user_id'";

    if (mysqli_query($conn, $update_query)) {
        $success_message = "Profile updated successfully!";
    } else {
        $error_message = "Error updating profile: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Edit Profile</h2>

<?php if (isset($success_message)) { echo "<p class='success'>$success_message</p>"; } ?>
<?php if (isset($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>

<form method="POST">
    <label for="name">Full Name:</label>
    <input type="text" name="name" value="<?= htmlspecialchars($customer['name']) ?>" required>

    <label for="email">Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($customer['email']) ?>" required>

    <label for="phone">Phone:</label>
    <input type="text" name="phone" value="<?= htmlspecialchars($customer['phone'] ?? '') ?>">

    <label for="address">Address:</label>
    <textarea name="address"><?= htmlspecialchars($customer['address'] ?? '') ?></textarea>

    <label for="password">New Password (leave blank to keep current):</label>
    <input type="password" name="password">

    <button type="submit">Update Profile</button>
</form>

<a href="customer_dashboard.php"><button>Back to Dashboard</button></a>

</body>
</html>
