<?php

declare(strict_types=1);

$codigobanco = "104";
$codigo_banco_com_dv = geraCodigoBanco($codigobanco);
$nummoeda = "9";
$fator_vencimento = fator_vencimento($dadosboleto["data_vencimento"]);

//valor tem 10 digitos, sem virgula
$valor = formata_numero($dadosboleto["valor_boleto"], 10, 0, "valor");
//agencia é 4 digitos
$agencia = formata_numero($dadosboleto["agencia"], 4, 0);
//conta é 5 digitos
$conta = formata_numero($dadosboleto["conta"], 5, 0);
//dv da conta
$conta_dv = formata_numero($dadosboleto["conta_dv"], 1, 0);
//carteira é 2 caracteres
$carteira = $dadosboleto["carteira"];

//conta cedente (sem dv) com 11 digitos   (Operacao de 3 digitos + Cedente de 8 digitos)
$conta_cedente = formata_numero($dadosboleto["conta_cedente"], 11, 0);
//dv da conta cedente
$conta_cedente_dv = formata_numero($dadosboleto["conta_cedente_dv"], 1, 0);

//nosso número (sem dv) é 10 digitos
$nnum = $dadosboleto["inicio_nosso_numero"] . formata_numero($dadosboleto["nosso_numero"], 8, 0);
//nosso número completo (com dv) com 11 digitos
$nossonumero = $nnum . '-' . digitoVerificador_nossonumero($nnum);

// 43 numeros para o calculo do digito verificador do codigo de barras
$dv = digitoVerificador_barra("$codigobanco$nummoeda$fator_vencimento$valor$nnum$agencia$conta_cedente", 9, 0);
// Numero para o codigo de barras com 44 digitos
$linha = "$codigobanco$nummoeda$dv$fator_vencimento$valor$nnum$agencia$conta_cedente";

$agencia_codigo = $agencia . " / " . $conta_cedente . "-" . $conta_cedente_dv;

$dadosboleto["codigo_barras"] = $linha;
$dadosboleto["linha_digitavel"] = monta_linha_digitavel($linha);
$dadosboleto["agencia_codigo"] = $agencia_codigo;
$dadosboleto["nosso_numero"] = $nossonumero;
$dadosboleto["codigo_banco_com_dv"] = $codigo_banco_com_dv;

function digitoVerificador_nossonumero(string $numero, int $base = 11, int $r = 0): int
{
    $numtotal10 = 0;
    $fator = 2;

    for ($i = strlen($numero); $i > 0; $i--) {
        $numeros[$i] = substr($numero, $i - 1, 1);
        $temp = $numeros[$i] * $fator;
        $parcial10[$i] = $temp;
        $numtotal10 += $parcial10[$i];
        if ($fator == 2) {
            $fator = 1;
        } else {
            $fator = 2;
        }
    }

    $resto = $numtotal10 % 10;
    $digito = ($resto == 0) ? 0 : (10 - $resto);

    return $digito;
}

function digitoVerificador_barra(string $numero, int $base = 9, int $r = 0): int
{
    $numtotal11 = 0;
    $fator = 2;

    for ($i = strlen($numero); $i > 0; $i--) {
        $numeros[$i] = substr($numero, $i - 1, 1);
        $numtotal11 += $numeros[$i] * $fator;
        $fator = ($fator == $base) ? 1 : $fator + 1;
    }

    $resto = $numtotal11 % 11;
    $digito = ($resto == 0 || $resto == 1) ? 0 : (11 - $resto);

    return $r == 0 ? $digito : $resto;
}

function formata_numero(string $numero, int $loop, int $insert, string $tipo = "geral"): string
{
    if ($tipo == "geral") {
        $numero = str_replace(",", "", $numero);
        while (strlen($numero) < $loop) {
            $numero = $insert . $numero;
        }
    }
    if ($tipo == "valor") {
        $numero = str_replace(",", "", $numero);
        while (strlen($numero) < $loop) {
            $numero =
