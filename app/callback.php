<?php

// Import necessary classes and configurations
include "../config/conexao.php";
require_once 'config/conexao.class.php';
require_once 'config/crud.class.php';
require_once 'config/mikrotik.class.php';
require_once 'config/librouteros/RouterOS.php';

// Check if XML data is set in the POST request
if (isset($_POST['xml'])) {
    // Transform XML string into an object
    $objXml = simplexml_load_string($_POST['xml']);

    // Extract necessary data from the XML object
    $nome = $objXml->cliente->cliente;
    $chave = $objXml->cobranca->chave;
    $retorno = $objXml->cobranca->retorno;
    $numeroPedido = $objXml->cobranca->documento;
    $valorPago = $objXml->cobranca->valorPago;
    $pag = $objXml->cobranca->pag;

    // Initialize an array with the XML object
    $produtos = array($objXml);

    // Loop through each item in the XML object
    foreach ($objXml->cobranca as $item) {
        // Extract data and process the payment status
        $retorno = $item->retorno;
        $chave = $item->chave;
        $status = strtoupper($item->status);

        if ($status == "I") {
            $status = "N";
        }

        $total = $item->total;
        $data = date('Y-m-d');

        // Update the payment status and amount in the database
        $sql = $mysqli->query("UPDATE financeiro SET pagamento_fn='$data', situacao='$status', recebido='$total' WHERE chave='$chave'");

        // Function to format the day, month, and year values
        function fndata($string)
        {
            $string = str_replace('01', '1', $string);
            $string = str_replace('02', '2', $string);
            $string = str_replace('03', '3', $string);
            $string = str_replace('04', '4', $string);
            $string = str_replace('05', '5', $string);
            $string = str_replace('06', '6', $string);
            $string = str_replace('07', '7', $string);
            $string = str_replace('08', '8', $string);
            $string = str_replace('09', '9', $string);
            return $string;
        }

        // Format the day, month, and year values
        $diannc = date('d');
        $mesnnc = date('m');
        $fndia = fndata($diannc);
        $fnmes = fndata($mesnnc);
        $fnano = date('Y');

        // Format the paid value
        $n1 = substr($total, 0, -2);
        $n2 = substr($total, -2);
        $vpago = $n1 . '.' . $n2;

        // Check if the payment already exists in the database
        $lcm = $mysqli->query("SELECT * FROM financeiro WHERE chave='$chave'");
        $row = mysqli_num_rows($lcm);

        // If the payment exists, insert a new record in the 'lc_movimento' table
        if ($row > 0) {
            $crud = new crud('lc_movimento'); // Pass the table name as a parameter
            $crud->inserir("tipo,dia,mes,ano,cat,descricao,valor,pedido", "'1','$fndia','$fnmes','$fnano','1','Recebimento de Mensalidade Via GerenciaNet- Fatura:# $pedboleto','$vpago','$pedidofin'");
        }

        // Get client details from the 'assinaturas' table
        $ccss = $mysqli->query("SELECT * FROM assinaturas WHERE pedido = '$pedidofin'");
        $cliente = mysqli_fetch_array($ccss);

        // Update the client's subscription status
        $idassn = $cliente['id'];
        $crud = new crud('assinaturas');
        $crud->atualizar("status='S
