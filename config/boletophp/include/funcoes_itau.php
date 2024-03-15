<?php

// BoletoPhp - Versão Beta
// Licença GPL - GNU General Public License
// Available at: http://pt.wikipedia.org/wiki/GNU_General_Public_License

// Originado do Projeto BBBoletoFree
// Equipe Coordenação Projeto BoletoPhp: <boletophp@boletophp.com.br>
// Desenvolvimento Boleto Itaú: Glauber Portella

// Constants
define('FINE', 1);
define('LARGE', 3);
define('HEIGHT', 50);

// Generate a digit verifier for a barcode
function digitoVerificador_barra($numero) {
    $resto2 = modulo_11($numero, 9, 1);
    $digito = 11 - $resto2;
    if ($digito == 0 || $digito == 1 || $digito == 10 || $digito == 11) {
        $dv = 1;
    } else {
        $dv = $digito;
    }
    return $dv;
}

// Format a number with padding and/or inserting a specific character
function formata_numero($numero, $loop, $insert, $tipo = 'geral') {
    if ($tipo == 'geral') {
        $numero = str_replace(",", "", $numero);
        while (strlen($numero) < $loop) {
            $numero = $insert . $numero;
        }
    }
    if ($tipo == 'valor') {
        $numero = str_replace(",", "", $numero);
        while (strlen($numero) < $loop) {
            $numero = $insert . $numero;
        }
    }
    if ($tipo == 'convenio') {
        while (strlen($numero) < $loop) {
            $numero = $numero . $insert;
        }
    }
    return $numero;
}

// Calculate the fator vencimento
function fator_vencimento($data) {
    $data = explode("/", $data);
    $ano = $data[2];
    $mes = $data[1];
    $dia = $data[0];
    return (abs((_dateToDays("1997", "10", "07")) - (_dateToDays($ano, $mes, $dia))));
}

// Convert a date to days
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
    return (floor((146097 * $century) / 4) + floor((1461 * $year) / 4) + floor((153 * $month + 2) / 5) + $day + 1721119);
}

// Modulo 10 calculation
function modulo_10($num) {
    $numtotal10 = 0;
    $fator = 2;

    for ($i = strlen($num); $i > 0; $i--) {
        $numeros[$i] = substr($num, $i - 1, 1);
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
    $digito = 10 - $resto;
    if ($resto == 0) {
        $digito = 0;
    }
    return $digito;
}

// Modulo 11 calculation
function modulo_11($num, $base = 9, $r = 0) {
    $soma = 0;
    $fator = 2;

    for ($i = strlen($num); $i > 0; $i--) {
        $numeros[$i] = substr($num, $i - 1, 1);
        $parcial[$i] = $numeros[$i] * $fator;
        $soma += $parcial[$i];
        if ($fator == $base) {
            $fator = 1;
        }
        $fator++;
    }

    if ($r == 0) {
        $soma *= 10;
        $digito = $soma % 11;
        if ($digito == 10) {
            $digito = 0;
        }
        return $digito;
    } elseif ($r == 1) {
        $resto = $soma % 11;
        return $resto;
    }
}

// Monta a linha digitável
function monta_linha_digitavel($codigo) {
    $banco = substr($codigo, 0, 3);
    $moeda = substr($codigo, 3, 1);
    $ccc = substr($codigo, 19, 3);
    $ddnnum = substr($codigo, 22, 2);
    $dv1 = modulo_10($banco . $moeda . $ccc . $ddnnum);
    $resnnum = substr($codigo, 24, 6);
    $dac1 = substr($codigo, 
