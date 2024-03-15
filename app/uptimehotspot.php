<?php

// Include the MikroTik API class
require('../config/mikrotik.class.php');

// Initialize the API object
$API = new routeros_api();

// Disable debug mode
$API->debug = false;

// Connect to the router using IP, login, and password from GET request
if ($API->connect($_GET['ip'], $_GET['login'], $_GET['senha'])) {

  // Execute the command to retrieve active hotspot users
  $ARRAY = $API->comm("/ip/hotspot/active/print");

  // Get the first element from the returned array
  $first = $ARRAY['0'];

  // Output the uptime of the first user
  ?>
  <?php echo $first['uptime']; ?>

  <?php
}

?>
