<?php

// Include the database configuration file
include 'dbconfig.php';

// Check if the form has been submitted
if(isset($_POST['cadastrar'])) {

    // Assign form data to variables and sanitize the inputs
    $chain = filter_input(INPUT_POST, 'chain', FILTER_SANITIZE_STRING);
    $dstaddress = filter_input(INPUT_POST, 'dstaddress', FILTER_SANITIZE_STRING);
    $srcaddress = filter_input(INPUT_POST, 'srcaddress', FILTER_SANITIZE_STRING);
    $naosrcaddresslist = filter_input(INPUT_POST, 'naosrcaddresslist', FILTER_SANITIZE_STRING);
    $srcaddresslist = filter_input(INPUT_POST, 'srcaddresslist', FILTER_SANITIZE_STRING);
    $naodstaddresslist = filter_input(INPUT_POST, 'naodstaddresslist', FILTER_SANITIZE_STRING);
    $dstaddresslist = filter_input(INPUT_POST, 'dstaddresslist', FILTER_SANITIZE_STRING);
    $protocolo = filter_input(INPUT_POST, 'protocolo', FILTER_SANITIZE_STRING);
    $naointerfacein = filter_input(INPUT_POST, 'naointerfacein', FILTER_SANITIZE_STRING);
    $interfacein = filter_input(INPUT_POST, 'interfacein', FILTER_SANITIZE_STRING);
    $naointerfaceout = filter_input(INPUT_POST, 'naointerfaceout', FILTER_SANITIZE_STRING);
    $interfaceout = filter_input(INPUT_POST, 'interfaceout', FILTER_SANITIZE_STRING);
    $dstport = filter_input(INPUT_POST, 'dstport', FILTER_SANITIZE_NUMBER_INT);
    $toaddresses = filter_input(INPUT_POST, 'toaddresses', FILTER_SANITIZE_STRING);
    $toports = filter_input(INPUT_POST, 'toports', FILTER_SANITIZE_STRING);
    $conteudo = filter_input(INPUT_POST, 'conteudo', FILTER_SANITIZE_STRING);
    $comentario = filter_input(INPUT_POST, 'comentario', FILTER_SANITIZE_STRING);
    $servidor = filter_input(INPUT_POST, 'servidor', FILTER_SANITIZE_NUMBER_INT);
    $cliente = filter_input(INPUT_POST, 'cliente', FILTER_SANITIZE_STRING);
    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);

    // Concatenate srcaddresslist variables
    $srcaddresslistFull = $naosrcaddresslist . $srcaddresslist;

    // Concatenate dstaddresslist variables
    $dstaddresslistFull = $naodstaddresslist . $dstaddresslist;

    // Concatenate interfacein variables
    $interfaceinFull = $naointerfacein . $interfacein;

    // Concatenate interfaceout variables
    $interfaceoutFull = $naointerfaceout . $interfaceout;

    // Create a new instance of the crud class and insert form data into the 'firewall' table
    $crud = new crud('firewall'); // Pass table name as parameter

    // Prepare the SQL statement and bind the parameters
    $stmt = $mysqli->prepare("INSERT INTO firewall (chain, dstaddress, srcaddress, naosrcaddresslist, srcaddresslist, naodstaddresslist, dstaddresslist, protocolo, naointerfacein, interfacein, naointerfaceout, interfaceout, dstport, toaddresses, toports, cliente, conteudo, comentario, servidor, action) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssssssss", $chain, $dstaddress, $srcaddress, $naosrcaddresslist, $srcaddresslist, $naodstaddresslist, $dstaddresslist, $protocolo, $naointerfacein, $interfacein, $naointerfaceout, $interfaceout, $dstport, $toaddresses, $toports, $cliente, $conteudo, $comentario, $servidor, $action);

    // Execute the SQL statement
    $result = $stmt->execute();

    // Check for errors
    if ($result === false) {
        die("Error: " . $mysqli->error);
    }

    // Query the 'servidores' table to retrieve server details
    $stmt = $mysqli->prepare("SELECT * FROM servidores WHERE id = ?");
    $stmt->bind_param("i", $servidor);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Fetch server data from the result set
    $server = $result->fetch_assoc();

    // Create a new instance of the routeros_api class
    $API = new routeros_api();

    // Disable API debugging
    $API->debug = false;

    // Connect to the MikroTik router
    if ($API->connect($server['ip'], $server['login'], $server['senha'])) {

        // Write NAT configuration to the router
        $API->write('/ip/firewall/nat/add', false);
        $API->write('=chain=' . $chain, false);
        $API->write('=action=' . $action, false);


