<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = intval($_SESSION['user_id']); // ✅ محفوظ بنائیں

// ✅ آرڈرز حاصل کریں (SQL Injection سے بچاؤ)
$orders_query = mysqli_query($conn, "SELECT * FROM orders WHERE customer_id = '$user_id' ORDER BY order_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
            text-align: center;
        }

        .container {
            width: 80%;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #008080;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background: #008080;
            color: white;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        .btn {
            display: inline-block;
            background: #008080;
            color: white;
            padding: 10px 15px;
            margin-top: 10px;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn:hover {
            background: #006666;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>All Customer Orders</h2>

    <table>
        <tr>
            <th>Order ID</th>
            <th>Total Price</th>
            <th>Status</th>
            <th>Order Date</th>
            <th>Action</th>
        </tr>
        <?php 
        while ($order = mysqli_fetch_assoc($orders_query)) { 
        ?>
        <tr>
            <td>#<?= htmlspecialchars($order['id']) ?></td>
            <td>$<?= number_format($order['total_price'], 2) ?></td>
            <td><?= htmlspecialchars($order['status']) ?></td>
            <td><?= htmlspecialchars($order['order_date']) ?></td>
            <td>
                <a href="order_details.php?id=<?= htmlspecialchars($order['id']) ?>" class="btn">View Details</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <!-- <a href="dashboard.php" class="btn">Back to Dashboard</a> -->
    <a href="customer_dashboard.php" class="btn">Back to Dashboard</a>

</div>

</body>
</html>
