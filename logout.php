<!-- 
    This file handles user logout for the Web Shop application.
    It clears the session data, destroys the session, and redirects the user to the login page.
-->
<?php
session_start();
session_unset();
session_destroy();
header("Location: login.php");
exit();
?>
