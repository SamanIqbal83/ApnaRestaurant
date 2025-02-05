<?php
include 'db_connection.php';

// Fetch products from the database where stock is greater than zero
$stmt = $conn->prepare("SELECT * FROM products WHERE quantity > 0");
$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Page</title>
    <link rel="stylesheet" href="Customer.css">
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="top-header">
            <h2>Our Business Products</h2>
        </div>
    </header>

    <!-- Products Section -->
    <div id="products">
        <h3>Available Products</h3>
        <?php if (empty($products)): ?>
            <p>No products available.</p>
        <?php else: ?>
            <div class="product-list">
                <?php foreach($products as $product): ?>
                    <div class="product">
                        <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" class="product-image">
                        <h3 class="product-name"><?= htmlspecialchars($product['name']) ?></h3>
                        <p class="product-price">Price: $<?= number_format($product['price'], 2) ?></p>
                        <p class="product-stock">Stock: <?= $product['quantity'] ?></p>
                        <form method="POST" action="customer_dashboard.php">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <button type="submit" name="buy_product" class="buy-button">Buy</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Store Info Section -->
    <div class="store-info">
        <h3>About Us</h3>
        <p>We are a leading provider of quality goods at competitive prices.</p>
        <p>Browse our collection and buy items that you like. Thank you for shopping with us!</p>
    </div>

    <!-- Contact, Feedback, and Email Buttons -->
    <div class="buttons-container">
        <a href="mailto:SamanXiqra@gmail.com">
            <button>✉</button>
        </a>
        <button id="contactButton">☎</button>
        <button id="feedbackButton">💬</button>
    </div>

    <!-- Feedback Form (Hidden initially) -->
    <div id="feedbackForm" class="popup-form">
        <h3>Leave Your Feedback</h3>
        <textarea id="feedbackMessage" placeholder="Write your feedback here..." rows="4" required></textarea>
        <button id="submitFeedback">Submit Feedback</button>
        <button id="closeFeedbackForm">Close</button>
    </div>

    <!-- Contact Form (Hidden initially) -->
    <div id="contactForm" class="popup-form">
        <h3>Contact Us</h3>
        <textarea id="contactMessage" placeholder="Write your message here..." rows="4" required></textarea>
        <button id="sendContactMessage">Send Message</button>
        <button id="closeContactForm">Close</button>
    </div>

    <script src="Customer.js"></script>
</body>
</html>