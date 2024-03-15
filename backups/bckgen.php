#!/usr/bin/php -q
<?php

// Import the database connection file
require_once '../config/conexao.php';

// Set the name of the backup file with the database name and current date/time
$dumpfile = $banco . "_" . date("Y-m-d_H-i-s") . ".sql";

// Get the current date/time and MD5 hash for the backup file name
$data = date("d-m-Y-H.m.s");
$data2 = date("d/m/Y");
$chave = md5($data);

// Set the directory path for storing backups
$dir_backup ="/var/www/myrouter/backups";

// Execute the mysqldump command to create a backup of the database
passthru("/usr/bin/mysqldump --opt --host=$host --user=$usuario --password=$senha $banco > $dumpfile");

// Display the backup file name and the first line of the backup content
echo "$dumpfile "; passthru("tail -1 $dumpfile");

// Define a function to execute shell commands
function execute($command)
{
    // Execute the command and check if there is an error
    if(!shell_exec($command))//error, stop the script
        exit;
    else//success, display the command
        echo "{$command}\n";
}

// Define a function to insert the backup information into the 'backups' table
function insertBackupInfo($host, $usuario, $senha, $banco, $dumpfile, $data2, $chave)
{
    // Connect to the database
    $db = new mysqli($host,$usuario,$senha,$banco);

    // Create an SQL query to insert the backup information
    $sql = "INSERT INTO backups (id, servidor, arquivo, `data`, idmk, regkey) VALUES (NULL ,'MyRouterERP','$dump
