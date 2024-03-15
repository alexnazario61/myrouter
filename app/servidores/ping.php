<?php

// Include the required classes
require('../../config/mikrotik.class.php');
require('../../config/conexao.class.php');

// Initialize the MikroTik class
$API = new routeros_api();

// Set debugging to false
$API->debug = false;

// Get the required parameters from GET request
$ip = isset($_GET['ip']) ? $_GET['ip'] : '';
$login = isset($_GET['login']) ? $_GET['login'] : '';
$senha = isset($_GET['senha']) ? $_GET['senha'] : '';

// Check if all required parameters are set
if (!empty($ip) && !empty($login) && !empty($senha)) {
    // Connect to the MikroTik router
    if ($API->connect($ip, $login, $senha)) {
        // Define the IP address to ping
        $ipping = '1.1.1.1';

        // Write the ping command to the MikroTik router
        $API->write('/ping', false);
        $API->write("=address=$ipping", false);
        $API->write('=count=3', false);
        $API->write('=interval=1');

        // Read the response from the MikroTik router
        $ARRAY = $API->read();

        // Print the response
        print_r($ARRAY);

        // Disconnect from the MikroTik router
        $API->disconnect();
    } else {
        // Connection failed
        echo "Connection to MikroTik router failed.";
    }
} else {
    // Required parameters not set
    echo "Required parameters not set.";
}

?>
