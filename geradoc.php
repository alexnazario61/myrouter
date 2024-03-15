<?php

require_once 'config/conexao.class.php';
require_once 'config/crud.class.php';

$con = new conexao();
$con->connect();

$idass = filter_var(base64_decode($_GET['id']), FILTER_SANITIZE_NUMBER_INT);

$imp = $con->query("SELECT * FROM assinaturas WHERE id = $idass");
$assinatura = $imp->fetch_assoc();

$idcliente = $assinatura['cliente'];
$clientes = $con->query("SELECT * FROM clientes WHERE id = $idcliente");
$cliente = $clientes->fetch_assoc();

$idplano = $assinatura['plano'];
$planos = $con->query("SELECT * FROM planos WHERE id = $idplano");
$planoCli = $planos->fetch_assoc();

$ers = $con->query("SELECT * FROM empresa");
$er = $ers->fetch_assoc();

$enome = htmlspecialchars($er['empresa']);
$ecnpj = htmlspecialchars($er['cnpj']);
$eend = htmlspecialchars($er['endereco']);
$contratocliente = htmlspecialchars($er['contratocliente']);
$ecidade = htmlspecialchars($er['cidade']);
$euf = htmlspecialchars($er['estado']);
$ecep = htmlspecialchars($er['cep']);
$etel = htmlspecialchars($er['tel1']);
$ecel = htmlspecialchars($er['tel2']);

$cnome = htmlspecialchars($cliente['nome']);
$ccpf = htmlspecialchars($cliente['cpf']);
$crg = htmlspecialchars($cliente['rg']);
$cestadocivil = htmlspecialchars($cliente['estadocivil']);
$cdatanascimento = htmlspecialchars($cliente['nascimento']);
$cend = htmlspecialchars($cliente['endereco']);
$cnumero = htmlspecialchars($cliente['numero']);
$ccomplemento = htmlspecialchars($cliente['complemento']);
$cbairro = htmlspecialchars($cliente['bairro']);
$ccidade = htmlspecialchars($cliente['cidade']);
$cuf = htmlspecialchars($cliente['estado']);
$ccep = htmlspecialchars($cliente['cep']);
$ctel = htmlspecialchars($cliente['tel']);
$ccel = htmlspecialchars($cliente['cel']);
$cemail = htmlspecialchars($cliente['email']);

$plano = htmlspecialchars($planoCli['nome']);
$preco = htmlspecialchars($planoCli['preco']);
$data_hoje = date('d-m-Y');

$arquivo = "assets/$contratocliente";

if (!file_exists($arquivo) || !is_readable($arquivo)) {
    die('O arquivo do contrato não existe ou não é legível.');
}

$fp = fopen($arquivo, "r");
$output = fread($fp, filesize($arquivo));
fclose($fp);

$output = str_replace(
    [
        '<<r_nome>>', '<<r_cnpj>>', '<<r_end>>', '<<r_cidade>>', '<<r_estado>>', '<<r_cep>>',
        '<<cliente_nome>>', '<<cliente_cpf>>', '<<cliente_rg>>', '<<cliente_estadocivil>>',
        '<<cliente_end>>', '<<cliente_numero>>', '<<cliente_complemento>>', '<<cliente_bairro>>',
        '<<cliente_cidade>>', '<<cliente_estado>>', '<<cliente_cep>>', '<<cliente_tel>>',
        '<<cliente_cel>>', '<<cliente_email>>', '<<cliente_datanascimento>>', '<<plano_nome>>',
        '<<valor>>', '<<data_hoje>>'
    ],
    [
        $enome, $ecnpj, $eend, $ecidade, $euf, $ecep,
        $cnome, $ccpf, $crg, $cestadocivil, $cend, $cnumero,
        $ccomplemento, $cbairro, $ccidade, $cuf, $ccep, $ctel,
        $ccel, $cemail, $cdatanascimento, $plano, $preco, $data_hoje
    ],
    $output
);

header('Content-Type: application/msword');
header('Content-Disposition: inline, filename=contrato.rtf');

echo $output;
