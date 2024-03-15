<?php
// Include the MikroTik class
require('../config/mikrotik.class.php');

// Create an instance of the MikroTik class
$api = new routeros_api();

// Set debug mode to false
$api->debug = false;

// Get input parameters
$ip = filter_input(INPUT_GET, 'ip', FILTER_VALIDATE_IP);
$login = filter_input(INPUT_GET, 'login');
$senha = filter_input(INPUT_GET, 'senha');

// Check if all input parameters are present
if (!$ip || !$login || !$senha) {
    die('Missing required parameters');
}

// Connect to the MikroTik router
if (!$api->connect($ip, $login, $senha)) {
    die('Failed to connect to the MikroTik router');
}

// Get the registration table
$registrationTable = $api->comm("/interface/wireless/registration-table/print");

// Check if the registration table is not empty
if (empty($registrationTable)) {
    die('Registration table is empty');
}

// Get the first item in the registration table
$first = $registrationTable[0];

// Print the uptime of the first item
echo $first['uptime'];

// Close the MikroTik router connection
$api->disconnect();
?>
