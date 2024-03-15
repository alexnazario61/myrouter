<?php
// Start the session
session_start();

// Disable output buffering
@ini_set('output_buffering', 'off');

// Enable error reporting with the highest level
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define the configuration file path
$configFilePath = 'config/conexao.php';

// Check if the configuration file exists
if (!file_exists($configFilePath)) {
    // Redirect to the installation page if the configuration file does not exist
    header("Location: setup/instalar.php");
    exit;
}

// Require necessary configuration and class files
require_once 'config/conexao.class.php';
require_once 'config/crud.class.php';
require_once 'config/mikrotik.class.php';
require_once 'config/librouteros/RouterOS.php';
require_once 'config/ubnt_class.php';

// Instantiate the database connection class
$database = new conexao();

// Connect to the database
$connection = $database->connect();

// Check if the user is logged in and has the correct permissions
if (!isset($_SESSION['login']) || $_SESSION['nivel'] == "0") {
    // Redirect to the login page if the user is not logged in or has no permissions
    if ($_SESSION['nivel'] == "0") {
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
    $idBase = (int) $_SESSION['id'];
    $csLoginQuery = $connection->prepare("SELECT * FROM usuarios WHERE id = ?");
    $csLoginQuery->bind_param("i", $idBase);
    $csLoginQuery->execute();
    $csLoginResult = $csLoginQuery->get_result();
    $logado = $csLoginResult->fetch_assoc();
    $_SESSION['empresa'] = 1;
    $idPUser = (int) $logado['id'];
    $gperQuery = $connection->prepare("SELECT * FROM permissoes WHERE codigo = ?");
    $gperQuery->bind_param("i", $idPUser);
    $gperQuery->execute();
    $gperResult = $gperQuery->get_result();
    $permissao = $gperResult->fetch_assoc();

    // Include the navigation file
    include("app/nav.php");

    // Include the main menu file
    include("app/menu.php");

    // Include the content based on the user's request
    $app = isset($_GET['app']) ? $_GET['app'] : 'app';
    switch ($app) {
        // ... (Include comments for each case as needed)
    }
}
