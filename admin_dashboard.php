<?php
include 'db_connection.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        // Add Product
        if ($action === 'add') {
            $item_name = $_POST['item_name'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];
            $is_permanent = isset($_POST['is_permanent']) ? 1 : 0;

            // Handle file upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                
                $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
                $uploadFile = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $stmt = $conn->prepare("INSERT INTO products (name, price, quantity, image, is_permanent) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("sdiss", $item_name, $price, $quantity, $uploadFile, $is_permanent);
                    $stmt->execute();
                }
            }
        }

        // Delete Product
        elseif ($action === 'delete') {
            $item_id = $_POST['item_id'];
            $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
            $stmt->bind_param("i", $item_id);
            $stmt->execute();
        }
    }
    header("Location: Admin.php");
    exit();
}

// Fetch products
$stmt = $conn->prepare("SELECT * FROM products");
$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);
?>