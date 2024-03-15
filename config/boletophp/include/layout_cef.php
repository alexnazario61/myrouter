<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .logo {
            width: 150px;
            height: auto;
        }

        .bc {
            font-weight: bold;
        }

        .lt {
            font-size: 12px;
        }

        .spacer {
            height: 20px;
        }

        .linha-digitavel {
            font-size: 10px;
            font-family: Courier, monospace;
        }

        .instructions {
            font-size: 10px;
        }
    </style>
</head>
<body>

<?php
// Database connection
$db = new mysqli('localhost', 'username', 'password', 'database');

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Fetch company data
$company_query = "SELECT * FROM empresa WHERE id = 1";
$company_result = $db->query($company_query);
$company = $company_result->fetch_assoc();

// Fetch boleto data
$boleto_query = "SELECT * FROM boleto WHERE id = 1";
$boleto_result = $db->query($boleto_query);
$boleto = $boleto_result->fetch_assoc();

// Close database connection
$db->close();
?>

<table>
    <tr>
        <td colspan="4" class="center">
            <img class="logo" src="assets/images/<?php echo $company['foto']; ?>" alt="Company logo">
        </td>
    </tr>
    <tr>
        <th colspan="4" class="bc">BOLETO PARA PAGAMENTO</th>
    </tr>
    <tr>
        <th>Cedente:</th>
        <td colspan="3"><?php echo $boleto['cedente']; ?></td>
    </tr>
    <tr>
        <th>Nosso Número:</th>
        <td colspan="3"><?php echo $boleto['nosso_numero']; ?></td>
    </tr>
    <tr>
        <th>Vencimento:</th>
        <td colspan="3"><?php echo $boleto['data_vencimento']; ?></td>
    </tr>
    <tr>
        <th>Valor:</th>
        <td colspan="3" class="right"><?php echo number_format($boleto['valor_boleto'], 2, ',', '.'); ?></td>
    </tr>
    <tr>
        <th colspan="4" class="lt">Linha Digitável: <?php echo $boleto['linha_digitavel']; ?></th>
    </tr>
    <tr>
        <td colspan="4" class="spacer"></td>
    </tr>
    <tr>
        <th colspan="2">Sacado:</th>
        <td colspan="2"><?php echo $boleto['sacado']; ?></td>
    </tr>
    <tr>
        <th colspan="2">Endereço:</th>
        <td colspan="2"><?php echo $boleto['endereco']; ?></td>
    </tr>
    <tr>
        <th colspan="2">Cidade / UF:</th>
        <td colspan="2"><?php echo $boleto['cidade_uf']; ?></td>
    </tr>
    <tr>
        <td colspan="4" class="spacer"></td>
    </tr>
    <tr>
        <th colspan="4" class="bc">INSTRUÇÕES PARA ENCERRAMENTO DO SACADO</th>
    </tr>
    <tr>
        <td colspan="4" class="instructions">
            <?php echo $boleto['instrucoes']; ?>
        </td>
    </tr>
    <tr>
        <td colspan="4" class="spacer"></td>
    </tr>
    <tr>
        <th colspan="4" class="bc">FORMAS DE PAGAMENTO</th>
    </tr>
    <tr>
        <td colspan="4">
            <img src="config/boletophp/imagens/codigo_barras.png" alt="Código de barras" class="linha-digitavel">
        </td>
    </tr>
    <tr>
        <td colspan="4" class="spacer"></td>
    </tr>
    <tr>
        <th colspan="4" class="bc">VENCIMENTO E VALOR</th>
    </tr>
    <tr>
        <td colspan="2">Vencimento:</td>
        <td colspan="2" class="right"><?php echo $boleto['data_vencimento']; ?></td>
    </tr>
    <tr>
        <td colspan="2">Valor:</td>
        <td colspan="2" class="right"><?php echo number_format($boleto['valor_boleto'], 2
