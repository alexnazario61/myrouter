<?php
    // Check if the 'key' parameter is set and not empty
    if(isset($_GET['key']) and $_GET['key']) {
        
        // Set default values for 'limite' and 'formato' if they are not set
        $numeros = isset($_GET['limite']) ? intval($_GET['limite']) : 10; //10 is the default
        $formato = (isset($_GET['formato']) and strtolower($_GET['formato']) == 'json') ? 'json' : 'xml'; //xml is the default
        $tipo = $_GET['tipo'];	
        
        // Include the database connection file
        require_once("config/conexao.class.php");
        
        // Connect to the database
        $conexao = mysql_connect("$host","$login_db","$senha_db") or die('Could not connect to the database');
        mysql_select_db("$database",$conexao) or die('Could not select the database');
        mysql_set_charset('utf8', $conexao); 
         
        // Determine the table name based on the 'tipo' parameter
        if ($tipo == "1") {
            $tabela = 'financeiro'; 
        } elseif ($tipo == "2") {
            $tabela = 'clientes';
        } elseif ($tipo == "3") {
            $tabela = 'planos'; 
        } elseif ($tipo == "4") {
            $tabela = 'ordemservicos'; 
        } elseif ($tipo == "5") {
            $tabela = 'notafiscal';
        } elseif ($tipo == "6") {
            $tabela = 'tecnicos';   
        } elseif ($tipo == "7") {
            $tabela = 'sici'; 
        } elseif ($tipo == "8") {
            $tabela = 'empresa'; 
        } else {
            $tabela = 'assinaturas';
        }
	
	// Get the search parameters from the URL query string
	$pesquisa = $_GET['pesquisa'];
	$idbusca = $_GET['busca'];
	
	// Build the WHERE clause for the SQL query
	if ($pesquisa <> "") {
            $where = "WHERE $pesquisa = '$idbusca'"; 
        } else {
            $where = '';
        }
      	
      	// Get the ORDER BY clause for the SQL query
      	$ordem = $_GET['ordem'];
      	if ($ordem <> "") {
            $ordem = "ASC"; 
        } else {
            $ordem = 'DESC';
        }

	// Build the SQL query
	$consulta = "SELECT * FROM $tabela $where ORDER BY id $ordem LIMIT $numeros";
	
        // Execute the SQL query
        $resultado = mysql_query($consulta,$conexao) or die('Consulta com Problemas:  ');
         
        // Create an array to store the query results
        $artigos = array();
        if(mysql_num_rows($resultado)) {
            while($artigo = mysql_fetch_assoc($resultado)) {
            
                // Add each row to the array
                $artigos[] = array('myrouter'=>$artigo);
            
            }
        } 
        
         
         
        // Output the query results in the specified format
        if($formato == 'json') {
            // Output the results as JSON
            header('Content-type: application/json');
            echo json_encode(array('myrouter'=>$artigos));
        }
        else {
            // Output the results as XML
            header('Content-type: text/xml');
            echo '<?xml version="1.0" encoding="UTF-8"?>'."\n";
            echo '<MYROUTER>'."\n";
            foreach($artigos as $indice => $artigo) {
                if(is_array($artigo)) {
                    foreach($artigo as $chave => $valor) {
                        // Output each array element as an XML tag
                        echo "\t<",$chave,'>'."\n";
                        if(is_array($valor)) {
                            foreach($valor as $tag => $val) {
                                // Replace 'pedido' with 'pedidos' in the tag name
                                echo "\t\t".'<',str_replace('pedido', 'pedidos', $tag) ,'><![CDATA[',$val,']]></',str_replace('pedido', 'pedidos', $tag) ,'>'."\n";
                            }
                        }
                        echo "\t".'</',$chave,'>'."\n";
                    }
                }
            }  
            echo '</MYROUTER>'."\n";
        }
         
        // Close the database connection
        @mysql_close($conexao);
    }
 
?>
