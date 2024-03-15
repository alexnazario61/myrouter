<?php

// Allow URL fopen, display errors, and set error reporting level
ini_set("allow_url_fopen", 1);
ini_set("display_errors", 1);
error_reporting(1);
ini_set("track_errors","1");

// Include necessary files and classes
require_once 'config/conexao.class.php';
require_once 'config/sws_extensao.php';
require_once 'config/sws_serasa_pefin.php';

// Connect to the database
$con = new conexao();
$con->connect();

// Retrieve the company key information from the database
$cskey = $mysqli->query("SELECT * FROM empresa WHERE id = '1'");
$chavekey = mysqli_fetch_array($cskey);

// Initialize the Credenciais class and set the email and password
$credenciais = new Credenciais();
$credenciais->Email = $chavekey['emailspc'];
$credenciais->Senha = $chavekey['senhaspc'];

// Initialize the Pefin class and set the credentials and document
$pefin = new Pefin();
$pefin->Credenciais = $credenciais;
$pefin->Documento = base64_decode($_GET['id']);

// Connect to the SERASA system and retrieve the Pefin information
$serasa = new SERASA();
$pefin = $serasa->getSerasaPefin($pefin);

// Display the retrieved information in an HTML format
echo "<html><title>Consulta Serasa</title>";
echo "<pre>";

// Display general information
echo "-----------------------   INFORMACOES GERAIS   -----------------------" . PHP_EOL;
echo 'Documento:         ' . $pefin->Documento . PHP_EOL;
echo 'Nome:              ' . $pefin->Nome . PHP_EOL;
echo 'Nome da Mae:           ' . $pefin->NomeMae . PHP_EOL;
echo 'Nome Fantasia:           ' . $pefin->NomeFantasia . PHP_EOL;
echo 'Data Nascimento:   ' . $pefin->DataNascimento . PHP_EOL;
echo 'DataFundacao:   ' . $pefin->DataFundacao . PHP_EOL;
echo 'SituacaoRFB:   ' . $pefin->SituacaoRFB . PHP_EOL;
echo 'SituacaoDescricaoRFB:   ' . $pefin->SituacaoDescricaoRFB . PHP_EOL;
echo 'DataSituacaoRFB:   ' . $pefin->DataSituacaoRFB . PHP_EOL;
echo 'Total Ocorrencias: ' . $pefin->TotalOcorrencias . PHP_EOL;
echo 'Mensagem:          ' . $pefin->Mensagem . PHP_EOL;
echo 'Status:            ' . $pefin->Status . PHP_EOL;

// Display alert document information
echo "\n\n\n";
echo "----------------------------------------------------------------------" . PHP_EOL;
echo "Alerta Documentos" . PHP_EOL;
echo "----------------------------------------------------------------------" . PHP_EOL;
foreach ($pefin->AlertaDocumentos as $AlertaDocumentos)
{
	echo 'Mensagem  : ' . $AlertaDocumentos->Mensagem . PHP_EOL;
	echo 'DDD/Fone 1: ' . $AlertaDocumentos->DDD1 . "-" . $AlertaDocumentos->Fone1 . PHP_EOL;
	echo 'DDD/Fone 2: ' . $AlertaDocumentos->DDD2 . "-" . $AlertaDocumentos->Fone2 . PHP_EOL;
	echo 'DDD/Fone 3: ' . $AlertaDocumentos->DDD3 . "-" . $AlertaDocumentos->Fone3 . PHP_EOL;
}

// Display financial pendencies
echo "\n\n\n";
echo "----------------------------------------------------------------------" . PHP_EOL;
echo "Pendencias Financeiras" . PHP_EOL;
echo "----------------------------------------------------------------------" . PHP_EOL;
echo "<table border='0' width='100%'>";
echo "<tr bgcolor='#eeeeee' cellspacing='0' height='30'>";
echo "<td>Data Ocorrencia</td>";
echo "<td>Modalidade</td>";
echo "<td>Avalista</td>";
echo "<td>Valor</td>";
echo "<td>Contrato</td>";
echo "<td>Sigla</td>";
echo "</tr>";
foreach ($pefin->PendenciasFinanceiras as $PendenciasFinanceiras)
{
	echo '<tr>';
	echo '<td>' . $PendenciasFinanceiras->DataOcorrencia . '</td>';
	echo '<td>' . $PendenciasFinanceiras->Modalidade . '</td>';
	echo '<td>' . $PendenciasFinanceiras->Avalista . '</td>';
	echo '<td>' . $PendenciasFinanceiras->Valor . '</td>';
	echo '<td>' . $PendenciasFinanceiras->Contrato . '</td>';
	echo '<td>' . $PendenciasFinanceiras->Sigla . '</td>';
	echo '</tr>';
}
echo "</table>";

// Display retail pendencies
echo "\n\n\n";
echo "----------------------------------------------------------------------" . PHP_EOL;
echo "Pendencias Varejo" . PHP_EOL;
echo "----------------------------------------------------------------------" . PHP_EOL;
echo "<table border='0' width='100%'>";
echo "<tr bgcolor='#eeeeee' cellspacing='0' height='30'>";
echo "<td>Codigo Compensacao Banco</td>";
echo "<td>Numero Agencia
