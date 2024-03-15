<?php

// Check if the user is already logged in, if so redirect to the home page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: home.php");
    exit;
}

// Unset and destroy the session
session_start();
session_unset();
session_destroy();

// Redirect to the login page
header("Location: login.php");
exit;

?>
