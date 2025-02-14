<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch customer details from `customers` table
$customer_query = mysqli_query($conn, "SELECT * FROM customers WHERE customer_id = '$user_id'");
$customer = mysqli_fetch_assoc($customer_query);

if (!$customer) {
    echo "Error: Customer not found!";
    exit();
}

// Fetch recent orders
$orders_query = mysqli_query($conn, "SELECT * FROM orders WHERE customer_id = '$user_id' ORDER BY order_date DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>

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
            background: #008080;
            color: white;
            padding: 15px;
            font-size: 22px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 40px;
        }

        .logout-button {
            background: red;
            color: white;
            padding: 8px 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .logout-button:hover {
            background: darkred;
        }

        /* 🌟 مین ڈیش بورڈ */
        .dashboard-container {
            width: 80%;
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        /* 🌟 پروفائل سیکشن */
        .profile-section {
            background: #20B2AA;
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .profile-section button {
            background: #006666;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .profile-section button:hover {
            background: #004C4C;
        }

        /* 🌟 آرڈرز سیکشن */
        .orders-section {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
            font-size: 14px;
        }

        th {
            background: #008080;
            color: white;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        /* 🌟 بٹن اسٹائل */
        button {
            background: #008080;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        button:hover {
            background: #006666;
        }

        /* 🌟 شاپنگ سیکشن */
        .shopping-section {
            background: #20B2AA;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<header>
    <h2>Welcome, <?= htmlspecialchars($customer['name']) ?>!</h2>
    <a href="logout.php"><button class="logout-button">Logout</button></a>
</header>

<div class="dashboard-container">
    <div class="profile-section">
        <h3>Your Profile</h3>
        <p><strong>Name:</strong> <?= htmlspecialchars($customer['name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($customer['email']) ?></p>
        <p><strong>Address:</strong> <?= htmlspecialchars($customer['address'] ?? 'Not provided') ?></p>
        <a href="edit_profile.php"><button>Edit Profile</button></a>
    </div>

    <div class="orders-section">
        <h3>Recent Orders</h3>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($orders_query)) { ?>
            <tr>
                <td>#<?= $row['id'] ?></td>
                <td>$<?= number_format($row['total_price'], 2) ?></td>
                <td><?= htmlspecialchars($row['status']) ?></td>
                <td><?= $row['order_date'] ?></td>
            </tr>
            <?php } ?>
        </table>
        <a href="aorders.php"><button>View All Orders</button></a>
    </div>

    <div class="shopping-section">
        <h3>Quick Links</h3>
        <a href="shop.php"><button>Shop Now</button></a>
        <a href="cart.php"><button>View Cart</button></a>
    </div>
</div>

</body>
</html>
