<?php
// Start the session
session_start();

// Enable output buffering
ob_start();

// Set configurations for error reporting and file handling
ini_set("allow_url_fopen", 1);
ini_set("display_errors", 1);
error_reporting(1);
ini_set("track_errors","1");

// Define the configuration file path
$filename = 'config/conexao.php';

// Check if the configuration file exists
if (!file_exists($filename)) {
    // Redirect to the installation page if the configuration file does not exist
    header("Location: setup/instalar.php");
}

// Set the content type and charset
header("Content-Type: text/html; charset=ISO-8859-1", true);

// Require necessary configuration and class files
require_once 'config/conexao.class.php';
require_once 'config/crud.class.php';
require_once 'config/mikrotik.class.php';
require_once 'config/librouteros/RouterOS.php';
require_once 'config/ubnt_class.php';

// Instantiate the database connection class
$con = new conexao();

// Connect to the database
$con->connect();

// Check if the user is logged in and has the correct permissions
if(!isset($_SESSION['login']) or $_SESSION['nivel'] == "0"){
    // Redirect to the login page if the user is not logged in or has no permissions
    if($_SESSION['nivel'] == "0"){
        echo "
        <script>
            window.location = 'cliente/index.php';
        </script>
        ";
    }
    echo "
    <script>
        window.location = 'login.php';
    </script>
    ";
} else {
    // Set necessary session variables
    $idbase = $_SESSION['id'];
    $cslogin = $mysqli->query("SELECT * FROM usuarios WHERE id = + $idbase");
    $logado = mysqli_fetch_array($cslogin);
    $_SESSION['empresa'] = 1;
    $idpuser = $logado['id'];
    $gper = $mysqli->query("SELECT * FROM permissoes WHERE codigo = '$idpuser'");
    $permissao = mysqli_fetch_array($gper);

    // Include the navigation file
    include("app/nav.php");

    // Include the main menu file
    include("app/menu.php");

    // Include the content based on the user's request
    $app = (isset ( $_GET ['app'] ) ? $_GET ['app'] : 'app');
    switch ($app) {
        // ... (Include comments for each case as needed)
    }
}
?>
