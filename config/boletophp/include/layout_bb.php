<?php
// Connect to the database and select the company information
$emp = mysql_query("SELECT * FROM empresa WHERE id = '1'");
$empresa = mysql_fetch_array($emp);

// Get the company logo
$empresa['foto'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title><?php echo $dadosboleto["identificacao"]; ?></title>
<META http-equiv=Content-Type content=text/html charset=ISO-8859-1>
<meta name="Generator" content="Projeto BoletoPHP - www.boletophp.com.br - Licença GPL" />

<style type="text/css">
<!--
.ti {font: 9px Arial, Helvetica, sans-serif}
-->
</style>
</head>

<STYLE>

@media screen,print {

/* Define the styles for the screen and print media types */

}

</STYLE>

</head>
<body>

<div id="container">

<!-- Header section with the company logo and instructions -->
<div id="instr_header">
	<h1><?php echo $dadosboleto["identificacao"]; ?> <?php echo isset($dadosboleto["cpf_cnpj"]) ? $dadosboleto["cpf_cnpj"] : '' ?></h1>
	<address><?php echo $dadosboleto["endereco"]; ?><br></address>
	<address><?php echo $dadosboleto["cidade_uf"]; ?></address>
</div>

<!-- Instructions section -->
<div id="">
	<div id="instr_content">
		<p>
			O pagamento deste boleto tamb&eacute;m poder&aacute; ser efetuado 
			nos terminais de Auto-Atendimento BB.
		</p>

		<h2>Instru&ccedil;&otilde;es</h2>
		<ol>
		<li>
			Imprima em impressora jato de tinta (ink jet) ou laser, em 
			qualidade normal ou alta. N&atilde;o use modo econ&ocirc;mico. 
			<p class="notice">Por favor, configure margens esquerda e direita
			para 17mm.</p>
		</li>
		<li>
			Utilize folha A4 (210 x 297 mm) ou Carta (216 x 279 mm) e margens
			m&iacute;nimas &agrave; esquerda e &agrave; direita do 
			formul&aacute;rio.
		</li>
		<li>
			Corte na linha indicada. N&atilde;o rasure, risque, fure ou dobre 
			a regi&atilde;o onde se encontra o c&oacute;digo de barras
		</li>
		</ol>
	</div>	<!-- id="instr_content" -->
</div>	<!-- id="instructions" -->

<!-- Boleto section -->
<div id="boleto">
	<div class="cut">
		<p>Corte na linha pontilhada</p>
	</div>

	<!-- Bank slip header with the bank logo, bank code, and line number -->
	<table class="header" border=0 cellspacing="0" cellpadding="0">
	<tbody>
	<tr>
		<td width=150><IMG SRC="config/boletophp/imagens/logobb.jpg"></td>
		<td width=50>
		<div class="field_cod_banco"><?php echo $dadosboleto["codigo_banco_com_dv"]?></div>
		</td>
		<td class="linha_digitavel"><?php echo $dadosboleto["linha_digitavel"]?></td>
	</tr>
	</tbody>
	</table>

	<!-- Bank slip lines with the information about the debtor, document, and value -->
	<table class="line" cellspacing="0" cellpadding="0">
	<tbody>
	<tr class="titulos">
		<td class="cedente">Cedente</TD>
		<td class="ag_cod_cedente">Ag&ecirc;ncia / C&oacute;digo do Cedente</td>
		<td class="especie">Esp&eacute;cie</TD>
		<td class="qtd">Quantidade</TD>
		<td class="nosso_numero">Nosso n&uacute;mero</td>
	</tr>

	<tr class="campos">
		<td class="cedente"><?php echo $dadosboleto["cedente"]; ?>&nbsp;</td>
		<td class="ag_cod_cedente"><?php echo $dadosboleto["agencia_codigo"]?> &nbsp;</td>
		<td class="especie"><?php echo $dadosboleto["especie"]?>&nbsp;</td>
		<TD class="qtd"><?php echo $dadosboleto["quantidade"]?>&nbsp;</td>
		<TD class="nosso_numero"><?php echo $dadosboleto["nosso_numero
