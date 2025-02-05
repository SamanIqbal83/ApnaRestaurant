<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "business_dashboard";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);

    if (empty($user) || empty($pass)) {
        echo json_encode(['success' => false, 'message' => 'Please fill all fields.']);
        exit;
    }

    // Prepared statement to protect against SQL injection
    $stmt = $conn->prepare("SELECT role FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($role);
        $stmt->fetch();

        // Return role-based response
        echo json_encode(['success' => true, 'role' => $role]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid credentials.']);
    }

    $stmt->close();
}

$conn->close();
?>
