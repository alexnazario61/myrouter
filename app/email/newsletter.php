<?php
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

if (isset($_POST['submit'])) {
    $subject = $_POST['assunto'];
    $texto = $_POST['text'];

    if (empty($texto)) {
        header('Location: ../../index.php?app=Newsletter&reg=3');
        exit;
    } else {
        require_once "../../config/conexao.class.php";

        $mysqli = new mysqli('localhost', 'username', 'password', 'database');
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        $sql5 = $mysqli->query("SELECT * FROM empresa WHERE id = '1'");
        if ($sql5) {
            $emp = mysqli_fetch_array($sql5);
            $NomeEmpresa = $emp['empresa'];
            $EmailEmpresa = $emp['email'];
        } else {
            echo "Error: " . $mysqli->error;
            exit;
        }

        $quant = 10; //número de mensagens enviadas de cada vez
        $sec = 10; //tempo entre o envio de um pacote e outro (em segundos)

        require 'PHPMailerAutoload.php';

        $sql = $mysqli->query("SELECT * FROM maile") or die (mysqli_error($mysqli));
        if ($sql) {
            $linha = mysqli_fetch_array($sql);
            $email = filter_var($linha['email'], FILTER_VALIDATE_EMAIL);
            if (!$email) {
                echo "Invalid email address";
                exit;
            }
            $senha = password_hash($linha['senha'], PASSWORD_DEFAULT);
            // ... rest of the code ...
        } else {
            echo "Error: " . $mysqli->error;
            exit;
        }

        // ... rest of the code ...

    }
}
?>
