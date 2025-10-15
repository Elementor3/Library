<!-- 
    This file provides the admin panel for the Web Shop application.
    It includes the header and footer files, checks if the user is an admin, and displays navigation links for various admin tasks.
-->
<?php
session_start();
// Redirect to the index page if the user is not an admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 1) {
    header("Location: index.php");
    exit();
}
include('header.php');
?>

<main class="config-main">
    <h2>Admin Panel</h2>
    <nav class="admin-nav">
        <a href="admin_products.php" class="admin-link">Config Products</a>
        <a href="admin_add_product.php" class="admin-link">Add Product</a>
        <a href="admin_manage_orders.php" class="admin-link">Manage Orders</a>
    </nav>
</main>

<?php include('footer.php'); ?>
