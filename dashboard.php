<?php
session_start();
include('db_connection.php'); 

// Check if user is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch statistics
$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM customers"))['count'];
$total_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM orders"))['count'];
$total_sales = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_price) AS sum FROM orders WHERE status = 'delivered'"))['sum'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
    <style>
        /* 🌟 بنیادی اسٹائل */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #f4f4f4;
            text-align: center;
            color: #333;
            padding: 20px;
        }

        /* 🌟 ہیڈر */
        header {
            background: #6A0DAD;
            color: white;
            padding: 15px;
            font-size: 24px;
            font-weight: bold;
        }

        /* 🌟 مین کنٹینر */
        .container {
            width: 80%;
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        /* 🌟 سٹیٹس باکس */
        .stats {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-top: 20px;
        }

        .box {
            flex: 1;
            background: #8A2BE2;
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
        }

        .box h3 {
            margin-bottom: 10px;
            font-size: 18px;
        }

        .box p {
            font-size: 22px;
            font-weight: bold;
        }

        /* 🌟 ڈیش بورڈ کے لنکس */
        .dashboard-links {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .dashboard-card {
            flex: 1;
            background: #6A0DAD;
            color: white;
            padding: 15px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 18px;
            text-align: center;
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            margin: 5px;
        }

        .dashboard-card:hover {
            background: #4B0082;
        }

        /* 🌟 لاگ آؤٹ بٹن */
        .logout-section {
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            background: red;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            transition: 0.3s;
        }

        .btn:hover {
            background: darkred;
        }

        /* 🌟 فوٹر */
        footer {
            margin-top: 20px;
            padding: 10px;
            background: #333;
            color: white;
        }
    </style>

</head>
<body>

<header>
    <h1>Admin Dashboard</h1>
</header>

<div class="container">
    <div class="stats">
        <div class="box">
            <h3>Total Users</h3>
            <p><?= $total_users ?></p>
        </div>
        <div class="box">
            <h3>Total Orders</h3>
            <p><?= $total_orders ?></p>
        </div>
        <div class="box">
            <h3>Total Sales</h3>
            <p>$<?= number_format($total_sales, 2) ?></p>
        </div>
    </div>

    <h3>Quick Links</h3>
    <div class="dashboard-links">
        <a href="users.php" class="dashboard-card">Manage Users</a>
        <a href="orders.php" class="dashboard-card">View Orders</a>
        <a href="products.php" class="dashboard-card">Manage Products</a>
    </div>

    <div class="logout-section">
        <a href="logout.php" class="btn">Logout</a>
    </div>
</div>

<footer>
    <p>&copy; <?= date("Y") ?> Admin Dashboard. All rights reserved.</p>
</footer>

</body>
</html>
