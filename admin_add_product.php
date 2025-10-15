<?php
// admin_add_product.php
session_start();
require_once('db.php');
include('header.php');

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 1) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_POST['image'];
    $quantity = $_POST['quantity'];

    //  Check if product name already exists
    $check = mysqli_prepare($conn, "SELECT pk_productID FROM product WHERE name = ?");
    mysqli_stmt_bind_param($check, "s", $name);
    mysqli_stmt_execute($check);
    mysqli_stmt_store_result($check);

    if (mysqli_stmt_num_rows($check) > 0) {
        echo "<script>showMessage('A product with this name already exists.', 'error');</script>";
        mysqli_stmt_close($check);
    } else {
        mysqli_stmt_close($check);

        $stmt = mysqli_prepare($conn, "INSERT INTO product (name, price, description, imageToPath, stock) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sdssi", $name, $price, $description, $image, $quantity);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo "<script>showMessage('Product added successfully!', 'success');</script>";

    }
}


?>

<main class="config-main">
    <h2>Add a New Product</h2>
    <nav class="admin-nav">
        <a href="admin_panel.php" class="admin-link">Back to Admin Panel</a>
    </nav>
    <form method="POST" class="config-form">
        <label for="name">Product Name:</label>
        <input type="text" name="name" required><br>
        <label for="price">Price:</label>
        <input type="number" name="price" step="0.01" required><br>
        <label for="description">Description:</label>
        <textarea name="description" required></textarea><br>
        <label for="image">Image URL:</label>
        <input type="text" name="image" required><br>
        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" required><br>
        <button type="submit">Add Product</button>
    </form>

</main>

<?php include('footer.php'); ?>
