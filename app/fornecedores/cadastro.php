<?php
session_start();
require_once 'db.php';

// Function to sanitize input data
function clean_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// Check if user is logged in and has permission
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['permissao']['fo2'] != 'S') {
    header("location: login.php");
    exit;
}

$idempresa = $_SESSION['empresa'];
$id = isset($_GET['id']) ? base64_decode($_GET['id']) : null;
$action = isset($_POST['action']) ? $_POST['action'] : null;

if ($action) {
    $nome = clean_input($_POST['nome']);
    $razao = clean_input($_POST['razao']);
    $cpf_cnpj = clean_input($_POST['cpf_cnpj']);
    $rg_ie = clean_input($_POST['rg_ie']);
    $tel = clean_input($_POST['tel']);
    $cel = clean_input($_POST['cel']);
    $endereco = clean_input($_POST['endereco']);
    $numero = clean_input($_POST['numero']);
    $complemento = clean_input($_POST['complemento']);
    $bairro = clean_input($_POST['bairro']);
    $cidade = clean_input($_POST['cidade']);
    $estado = clean_input($_POST['estado']);
    $cep = clean_input($_POST['cep']);
    $email = clean_input($_POST['email']);
    $site = clean_input($_POST['site']);
    $contato = clean_input($_POST['contato']);
    $referencia = clean_input($_POST['referencia']);
    $status = clean_input($_POST['status']);
    $fornecedorid = isset($_POST['fornecedorid']) ? clean_input($_POST['fornecedorid']) : null;

    if ($action == 'insert') {
        $sql = "INSERT INTO fornecedores (empresa, nome, razao, cpf_cnpj, rg_ie, tel, cel, endereco, numero, complemento, bairro, cidade, estado, cep, email, site, contato, referencia, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssssssssssssssss", $idempresa, $nome, $razao, $cpf_cnpj, $rg_ie, $tel, $cel, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $cep, $email, $site, $contato, $referencia, $status);
        $stmt->execute();
        header("location: fornecedores.php?reg=1");
    } else if ($action == 'update') {
        $sql = "UPDATE fornecedores SET nome=?, razao=?, cpf_cnpj=?, rg_ie=?, tel=?, cel=?, endereco=?, numero=?, complemento=?, bairro=?, cidade=?, estado=?, cep=?, email=?, site=?, contato=?, referencia=?, status=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssssssssssssssi", $nome, $razao, $cpf_cnpj, $rg_ie, $tel, $cel, $endereco, $numero, $complemento, $bairro, $cidade, $estado, $cep, $email, $site, $contato, $referencia, $status, $fornecedorid);
        $stmt->execute();
        header("location: fornecedores.php?reg=2");
    }
}

if ($id) {
    $sql = "SELECT * FROM fornecedores WHERE id = ? AND empresa = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $id, $idempresa);
    $stmt->execute();
    $campo = $stmt->get_result()->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fornecedores</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" integrity="sha384-pzjw8f+ua7Kw1TIq0v8FqFjcJ6pajs/rfdfs3SO+kD4Ck5BdPtF+to8xMmcke49" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSGFpoO9xmv/+/z7nU7ELJ6EeAZWlCmGKZk4M1RtIDZOt6Xq/YD" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoJtKh7z7lGz7fuP4F8nfdFvAOA6Gg/z6Y5J6XqqyGXYM2ntX5" crossorigin="anonymous"></script>

