<?php
session_start();
include('db_connection.php'); 

// Check if user is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch all users
$users = mysqli_query($conn, "SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>User Management</h2>

<table border="1">
    <tr>
        <th>User ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>Action</th>
    </tr>
    <?php while ($user = mysqli_fetch_assoc($users)) { ?>
    <tr>
        <td><?= htmlspecialchars($user['user_id']) ?></td>
        <td><?= htmlspecialchars($user['username']) ?></td>
        <td><?= htmlspecialchars($user['email']) ?></td>
        <td><?= htmlspecialchars($user['role']) ?></td>
        <td>
            <a href="edit_user.php?id=<?= $user['user_id'] ?>">Edit</a> |
            <a href="delete_user.php?id=<?= $user['user_id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php } ?>
</table>

<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>
