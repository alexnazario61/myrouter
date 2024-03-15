<?php

header("Content-Type: text/html; charset=ISO-8859-1", true);
require_once 'config/conexao.class.php';
require_once 'config/crud.class.php';
require_once 'config/mikrotik.class.php';
require_once 'config/librouteros/RouterOS.php';

$con = new conexao(); // Instantiate the connection class
$con->connect(); // Connect to the database

function limpavariavel($valor) {
    $valor = trim($valor);
    $valor = str_replace([".", "," , "-", "/", "(", ")"], "", $valor);
    return $valor;
}

$qrAssinatura = $mysqli->query("SELECT * FROM assinaturas");

while ($linhas = mysqli_fetch_assoc($qrAssinatura)) {
    if ($linhas['insento'] == 'S') {
        echo 'Isento';
    } else {
        if ($linhas['status'] == 'N') {
            continue;
        }

        $pedido = $linhas['pedido'];
        $ffnx = $mysqli->query("SELECT * FROM financeiro WHERE pedido = '$pedido' AND situacao = 'N' AND avulso = '0'") or die(mysqli_error($mysqli));
        $contar = mysqli_num_rows($ffnx);

        if ($contar > 1) {
            continue;
        }

        $idass = $linhas['id'];
        $DataVencimentoFFNX = '';

        if ($contar == "1" || $contar == "0") {
            $asse = $mysqli->query("SELECT * FROM assinaturas WHERE id = '$idass'");
            $assinatura = mysqli_fetch_array($asse);

            // ... Rest of the code

            if ($datal['vencimento'] != $parcela && $contar <= 1 && $datalancamento <= $hoje) {
                // ... Rest of the code

                if (isset($statusCod) && $statusCod == 1) {
                    exit("Fatura já lançada pelo GerenciaNet");
                } else {
                    if ($chave != "" && $linkGerencia != "" && $confere['banco'] == "10") {
                        $crud = new crud('financeiro');
                        $crud->inserir(
                            "nfatura,cadastro,mesparcela,cliente,pedido,vencimento,dia,mes,ano,plano,login,ip,mac,valor,boleto,situacao,status, avulso,chave,linkGerencia",
                            "$x,'$data_inicial','$mescorre','$cliente','$pedido','$parcela','$diafn','$mesfn','$anofn','$plano','$login','$ip','$mac','$precofn','$nossonumero','N','A', '0','$chave','$linkGerencia'"
                        );
                    } elseif ($confere['banco'] != "10") {
                        $crud = new crud('financeiro');
                        $crud->inserir(
                            "nfatura,cadastro,mesparcela,cliente,pedido,vencimento,dia,mes,ano,plano,login,ip,mac,valor,boleto,situacao,status, avulso,chave,linkGerencia",
                            "$x,'$data_inicial','$mescorre','$cliente','$pedido','$parcela','$diafn','$mesfn','$anofn','$plano','$login','$ip','$mac','$precofn','$nossonumero','N','A', '0','$chave','$linkGerencia'"
                        );
                    }
                }
            }
        }
    }
}
