<?php

/**
 * BoletoPhp - Versão Beta
 *
 * This file is available under the GNU General Public License.
 * For more information, visit:
 * http://pt.wikipedia.org/wiki/GNU_General_Public_License
 *
 * Equipe Coordenação Projeto BoletoPhp: <boletophp@boletophp.com.br>
 * Desenvolvimento Boleto CEF: Elizeu Alcantara
 */

// Functions
require_once 'functions.php';

// Configuration
$banco = '104';
$convenio = '0000';
$carteira = '10';
$agencia = '1234';
$conta = '56789';
$conta_dv = '0';
$conta_cedente = '00001234';
$conta_cedente_dv = '0';
$inicio_nosso_numero = '000';
$nosso_numero = '00000001';
$valor_boleto = '123456.78';
$data_vencimento = '30/12/2022';

// Generate the bank code with DV
$bank_code = geraCodigoBanco($banco);

// Format values
$formatted_agencia = formata_numero($agencia, 4, '');
$formatted_conta = formata_numero($conta, 5, '');
$formatted_conta_cedente = formata_numero($conta_cedente, 8, '');
$formatted_conta_cedente_dv = formata_numero($conta_cedente_dv, 1, '');
$formatted_nosso_numero = formata_numero($nosso_numero, 8, '');
$formatted_valor_boleto = formata_numero($valor_boleto, 10, 'valor');

// Calculate the fator vencimento
$fator_vencimento = fator_vencimento($data_vencimento);

// Calculate the nosso número
$nosso_numero_completo = $inicio_nosso_numero . $formatted_nosso_numero;
$nosso_numero_dv = digitoVerificador_nossonumero($nosso_numero_completo);

// Calculate the digito verificador of the barcode
$dv = digitoVerificador_barra($bank_code . '9' . $fator_vencimento . $formatted_valor_boleto . $nosso_numero_completo . $formatted_agencia . $formatted_conta_cedente, 9, 0);

// Generate the barcode and linha digitável
$codigo_barras = $bank_code . '9' . $dv . $fator_vencimento . $formatted_valor_boleto . $nosso_numero_completo . $formatted_agencia . $formatted_conta_cedente;
$linha_digitavel = monta_linha_digitavel($codigo_barras);

// Generate the output
$output = [
    'bank_code' => $bank_code,
    'convenio' => $convenio,
    'carteira' => $carteira,
    'agencia' => $formatted_agencia,
    'conta' => $formatted_conta,
    'conta_dv' => $conta_dv,
    'conta_cedente' => $formatted_conta_cedente . '-' . $formatted_conta_cedente_dv,
    'nosso_numero' => $nosso_numero_completo . '-' . $nosso_numero_dv,
    'valor_boleto' => $valor_boleto,
    'data_vencimento' => $data_vencimento,
    'codigo_barras' => $codigo_barras,
    'linha_digitavel' => $linha_digitavel,
];

// Display the output
print_r($output);



<?php

/**
 * Formats a number by adding leading zeros or a specific character.
 *
 * @param string $numero
 * @param int $loop
 * @param string $insert
 * @param string $tipo
 * @return string
 */
function formata_numero($numero, $loop, $insert, $tipo = 'geral')
{
    // Function implementation
}

/**
 * Calculates the fator vencimento based on the due date.
 *
 * @param string $data
 * @return string
 */
function fator_vencimento($data)
{
    // Function implementation
}

/**
 * Calculates the nosso número DV.
 *
 * @param string $numero
 * @return string
 */
function digitoVerificador_nossonumero($numero)
{
    // Function implementation
}

/**
 * Calculates the barcode DV.
 *
 * @param string $numero
 * @param int $base
 * @param int $r
 * @return string
 */
function digitoVerificador_barra($numero, $base = 9, $r = 0)
{
    // Function implementation
}

/**
 * Generates the bank code with DV.
 *
 * @param string $numero
 * @return string
 */
function geraCodigoBanco($numero)
{
    // Function implementation
}

/**
 * Generates the barcode.
 *
 * @param string $cod
