<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Delete Customer
if (isset($_GET['delete'])) {
    $customer_id = (int) $_GET['delete'];
    mysqli_query($conn, "DELETE FROM users WHERE user_id = '$customer_id'");
    header("Location: customers.php");
    exit();
}

// Fetch Customers
$customers = mysqli_query($conn, "SELECT * FROM users WHERE role = 'customer' ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Customer Management</h2>

<table>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Registered Date</th>
        <th>Action</th>
    </tr>
    <?php while ($customer = mysqli_fetch_assoc($customers)) { ?>
    <tr>
        <td><?= htmlspecialchars($customer['name']) ?></td>
        <td><?= htmlspecialchars($customer['email']) ?></td>
        <td><?= $customer['created_at'] ?></td>
        <td>
            <a href="customers.php?delete=<?= $customer['user_id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php } ?>
</table>

<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>
