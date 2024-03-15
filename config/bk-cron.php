<?php

// Set error reporting.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR | E_PARSE | E_WARNING);

// Required files.
require_once 'conexao.class.php';
require_once 'conexao.php';
require_once 'crud.class.php';
require_once 'mikrotik.class.php';

// Create a new connection object.
$pdo = new conexao();

// Connect to the database.
$pdo->connect();

// Get the current date.
$currentDate = date('Y-m-d');

// Get the invoices that need to be processed.
$stmt = $pdo->prepare("SELECT * FROM financeiro WHERE situacao = 'N' AND mes = :mes AND ano = :ano");
$stmt->bindParam(':mes', date('m'));
$stmt->bindParam(':ano', date('Y'));
$stmt->execute();
$invoices = $stmt->fetchAll();

// Loop through the invoices.
foreach ($invoices as $invoice) {
    // Calculate the due date.
    $dueDate = date("Y-m-d", strtotime("+5 days", strtotime($invoice['vencimento'])));

    // Check if the due date has passed.
    if ($dueDate < $currentDate) {
        // Update the invoice status to 'B'.
        $stmt = $pdo->prepare("UPDATE financeiro SET situacao = 'B' WHERE id = :id");
        $stmt->bindParam(':id', $invoice['id']);
        $stmt->execute();

        // Get the customer details.
        $customerStmt = $pdo->prepare("SELECT * FROM assinaturas WHERE pedido = :pedido");
        $customerStmt->bindParam(':pedido', $invoice['pedido']);
        $customerStmt->execute();
        $customer = $customerStmt->fetch();

        // Get the plan details.
        $planStmt = $pdo->prepare("SELECT * FROM planos WHERE id = :id");
        $planStmt->bindParam(':id', $customer['plano']);
        $planStmt->execute();
        $plan = $planStmt->fetch();

        // Get the server details.
        $serverStmt = $pdo->prepare("SELECT * FROM servidores WHERE id = :id");
        $serverStmt->bindParam(':id', $plan['servidor']);
        $serverStmt->execute();
        $server = $serverStmt->fetch();

        // Disable the customer's internet access.
        disableInternetAccess($server, $customer);
    }
}

// Function to disable the customer's internet access.
function disableInternetAccess($server, $customer)
{
    // Create a new Mikrotik API object.
    $API = new routeros_api();
    $API->debug = false;

    // Connect to the Mikrotik router.
    if ($API->connect($server['ip'], $server['login'], $server['senha'])) {
        // Disable the customer's internet access based on their type.
        switch ($customer['tipo']) {
            case 'HOTSPOT':
                // Remove the active hotspot user.
                $API->write('/ip/hotspot/active/print', false);
                $API->write('?=user=' . $customer['login'] . '');
                $res = $API->read();

                $user_login = $res[1];

                if (!empty($user_login)) {
                    $API->write('/ip/hotspot/active/remove', false);
                    $API->write($user_login);
                    $res = $API->read();
                }

                break;
            case 'PPPoE':
                // Remove the active PPPoE user.
                $API->write('/ppp/active/print', false);
                $API->write('?=name=' . $customer['login'] . '');
                $res = $API->read();

                $user_login = $res[1];

                if (!empty($user_login)) {
                    $API->write('/ppp/active/remove', false);
                    $API->write($user_login);
                    $res = $API->read();
                }

                break;
            case 'IPARP':
                // Disable the ARP entry.
                $API->write('/ip/arp/disable', false);
                $API->write('=.id=' . $customer['ip'] . '');
                $ARRAY = $API->read();

                break;
        }

        // Disconnect from the Mikrotik router.
        $API->disconnect();
    }
}
