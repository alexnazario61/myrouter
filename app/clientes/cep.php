<?php
// Check if the 'cep' parameter is set and is a valid Brazilian postal code
if (isset($_GET['cep']) && preg_match('/^\d{5}-?\d{3}$/', $_GET['cep'])) {
    // Get the XML data from the web service
    $xml_data = file_get_contents("http://cep.republicavirtual.com.br/web_cep.php?formato=xml&cep=" . $_GET['cep']);

    // Parse the XML data
    $reg = simplexml_load_string($xml_data);

    // Check if the XML data is valid
    if ($reg && isset($reg->resultado)) {
        $dados = [
            'sucesso' => false,
            'endereco' => '',
            'bairro' => '',
            'cidade' => '',
            'estado' => ''

