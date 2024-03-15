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

// Instantiate the connection class and connect to the database
$con = new conexao();
if (!$con->connect()) {
    die('Failed to connect to the database.');
}

// Check if the 'registro' POST variable is set
if (isset($_POST['registro'])) {

    // Assign the value of the 'chave' POST variable to the $chave variable
    $chave = $_POST['chave'];

    // Check if $chave is not empty
    if (!empty($chave)) {

        // Instantiate the CRUD class and update the 'chave' field where the 'id' is 1
        $crud = new crud('empresa');
        $stmt = $crud->prepare("UPDATE empresa SET chave = ? WHERE id = ?");
        $stmt->bind_param("si", $chave, 1);
        $result = $stmt->execute();

        // Check if the query was successful
        if ($result) {
            // Redirect the user to the Dashboard page
            header("Location: index.php?app=Dashboard");
            exit();
        } else {
            echo "Error: " . $crud->error;
        }

        $stmt->close();
    } else {
        echo "Error: chave is empty.";
    }
}

// Check if output buffering is enabled
if (ob_get_level() == 0) {
    ob_start();
}

// Check if a session has been started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
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
                    - Problema
