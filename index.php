<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Small Business Dashboard</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
        text-align: center;
    }
    header {
        background-color: #4B0082;
        color: white;
        padding: 15px;
    }
    nav ul {
        list-style: none;
        padding: 0;
    }
    nav ul li {
        display: inline;
        margin: 0 15px;
    }
    nav ul li a {
        color: white;
        text-decoration: none;
        font-size: 16px;
    }
    .welcome {
        padding: 30px;
        background-color: #eee;
    }
    .dashboards {
        padding: 20px;
    }
    .dashboard-links {
        display: flex;
        justify-content: center;
        gap: 15px;
    }
    .dashboard-card {
        display: block;
        width: 200px;
        padding: 15px;
        background-color: #6A0DAD;
        color: white;
        text-decoration: none;
        font-size: 18px;
        border-radius: 10px;
        transition: 0.3s;
    }
    .dashboard-card:hover {
        background-color: #8A2BE2;
    }
    footer {
        /* margin: 0 auto; */
        background-color: #4B0082;
        color: white;
        padding: 10px 0px;
        position: absolute;
        bottom: 0;
        width: 100%;
    }
</style>
</head>
<body>

<!-- Navigation Bar -->
<header>
    <h1>Small Business Dashboard</h1>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="signup.php">Register</a></li>
            <?php else: ?>
                <!-- <li><a href="logout.php">Logout</a></li> -->
            <?php endif; ?>
        </ul>
    </nav>
</header>

<!-- Welcome Section -->
<section class="welcome">
    <h2>Welcome to Our Business Management System</h2>
    <p>Manage your business efficiently with our easy-to-use dashboard.</p>
</section>

<!-- Dashboard Options -->
<section class="dashboards">
    <h2>Select Your Dashboard</h2>
    <div class="dashboard-links">
        <a href="
            <?php 
                if (!isset($_SESSION['user_id'])) { 
                    echo 'login.php'; 
                } elseif ($_SESSION['role'] !== 'admin') { 
                    echo 'login.php'; 
                } else { 
                    echo 'dashboard.php'; 
                } 
            ?>" 
            class="dashboard-card">
            Admin Dashboard
        </a>

        <a href="
            <?php 
                if (!isset($_SESSION['user_id'])) { 
                    echo 'login.php'; 
                } elseif ($_SESSION['role'] !== 'customer') { 
                    echo 'login.php'; 
                } else { 
                    echo 'customer_dashboard.php'; 
                } 
            ?>" 
            class="dashboard-card">
            Customer Dashboard
        </a>
    </div>
</section>

<!-- Footer -->
<footer>
    <p>&copy; <?php echo date("Y"); ?> Small Business Dashboard. All rights reserved.</p>
</footer>

</body>
</html>
