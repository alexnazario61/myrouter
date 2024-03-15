<?php

/**
 * BoletoPhp - Versão Beta
 *
 * This file is available under the GNU GPL license available at
 * http://pt.wikipedia.org/wiki/GNU_General_Public_License
 *
 * You should have received a copy of the GNU Public License along with this
 * package; if not, write to:
 *
 * Free Software Foundation, Inc.
 * 59 Temple Place - Suite 330
 * Boston, MA 02111-1307, USA.
 *
 * Originally based on the BBBoletoFree project, which had contributions from
 * Daniel William Schultz and Leandro Maniezo, and was derived from PHPBoleto
 * by João Prado Maia and Pablo Martins F. Costa.
 *
 * If you want to collaborate, help us develop for other banks:
 * Visit the BoletoPhp project website: www.boletophp.com.br
 */

// Helper functions
require_once 'helpers.php';

// Boleto data
$bankCode = '356';
$bankName = geraCodigoBanco($bankCode);
$currencyCode = '9';
$dueFactor = fator_vencimento($dadosboleto['data_vencimento']);

// Format values
$value = formata_numero($dadosboleto['valor_boleto'], 10, 0, 'valor');
$agency = formata_numero($dadosboleto['agencia'], 4, 0);
$account = formata_numero($dadosboleto['conta'], 7, 0);
$checkoutDigit = $dadosboleto['carteira'];
$checkoutNumber = formata_numero($dadosboleto['nosso_numero'], 13, 0);

// Calculate checkout digit
$checkoutCobrancaDigito = modulo_10("$checkoutNumber$agency$account");

// Generate barcode
$barcode = "$bankCode$currencyCode" . "0$dueFactor$value$agency$account$checkoutCobrancaDigito$checkoutNumber";
$barcode = dvBarra($barcode);

// Format bank agency and account
$agencia_codigo = "$agency/$account/$checkoutCobrancaDigito";

// Save formatted data to the boleto object
$dadosboleto['codigo_barras'] = $barcode;
$dadosboleto['linha_digitavel'] = monta_linha_digitavel($barcode);
$dadosboleto['agencia_codigo'] = $agencia_codigo;
$dadosboleto['nosso_numero'] = $checkoutNumber;
$dadosboleto['codigo_banco_com_dv'] = $bankName;

// Main functions
function dvBarra(&$numero)
{
    // ... (code for dvBarra function)
}

function formata_numero($numero, $loop, $insert, $tipo = 'geral')
{
    // ... (code for formata_numero function)
}

function fator_vencimento($data)
{
    // ... (code for fator_vencimento function)
}

function geraCodigoBanco($numero)
{
    // ... (code for geraCodigoBanco function)
}

// Additional helper functions
require_once 'modulo10.php';
require_once 'modulo11.php';
require_once 'date_to_days.php';
require_once 'barcode.php';
