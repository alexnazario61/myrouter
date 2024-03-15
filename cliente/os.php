<?php
// Start the session
session_start();

// Start output buffering
ob_start();

// Set the content type to text/html with ISO-8859-1 charset
header("Content-Type: text/html; charset=ISO-8859-1", true);

// Require the necessary classes
require_once '../config/conexao.class.php';
require_once '../config/crud.class.php';
require_once '../config/mikrotik.class.php';

// Instantiate the database connection class
$con = new conexao();

// Connect to the database
$con->connect();

// Check if the user is logged in
if (!isset($_SESSION['login'])) {
    // If not, redirect to the login page
    echo "
<script>
   	window.location = 'login.php';
    </script>
";
} else { 
    
    // Get the user's ID from the session
    $idbase = $_SESSION['id'];  
    
    // If the user's ID is set
    if($idbase){ 
        // Query the database to get the user's details
        $cslogin = $mysqli->query("SELECT * FROM clientes WHERE id = + $idbase");
        // Fetch the user's details into an associative array
        $logado = mysqli_fetch_array($cslogin);
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Set the character encoding to ISO-8859-1 -->
    <meta charset="ISO-8859-1">
    <!-- Set the viewport to be responsive on different devices -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Set the page description and author -->
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Set the page icon -->
    <link rel="icon" href="favicon.ico">

    <!-- Set the page title -->
    <title>Painel do Cliente, Bem vindo <?php echo $logado['nome']; ?></title>

    <!-- Include the Font Awesome CSS file -->
    <link href="../assets/css/font-awesome.css" rel="stylesheet" type="text/css">

    <!-- Include the Bootstrap core CSS file -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Include the custom CSS file for this template -->
    <link href="dashboard.css" rel="stylesheet">

    <!-- Include the HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!-- Include the navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <!-- Button for collapsing the navbar on smaller screens -->
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!-- Branding for the navbar -->
          <a class="navbar-brand" href="#">MyRouter ERP</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <!-- Navbar items for the right side of the navbar -->
          <ul class="nav navbar-nav navbar-right">
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="os.php">Ordem de Serviço</a></li>
            <li><a href="dados.php">Meus Dados</a></li>
            <li><a href="sair.php">Sair</a></li>
          </ul>
          
        </div>
      </div>
    </nav>

    <!-- Include the container -->
    <div class="container-fluid">
      <div class="row">
        <!-- Include the sidebar -->
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li><a href="index.php">Faturas </a></li>
            <li class="active"><a href="#">Ordem de Serviço <span class="sr-only">(current)</span></a></li>
            <li><a href="dados.php">Meus Dados</a></li>
            <li><a href="sair.php">Sair</a></li>
          </ul>
          
        </div>
        <!-- Include the main content area -->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Ordem de Serviço</h1>
          <!-- Display a welcome message for the user -->
          Bem vindo <?php echo $logado['nome']; ?> <?php echo $logado['cpf']; ?>

          <!-- Include a button for creating a new ticket -->
          <a href="novoticket.php" style="float:right;" class="btn btn-info">ABRIR CHAMADO</a><br>
          
          
                <!-- Include a container for displaying the
