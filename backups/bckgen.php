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
$dir_backup = "/var/www/myrouter/backups";

// Check if the backup directory exists, and create it if it doesn't
if (!file_exists($dir_backup)) {
    mkdir($dir_backup, 0777, true);
}

// Execute the mysqldump command to create a backup of the database
$mysqldump_command = "/usr/bin/mysqldump --opt --host={$host} --user={$usuario} --password={$senha} {$banco} > {$dumpfile}";
exec($mysqldump_command, $output, $return_var);

if ($return_var !== 0) {
    // Error occurred while creating the backup
    echo "Error: mysqldump command failed\n";
    exit(1);
}

// Display the backup file name and the first line of the backup content
echo "Backup file: {$dumpfile}\n";
passthru("tail -1 {$dumpfile}");

// Define a function to execute shell commands
function execute($command)
{
    // Execute the command and check if there is an error
    if (!shell_exec($command)) {
        // Error, stop the script
        exit;
    } else {
        // Success, display the command
        echo "{$command}\n";
    }
}

// Define a function to insert the backup information into the 'backups' table
function insertBackupInfo($host, $usuario, $
