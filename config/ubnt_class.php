<?php

function conecta_ubnt($server, $login, $password, $port = 22, $debug = false) {
    if (!function_exists("ssh2_connect")) {
        die("ERRO: Biblioteca PHP SSH2 nao esta funcionando corretamente!");
    }

    if (!($con = ssh2_connect($server, $port))) {
        if ($debug) {
            echo "ERRO: Nao foi possivel se conectar\n";
        }
        return false;
    }

    if (!ssh2_auth_password($con, $login, $password)) {
        if ($debug) {
            echo "ERRO: usuario e senhas invalidos\n";
        }
        return false;
    }

    return $con;
}

function executa_ubnt($cmd, $con, $debug = false) {
    if (!($stream = ssh2_exec($con, $cmd))) {
        if ($debug) {
            echo "ERRO: Nao foi possivel executar o comando\n";
        }
        return false;
    }

    $errorStream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);
    stream_set_blocking($stream, true);
    $output = stream_get_contents($stream);

    if ($errorStream) {
        $errorOutput = stream_get_contents($errorStream);
        // Combine output and error output for better error handling
        $output = "Command Output: $output\nCommand Error: $errorOutput";
    }

    return json_decode($output, true);
}

// Usage Example
$conexao = conecta_ubnt("192.168.1.1", "ubnt", "ubnt", 22, true);
if ($conexao) {
    $retorno = executa_ubnt("wstalist -i ath0", $conexao, true);
    print_r($retorno);

