<?php
// products.php
session_start();
require_once('db.php');
include('header.php');
if (isset($_SESSION['message'])) {
    $type = $_SESSION['message_type'] ?? 'success';
    echo "<script>showMessage(" . json_encode($_SESSION['message']) . ", " . json_encode($type) . ");</script>";
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}
?>

<main>
    <h2>Our Products</h2>


    <form method="GET" class="filter-form">
        <input type="text" name="name" placeholder="Name" value="<?= htmlspecialchars($_GET['name'] ?? '') ?>">
        <input type="number" name="min_price" placeholder="Min Price" step="0.01" value="<?= htmlspecialchars($_GET['min_price'] ?? '') ?>">
        <input type="number" name="max_price" placeholder="Max Price" step="0.01" value="<?= htmlspecialchars($_GET['max_price'] ?? '') ?>">
        <select name="availability">
            <option value="">Any Stock</option>
            <option value="in" <?= ($_GET['availability'] ?? '') === 'in' ? 'selected' : '' ?>>In Stock</option>
            <option value="out" <?= ($_GET['availability'] ?? '') === 'out' ? 'selected' : '' ?>>Out of Stock</option>
        </select>
        <button type="submit">Filter</button>
    </form>

    <div class="products-container">
        <?php
        $query = "SELECT pk_productID, name, price, description, imageToPath, stock FROM product WHERE 1=1";
        $params = [];
        $types = '';
        
        if (!empty($_GET['name'])) {
            $query .= " AND name LIKE ?";
            $params[] = '%' . $_GET['name'] . '%';
            $types .= 's';
        }
        if (!empty($_GET['min_price'])) {
            $query .= " AND price >= ?";
            $params[] = $_GET['min_price'];
            $types .= 'd';
        }
        if (!empty($_GET['max_price'])) {
            $query .= " AND price <= ?";
            $params[] = $_GET['max_price'];
            $types .= 'd';
        }
        if (!empty($_GET['availability'])) {
            if ($_GET['availability'] === 'in') {
                $query .= " AND stock > 0";
            } elseif ($_GET['availability'] === 'out') {
                $query .= " AND stock = 0";
            }
        }
        
        $stmt = mysqli_prepare($conn, $query);
        if (!empty($params)) {
            mysqli_stmt_bind_param($stmt, $types, ...$params);
        }
        mysqli_stmt_execute($stmt);
       $result = mysqli_stmt_get_result($stmt);
       
        //$result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            $productID = $row['pk_productID'];
            $name = $row['name'];
            $price = $row['price'];
            $description = $row['description'];
            $image = $row['imageToPath'];
            $quantity = $row['stock'];

            echo "<div class='product'>
                    <img src='$image' alt='$name' class='product-image'>
                    <div class='product-details'>
                        <h3>$name</h3>
                        <p class='description'>$description</p>
                        <p class='price'>Price: \$$price</p>
                        <p class='quantity'>Available: $quantity</p>
                        <form method='POST' action='add_to_cart.php'>
                            <input type='hidden' name='product_id' value='$productID'>
                            <input type='hidden' name='product_name' value='$name'>
                            <input type='hidden' name='price' value='$price'>
                            <label for='quantity'>Quantity:</label>
                            <input type='number' name='quantity' value='1' min='1' max='$quantity' class='quantity-input'>
                            <button type='submit'>Add to Cart</button>
                        </form>
                    </div>
                  </div>";
        }
        ?>
    </div>
</main>

<?php include('footer.php'); ?>
