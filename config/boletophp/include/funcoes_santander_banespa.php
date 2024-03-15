<?php

// BoletoPhp - Versão Beta
// Licença GPL disponível em http://pt.wikipedia.org/wiki/GNU_General_Public_License

// Equipe Coordenação Projeto BoletoPhp: <boletophp@boletophp.com.br>
// Desenvolvimento Boleto Santander-Banespa : Fabio R. Lenharo

function geraCodigoBanco($numero) {
    $parte1 = substr($numero, 0, 3);
    $parte2 = modulo11($parte1);
    return $parte1 . "-" . $parte2;
}

function modulo11($num) {
    $numeros = str_split(strrev($num));
    $soma = 0;
    $fator = 2;

    foreach ($numeros as $n) {
        $soma += $n * $fator;
        $fator = ($fator === 2) ? 9 : 2;
    }

    $resto = $soma % 11;
    return ($resto === 0 || $resto === 1) ? 0 : 11 - $resto;
}

function dataJuliano($data) {
    list($dia, $mes, $ano) = explode('/', $data);
    $dataf = strtotime("$ano/$mes/$dia");
    $datai = strtotime((string)($ano - 1) . '/12/31');
    $dias = (int)(($dataf - $datai) / (60 * 60 * 24));
    return str_pad($dias, 3, '0', STR_PAD_LEFT) . substr($data, 9, 4);
}

function formata_numero($numero, $loop, $insert, $tipo = "geral") {
    if ($tipo === "geral") {
        $numero = str_replace(",", "", $numero);
        while (strlen($numero) < $loop) {
            $numero = $insert . $numero;
        }
    }
    if ($tipo === "valor") {
        $numero = str_replace(",", "", $numero);
        while (strlen($numero) < $loop) {
            $numero = $insert . $numero;
        }
    }
    if ($tipo === "convenio") {
        while (strlen($numero) < $loop) {
            $numero = $numero . $insert;
        }
    }
    return $numero;
}

function fator_vencimento($data) {
    list($dia, $mes, $ano) = explode('/', $data);
    return abs((_dateToDays("1997", "10", "07")) - (_dateToDays($ano, $mes, $dia)));
}

function _dateToDays($year, $month, $day) {
    $century = substr($year, 0, 2);
    $year = substr($year, 2, 2);
    if ($month > 2) {
        $month -= 3;
    } else {
        $month += 9;
        if ($year) {
            $year--;
        } else {
            $year = 99;
            $century--;
        }
    }
    return floor((146097 * $century) / 4) + floor((1461 * $year) / 4) + floor((153 * $month + 2) / 5) + $day + 1721119;
}

$codigobanco = "033";
$nummoeda = "9";
$fixo = "9";
$ios = "0";
$fator_vencimento = fator_vencimento("2023-03-28");
$valor = formata_numero("123456.78", 10, "", "valor");
$carteira = "1";
$codigocliente = formata_numero("1234567", 7, "", "convenio");
$nnum = formata_numero("123456", 7, "", "convenio");
$dv_nosso_numero = modulo11($nnum);
$nossonumero = "00000" . $nnum . $dv_nosso_numero;
$vencimento = "2023-03-28";
$vencjuliano = dataJuliano($vencimento);
$barra = "$codigobanco$nummoeda$fator_vencimento$valor$fixo$codigocliente$nossonumero$ios$carteira";
$dv = modulo11($barra);
$linha = substr($barra, 0, 4) . $dv . substr($barra, 4);

$dadosboleto = [
    "codigo_barras" => $linha,
    "linha_digitavel" => monta_linha_digitavel($linha),
    "nosso_numero" => $nossonumero,
    "codigo_banco_com_dv" => geraCodigoBanco($codigobanco),
];

function monta_linha_digitavel($codigo) {
    $campo1 = substr($codigo, 0, 3) . substr($codigo, 3, 1) . substr($codigo, 19, 1) . substr($codigo, 20, 4);
    $campo1 = $campo1 . modulo11($campo1);
    $campo1 = substr($campo1, 0, 5) . '.' . substr($campo1, 5);

    $campo2
