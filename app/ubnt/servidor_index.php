<?php
// Backup

if($_GET['bkp'] == "OK") { // Check if the request is for backup

// Get the server details from the database
$regbkp = $mysqli->query("SELECT * FROM servidores WHERE tiporouter = 'UBIQUITI' AND empresa = '$idempresa'");
$mk = mysqli_fetch_array($regbkp);

// Connect to the Mikrotik router using routeros_api
$API = new routeros_api();
$API->debug = false;
if ($API->connect(''.$ipmk.'', ''.$loginmk.'', ''.$senhamk.'')) {

// Write the command to save the backup
$API->write('/system/backup/save',false);
$API->write('=name=backup-mikrotik.backup' );  
$ARRAY = $API->read();

// Disconnect from the Mikrotik router
$API->disconnect();
}

// Get the current date and format it
$data = date('dmY');
$databkp = date('d/m/Y');

// Define the target file name and source file path
$targetFile = "backup-mikrotik".$data.".backup";
$sourceFile = "ftp://$ipmk/backup-mikrotik.backup";

// Define the FTP credentials
$ftpuser = "$loginmk";
$ftppassword = "$senhamk";

// Encode the target file name for the database
$regkey = base64_encode(md5($targetFile));

// Insert the backup details into the backups table
$crud = new crud('backups');  // tabela como parametro
$crud->inserir("idmk,servidor,arquivo,data,regkey", "'$idmk','$nomemk','$targetFile','$databkp','$regkey'");

// Define the function to save the backup file using FTP
function saveFtpFile( $targetFile = null, $sourceFile = null, $ftpuser = null, $ftppassword = null ){

// Define the timeout and file open mode
$timeout = 50;
$fileOpen = 'w';

// Initialize cURL
$curl = curl_init();

// Open the target file
$file = fopen ('backups/'.$targetFile, $fileOpen);

// Set the cURL options for FTP transfer
curl_setopt($curl, CURLOPT_URL, $sourceFile); 
curl_setopt($curl, CURLOPT_USERPWD, $ftpuser.':'.$ftppassword);

// Set other cURL options
curl_setopt($curl, CURLOPT_FAILONERROR, 1);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_FILE, $file); 

// Execute the cURL transfer and get the result
$result = curl_exec($curl);
$info = curl_getinfo($curl);

// Close the cURL session and the target file
curl_close($curl);
fclose($file);

// Return the result
return $result;
}

// Call the saveFtpFile function to save the backup file
var_dump(saveFtpFile( $targetFile, $sourceFile, $ftpuser, $ftppassword ));

// Redirect to the index page
header("Location: index.php?app=ServidoresUBNT&reg=4");
}
?>
