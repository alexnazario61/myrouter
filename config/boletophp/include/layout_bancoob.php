<?php
// Connect to the database using the mysql_query function
$emp = mysql_query("SELECT * FROM empresa WHERE id = '1'");

// Fetch the array of the query result into the $empresa variable
$empresa = mysql_fetch_array($emp);

// Retrieve the value of the 'foto' key from the $empresa array
$empresa_foto = $empresa['foto'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title><?php echo $dadosboleto["identificacao"]; ?></title>
<META http-equiv="Content-Type" content="text/html" >
<meta name="Generator" content="Projeto BoletoPHP - www.boletophp.com.br - Licença GPL" />

<style type="text/css">
<!-- 
.ti {font: 9px Arial, Helvetica, sans-serif}
-->
</style>
</HEAD>

<STYLE>

@media screen,print {

/* CSS styles for printing and screen display */

}

</STYLE>

</head>
<body>

<div id="container">

<!-- Container for the boleto information -->

	<div id="instr_header">
		<!-- Header for the boleto information -->
		<h1><?php echo utf8_encode($dadosboleto["identificacao"]); ?> <?php echo isset($dadosboleto["cpf_cnpj"]) ? $dadosboleto["cpf_cnpj"] : '' ?></h1>
		<address><?php echo utf8_encode($dadosboleto["endereco"]); ?> -  <?php echo utf8_encode($dadosboleto["cidade_uf"]); ?> </address>
	</div>	<!-- id="instr_header" -->

	<div id="">
		<!-- Instructions for printing the boleto -->
		<div id="instr_content">
			<h2>Instru&ccedil;&otilde;es</h2>
			<ol>
			<li>
				<p class="notice">Utilize folha A4 (210 x 297 mm) ou Carta (216 x 279 mm) e margens
					m&iacute;nimas &agrave; esquerda e &agrave; direita do
					formul&aacute;rio.</p>
			</li>

			</ol>
		</div>	<!-- id="instr_content" -->
	</div>	<!-- id="instructions" -->
	
	<div id="boleto">
		<!-- Boleto information -->
		<div class="cut">
			<p>Corte na linha pontilhada</p>
		</div>
    		
		<!-- Boleto header with the bank logo and other information -->
		<table class="header" border=0 cellspacing="0" cellpadding="0">
		<tbody>
		<tr>
			<td width=150><IMG SRC="config/boletophp/imagens/logobancoob.jpg"></td>
			<td width=50>
        <div class="field_cod_banco"><?php echo $dadosboleto["codigo_banco_com_dv"]?></div>
			</td>
			<td class="linha_digitavel"><?php echo $dadosboleto["linha_digitavel"]?></td>
		</tr>
		</tbody>
		</table>

		<!-- Boleto lines with information about the cedent, agency, code, species, quantity, and nosso number -->
		<table class="line" cellspacing="0" cellpadding="0">
		<tbody>
		<tr class="titulos">
			<td class="cedente">Cedente</TD>
			<td class="ag_cod_cedente">Ag&ecirc;ncia / C&oacute;digo do Cedente</td>
	
