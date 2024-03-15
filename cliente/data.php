<?php // Starting PHP code block

require_once('../config/api_mt_include.php'); // Include the API configuration file

$ipRouteros = $_GET["nasipaddress"]; // Get the router IP address from GET request
$Username = "edielson"; // Set the username
$Pass = "33#@myrouter@#33"; // Set the password
$api_puerto = 8728; // Set the API port
$interface = $_GET["interface"]; // Get the interface name from GET request

$API = new routeros_api(); // Initialize the routeros_api
$API->debug = false; // Disable debug mode

if ($API->connect($ipRouteros, $Username, $Pass, $api_puerto)) { // Connect to the router using the provided credentials
	$rows = array(); $rows2 = array(); // Initialize arrays to store traffic data

	$API->write("/interface/monitor-traffic", false); // Write the command to monitor traffic
	$API->write("=interface=" . '<pppoe-' . $interface . '>', false); // Set the interface to monitor
	$API->write("=once=", true); // Get the traffic data once
	$READ = $API->read(false); // Read the response
	$ARRAY = $API->parse_response($READ); // Parse the response

	if (count($ARRAY) > 0) { // Check if the response contains data
		$rx = $ARRAY[0]["rx-bits-per-second"]; // Get the received traffic rate
		$tx = $ARRAY[0]["tx-bits-per-second"]; // Get the transmitted traffic rate

		$rows['name'] = 'Tx'; // Set the name for transmitted traffic data
		$rows['data'][] = $tx; // Add the transmitted traffic rate to the data array

		$rows2['name'] = 'Rx'; // Set the name for received traffic data
		$rows2['data'][] = $
