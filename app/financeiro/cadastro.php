<?php

// Include the base64 decoding function for the GET request
include 'base64_decode.php';

// Define the $idpuser variable to store the user's name from the session
session_start();
$idpuser = $_SESSION['nome'];

// Decode the GET request and assign it to the $getId variable
$getId = isset($_GET['id']) ? base64_decode($_GET['id']) : null;

// Query the database to retrieve the record with the matching id
if ($getId) {
    $alterar = $mysqli->query("SELECT * FROM financeiro WHERE id = $getId");
    $campo = mysqli_fetch_array($alterar);
}

// Check if the POST request is set and the 'editar' button is clicked
if (isset($_POST['editar'])) {
    // Assign the submitted form data to variables
    $valor = $_POST['valor'];
    $vencimento = $_POST['vencimento'];
    $motivo = $_POST['motivo'];
    $descricao = $_POST['descricao'];
    $faturaid = $_POST['faturaid'];
    $situacao = $_POST['situacao'];

    // Parse the vencimento date into day, month, and year components
    $prd = explode("/", $vencimento);
    $dia = $prd[0];
    $mes = $prd[1];
    $ano = $prd[2];

    // Combine the date components into a single string
    $vencatual = "$ano-$mes-$dia";

    // Instantiate the crud class and update the record in the financeiro table
    $crud = new crud('financeiro');
    $crud->atualizar("situacao='$situacao',valor='$valor',motivo='$motivo',descricao='$descricao',vencimento='$vencatual',dia='$dia',mes='$mes',ano='$ano',admin='$idpuser'", "id='$faturaid'");

    // If the situation is 'P', perform additional operations
    if ($situacao == 'P') {
        // Define a function to replace the leading zeros in the day and month components
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

        // Get the current day, month, and year
        $diannc = date('d');
        $mesnnc = date('m');
        $fndia = fndata($diannc);
        $fnmes = fndata($mesnnc);
        $fnano = date('Y');

        // Assign the submitted form data to variables
        $pedboleto = $_POST['boletoid'];

        // Instantiate the crud class and insert a new record into the lc_movimento table
        $crud = new crud('lc_movimento');
        $crud->inserir("tipo,dia,mes,ano,cat,descricao,valor,pedido,admin", "1,'$fndia','$fnmes','$fnano','1','Recebimento de Mensalidade - Fatura:# $pedboleto','$valor','$faturaid','$idpuser'");

        // Query the database to retrieve the record with the matching pedido
        $sxd = $mysqli->query("SELECT * FROM financeiro WHERE id = $faturaid");
        $daa = mysqli_fetch_array($sxd);

        // Assign the retrieved record data to variables
        $codass = $daa['pedido'];
        $ccss = $mysqli->query("SELECT * FROM assinaturas WHERE pedido = '$codass'");
        $cliente = mysqli_fetch_array($ccss);

        // Assign the retrieved record data to variables
        $idassn = $cliente['id'];

        // Instantiate the crud class and update the record in the assinaturas table
        $crud = new crud('assinaturas');
        $crud->atualizar("status='S'", "id='$idassn'");
    }

    // If the situation is 'B' or 'C', perform additional operations
    if ($situacao == 'B' || $situacao == 'C') {
        // Query the database to retrieve the record with the matching pedido
        $sxd = $mysqli->query("SELECT * FROM financeiro WHERE id = $faturaid");
        $daa = mysqli_fetch_array($sxd);

        // Assign the retrieved record data to variables
        $codass = $daa['pedido'];
        $ccss = $mysqli->query("SELECT * FROM assinaturas WHERE pedido = '$codass'");
        $cliente = mysqli_fetch_array($ccss);

        // Assign the retrieved record data to variables
        $idassn = $cliente['id'];

        // Instantiate the crud class and update the record in the assinaturas table
        $crud = new crud('assinaturas');
        $crud->atualizar("status='$situacao'", "id='$idassn'");
    }
}
?>
