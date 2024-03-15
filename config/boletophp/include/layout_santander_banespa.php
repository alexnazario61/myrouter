<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="Generator" content="Projeto BoletoPHP - www.boletophp.com.br - Licença GPL">
    <title><?php echo $dadosboleto["identificacao"]; ?></title>
    <style>
        .cp { font-weight: bold; font-size: 10px; color: black; }
        .ti { font: 9px Arial, Helvetica, sans-serif; }
        .ld { font-weight: bold; font-size: 15px; color: #000000; }
        .ct { font: 9px "Arial Narrow"; color: #000033; }
        .cn { font: 9px Arial; color: black; }
        .bc { font-weight: bold; font-size: 20px; color: #000000; }
        .ld2 { font-weight: bold; font-size: 12px; color: #000000; }
    </style>
</head>
<body text="#000000" bgcolor="#ffffff">

<?php
$empresaId = 1;
$emp = $conn->query("SELECT * FROM empresa WHERE id = '$empresaId'");
$empresa = $emp->fetch_assoc();
$empresaFoto = $empresa['foto'];
?>

<table width=666 cellspacing=0 cellpadding=0 border=0>
    <tr>
        <td valign=top class=cp>
            <div align="CENTER">Instruções de Impressão</div>
        </TD>
    </TR>
    <TR>
        <TD valign=top class=cp>
            <div align="left">
                <ul>
                    <li>Imprima em impressora jato de tinta (ink jet) ou laser em qualidade normal ou alta (Não use modo econômico).
                    <li>Utilize folha A4 (210 x 297 mm) ou Carta (216 x 279 mm) e margens mínimas à esquerda e à direita do formulário.
                    <li>Corte na linha indicada. Não rasure, risque, fure ou dobre a região onde se encontra o código de barras.
                    <li>Caso não apareça o código de barras no final, clique em F5 para atualizar esta tela.
                    <li>Caso tenha problemas ao imprimir, copie a seqüencia numérica abaixo e pague no caixa eletrônico ou no internet banking:<br><br>
                    <span class="ld2">
                        &nbsp;&nbsp;&nbsp;&nbsp;Linha Digitável: &nbsp;<?php echo $dadosboleto["linha_digitavel"]?><br>
                        &nbsp;&nbsp;&nbsp;&nbsp;Valor: &nbsp;&nbsp;R$ <?php echo $dadosboleto["valor_boleto"]?><br>
                    </span>
            </div>
        </td>
    </tr>
</table>
<br>
<table cellspacing=0 cellpadding=0 width=666 border=0>
    <tbody>
        <tr>
            <td class=ct width=666>
                <img height=1 src="config/boletophp/imagens/6.png" width=665 border=0>
            </td>
        </tr>
        <tr>
            <td class=ct width=666>
                <div align=right>
                    <b class=cp>Recibo do Sacado</b>
                </div>
            </td>
        </tr>
    </tbody>
</table>
<table width=666 cellspacing=5 cellpadding=0 border=0>
    <tr>
        <td width=41>
            <img height="56px" width="178px" src="assets/images/<?php echo $empresaFoto; ?>">
        </td>
        <td class=ti width=455>
            <?php echo $dadosboleto["identificacao"]; ?>
            <?php echo isset($dadosboleto["cpf_cnpj"]) ? "<br>" . $dadosboleto["cpf_cnpj"] : ''; ?>
            <br>
            <?php echo $dadosboleto["endereco"]; ?><br>
            <?php echo $dadosboleto["cidade_uf"]; ?><br>
        </td>
        <td align=RIGHT width=150 class=ti>
            &nbsp;
        </td>
    </tr>
</table>
<br>
<table cellspacing=0 cellpadding=0 border=0>
    <tbody>
        <tr>
            <td class=cp width=7 height=13>
                <img height=13 src="config/boletophp/imagens/logosantander.jpg" width="140" height="37" border=0>
            </td>
            <td width=3 valign=bottom>
                <img height=22 src="config/boletophp/imagens/3.png" width=2 border=0>
            </td>
            <td class=cpt width=58 valign=bottom>
                <div align=center>
                    <font class=bc><?php echo $dadosboleto["codigo_banco_com_dv"]?></font>
                </div>
            </td>
            <td width=3 valign=bottom>
                <img height=22 src="config/
