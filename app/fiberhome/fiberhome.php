<?php

// Define constants
define('IPADMIN', '201.87.240.9');
define('IPTL1SRV', '10.10.6.146');
define('TL1USR', '1');
define('TL1PWD', '33#sysadmin#33');

// Include the FiberHome class
include 'FiberHome.class.php';

try {
    // Connect to the FiberHome device
    echo "Connecting...\n";
    $fh = new FiberHome(IPADMIN, IPTL1SRV, TL1USR, TL1PWD, false);

    // List the ONU devices
    echo "Listing...\n";
    $onus = $fh->ONUList();

    // Obtain additional information about the ONU devices
    echo "Getting extra information...\n";
    $fh->ONUInfos($onus);

    // Display the ONU devices' information in a preformatted format
    echo '<pre>';
    var_dump($onus);
    echo '</pre>';
} catch (Exception $e) {
    // Handle errors
    echo 'Error: ' . $e->getMessage() . '\n';
}
