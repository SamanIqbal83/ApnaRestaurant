<?php
session_start();
include('db_connection.php'); 

// Check if user is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch all users
$users = mysqli_query($conn, "SELECT * FROM customers");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Users Management</h2>

    <table>
        <tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone No</th>
            <th>Address</th>
            <th>Actions</th>
        </tr>
        <?php while ($user = mysqli_fetch_assoc($users)) { ?>
        <tr>
            <td><?= $user['customer_id'] ?></td>
            <td><?= htmlspecialchars($user['name']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars($user['phone']) ?></td>
            <td><?= htmlspecialchars($user['address']) ?></td>
            <td>
                <a href="edit_user.php?id=<?= $user['customer_id'] ?>">Edit</a> | 
                <a href="delete_user.php?id=<?= $user['customer_id'] ?>" class="btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <a href="dashboard.php" class="btn">Back to Dashboard</a>
</div>

</body>
</html>
