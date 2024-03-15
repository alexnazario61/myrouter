<?php
// BoletoPhp - Versão Beta
// This file is available under the GPL license, which can be found at http://pt.wikipedia.org/wiki/GNU_General_Public_License

// The code starts by querying a database for the company information that will be used to populate the boleto
$emp = mysql_query("SELECT * FROM empresa WHERE id = '1'");
$empresa = mysql_fetch_array($emp);

// The company logo is retrieved from the database and stored in a variable
$empresa['foto'];

// The HTML document is defined, with a title and a character set
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 Transitional//EN'>
<HTML>
<HEAD>
<TITLE><?php echo $dadosboleto["identificacao"]; ?></TITLE>
<META http-equiv=Content-Type content=text/html charset=ISO-8859-1>

// The CSS styles for the boleto are defined
<style type=text/css>
...
</style> 
</head>

// The body of the HTML document is defined, with a white background and black text
<BODY text=#000000 bgColor=#ffffff topMargin=0 rightMargin=0>

// A table is defined, with a width of 666 pixels and a cellspacing of 0
<table width=666 cellspacing=0 cellpadding=0 border=0>

// The first row of the table contains the title "Instruções de Impressão"
<tr><td valign=top class=cp><DIV ALIGN="CENTER">Instruções 
de Impressão</DIV></TD></TR>

// The second row of the table contains a list of instructions for printing the boleto
<TR><TD valign=top class=cp><DIV ALIGN="left">
<p>
<li>Imprima em impressora jato de tinta (ink jet) ou laser em qualidade normal ou alta (Não use modo econômico).<br>
...
</DIV></td></tr>

// The third row of the table contains the company logo, which was retrieved from the database earlier
<tr><td class=ct width=666><img height=1 src=config/boletophp/imagens/6.png width=665 border=0></td></tr>

// The fourth row of the table contains the title "Recibo do Sacado"
<tr><td class=ct width=666><div align=right><b class=cp>Recibo 
do Sacado</b></div></TD></tr>

// The fifth row of the table contains a table with the boleto's information
<tr><td width=41></TD></tr>
<table cellspacing=5 cellpadding=0 border=0 align=Default>
  <tr>
    <td width=41> <IMG height="56px" width="178px" SRC="assets/images/<?php echo $empresa['foto'];?>"></td>
    <td class=ti width=455><?php echo $dadosboleto["identificacao"]; ?> <?php echo isset($dadosboleto["cpf_cnpj"]) ? "<br>".$dadosboleto["cpf_cnpj"] : '' ?><br>
	<?php echo $dadosboleto["endereco"]; ?><br>
	<?php echo $dadosboleto["cidade_uf"]; ?><br>
    </td>
    <td align=RIGHT width=150 class=ti>&nbsp;</td>
  </tr>
</table>

// The rest of the code contains additional tables and functions for generating the
