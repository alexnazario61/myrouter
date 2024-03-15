<?php

// Define a whitelist for the 'tipo' parameter
$tipoWhitelist = [1, 2, 3, 4, 5, 6, 7, 8, 'assinaturas'];

// Check if the 'key' parameter is set and not empty
if (isset($_GET['key']) and $_GET['key']) {
    // Set default values for 'limite' and 'formato' if they are not set
    $limite = isset($_GET['limite']) ? intval($_GET['limite']) : 10; //10 is the default
    $formato = (isset($_GET['formato']) and in_array(strtolower($_GET['formato']), ['json', 'xml'])) ? strtolower($_GET['formato']) : 'xml'; //xml is the default
    $tipo = in_array($_GET['tipo'], $tipoWhitelist) ? $_GET['tipo'] : 'assinaturas';

    // Include the database connection file
    require_once("config/conexao.class.php");

    // Connect to the database
    $conexao = new mysqli($host, $login_db, $senha_db, $database);
    if ($conexao->connect_error) {
        die('Could not connect to the database: ' . $conexao->connect_error);
    }
    $conexao->set_charset('utf8');

    // Determine the table name based on the 'tipo' parameter
    $tabela = '';
    switch ($tipo) {
        case 1:
            $tabela = 'financeiro';
            break;
        case 2:
            $tabela = 'clientes';
            break;
        case 3:
            $tabela = 'planos';
            break;
        case 4:
            $tabela = 'ordemservicos';
            break;
        case 5:
            $tabela = 'notafiscal';
            break;
        case 6:
            $tabela = 'tecnicos';
            break;
        case 7:
            $tabela = 'sici';
            break;
        case 8:
            $tabela = 'empresa';
            break;
        default:
            $tabela = 'assinaturas';
            break;
    }

    // Get the search parameters from the URL query string
    $pesquisa = $_GET['pesquisa'];
    $idbusca = $_GET['busca'];

    // Build the WHERE clause for the SQL query
    $where = $pesquisa <> "" ? "WHERE $pesquisa = ?" : "";

    // Get the ORDER BY clause for the SQL query
    $ordem = $_GET['ordem'];
    $ordemClause = $ordem <> "" ? "ORDER BY id $ordem" : "ORDER BY id DESC";

    // Prepare the SQL query
    $stmt = $conexao->prepare("SELECT * FROM $tabela $where $ordemClause LIMIT ?");
    if (!$stmt) {
        die('Consulta com Problemas: ' . $conexao->error);
    }

    // Bind the parameters
    $stmt->bind_param("is", $pesquisa, $limite);

    // Execute the SQL query
    $stmt->execute();

    // Get the result set
    $resultado = $stmt->get_result();

    // Create an array to store the query results
    $artigos = [];
    if ($resultado->num_rows > 0) {
        while ($artigo = $resultado->fetch_assoc()) {
            // Add each row to the array
            $artigos[] = array('myrouter' => $artigo);
        }
    }

    // Output the query results in the specified format
    if ($formato == 'json') {
        // Output the results as JSON
        header('Content-type: application/json');
        echo json_encode(array('myrouter' => $artigos), JSON_UNESCAPED_UNICODE);
    } else {
        // Output the results as XML
        header('Content-type: text/xml');
        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<MYROUTER>' . "\n";
        foreach ($artigos as $indice => $artigo) {
            if (is_array($artigo)) {
                foreach ($artigo as $chave => $valor) {
                    // Output each array element as an XML tag
                    echo "\t<", htmlspecialchars($chave), '>' . "\n";
                    if (is_array($valor)) {
                        foreach ($valor as $tag => $val) {
                            // Replace 'pedido' with 'pedidos' in the tag name
                            echo "\t\t" . '<', htmlspecialchars(str_replace('pedido', 'pedidos', $tag)), '><![CDATA[', mysqli_real_escape_string($conexao, $val), ']]></', htmlspecialchars(str_replace('pedido', 'pedidos', $tag)), '>' . "\n";
                        }
                    }
                    echo
