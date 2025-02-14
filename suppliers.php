<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$message = "";

// Add Supplier
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_supplier'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $insert_query = "INSERT INTO suppliers (name, contact, email) VALUES ('$name', '$contact', '$email')";
    if (mysqli_query($conn, $insert_query)) {
        $message = "Supplier added successfully!";
    } else {
        $message = "Error adding supplier.";
    }
}

// Delete Supplier
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM suppliers WHERE supplier_id = '$delete_id'");
    header("Location: suppliers.php");
    exit();
}

// Fetch Suppliers
$suppliers = mysqli_query($conn, "SELECT * FROM suppliers ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Suppliers</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Manage Suppliers</h2>

<?php if (!empty($message)) { echo "<p style='color: green;'>$message</p>"; } ?>

<h3>Add New Supplier</h3>
<form method="POST">
    <label>Name:</label>
    <input type="text" name="name" required>

    <label>Contact:</label>
    <input type="text" name="contact" required>

    <label>Email:</label>
    <input type="email" name="email" required>

    <button type="submit" name="add_supplier">Add Supplier</button>
</form>

<h3>Supplier List</h3>
<table border="1">
    <tr>
        <th>Name</th>
        <th>Contact</th>
        <th>Email</th>
        <th>Action</th>
    </tr>
    <?php while ($supplier = mysqli_fetch_assoc($suppliers)) { ?>
    <tr>
        <td><?= htmlspecialchars($supplier['name']) ?></td>
        <td><?= htmlspecialchars($supplier['contact']) ?></td>
        <td><?= htmlspecialchars($supplier['email']) ?></td>
        <td>
            <a href="suppliers.php?delete_id=<?= $supplier['supplier_id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php } ?>
</table>

<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>
