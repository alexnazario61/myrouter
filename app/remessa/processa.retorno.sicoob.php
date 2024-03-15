<?php
// Start the session and output buffering
session_start();
ob_start();

// Include necessary classes and files
include 'vendor/CnabPHP/autoloader.php';
require_once 'config/conexao.class.php';
require_once 'config/crud.class.php';
require_once 'config/mikrotik.class.php';

// Initialize variables and settings
$idpuser = $logado['nome']; // Get the user's name from the session
ini_set("allow_url_fopen", 1);
ini_set("display_errors", 1);
error_reporting(E_ALL);
ini_set("track_errors", "1");
header("Content-Type: text/html; charset=ISO-8859-1", true);

// Connect to the database
$con = new conexao();
$con->connect();

// Read the contents of the uploaded file
$file = file_get_contents($_FILES['arquivo']['tmp_name']);

// Define allowed file extensions
$_UP['extensoes'] = array('ret', 'RET');

// Get the file type
$tiporet = $_FILES['arquivo']['type'];

// Get the file extension
$extensao = strtolower(@end(explode('.', $_FILES['arquivo']['name'])));

// Check if the file extension is allowed
if (array_search($extensao, $_UP['extensoes']) === false) {
    header("Location: index.php?app=Retorno&reg=2");
    exit;
}

// Parse the bank slip file
$arquivo = new CnabPHP\Retorno($file);

// Process each record with codigo_movimento = 6
$registros = $arquivo->getRegistros();
foreach ($registros as $registro) {
    // Extract relevant information from the record
    $t_cod_banco = $registro->codigo_banco;
    $t_id_titulo_banco = $registro->nosso_numero;
    $t_cod_carteira = $registro->carteira;
    $t_num_doc_cob = $registro->seu_numero;
    $t_v_nominal = $registro->valor;
    $t_cod_ag_receb = $registro->agencia;
    $t_dv_ag_receb = $registro->agencia_dv;
    $t_id_titulo_empresa = $registro->seu_numero;
    $u_juros_multa = $registro->vlr_juros_multa;
    $u_desconto = $registro->vlr_desconto;
    $u_abatimento = $registro->vlr_abatimento;
    $u_iof = $registro->vlr_iof;
    $u_v_pago = $registro->vlr_pago;
    $t_dt_vencimento = $registro->data_vencimento;
    $u_dt_ocorencia = $registro->data_ocorrencia;
    $u_dt_efetivacao = $registro->data_ocorrencia;

    // Perform various operations based on the record data
    // ...
}

// Redirect to another page
header("Location: index.php?app=Retorno&reg=1");
?>
