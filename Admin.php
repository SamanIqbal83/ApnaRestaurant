<?php
include 'db_connection.php';

// Fetch inventory from the database
$stmt = $conn->prepare("SELECT * FROM inventory");
$stmt->execute();
$result = $stmt->get_result();
$inventory = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="Admin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="background-effects">
        <div class="glow-circle"></div>
        <div class="glow-circle"></div>
        <div class="glow-circle"></div>
    </div>

    <div class="admin-dashboard-container">
        <h2 class="glow-text">Apna Restaurant Dashboard</h2>

        <!-- Business Info Introduction (Top) -->
        <div class="business-info-top fade-in">
            <h3>Welcome to Iqra & Saman's Business</h3>
            <p>Welcome to the official admin dashboard for <strong>Iqra & Saman's Business</strong>, a growing enterprise committed to providing exceptional products and services. As the founders, Iqra and Saman are dedicated to ensuring a seamless customer experience and a highly efficient business model.</p>
            <p>Our goal is to deliver value while maintaining high standards in quality and service. We strive for excellence in all aspects of the business.</p>
        </div>

        <!-- Revenue Section -->
        <div class="dashboard-section slide-in">
            <h3 class="section-title">Revenue Overview</h3>
            <div class="revenue-stats">
                <p><strong>Total Revenue: </strong>$<span id="totalRevenue" class="highlight-text">0</span></p>
            </div>

            <!-- Revenue Chart -->
            <div class="revenue-chart-container glass-effect">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Manage Inventory Section -->
        <div class="dashboard-section slide-in-delayed">
            <h3 class="section-title">Manage Inventory</h3>
            <div class="inventory-management glass-effect">
                <!-- Add Inventory Form -->
                <form action="admin_dashboard.php" method="POST" id="inventoryForm" class="animated-form" enctype="multipart/form-data">
                    <input type="text" id="itemName" name="item_name" placeholder="Item Name" required>
                    <input type="number" id="itemPrice" name="price" placeholder="Item Price" required step="0.01">
                    <input type="number" id="itemQuantity" name="quantity" placeholder="Item Quantity" required>
                    <input type="file" id="itemImage" name="image" accept="image/*" required> 
                    <button type="submit" name="action" value="add" class="glow-button">Add Inventory Item</button>
                </form>

                <label>
                    <input type="checkbox" id="isPermanent" />
                    Save as Permanent Product
                </label>

                <h3 class="section-title">Current Inventory</h3>
                <div class="table-container glass-effect">
                    <table id="inventoryTable">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- In the inventory table -->
<?php foreach ($products as $item): ?>
<tr>
    <td><?= htmlspecialchars($item['name']) ?></td>
    <td>$<?= number_format($item['price'], 2) ?></td>
    <td><?= $item['quantity'] ?></td>
    <td><img src="<?= $item['image'] ?>" alt="Item Image" width="80"></td>
    <td>
        <form method="POST">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
            <button type="submit">Delete</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Admin Profile Information (Bottom) -->
        <div class="business-info-bottom fade-in-delayed">
            <h3>Meet the Admins: Iqra & Saman</h3>
            <div class="team-info">
                <div class="admin-profile glass-effect">
                    <h4>Iqra</h4>
                    <p class="role">Founder & CEO</p>
                    <p class="bio">With a passion for entrepreneurship, Iqra is the visionary behind the business. She oversees strategic direction and ensures that the company remains on a path of growth and success.</p>
                </div>
                <div class="admin-profile glass-effect">
                    <h4>Saman</h4>
                    <p class="role">Co-Founder & Operations Manager</p>
                    <p class="bio">Saman brings operational excellence to the company. From product sourcing to logistics, she is responsible for making sure everything runs smoothly on a day-to-day basis.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="Admin.js"></script>
</body>
</html>