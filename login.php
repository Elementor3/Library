<?php
// login.php
session_start();
require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = mysqli_prepare($conn, "SELECT pk_userID, password, isAdmin FROM user WHERE name = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) === 1) {
        mysqli_stmt_bind_result($stmt, $userID, $storedPassword, $isAdmin);
        mysqli_stmt_fetch($stmt);

        if ($storedPassword === $password) {
            $_SESSION['username'] = $username;
            $_SESSION['user_type'] = $isAdmin;
            $_SESSION['user_id'] = $userID;
            header("Location: login.php");
            exit();
        } else {
            $error = "Invalid login credentials.";
        }
    } else {
        $error = "Invalid login credentials.";
    }
    mysqli_stmt_close($stmt);
}

include('header.php');
?>

<main class="login-main">
    <?php if (isset($_SESSION['username'])): ?>
        <div class="logged-in-message">
            <p>You are logged in as <strong class="current-user"><?php echo $_SESSION['username']; ?></strong>.</p>
            <p><a class="auth-link" href="logout.php">Logout</a></p>
        </div>
    <?php else: ?>
        <h2>Login</h2>
        <form method="POST" class="auth-form">
            <label for="username">Username:</label>
            <input type="text" name="username" required><br>
            <label for="password">Password:</label>
            <input type="password" name="password" required><br>
            <button type="submit">Login</button>
        </form>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <?php endif; ?>
</main>
<?php include('footer.php'); ?>
