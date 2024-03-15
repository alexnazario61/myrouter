<?php
// Start a PHP session
session_start();

// Start output buffering
ob_start();

// Enable URL fopen and display errors
ini_set("allow_url_fopen", 1);
ini_set("display_errors", 1);

// Set error reporting level
error_reporting(1);

// Enable tracking of errors
ini_set("track_errors","1"); 

// Require necessary files
require_once '../config/conexao.class.php';
require_once '../config/crud.class.php';
require_once '../config/mikrotik.class.php';

// Decode the IP address from the GET request
@$getIP = base64_decode($_GET['ip']);

// Instantiate the database connection class
$con = new conexao();

// Connect to the database
$con->connect();

// Query for all servers
$servidor = mysql_query("SELECT * FROM servidores");

// Fetch the first row of the result set
$mk = mysql_fetch_array($servidor);

// Set the IP and secret variables
$ipnas = $mk['ip'];
$secret = $mk['secret'];

// Query for all records in the financeiro table with a status of 'B'
$query = "SELECT * FROM  financeiro WHERE situacao = 'B'";

// Execute the query
$result = mysql_query($query) or die(mysql_error());

// Loop through the result set
while($row = mysql_fetch_array($result)){
     // Set the pedido and login variables to the current row's values
     $row['pedido'];
     $row['login'];

    // Call the radDesloga function with the current row's login value
    radDesloga($row['login']);

   // Uncomment the following line to disconnect the user using radclient
   // shell_exec(" echo  User-Name=".$row['login']." | radclient -x $ipnas:3799 disconnect $secret");
}

// Define the radDesloga function
function radDesloga($username) {
    // Query for the framedipaddress and nasipaddress for the given username
    $consulta_rsDesl = "SELECT framedipaddress, nasipaddress FROM radacct WHERE username = '" . $username . "' ORDER BY radacctid DESC";
    $rsDesl = mysql_query($consulta_rsDesl);
    $row_rsDesl = mysql_fetch_assoc($rsDesl);
    $totalRows_rsDesl = mysql_num_rows($rsDesl);

    // Set the ipcli and nascli variables to the fetched values
    $ipcli = $row_rsDesl['framedipaddress'];
    $nascli = $row_rsDesl['nasipaddress'];

    // If there is a result
    if ($totalRows_rsDesl) {
        // Query for the secret for the given nasipaddress
        $consulta_rsRamais = "SELECT secret FROM nas WHERE nasname = '" . $nascli . "'";
        $rsRamais = mysql_query($consult
