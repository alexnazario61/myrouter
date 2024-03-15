<?php

// Include the Boleto class file
include_once('config/Boleto.class.php');

// Decode the cliente and assinatura GET parameters
$cliente = base64_decode($_GET['cliente']);
$assinatura = base64_decode($_GET['fatura']);
$tipo = $_GET['tipo']; // 1 for boleto, 2 for duplicata

// Create a new Boleto object
$boleto = new Boleto;

// Retrieve the empresa data from the database
$conn = mysqli_connect("localhost", "username", "password", "database_name");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM empresa WHERE id = ?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("i", $empresa_id);
    $empresa_id = 1;
    $stmt->execute();
    $result = $stmt->get_result();
    $empresa = $result->fetch_assoc();
    $stmt->close();
} else {
    die("Error preparing statement: " . $conn->error);
}

// Emit the boleto based on the selected bank
switch ($empresa['banco']) {
    case 1: // BANCO DO BRASIL
        $boleto->emitir_bb($cliente, $assinatura, $tipo);
        break;
    case 2: // BRADESCO
        $boleto->emitir_bradesco($cliente, $assinatura, $tipo);
        break;
    case 3: // CEF
        $boleto->emitir_cef($cliente, $assinatura, $tipo);
        break;
    case 4: // ITAÚ
        $boleto->emitir_itau($cliente, $assinatura, $tipo);
        break;
    case 5: // SANTANDER
        $boleto->emitir_santander($cliente, $assinatura, $tipo);
        break;
    case 6: // SICOOB
        $boleto->emitir_sicoob($cliente, $assinatura, $tipo);
        break;
    case 7: // SICREDI
        $boleto->emitir_sicredi($cliente, $assinatura, $tipo);
        break;
    default:
        die("Invalid bank selected.");
}

// Close the database connection
mysqli_close($conn);
