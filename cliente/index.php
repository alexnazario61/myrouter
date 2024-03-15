<?php
// Start the session
session_start();

// Start output buffering
ob_start();

// Set the content type to text/html with ISO-8859-1 charset
header("Content-Type: text/html; charset=ISO-8859-1", true);

// Require the necessary files
require_once '../config/conexao.class.php';
require_once '../config/crud.class.php';
require_once '../config/mikrotik.class.php';

// Create a new instance of the conexao class and connect to the database
$con = new conexao(); // instancia classe de conxao
$con->connect(); // abre conexao com o banco

// Query the empresa table and fetch the result into $campoEmpresa
$empresa = $mysqli->query("SELECT * FROM empresa");
$campoEmpresa = mysqli_fetch_array($empresa);

// Check if the user is logged in
if (!isset($_SESSION['login'])) { // Verifica Login do Usuário
    // If not, redirect to the login page
    echo "
<script>
   	window.location = 'login.php';
    </script>
";
} else { // If the user is logged in
    
    // Get the user's ID from the session
    $idbase = $_SESSION['id'];  
    
    // Query the clientes table to get the user's data
    if($idbase){ 
        $cslogin = $mysqli->query("SELECT * FROM clientes WHERE id = + $idbase");
        $logado = mysqli_fetch_array($cslogin);
    }
    
    // Define the link to the monitor page with the user's CPF
    $link_monitor = "monitor.php?cpf=".$logado['cpf'];
    
    // Start the HTML document
    ?>

    <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="ISO-8859-1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../favicon.ico">

    <title>Painel do Cliente, Bem vindo <?php echo $logado['nome']; ?></title>
    <link href="../assets/css/font-awesome.css" rel="stylesheet" type="text/css">
    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">

    <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><?php echo $campoEmpresa['empresa'];?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="os.php">Ordem de Serviço</a></li>
            <li><a href="dados.php">Meus Dados</a></li>
              <li><a href=<?php echo $link_monitor  ?> >Monitoramento</a></li>
              <li><a href="sair.php">Sair</a></li>
          </ul>
          
        </div>
      </div>
    </nav>


    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="#">Faturas <span class="sr-only">(current)</span></a></li>
            <li><a href="os.php">Ordem de Serviço</a></li>
            <li><a href="dados.php">Meus Dados</a></li>
              <li><a href=<?php echo $link_monitor  ?>>Monitoramento</a></li>
            <li><a href="sair.php">Sair</a></li>
          </ul>
          
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Dashboard</h1>
	  <!-- Display a welcome message with the user's name and CPF -->
	  Bem vindo <?php echo $logado['n
