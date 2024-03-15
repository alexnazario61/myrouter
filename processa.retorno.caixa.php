<?php

session_start();
ob_start();
ini_set("allow_url_fopen", 1);
ini_set("display_errors", 1);
error_reporting(1);
ini_set("track_errors", "1");
header("Content-Type: text/html; charset=ISO-8859-1", true);

require_once 'config/conexao.class.php';
require_once 'config/crud.class.php';
require_once 'config/mikrotik.class.php';

// Homologado Para CEF 
// Para Modificações Consulte a documentação do banco
// Padrão 240
$con = new conexao(); // instancia classe de conxao
$con->connect(); // abre conexao com o banco

$allowedExtensions = ['ret', 'RET'];
$fileType = strtolower(pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION));

if (!in_array($fileType, $allowedExtensions)) {
    header("Location: index.php?app=Retorno&reg=2");
    exit;
}

$file = $_FILES['arquivo']['tmp_name'];
$handle = fopen($file, "r");

function formatNumber($number)
{
    $number = str_replace(['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'], ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'], $number);
    return $number;
}

$i = 0;
$data_agora = date('Y-m-d');
$hora_agora = date('H:i:s');

while (!feof($handle)) {
    $i++;
    $line = fgets($handle);

    $t_u_segmento = substr($line, 13, 1); // Segmento T ou U
    $t_tipo_reg = substr($line, 7, 1); // Tipo de Registro

    if ($t_u_segmento == 'T') {
        $t_data_vencimento = substr(substr($line, 73, 8), 4, 4) . '-' . substr(substr($line, 73, 8), 2, 2) . '-' . substr(substr($line, 73, 8), 0, 2);

        // ... continue processing the T record
    }

    if ($t_u_segmento == 'U') {
        // ... continue processing the U record
    }

    if ($t_u_segmento == '3' && $t_tipo_reg == '5') {
        $juros_multa = str_replace('.', '', formatNumber(substr($line, 17, 15)));
        $desconto = str_replace('.', '', formatNumber(substr($line, 32, 15)));
        $abatimento = str_replace('.', '', formatNumber(substr($line, 47, 15)));
        $iof = str_replace('.', '', formatNumber(substr($line, 62, 15)));
        $v_pago = str_replace('.', '', formatNumber(substr($line, 77, 15)));
        $v_liquido = str_replace('.', '', formatNumber(substr($line, 92, 15)));
        $v_despesas = str_replace('.', '', formatNumber(substr($line, 107, 15)));
        $v_creditos = str_replace('.', '', formatNumber(substr($line, 122, 15)));

        $codigo = substr(substr($line, 41, 15), 0, -1);

        $consultas = $mysqli->query("SELECT * FROM retornos WHERE codigo = '$codigo'");
        $campo = mysqli_fetch_array($consultas);

        if ((int)$codigo !== $campo['codigo']) {
            $crud = new crud('retornos');
            $crud->inserir("juros,codigo,valor,dataefetivacao,dataocorrencia,dataprocessado,horaprocessado,datavencimento",
                "{$juros_multa},{$codigo},{$v_pago},'{$u_dt_efetivacao}','{$u_dt_ocorencia}','{$data_agora}','{$hora_agora}','{$t_dt_vencimento}'");

            // ... continue processing the U record and inserting data
        }
    }
}

fclose($handle);
header("Location: index.php?app=Retorno&reg=1");
