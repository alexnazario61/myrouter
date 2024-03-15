<?php

// Include the MikroTik API class
require('../config/mikrotik.class.php');

// Initialize the API object
$api = new routeros_api();

// Disable debug mode
$api->debug = false;

// Set the IP, login, and password as variables
$ip = isset($_GET['ip']) ? $_GET['ip'] : '';
$login = isset($_GET['login']) ? $_GET['login'] : '';
$password = isset($_GET['senha']) ? $_GET['senha'] : '';

// Check if all required variables are set
if (!empty($ip) && !empty($login) && !empty($password)) {

  // Connect to the router using IP, login, and password
  if ($api->connect($ip, $login, $password)) {

    // Execute the command to retrieve active hotspot users
    $array = $api->comm("/ip/hotspot/active/print");

    // Check if at least one user is returned
    if (isset($array[0])) {

      // Output the uptime of the first user
      echo $array[0]['uptime'];

    } else {

      // Output a message if no users are found
      echo "No active hotspot users found.";

    }

    // Close the connection
    $api->disconnect();

  } else {

    // Output a message if the connection fails
    echo "Failed to connect to the router.";

  }

} else {

  // Output a message if required variables are not set
  echo "Missing required variables.";

}

?>
