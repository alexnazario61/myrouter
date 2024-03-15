<?php
// Establishing a connection to the database
$link = mysqli_connect('localhost', 'root', '33#erp@myrouter#3', 'database_name');

// Checking the connection
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Your database query goes here

// Closing the connection
mysqli_close($link);
?>
