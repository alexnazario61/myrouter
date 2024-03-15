<?php
// Start the session
session_start();

// Set the maximum execution time to 0 (unlimited)
set_time_limit(0);

// Enable URL fopen
ini_set("allow_url_fopen", 1);

// Enable displaying errors
ini_set("display_errors", 1);

// Set error reporting level
error_reporting(1);

// Enable tracking errors
ini_set("track_errors","1"); 

// Set the content type to text/html with ISO-8859-1 charset
header("Content-Type: text/html; charset=ISO-8859-1", true);

// Require the config/conexao.php file for database connection settings
require_once("../../config/conexao.php");

// Connect to the database using the settings from config/conexao.php
$conn = mysql_connect("$host", "$usuario", "$senha") or die("Erro na conexao com a base de dados");

// Select the database
$db = mysql_select_db("$banco", $conn) or die("Erro na seleÐ·Ð³o da base de dados");

// Include the functions.php file
include 'functions.php';

// Check if 'acao' and 'id' are set in the GET request for the 'apagar' action
if (isset($_GET['acao']) && $_GET['acao'] == 'apagar') {
    $id = $_GET['id'];

    // Delete the record with the given id from the lc_movimento table
    mysql_query("DELETE FROM lc_movimento WHERE id='$id'");
    echo mysql_error(); // Print any MySQL error

    // Redirect to the same page with the 'ok' parameter set to 2
    header("Location: ?mes=" . $_GET['mes'] . "&ano=" . $_GET['ano'] . "&ok=2");
    exit();
}

// Check if 'acao' and 'id', 'nome' are set in the POST request for the 'editar_cat' action
if (isset($_POST['acao']) && $_POST['acao'] == 'editar_cat') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];

    // Update the record with the given id in the lc_cat table
    mysql_query("UPDATE lc_cat SET nome='$nome' WHERE id='$id'");
    echo mysql_error(); // Print any MySQL error

    // Redirect to the same page with the 'cat_ok' parameter set to 3
    header("Location: ?mes=" . $_GET['mes'] . "&ano=" . $_GET['ano'] . "&cat_ok=3");
    exit();
}

// Check if 'acao' and 'id' are set in the GET request for the 'apagar_cat' action
if (isset($_GET['acao']) && $_GET['acao'] == 'apagar_cat') {
    $id = $_GET['id'];

    // Check if there are any records in the lc_movimento table associated with the given category id
    $qr=mysql_query("SELECT c.id FROM lc_movimento m, lc_cat c WHERE c.id=m.cat && c.id=$id");
    if (mysql_num_rows($qr)>0){
        header("Location: ?mes=" . $_GET['mes'] . "&ano=" . $_GET['ano'] . "&cat_err=1");
        exit();
    }

    // Delete the record with the given id from the lc_cat table
    mysql_query("DELETE FROM lc_cat WHERE id='$id'");
    echo mysql_error(); // Print any MySQL error

    // Redirect to the same page with the 'cat_ok' parameter set to 2
    header("Location: ?mes=" . $_GET['mes'] . "&ano=" . $_GET['ano'] . "&cat_ok=2");
    exit();
}

// Check if 'acao', 'id', 'dia', 'tipo', 'cat', 'descricao', 'valor' are set in the POST request for the 'editar_mov' action
if (isset($_POST['acao']) && $_POST['acao'] == 'editar_mov') {
    $id = $_POST['id'];
    $dia = $_POST['dia'];
    $tipo = $_POST['tipo'];
    $cat = $_POST['cat'];
    $descricao = $_POST['descricao'];
    $valor = str_replace(",", ".", $_POST['valor']);

    // Update the record with the given id in the lc_movimento table
    mysql_query("UPDATE lc_movimento SET dia='$dia', tipo='$tipo', cat='$cat', descricao='$descricao', valor='$valor' WHERE id='$id'");
    echo mysql_error(); // Print any MySQL error

    // Redirect to the same page with the 'ok' parameter set to 3
    header("Location: ?mes=" . $_GET['mes'] . "&ano=" . $_GET['ano'] . "&ok=3");
    exit();
}

// Check if 'acao', 'nome' are set in the POST request for the insert action
if (isset($_POST['acao']) && $_POST['acao'] == 2) {

    $nome = $_POST['nome'];

    // Insert a new record into the lc_cat table
    mysql_query("INSERT INTO lc_cat (nome) values ('$nome')");

    echo mysql_error(); // Print any MySQL error

    // Redirect to the same page with the 'cat_ok' parameter set to 1
    header("Location: ?mes=" . $_GET['mes'] . "&ano=" . $_GET['ano'] . "&cat_ok=1");
    exit();
}

// Check if 'acao', 'data', 'tipo', 'cat', 'descricao', 'valor' are set in the POST request for
