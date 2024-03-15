<?php
// Start the session and output buffering
session_start();
ob_start();

// Set various INI settings
ini_set("allow_url_fopen", 1);
ini_set("display_errors", 1);
error_reporting(1);
ini_set("track_errors","1");

// Require necessary configuration and class files
require_once 'config/conexao.php';
require_once 'config/conexao.class.php';
require_once 'config/crud.class.php';

// Check if the user is logged in
if ( !isset($_SESSION['login']) ){
    // Redirect to the login page if not logged in
    echo "
<script>
    window.location = 'login.php';
</script>
";
} else {
    // Get the current system version from the database
    $empresaUpdate = $mysqli->query("SELECT versao FROM empresa");
    $empUpdate = mysqli_fetch_array($empresaUpdate);
    $versaoSistema = preg_replace('/[^a-z0-9\s]/i', '', $empUpdate['versao']);
    $versaoSistemaAtual = $versaoSistema;

    // Fetch the latest version number from a remote text file
    $arquivoUpdate = file('http://myrouter.myrouter.com.br/atualizacao/update.txt');
    $novaVersao  =  $arquivoUpdate[0];

    // Compare the current and latest version numbers
    if($versaoSistemaAtual < $novaVersao ) {
        // Display a message indicating the system is updating
        echo "Atualizando Versão do Sistema";

        // Backup the current system files

        // Remove any existing backup.zip file
        exec('sudo rm -f backup.zip 2');

        // Define the directory to be backed up
        $directory = '/var/www/myrouter';

        // Set up the zip file and array for filenames
        $zipfile = 'backup.zip';
        $filenames = array();

        // Function to recursively collect filenames from the directory
        function browse($dir) {
            global $filenames;
            if ($handle = opendir($dir)) {
                while (false !== ($file = readdir($handle))) {
                    if ($file != "." && $file != ".." && is_file($dir.'/'.$file)) {
                        $filenames[] = $dir.'/'.$file;
                    }
                    else if ($file != "." && $file != ".." && is_dir($dir.'/'.$file)) {
                        browse($dir.'/'.$file);
                    }
                }
                closedir($handle);
            }
            return $filenames;
        }

        // Call the browse function to collect filenames
        browse($directory);

        // Create a new ZipArchive object
        $zip = new ZipArchive();

        // Open the zip file for writing
        if ($zip->open($zipfile, ZIPARCHIVE::CREATE)!==TRUE) {
            exit("cannot open <$zipfile>\n");
        }

        // Add each file to the zip archive
        foreach ($filenames as $filename) {
            echo "Adding " . $filename . "<br/>";
            $zip->addFile($filename,$filename);
        }

        // Close the zip archive
        $zip->close();

        // Move the backup.zip file to a safe location
        exec('sudo mv backup.zip /home/myrouter');

        // Update the system files

        // Remove any existing myrouter.zip file
        shell_exec("sudo rm -f myrouter.zip 2>&1 1> /dev/null");

        // Download the new system files
        shell_exec('sudo wget http://myrouter.myrouter.com.br/instalar/myrouter.zip 2>&1 1> /dev/null');

        // Move the downloaded myrouter.zip file to a safe location
        shell_exec("sudo mv myrouter.zip /home/myrouter");

        // Unzip the new system files
        shell_exec("sudo unzip
