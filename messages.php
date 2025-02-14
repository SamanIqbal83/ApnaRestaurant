<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch Messages
$messages = mysqli_query($conn, "SELECT messages.*, users.name FROM messages JOIN users ON messages.user_id = users.user_id");
?>

<h2>Customer Messages</h2>
<table border="1">
    <tr><th>ID</th><th>Customer</th><th>Message</th></tr>
    <?php while ($msg = mysqli_fetch_assoc($messages)) : ?>
    <tr>
        <td><?= $msg['id'] ?></td>
        <td><?= $msg['name'] ?></td>
        <td><?= $msg['message'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>
<a href="admin_dashboard.php">Back to Dashboard</a>
