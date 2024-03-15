<?php

// Start a PHP session
session_start();

// Start output buffering
ob_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Enable tracking of errors
ini_set("track_errors","1");

// Enable URL fopen
ini_set("allow_url_fopen", 1);

// Require necessary files
require_once '../config/conexao.class.php';
require_once '../config/crud.class.php';
require_once '../config/mikrotik.class.php';

// Decode the IP address from the GET request
$getIP = isset($_GET['ip']) ? base64_decode($_GET['ip']) : '';

// Instantiate the database connection class
$con = new conexao();

// Connect to the database
$con->connect();

// Query for all servers
$servidor = $con->query("SELECT * FROM servidores");

// Fetch the first row of the result set
$server = $servidor->fetch_array();

// Set the IP and secret variables
$ipnas = $server['ip'];
$secret = $server['secret'];

// Query for all records in the financeiro table with a status of 'B'
$query = "SELECT * FROM  financeiro WHERE situacao = 'B'";

// Execute the query
$result = $con->query($query) or die($con->error);

// Loop through the result set
while($row = $result->fetch_array()){
    // Set the pedido and login variables to the current row's values
    $pedido = $row['pedido'];
    $login = $row['login'];

    // Call the radDesloga function with the current row's login value
    radDesloga($con, $ipnas, $secret, $login);
}

// Define the radDesloga function
function radDesloga($con, $ipnas, $secret, $username) {
    // Query for the framedipaddress and nasipaddress for the given username
    $consulta_rsDesl = "SELECT framedipaddress, nasipaddress FROM radacct WHERE username = '" . $username . "' ORDER BY radacctid DESC";
    $rsDesl = $con->query($consulta_rsDesl);
    $row_rsDesl = $rsDesl->fetch_assoc();
    $totalRows_rsDesl = $rsDesl->num_rows;

    // Set the ipcli and nascli variables to the fetched values
    $ipcli = $row_rsDesl['framedipaddress'];
    $nascli = $row_rsDesl['nasipaddress'];

    // If there is a result
    if ($totalRows_rsDesl) {
        // Query for the secret for the given nasipaddress
        $consulta_rsRamais = "SELECT secret FROM nas WHERE nasname = '" . $nascli . "'";
        $rsRamais = $con->query($consulta_rsRamais);
        $row_rsRamais = $rsRamais->fetch_assoc();
        $secret_nas = $row_rsRamais['secret'];

        // Build the disconnect command
        $command = "echo User-Name=" . $username . " | radclient -x " . $ipnas . ":3799 disconnect " . $secret_nas;

        // Execute the command
        shell_exec($command);
    }
}
