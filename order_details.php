<?php
session_start();
include('db_connection.php'); 

// 🔒 چیک کریں کہ یوزر ایڈمن ہے
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
//     header("Location: login.php");
//     exit();
// }

// 📌 چیک کریں کہ `order_id` گیٹ پیرامیٹر میں موجود ہے
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Order not found!";
    exit();
}

$order_id = intval($_GET['id']); // ✅ `intval()` سے محفوظ بنائیں

// 🔍 آرڈر کی تفصیلات حاصل کریں
$order_query = mysqli_query($conn, "SELECT orders.*, customers.name AS customer_name 
                                    FROM orders 
                                    JOIN customers ON orders.customer_id = customers.customer_id 
                                    WHERE orders.id = '$order_id'");

$order = mysqli_fetch_assoc($order_query);

if (!$order) {
    echo "Order not found!";
    exit();
}

// 🔍 آرڈر آئٹمز کی تفصیلات حاصل کریں (✅ صحیح QUERY)
$order_items_query = mysqli_query($conn, "SELECT products.name, order_items.quantity, order_items.price 
                                          FROM order_items 
                                          JOIN products ON order_items.products_id = products.products_id 
                                          WHERE order_items.id = '$order_id'");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            text-align: center;
            padding: 20px;
        }

        .container {
            width: 70%;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #008080;
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
    <h2>Order Details</h2>

    <p><strong>Order ID:</strong> <?= htmlspecialchars($order['id']) ?></p>
    <p><strong>Customer Name:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
    <p><strong>Total Price:</strong> $<?= number_format($order['total_price'], 2) ?></p>
    <p><strong>Status:</strong> <?= htmlspecialchars($order['status']) ?></p>
    <p><strong>Order Date:</strong> <?= htmlspecialchars($order['order_date']) ?></p>

    <h3>Ordered Products:</h3>
    <table>
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
        <?php while ($item = mysqli_fetch_assoc($order_items_query)) { ?>
        <tr>
            <td><?= htmlspecialchars($item['name']) ?></td>
            <td><?= $item['quantity'] ?></td>
            <td>$<?= number_format($item['price'], 2) ?></td>
        </tr>
        <?php } ?>
    </table>

    <a href="aorders.php" class="btn">Back to Orders</a>
</div>

</body>
</html>
