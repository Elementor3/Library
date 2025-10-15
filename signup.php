<?php
// signup.php
session_start();
require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        // Check if username already exists
        $stmt = mysqli_prepare($conn, "SELECT name FROM user WHERE name = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $error = "Username already exists.";
        } else {
            $userType = 0;
            $insert = mysqli_prepare($conn, "INSERT INTO user (name, password, isAdmin) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($insert, "ssi", $username, $password, $userType);
            mysqli_stmt_execute($insert);

            $_SESSION['username'] = $username;
            $_SESSION['user_type'] = $userType;
            $_SESSION['user_id'] = mysqli_insert_id($conn);

            header("Location: index.php");
            exit();
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<?php include('header.php'); ?>
<main>
    <form method="POST" class="auth-form">
        <h2>Sign Up</h2>
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" required><br>
        <button type="submit">Sign Up</button>
    </form>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
</main>
<?php include('footer.php'); ?>
