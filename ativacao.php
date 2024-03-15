<?php
// Start a new session
session_start();

// Start output buffering
ob_start();

// Set the content type to ISO-8859-1
header("Content-Type: text/html; charset=ISO-8859-1", true);

// Require the necessary classes and connect to the database
require_once 'config/conexao.class.php';
require_once 'config/crud.class.php';
require_once 'config/mikrotik.class.php';
$con = new conexao(); // instantiate the connection class
$con->connect(); // connect to the database

// Check if the 'registro' POST variable is set
if(isset ($_POST['registro'])){

    // Assign the 'chave' and 'cnpj' POST variables to their respective variables
    $chave = $_POST['chave'];
    $cnpj   = $_POST['cnpj'];

    // Instantiate the CRUD class and update the 'empresa' table with the new 'chave' and 'cnpj' values
    $crud = new crud('empresa'); // instantiate the CRUD class and pass the table name as a parameter
    $crud->atualizar("chave='$chave',cnpj='$cnpj'", "id='1'");

    // Redirect the user to the dashboard
    header("Location: index.php?app=Dashboard");
}
?>
<!DOCTYPE html>

<head>
<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
<meta name="keywords" content="">
<meta name="author" content="MyRouter ERP">
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>MyRouter ERP | Sistema Não Registrado</title>
<link href="assets/css/styles.css" rel="stylesheet" type="text/css">

<link id="demo-styles" href="assets/css/styles-defaults.css" rel="stylesheet" type="text/css">

<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
<script type="text/javascript" src="assets/js/vendors/modernizr/modernizr.custom.js"></script>
</head>

<body>
<div class="standalone-page-wrapper"> 
  

  <div class="error-top-block">
    <div class="error-top-block-image"> <img src="assets/images/error-robot.png" alt="Ooops!" /> </div>
  </div>

  <div class="error-bottom-block">
    <div class="col-md-6 col-md-offset-3 error-description">
      <div class="error-code">BLOQUEADO</div>
      <div class="todo">
        <h4>Por que isso ?</h4>
        Desculpe o nosso sistema não reconheceu sua chave por varios motivos.<br>
        - Nova atualização ou instalação do programa.<br>
        - Copia sem autorização.<br>
        - Bloqueio da mensalidade. <br>
        * Entre em contato com nosso suporte; <b>contato@myrouter.com.br</b>

        <!-- Display a form to the user to enter their 'chave' and 'cnpj' values -->
        <form action="" method="POST">
          <div class="input-group">
            <input placeholder="CHAVE" name="chave" type="text" class="form-control">
            <span class="input-group-btn"></span>

            <input placeholder="CNPJ" name="cnpj" type="text" class="form-control">
            <span class="input-group-btn"></span>

            <input type="submit" class="btn btn-default" name="registro" value="OK!">
          </div>
        </form>
      </div>
      <div class="copyrights"> MyRouter ERP &copy; <?php echo date('Y'); ?> </div>
    </div>
  </div>

</div>

