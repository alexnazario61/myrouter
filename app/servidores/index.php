<?php
// Backup

// Check if the request method is GET and the 'bkp' parameter is set to 'OK'
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['bkp']) && $_GET['bkp'] === 'OK') {
    // Define the database connection variable
    global $mysqli;

    // Sanitize the input data
    $idempresa = $mysqli->real_escape_string($idempresa);

    // Fetch the Mikrotik server details from the database
    $regbkp = $mysqli->query("SELECT * FROM servidores WHERE tiporouter = 'MIKROTIK' AND empresa = '$idempresa'");
    $mk = mysqli_fetch_array($regbkp);
    $ipmk = $mk["ip"];
    $loginmk = $mk["login"];
    $senhamk = $mk["senha"];
    $idmk = $mk["id"];
    $nomemk = $mk["servidor"];
    $portaftp = $mk["portaftp"];

    // Include the routeros_api class
    require_once 'routeros_api.class.php';

    // Create a new routeros_api object
    $API = new routeros_api();
    $API->debug = false;

    // Connect to the Mikrotik router
    if ($API->connect($ipmk, $loginmk, $senhamk)) {
        // Save the backup
        $API->write('/system/backup/save', false);
        $API->write('=name=backup-mikrotik.backup');
        $ARRAY = $API->read();

        // Disconnect from the Mikrotik router
        $API->disconnect();
    }

    // Get the current date and format it
    $data = date('dmY');
    $databkp = date('d/m/Y');

    // Define the target and source file names
    $targetFile = "backup-mikrotik" . $data . ".backup";
    $sourceFile = "ftp://$ipmk:$portaftp/backup-mikrotik.backup";
    $ftpuser = $loginmk;
    $ftppassword = $senhamk;
    $regkey = base64_encode(md5($targetFile));

    // Insert the backup details into the 'backups' table
    $crud = new crud('backups');
    $crud->inserir("idmk,servidor,arquivo,data,regkey", "'$idmk','$nomemk','$targetFile','$databkp','$regkey'");

    // Define the FTP upload function
    function saveFtpFile($targetFile, $sourceFile, $ftpuser, $ftppassword)
    {
        // Define the timeout and file open mode
        $timeout = 50;
        $fileOpen = 'w';

        // Initialize cURL
        $curl = curl_init();

        // Open the target file
        $file = fopen('backups/' . $targetFile, $fileOpen);

        // Set cURL options
        curl_setopt($curl, CURLOPT_URL, $sourceFile);
        curl_setopt($curl, CURLOPT_USERPWD, $ftpuser . ':' . $ftppassword);
        curl_setopt($curl, CURLOPT_FAILONERROR, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_FILE, $file);

        // Execute the cURL request
        $result = curl_exec($curl);
        $info = curl_getinfo($curl);

        // Close cURL and the target file
        curl_close($curl);
        fclose($file);

        // Return the result
        return $result;
    }

    // Call the FTP upload function
    $uploadResult = saveFtpFile($targetFile, $sourceFile, $ftpuser, $ftppassword);

    // Log the upload result
    error_log(print_r($uploadResult, true));

    // Redirect the user to the index page
    header("Location: index.php?app=Servidores&reg=4");
} else {
    // Display an error message if the request method is not GET or the 'bkp' parameter is not set to 'OK'
    echo 'Error: Invalid request.';
}
