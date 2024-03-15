<?php
session_start();
ob_start();
ini_set("allow_url_fopen", 1);
ini_set("display_errors", 0);
error_reporting(0);
ini_set("track_errors","0"); 
header("Content-Type: text/html; charset=ISO-8859-1", true);
require_once '../config/conexao.class.php';
$con = new conexao(); // instancia classe de conxao
$con->connect(); // abre conexao com o banco

if (!isset($_SESSION['login'])) { // Verifica Login do Usuário
    header('Location: login.php');
    exit;
} else {
    $idbase = $_SESSION['id'];
    if ($idbase) {
        $cslogin = $mysqli->query("SELECT * FROM tecnicos WHERE id = + $idbase");
        $logado = mysqli_fetch_array($cslogin);
    }
}
?>
<!DOCTYPE html>
<html manifest="manifest.webapp">
<head>
    <meta charset="ISO-8859-1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MyRouter ERP</title>
    <link rel="stylesheet" href="styles.css" />
    <link rel="stylesheet" href="css/jquery.mobile-1.3.2.min.css" />
    <script src="js/jquery-1.9.1.min.js"></script>
    <script src="js/jquery.mobile-1.3.2.min.js"></script>
    <script src="fuiprafinal.js"></script>
    <link rel="stylesheet" href="jqm-icon-pack-2.0-original.css" />
    <link rel="apple-touch-icon" href="images/iphone.png" />
    <link rel="shortcut icon" href="images/favicon.ico" >
</head>
<body onload="initMap()" style="margin:0px; border:0px; padding:0px;">
    <div data-role="page" id="home" data-url="home" data-theme="a" data-title="MyRouter ERP">
        <div data-role="header" data-theme="b">
            <h1>MyRouter ERP</h1>
        </div>
        <div data-role="content">
            <a href="#atendimentos" data-role="button" data-icon="calendar" data-inline="false" data-theme="b" id="atendimentosButton">Atendimentos</a>
            <a href="#clientes" data-role="button" data-icon="grid" data-inline="false" data-theme="b" id="clientesButton">Clientes</a>
            <a href="#torres" data-role="button" data-icon="bullets" data-inline="false" data-theme="b" id="torresButton">Torres</a>
            <a href="#" data-role="button" data-icon="gear" data-inline="false" data-theme="b">Recursos do Sistema</a>
            <a href="#" data-role="button" data-icon="file" data-inline="false" data-theme="d">Tarefas</a>
        </div>
        <div data-role="footer" data-position="fixed" data-theme="b">
            <div id="navgroup">
                <div data-role="controlgroup" data-type="horizontal">
                    <a href="#about" data-role="button" data-icon="info2" data-inline="false" data-theme="b">Sobre</a>
                    <a href="sair.php" data-role="button" data-icon="wrench" data-inline="false" data-theme="b">Sair</a>
                </div>
            </div>
        </div>
    </div>
    <div data-role="page" id="about" data-url="about" data-theme="b" data-title="MyRouter ERP">
        <div data-role="header" data-theme="b">
            <h1>MyRouter ERP</h1>
        </div>
        <div data-role="content">
            <p><strong>MyRouter ERP Mobile</strong> is an additional module to the main system that offers management tools for the technicians of your provider.</p>
            <p>In a simplified way, MyRouter ERP Mobile can connect to the towers, manage service orders, customer service, and other resources integrated with Mikrotik.</p>
            <p>For functioning, it is necessary to point your communication IP in the INSTALL menu.</p>
            <a href="#home" data-role="button" data-icon="back" data-inline="false" data-theme="b">Voltar</a>
        </div>
        <div data-role="footer" data-position="fixed" data-theme="b">
            <h5>MyRouter ERP</h5>
        </div>
    </div>
    <div data-role="page" id="clientes" data-url="clientes" data-theme="a" data-title="MyRouter ERP">
        <div data-role="
