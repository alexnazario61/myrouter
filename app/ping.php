<?php
// Include the MikroTik API class
require('../config/mikrotik.class.php');

// Create an instance of the MikroTik API class
$API = new routeros_api();

// Disable debug mode
$API->debug = false;

// Decode the input parameters from GET request
$ip = base64_decode($_GET['ip']);
$login = base64_decode($_GET['login']);
$senha = base64_decode($_GET['senha']);
$ping = base64_decode($_GET['ping']);

// Connect to the MikroTik router using the provided IP, login, and password
if ($API->connect(''.$ip.'', ''.$login.'', ''.$senha.'')) {

    // Set the IP address for the ping test
    $ipping = $ping;

    // Write the ping command to the MikroTik router
    $API->write('/ping',false);
    $API->write("=address=$ipping",false);
    $API->write('=count=3',false);
    $API->write('=interval=1');

    // Read the response from the MikroTik router
    $ARRAY= $API->read();

    // Get the first element of the response array
    $first = $ARRAY['0'];

    // Display the ping test results in a formatted HTML
    echo "<span style='font-size:12px;font-family:verdana;'><b>HOST:</b> " . $first['host'] . " | <b>REPLAY SIZE:</b> " . $first['size'] . " <br>"
        . "<b>TTL:</b> " . $first['ttl'] . " <br>"
        . "<b>TIME:</b> " . $first['time'] . " <br>"
        . "<b>ENVIADO:</b> " . $first['sent'] . " <br>"
        . "<b>RECEB
