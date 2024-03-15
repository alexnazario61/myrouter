<?php
// Setting the content type to text/html and charset to UTF-8
header("Content-Type: text/html; charset=UTF-8", true);

// Including the database connection class
include("../config/conexao.class.php");

// Assigning the values received from GET request to variables
$campo = filter_input(INPUT_GET, 'campo', FILTER_SANITIZE_STRING);
$valor = filter_input(INPUT_GET, 'valor', FILTER_SANITIZE_STRING);

// Initializing the success and error messages
$ok = ''; // represents the image of confirmation
$erro = '<font color=red>ERRO</font>'; // represents the image of negation

// Checking if the field is 'ip'
if ($campo == "ip") {
    // Querying the database for the user with the given IP address
    $sql = $mysqli->query("SELECT * FROM assinaturas WHERE ip = '$valor'");
    
    // Fetching the result of the query into an associative array
    $job = mysqli_fetch_array($sql);

    // Checking if the fetched IP address matches the given IP address
    if ($job && $job['ip'] == $valor) {
        // Displaying the error message and the reason for the error
        echo $erro;
        echo " Endereço de IP já Ultilzado por outro Usuário";
    } else {
        // Displaying the success message
        echo $ok;
    }
}
?>
