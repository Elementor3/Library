<?php
// admin_products.php
session_start();
require_once('db.php');

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 1) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $idToDelete = $_POST['id'];
        $stmt = mysqli_prepare($conn, "DELETE FROM product WHERE pk_productID = ?");
        mysqli_stmt_bind_param($stmt, "i", $idToDelete);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo "<script>showMessage('Product deleted successfully!', 'success');</script>";

    } else {
        $id = trim($_POST['id']); 
        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $image = $_POST['image'];
        $quantity = $_POST['quantity'];

        // Check for duplicate product name
        if ($id === "") {
            // INSERT: Check if name already exists
            $check = mysqli_prepare($conn, "SELECT pk_productID FROM product WHERE name = ?");
            mysqli_stmt_bind_param($check, "s", $name);
        } else {
            // UPDATE: Check if same name exists in another product
            $check = mysqli_prepare($conn, "SELECT pk_productID FROM product WHERE name = ? AND pk_productID != ?");
            mysqli_stmt_bind_param($check, "si", $name, $id);
        }

        mysqli_stmt_execute($check);
        mysqli_stmt_store_result($check);
        if (mysqli_stmt_num_rows($check) > 0) {
            $message = "A product with this name already exists";
            $type = "error";
            mysqli_stmt_close($check);
        } else {
            mysqli_stmt_close($check);

            if ($id === "") {
                // INSERT
                $stmt = mysqli_prepare($conn, "INSERT INTO product (name, price, description, imageToPath, stock) VALUES (?, ?, ?, ?, ?)");
                mysqli_stmt_bind_param($stmt, "sdssi", $name, $price, $description, $image, $quantity);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                echo "<script>showMessage('Product added successfully!', 'success');</script>";

            } else {
                // UPDATE
                $stmt = mysqli_prepare($conn, "UPDATE product SET name=?, price=?, description=?, imageToPath=?, stock=? WHERE pk_productID=?");
                mysqli_stmt_bind_param($stmt, "sdssii", $name, $price, $description, $image, $quantity, $id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                echo "<script>showMessage('Product updated successfully!', 'success');</script>";

            }
        }
    }
}

$result = mysqli_query($conn, "SELECT * FROM product");

include('header.php');
if (isset($message)) {
    echo "<script>showMessage(" . json_encode($message) . ", " . json_encode($type) . ");</script>";
}

?>

<main class="config-main">
    <h2>Admin - Manage Products</h2>
    <nav class="admin-nav">
        <a href="admin_panel.php" class="admin-link">Back to Admin Panel</a>
    </nav>
    <div class="products-grid">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="product-item">
                <form method="POST" class="delete-form">
                    <input type="hidden" name="id" value="<?php echo $row['pk_productID']; ?>">
                    <button type="submit" name="delete" class="delete-button" title="Delete Product">×</button>
                </form>
                <form method="POST" class="config-form">
                    <input type="hidden" name="id" value="<?php echo $row['pk_productID']; ?>">
                    <label for="name">Product Name:</label>
                    <input type="text" name="name" value="<?php echo $row['name']; ?>" required>
                    <label for="price">Price:</label>
                    <input type="number" name="price" value="<?php echo $row['price']; ?>" required>
                    <label for="description">Description:</label>
                    <textarea name="description" required><?php echo $row['description']; ?></textarea>
                    <label for="image">Image URL:</label>
                    <input type="text" name="image" value="<?php echo $row['imageToPath']; ?>" required>
                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity" value="<?php echo $row['stock']; ?>" required>
                    <button type="submit" class="admin-link">Update Product</button>
                </form>
            </div>

        <?php endwhile; ?>
    </div>
</main>

<?php include('footer.php'); ?>
