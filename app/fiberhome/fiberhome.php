<?php
// Define the IP address of the administration interface
define(IPADMIN, '201.87.240.9');

// Define the IP address of the TL1 server
define(IPTL1SRV, '10.10.6.146');

// Define the TL1 username and password
define(TL1USR, '1');
define(TL1PWD, '33#sysadmin#33');

// Include the FiberHome class
include 'FiberHome.class.php';

// Connect to the FiberHome device
echo "Conectando...\n";
$fh = new FiberHome(IPADMIN, IPTL1SRV, TL1USR, TL1PWD, false);

// List the ONU devices
echo "Listando...\n";
$onus = $fh->ONUList();

// Commented out as it seems to be a duplicate of the ONUInfos method
//echo "Obtendo status...\n";
//$fh->ONUStates($onus);

// Obtain additional information about the ONU devices
echo "Obtendo informações extras...\n";
$fh->ONUInfos($onus);

// Display the ONU devices' information in a preformatted format
echo '<pre>';
var_dump($onus);
echo '</pre>';
