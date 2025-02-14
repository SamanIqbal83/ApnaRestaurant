<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Update Order Status
if (isset($_GET['complete'])) {
    $order_id = $_GET['complete'];
    mysqli_query($conn, "UPDATE orders SET status='Completed' WHERE id=$order_id");
}

// Fetch Orders
$orders = mysqli_query($conn, "SELECT orders.*, users.name, products.name AS product 
                               FROM orders
                               JOIN users ON orders.customer_id = users.user_id
                               JOIN products ON orders.products_id = products.products_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 0;
            padding: 20px;
        }
        h2 {
            color: #333;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #333;
            color: white;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        a {
            text-decoration: none;
            color: white;
            background: green;
            padding: 8px 12px;
            border-radius: 5px;
        }
        a:hover {
            background: darkgreen;
        }
        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #555;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-button:hover {
            background: #333;
        }
    </style>
</head>
<body>
    <h2>Manage Orders</h2>
    <table>
        <tr><th>ID</th><th>Customer</th><th>Product</th><th>Status</th><th>Action</th></tr>
        <?php while ($order = mysqli_fetch_assoc($orders)) : ?>
        <tr>
            <td><?= $order['id'] ?></td>
            <td><?= $order['name'] ?></td>
            <td><?= $order['product'] ?></td>
            <td><?= $order['status'] ?></td>
            <td><a href="?complete=<?= $order['id'] ?>">Mark as Completed</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="admin_dashboard.php" class="back-button">Back to Dashboard</a>
</body>
</html>

