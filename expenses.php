<?php
session_start();
include('db_connection.php'); 

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Add Expense
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $amount = (float) $_POST['amount'];

    mysqli_query($conn, "INSERT INTO expenses (description, amount, user_id) VALUES ('$description', '$amount', '{$_SESSION['user_id']}')");
}

// Fetch Expenses
$expenses = mysqli_query($conn, "SELECT * FROM expenses ORDER BY date_added DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenses</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Manage Expenses</h2>

<form method="POST">
    <label>Description:</label>
    <input type="text" name="description" required>

    <label>Amount ($):</label>
    <input type="number" step="0.01" name="amount" required>

    <button type="submit">Add Expense</button>
</form>

<h3>Expense List</h3>
<table>
    <tr>
        <th>Description</th>
        <th>Amount ($)</th>
        <th>Date</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($expenses)) { ?>
    <tr>
        <td><?= htmlspecialchars($row['description']) ?></td>
        <td>$<?= number_format($row['amount'], 2) ?></td>
        <td><?= $row['date_added'] ?></td>
    </tr>
    <?php } ?>
</table>

<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>
