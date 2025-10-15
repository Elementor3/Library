<!-- 
    This file handles adding products to the shopping cart for the Web Shop application.
    It includes session management, processes form submission, and updates the cart with the selected items.
-->
<?php
session_start();
// Redirect to login page if the user is not logged in
if (!isset($_SESSION['username'])) {
    $_SESSION['message'] = "Please log in to add items to the cart.";
    $_SESSION['message_type'] = "error";
    header("Location: products.php");
    exit();
}
// Handle form submission for adding a product to the cart
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productID = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    // Create an associative array for the cart item
    $cartItem = [
        'product_id' => $productID,
        'product_name' => $productName,
        'price' => $price,
        'quantity' => $quantity
    ];
    // Initialize the cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add item to cart
    $_SESSION['cart'][] = $cartItem;
    $_SESSION['message'] = "$productName has been added to your cart.";
    // Redirect to the products page
    header("Location: products.php");
    exit();
}
