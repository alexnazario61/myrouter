<?php
// Database connection class
class Database {
    private $host = "localhost";
    private $user = "username";
    private $password = "password";
    private $dbname = "database_name";

    public function connect() {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $pdo = new PDO($dsn, $this->user, $this->password);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }
}

// Create an instance of the Database class
$db = new Database();
$pdo = $db->connect();

// Function to set the $mesatual variable
function setMesAtual($mes) {
    switch ($mes) {
        case '01':
            $mesatual = "Janeiro";
            break;
        case '02':
            $mesatual = "Fevereiro";
            break;
        case '03':
            $mesatual = "Março";
            break;
        case '04':
            $mesatual = "Abril";
            break;
        case '05':
            $mesatual = "Maio";
            break;
        case '06':
            $mesatual = "Junho";
            break;
        case '07':
            $mesatual = "Julho";
            break;
        case '08':
            $mesatual = "Agosto";
            break;
        case '09':
            $mesatual = "Setembro";
            break;
        case '10':
            $mesatual = "Outubro";
            break;
        case '11':
            $mesatual = "Novembro";
            break;
        case '12':
            $mesatual = "Dezembro";
            break;
        default:
            $mesatual = "";
            break;
    }
    return $mesatual;
}

// Set the $mesatual variable
$mesatual = "";
if (isset($_GET['ftmes']) && ctype_digit($_GET['ftmes'])) {
    $mesatual = setMesAtual($_GET['ftmes']);
} else if (date('m') !== false) {
    $mesatual = setMesAtual(date('m'));
}

// Default page title
$page_title = "MyRouter ERP";

// Page title based on the relatorio GET parameter
switch ($_GET['relatorio'] ?? '') {
    case "relatorio_ativos":
        $page_title = "Faturas Abertas Mês " . $mesatual;
        break;
    case "relatorio_pagos":
        $page_title = "Faturas Pagas Mês " . $mesatual;
        break;
    case "relatorio_bloqueios":
        $page_title = "Faturas Bloqueadas Mês " . $mesatual;
        break;
    case "relatorio_clientesassinantes":
        $page_title = "Clientes Assinantes";
        break;
    case "relatorio_financeiromes":
        $page_title = "Movimento Financeiro Mês " . $mesatual;
        break;
    case "relatorio_retornos":
        $page_title = "Retorno Bancário";
        break;
    case "relatorio_planosvclientes":
        $page_title = "Planos x Assinaturas";
        break;
    case "clientexplanos":
        $page_title = "Clientes x Planos";
        break;
    case "atvxplanos":
        $page_title = "Clientes Ativos x Planos";
        break;
    case "blockxplanos":
        $page_title = "Clientes Bloqueados x Planos";
        break;
    case "relatorio_fatura_data":
        $page_title = "Fatura por Data e Situação";
        break;
    case "log_conexao":
        $page_title = "Log de Conexão";
        break;
    case "relatorio_comodato":
        $page_title = "Comodato";
        break;
    case "relatorio_clientesassinantesbloqueio":
        $page_title = "Clientes Assinantes Bloqueados";
        break;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
</head>
<body>
    <!-- Your existing HTML content goes here -->
</body>
</html>
