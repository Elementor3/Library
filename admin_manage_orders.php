<?php
// admin_manage_orders.php
session_start();
require_once('db.php');
include('header.php');

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 1) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['order_id'];
    $action = $_POST['action'];
    $adminId = $_SESSION['user_id'];

    if ($action === 'accept') {
        // fetch product and quantity
        $stmt = mysqli_prepare($conn, "SELECT fk_product, quantity FROM orders WHERE pk_orderID = ?");
        mysqli_stmt_bind_param($stmt, "i", $orderId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $productId, $quantity);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        // reduce stock
        $updateStock = mysqli_prepare($conn, "UPDATE product SET stock = stock - ? WHERE pk_productID = ?");
        mysqli_stmt_bind_param($updateStock, "ii", $quantity, $productId);
        mysqli_stmt_execute($updateStock);
        mysqli_stmt_close($updateStock);

        // update order status and managedBy
        $updateOrder = mysqli_prepare($conn, "UPDATE orders SET status = 1, fk_managedBy = ? WHERE pk_orderID = ?");
        mysqli_stmt_bind_param($updateOrder, "ii", $adminId, $orderId);
        mysqli_stmt_execute($updateOrder);
        mysqli_stmt_close($updateOrder);

    } elseif ($action === 'decline') {
        // just update status and manager
        $updateOrder = mysqli_prepare($conn, "UPDATE orders SET status = 2, fk_managedBy = ? WHERE pk_orderID = ?");
        mysqli_stmt_bind_param($updateOrder, "ii", $adminId, $orderId);
        mysqli_stmt_execute($updateOrder);
        mysqli_stmt_close($updateOrder);
    } elseif ($action === 'delete') {
        $deleteOrder = mysqli_prepare($conn, "DELETE FROM orders WHERE pk_orderID = ?");
        mysqli_stmt_bind_param($deleteOrder, "i", $orderId);
        mysqli_stmt_execute($deleteOrder);
        mysqli_stmt_close($deleteOrder);

        $_SESSION['message'] = "Order #$orderId has been deleted.";
        $_SESSION['message_type'] = "info";
        header("Location: admin_manage_orders.php");
        exit();
    }
    
}



?>

<main class="config-main">
    <h2>Admin - Manage Orders</h2>
    <nav class="admin-nav">
        <a href="admin_panel.php" class="admin-link">Back to Admin Panel</a>
    </nav>

    <div class="orders-grid">
        <?php
        $result = mysqli_query($conn, " SELECT o.pk_orderID, u.name AS user, p.name AS product, o.quantity, o.totalPrice, o.status, o.fk_managedBy, o.date
                                        FROM orders o
                                        JOIN user u ON o.fk_user = u.pk_userID
                                        JOIN product p ON o.fk_product = p.pk_productID
                                        ORDER BY o.date DESC");
        $statusText = ['Pending', 'Accepted', 'Declined'];
        $statusClass = ['pending', 'accepted', 'declined'];

        while ($row = mysqli_fetch_assoc($result)):
            $statusLabel = $statusText[$row['status']];
            $statusClassName = $statusClass[$row['status']];
        ?>
            <div class="order-item">
                <!-- ✖ Delete button -->
                <form method="POST" class="delete-form">
                    <input type="hidden" name="order_id" value="<?php echo $row['pk_orderID']; ?>">
                    <button type="submit" name="action" value="delete" class="delete-button" title="Delete Order">×</button>
                </form>

                <p><strong>Order ID:</strong> <?php echo $row['pk_orderID']; ?></p>
                <p><strong>User:</strong> <?php echo htmlspecialchars($row['user']); ?></p>
                <p><strong>Product:</strong> <?php echo htmlspecialchars($row['product']); ?></p>
                <p><strong>Quantity:</strong> <?php echo $row['quantity']; ?></p>
                <p><strong>Total Price:</strong> $<?php echo $row['totalPrice']; ?></p>
                <p><strong>Date:</strong> <?php echo $row['date']; ?></p>
                <p class="status-<?php echo $statusClassName; ?>">
                    <strong>Status:</strong> <?php echo $statusLabel; ?>
                </p>

                <?php if (!$row['fk_managedBy']): ?>
                    <form method="POST" class="config-form">
                        <input type="hidden" name="order_id" value="<?php echo $row['pk_orderID']; ?>">
                        <button type="submit" name="action" value="accept" class="admin-link">Accept</button>
                        <button type="submit" name="action" value="decline" class="admin-link">Decline</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
</main>

<?php include('footer.php'); ?>