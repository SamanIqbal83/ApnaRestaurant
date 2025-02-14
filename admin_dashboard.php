<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch Total Users
$totalUsers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM users"))['count'];

// Fetch Total Orders
$totalOrders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM orders"))['count'];

// Fetch Total Revenue
$totalRevenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_price) AS revenue FROM orders WHERE status IN ('shipped', 'delivered')"))['revenue'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            text-align: center;
        }
        h1 {
            background: #333;
            color: white;
            padding: 15px;
            margin: 0;
        }
        nav ul {
            list-style: none;
            padding: 0;
            background: #444;
            margin: 0;
            display: flex;
            justify-content: center;
        }
        nav ul li {
            padding: 15px;
        }
        nav ul li a {
            text-decoration: none;
            color: white;
            font-weight: bold;
        }
        nav ul li a:hover {
            text-decoration: underline;
        }
        .container {
            margin: 20px;
            padding: 20px;
        }
        .dashboard {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 250px;
            text-align: center;
            transition: transform 0.3s ease-in-out;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .logout {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: red;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s ease;
        }
        .logout:hover {
            background: darkred;
        }
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <nav>
        <ul>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="manage_products.php">Manage Products</a></li>
            <li><a href="manage_orders.php">Manage Orders</a></li>
            <li><a href="sales_reports.php">View Reports</a></li>
            <li><a href="messages.php">Customer Messages</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <div class="container">
        <h2>📊 Dashboard Overview</h2>
        <div class="dashboard">
            <div class="card">
                <h2>Total Users</h2>
                <p><?= $totalUsers ?></p>
            </div>
            <div class="card">
                <h2>Total Orders</h2>
                <p><?= $totalOrders ?></p>
            </div>
            <div class="card">
                <h2>Total Revenue</h2>
                <p>$<?= number_format($totalRevenue, 2) ?></p>
            </div>
        </div>
        <a href="logout.php" class="logout">Logout</a>
    </div>
</body>
</html>