<!-- 
    cart.php - Web Shop Shopping Cart Page
    This file displays the shopping cart for the Web Shop application.
    It includes the header and footer files, lists the items in the cart, allows item removal, and provides the option to submit the order.
-->

<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include('header.php');

// Remove item from cart
if (isset($_GET['remove']) && isset($_SESSION['cart'][$_GET['remove']])) {
    unset($_SESSION['cart'][$_GET['remove']]);
}
if (isset($_SESSION['order_message'])) {
    $type = $_SESSION['order_type'] ?? 'success';
    echo "<script>showMessage(" . json_encode($_SESSION['order_message']) . ", " . json_encode($type) . ");</script>";
    unset($_SESSION['order_message']);
    unset($_SESSION['order_type']);
}
?>

<main class="cart-main">
    <h2>Your Shopping Cart</h2>
       <!-- Check if the cart is not empty -->
    <?php if (!empty($_SESSION['cart'])): ?>
        <div class="cart-items">
            <?php $totalPrice = 0; ?>
             <!-- Loop through each item in the cart -->
            <?php foreach ($_SESSION['cart'] as $index => $item): ?>
                <div class="cart-item">
                    <p><strong><?php echo $item['product_name']; ?></strong></p>
                    <p>Price: $<?php echo $item['price']; ?></p>
                    <p>Quantity: <?php echo $item['quantity']; ?></p>
                      <!-- Link to remove item from cart -->
                    <a href="cart.php?remove=<?php echo $index; ?>" class="remove-link">Remove</a>
                    <hr> <!-- Add a horizontal line to distinguish products -->
                    <?php $totalPrice += $item['price'] * $item['quantity']; ?>
                </div>
            <?php endforeach; ?>
        </div>
         <!-- Display the total price of items in the cart -->
        <p class="total-price">Total Price: $<?php echo $totalPrice; ?></p>
          <!-- Form to submit the order -->
        <form method="POST" action="submit_order.php">
            <button type="submit">Submit Order</button>
        </form>
    <?php else: ?>
          <!-- Display a message if the cart is empty -->
        <p>Your cart is empty.</p>
    <?php endif; ?>
</main>

<?php include('footer.php'); ?>
