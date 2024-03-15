<?php

// Enable error reporting for debugging purposes
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Require necessary files
require_once 'conexao.class.php';
require_once 'crud.class.php';
require_once 'mikrotik.class.php';
require_once 'cliente.class.php';
require_once 'plano.class.php';
require_once 'servidor.class.php';

// Get the company information from the database
$conexao = new Conexao();
$connection = $conexao->connect();
$query = "SELECT * FROM empresa WHERE id = 1";
$result = mysqli_query($connection, $query);
$empresa = mysqli_fetch_assoc($result);
$dias_bloc = $empresa['dias_bloc'];

// Get the list of unpaid invoices that are overdue by the number of days specified in the company settings
$query = "SELECT * FROM financeiro  WHERE date_add(vencimento, interval '$dias_bloc' day) < now() AND situacao = 'N'";
$result = mysqli_query($connection, $query);

// Loop through each overdue invoice
while ($daa = mysqli_fetch_assoc($result)) {
    // Count the number of overdue invoices
    $verificazeros = mysqli_num_rows($result);

    // If there are any overdue invoices
    if ($verificazeros > 0) {
        // Update the invoice status to 'B' (blocked)
        $crud = new Crud('financeiro');
        $crud->atualizar(["situacao" => 'B'], ["id" => $daa['id']]);

        // Get the associated client information
        $cliente = new Cliente();
        $cliente->setId($daa['pedido']);
        $cliente->carregarPorId();

        // Get the client's ID
        $cliente_id = $cliente->getId();

        // Get the plan information
        $plano = new Plano();
        $plano->setId($cliente->getPlano());
        $plano->carregarPorId();

        // Get the server information
        $servidor = new Servidor();
        $servidor->setId($plano->getServidor());
        $servidor->carregarPorId();

        // If the client has autobloqueio enabled
        if ($cliente->getAutobloqueio() == 'S') {
            // Block the client's access
            echo 'block ' . $cliente->getLogin() . "\n";

            // Determine the type of connection (hotspot, PPPoE, or IPARP) and block it accordingly
            switch ($cliente->getTipo()) {
                case 'HOTSPOT':
                    // Connect to the MikroTik router and disable the user's hotspot session
                    $mikrotik = new Mikrotik($servidor->getIp(), $servidor->getLogin(), $servidor->getSenha());
                    $mikrotik->desabilitarSessaoHotspot($cliente->getLogin());
                    break;
                case 'PPPoE':
                    // Connect to the MikroTik router and disable the user's PPPoE session
                    $mikrotik = new Mikrotik($servidor->getIp(), $servidor->getLogin(), $servidor->getSenha());
                    $mikrotik->desabilitarSessaoPPPoE($cliente->getLogin());
                    break;
                case 'IPARP':
                    // Connect to the MikroTik router and disable the user's IPARP session
                    $mikrotik = new Mikrotik($servidor->getIp(), $servidor->getLogin(), $servidor->getSenha());
                    $mikrotik->desabilitarSessaoIPARP($cliente->getLogin());
                    break;
            }
        }
    }
}

// Close the database connection
$conexao->disconnect();
