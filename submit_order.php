<?php
// submit_order.php
session_start();
require_once('db.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $userId = $_SESSION['user_id'];
    $totalPrice = 0;
    $cartItems = [];

    // Sum up quantity and validate stock
    foreach ($_SESSION['cart'] as $item) {
        $pid = $item['product_id'];
        $qty = $item['quantity'];
        if (!isset($cartItems[$pid])) {
            $cartItems[$pid] = 0;
        }
        $cartItems[$pid] += $qty;
        $totalPrice += $item['price'] * $qty;
    }

    $enoughStock = true;
    foreach ($cartItems as $productId => $quantity) {
        $stmt = mysqli_prepare($conn, "SELECT stock FROM product WHERE pk_productID = ?");
        mysqli_stmt_bind_param($stmt, "i", $productId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $stock);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($stock < $quantity) {
            $enoughStock = false;
            break;
        }
    }

    if ($enoughStock) {
        foreach ($cartItems as $productId => $quantity) {
            // Calculate price again to avoid tampering
            $stmt = mysqli_prepare($conn, "SELECT price FROM product WHERE pk_productID = ?");
            mysqli_stmt_bind_param($stmt, "i", $productId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $price);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);

            $total = $price * $quantity;

            $insert = mysqli_prepare($conn, "INSERT INTO orders (fk_user, fk_product, quantity, totalPrice, date) VALUES (?, ?, ?, ?, NOW())");
            mysqli_stmt_bind_param($insert, "iiid", $userId, $productId, $quantity, $total);
            mysqli_stmt_execute($insert);
            mysqli_stmt_close($insert);

            /*// Reduce stock
            $update = mysqli_prepare($conn, "UPDATE product SET stock = stock - ? WHERE pk_productID = ?");
            mysqli_stmt_bind_param($update, "ii", $quantity, $productId);
            mysqli_stmt_execute($update);
            mysqli_stmt_close($update);*/
        }

        unset($_SESSION['cart']);
        $_SESSION['order_message'] = "Order submitted successfully!";
    } else {
        $_SESSION['order_message'] = "Not enough items in stock for your order.";
    }

    header("Location: cart.php");
    exit();
} else {
    header("Location: cart.php?error=Your cart is empty.");
    exit();
}
