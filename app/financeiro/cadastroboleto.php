<?php

$idpuser = $logado['nome']; // pegar nome do login da sessão

/////////////////////////// FUNÇÕES GRIFF SISTEMAS /////////////////
function limpavariavel($valor)
{
    $valor = trim($valor);
    $valor = str_replace(".", "", $valor);
    $valor = str_replace(",", "", $valor);
    $valor = str_replace("-", "", $valor);
    $valor = str_replace("/", "", $valor);
    $valor = str_replace("(", "", $valor);
    $valor = str_replace(")", "", $valor);
    return $valor;
}
//////////////// fim da função griff ///////////////

$idempresa = $_SESSION['empresa'];
@$getId = base64_decode($_GET['id']);
if (@$getId) {
    $alterar = $mysqli->query("SELECT * FROM financeiro WHERE id = + $getId");
    $campo = mysqli_fetch_array($alterar);
}

if (isset($_POST['cadastrar'])) {
    $nfatura = $_POST['nfatura'];
    $cliente = $_POST['cliente'];

    //AQUI AGENTE CONVERTE A DATA PARA O FORMATO 0000-00-00
    $data = $_POST['vencimento'];
    $data_conv = substr($data, 6, 7) . '-' . substr($data, 3, 2) . '-' . substr($data, 0, 2);
    $vencimento = $data_conv;
    $cadastro = date('Y-m-d');
    //FIM DA CONVERSÃO

    //INICIO - nosso numero sequencial
    $qr_numero = $mysqli->query("SELECT * FROM financeiro ORDER BY id DESC");
    $row_numero = mysqli_fetch_array($qr_numero);
    $numero = str_pad($row_numero['id'], 9, 0, STR_PAD_LEFT);// tamanho 9
    // FIM - nosso numero sequencial
    $nossonumero = $numero;

    $dia = date('d', strtotime($vencimento));
    $mes = date('m', strtotime($vencimento));
    $ano = date('Y', strtotime($vencimento));
    $mes1 = date('n', strtotime($vencimento));

    $bservidor = $mysqli->query("SELECT * FROM assinaturas WHERE id = '$cliente'");
    $bservidor_row = mysqli_fetch_array($bservidor);
    $cliente = $bservidor_row['cliente'];
    $plano = $bservidor_row['plano'];
    $pedido = $bservidor_row['pedido'];
    $login = $bservidor_row['login'];
    $valor = $_POST['valor'];
    $descricao = $_POST['descricao'];
    $mesparcela = $_POST['mesparcela'];

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    /*		                    CODIGOS ELSON - CODIGO PARA EMISSAO PELO GERENCIA NET                   /                           /*
    /							                                                                        */
    ////////////////////////////////// /////////////////////////////////////////////////////////////////
    if ($confere['banco'] == "10") {
        $url = "https://integracao.gerencianet.com.br/xml/boleto/emite/xml";

        // SELECIONA A TABELA "empresa" E PEGA O TOKEM
        $sql = $mysqli->query("SELECT token_gnet FROM empresa") or die(mysqli_error($mysqli));
        $t = mysqli_fetch_array($sql);
        $token = $t['token_gnet'];

        // PEGA OS DADOS DO CLIENTE PARA O GERENCIANET
        $cli = $mysqli->query("SELECT * FROM clientes WHERE id='$cliente'") or die(mysqli_error($mysqli));
        $verCliente = mysqli_fetch_array($cli);
        $NomeCliente = $verCliente['nome'];
        $CpfCnpj = limpavariavel($verCliente['cpf']);
        $cel = limpavariavel($verCliente['cel']);
        $email = $verCliente['email'];
        $cep = limpavariavel($verCliente['cep']);
        $EnderecoCliente = $verCliente['endereco'];
        $NumeroCliente = $verCliente['numero'];
        $ComplementoCliente = $verCliente['complemento'];
        $BairroCliente = $verCliente['bairro'];
        $Uf = $verCliente['estado'];
        $CidadeCliente = $verCliente['cidade'];
        $valorG = limpavariavel($_POST['valor']);
        $dataG = $_POST['vencimento'];
        $retorno = intval($nossonumero);

        // GERANDO O XML PARA O GERENCIA NET
        $xml = "<?xml version='1.0' encoding='utf-8'?>
    <boleto>
    	<token>$token</token>
    	<clientes>
    		<cliente>
