// Bank information
$codigobanco = "399";
$codigo_banco_com_dv = geraCodigoBanco($codigobanco);
$nummoeda = "9"; // Real (Brazilian currency)


$fator_vencimento = fator_vencimento($dadosboleto["data_vencimento"]);


// Format values
$valor = formata_numero($dadosboleto["valor_boleto"],10,0,"valor");
$carteira = $dadosboleto["carteira"];
$codigocedente = formata_numero($dadosboleto["codigo_cedente"],7,0);
$ndoc = $dadosboleto["numero_documento"];
$vencimento = $dadosboleto["data_vencimento"];
$nnum = formata_numero($dadosboleto["numero_documento"],13,0);


$nossonumero = geraNossoNumero($nnum,$codigocedente,$vencimento,'4');


$vencjuliano = dataJuliano($vencimento);


$barra = "$codigobanco$nummoeda$fator_vencimento$valor$codigocedente$nnum$vencjuliano$app";
$dv = digitoVerificador_barra($barra, 9, 0);
$linha = substr($barra,0,4) . $dv . substr($barra,4);


$dadosboleto["codigo_barras"] = $linha;
$dadosboleto["linha_digitavel"] = monta_linha_digitavel($linha);
$dadosboleto["agencia_codigo"] = $agencia_codigo;
$dadosboleto["nosso_numero"] = $nossonumero;
$dadosboleto["codigo_banco_com_dv"] = $codigo_banco_com_dv;
