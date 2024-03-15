<?php
header("Content-Type: text/html; charset=ISO-8859-1", true);
require_once 'config/conexao.class.php';
require_once 'config/crud.class.php';
require_once 'config/mikrotik.class.php';
require_once 'config/librouteros/RouterOS.php';
require_once 'functions.php'; // Moved common functions to a separate file

$con = new conexao();
$con->connect();

$idass = filter_var(base64_decode($_GET['id']), FILTER_SANITIZE_NUMBER_INT);
$asse = $mysqli->query("SELECT * FROM assinaturas WHERE id = '$idass'");
$assinatura = mysqli_fetch_array($asse);

$plano = $assinatura['plano'];
$cliente = $assinatura['cliente'];
$pedido = $assinatura['pedido'];
$vencimento = $assinatura['vencimento'];
$ip = $assinatura['ip'];
$mac = $assinatura['mac'];

$pplano = $mysqli->query("SELECT * FROM planos WHERE id = '$plano'");
$pp = mysqli_fetch_array($pplano);

$clliente = $mysqli->query("SELECT * FROM clientes WHERE id = '$cliente'");
$cc = mysqli_fetch_array($clliente);

$servidor = $mysqli->query("SELECT * FROM servidores WHERE id = '$idservidor'");
$mk = mysqli_fetch_array($servidor);

calcularParcelas($cliente, $pedido, $plano, $login, $ip, $mac, $precofn, $qtddiasrenovacaoboleto, $vencimento);

header("Location: index.php?app=Assinaturas&reg=4");

function calcularParcelas($cliente, $pedido, $plano, $login, $ip, $mac, $precofn, $nParcelas, $dataPrimeiraParcela = null) {
    global $mysqli, $qtddiasrenovacaoboleto;

    // Rest of the function remains the same
}


<?php
function limpavariavel($valor)
{
    $valor = trim($valor);
    $valor = str_replace([".", ",", "-", "/", "(", ")"], "", $valor);
    return $valor;
}

// Add other common functions here
