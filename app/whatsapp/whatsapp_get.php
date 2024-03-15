<?php

// Get the 'fone' and 'mensagem' parameters from the GET request
$fone = $_GET['fone'];
$mensagem = $_GET['mensagem'];

// Assign the same values to new variables with more descriptive names
$telefone = $fone;
$mensagens = $mensagem;

// Check if both 'fone' and 'mensagem' parameters have values
if ($fone != '' && $mensagem != '') {
    // Concatenate the country code and phone number
    $phoneNumber = "55{$telefone}";

    // Construct the shell command using the yowsup-cli tool
    $shellCommand = "yowsup-cli demos -s {$phoneNumber} \"{$mensagens}\" -c /etc/whatsapp/whatsapp.conf";

    // Execute the shell command
    shell_exec($shellCommand);

    // Display a success message
    echo "MENSAGEM ENVIADA";
} else {
    // Display an error message
    echo "NAO FOI ENVIADO";
}

// Previous commented code, possibly for testing or alternative functionality
// $content = file_get_contents("http://whatsapp.myrouter.com.br/api.php?fone=$telefone&mensagem=$mensagens");
// echo $content;

?>
