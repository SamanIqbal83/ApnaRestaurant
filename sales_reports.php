<?php
session_start();
include('db_connection.php'); 

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Get total sales
$total_sales = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_price) AS sum FROM orders WHERE status = 'delivered'"))['sum'];

// Get top-selling products
$top_products = mysqli_query($conn, "SELECT p.name, SUM(o.quantity) AS total_sold 
                                      FROM order_items o 
                                      JOIN products p ON o.products_id = p.products_id 
                                      GROUP BY o.products_id 
                                      ORDER BY total_sold DESC LIMIT 5");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Sales Report</h2>

<h3>Total Revenue: $<?= number_format($total_sales, 2) ?></h3>

<h3>Top Selling Products</h3>
<table>
    <tr>
        <th>Product Name</th>
        <th>Quantity Sold</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($top_products)) { ?>
    <tr>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= $row['total_sold'] ?></td>
    </tr>
    <?php } ?>
</table>

<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>
