<?php
session_start();
ob_start();
header("Content-Type: text/html; charset=ISO-8859-1", true);

require_once '../config/conexao.class.php';
require_once '../config/crud.class.php';
require_once '../config/mikrotik.class.php';

$con = new Conexao();
$con->connect();

if (!isset($_SESSION['login'])) {
    echo "<script>window.location = 'login.php';</script>";
    exit;
}

$idbase = $_SESSION['id'];
if ($idbase) {
    $cslogin = $mysqli->query("SELECT * FROM clientes WHERE id = + $idbase");
    $logado = mysqli_fetch_array($cslogin);
}

if (isset($_POST['editar'])) {
    $nome = htmlspecialchars(trim($_POST['nome']));
    $senha = htmlspecialchars(trim($_POST['senha']));
    $tel = htmlspecialchars(trim($_POST['tel']));
    $cel = htmlspecialchars(trim($_POST['cel']));
    $cpf = htmlspecialchars(trim($_POST['cpf']));
    $rg = htmlspecialchars(trim($_POST['rg']));
    $nascimento = htmlspecialchars(trim($_POST['nascimento']));
    $endereco = htmlspecialchars(trim($_POST['endereco']));
    $numero = htmlspecialchars(trim($_POST['numero']));
    $referencia = htmlspecialchars(trim($_POST['referencia']));
    $complemento = htmlspecialchars(trim($_POST['complemento']));
    $pai = htmlspecialchars(trim($_POST['pai']));
    $mae = htmlspecialchars(trim($_POST['mae']));
    $bairro = htmlspecialchars(trim($_POST['bairro']));
    $cidade = htmlspecialchars(trim($_POST['cidade']));
    $estado = htmlspecialchars(trim($_POST['estado']));
    $cep = htmlspecialchars(trim($_POST['cep']));
    $email = htmlspecialchars(trim($_POST['email']));
    $clienteid = htmlspecialchars(trim($_POST['clienteid']));

    $crud = new Crud('clientes');
    $crud->atualizar("nome='$nome',email='$email',senha='$senha',tel='$tel',cel='$cel',cpf='$cpf',rg='$rg',nascimento='$nascimento',endereco='$endereco',numero='$numero',referencia='$referencia',complemento='$complemento',pai='$pai',mae='$mae',bairro='$bairro',cidade='$cidade',estado='$estado',cep='$cep'", "id='$clienteid'");

    header("Location: dados.php?op=atz");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- head content here -->
</head>
<body>
    <!-- body content here -->
    <script>
        // JavaScript code here
    </script>
    <script src="http://cidades-estados-js.googlecode.com/files/cidades-estados-1.2-utf8.js"></script>
    <script>
        window.onload = function() {
            new dgCidadesEstados({
                estado: document.getElementById('estado'),
                cidade: document.getElementById('cidade')
            });
        }
    </script>
</body>
</html>
