<?php
session_start();

// Destroy session data
session_destroy();

// Redirect to the login page
header("Location: login.php");
exit();
?>
