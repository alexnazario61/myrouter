<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../../config/conexao.class.php";

$conlote = filter_var(base64_decode($_GET['id']), FILTER_SANITIZE_STRING);
$nlote = filter_var($_GET['nlote'], FILTER_SANITIZE_STRING);

if ($conlote && $nlote) {
    $conn = new Conexao();
    $mysqli = $conn->connect();

    if ($mysqli) {
        $sql = "SELECT
                    cliente,
                    cliente,
                    clientenome,
                    clienteendereco,
                    clientenumero,
                    clientecomplemento,
                    clientebairro,
                    clientecidade,
                    clienteuf,
                    clientecep,
                    clientecpf,
                    clienterg,
                    diavencimento,
                    modelonota,
                    cfop,
                    clientetelefone,
                    clienteemail,
                    tipoassinante,
                    tipoutilizacao,
                    emissao,
                    emissao,
                    nnota,
                    codmunicipio
                FROM
                    notafiscal
                WHERE
                    nlote = ?";

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $nlote);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $output = "";
                while ($row = $result->fetch_assoc()) {
                    $data_emissao = date('d/m/Y', strtotime($row['emissao']));
                    $telefone = preg_replace("/\D+/", "", $row['clientetelefone']);

                    $output .= "{$row['cliente']}|"
                              . "{$row['cliente']}|"
                              . "{$row['clientenome']}|"
                              . "{$row['clienteendereco']}|"
                              . "{$row['clientenumero']}|
