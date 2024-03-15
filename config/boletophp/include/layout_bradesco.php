<?php
$emp = mysqli_query($conn, "SELECT * FROM empresa WHERE id = 1");
$empresa = mysqli_fetch_array($emp);
?>

<!DOCTYPE HTML>
<html>
<head>
    <title><?= htmlspecialchars($dadosboleto["identificacao"]) ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <meta name="Generator" content="Projeto BoletoPHP - www.boletophp.com.br - Licença GPL">
    <style type="text/css">
        /* ... */
    </style>
</head>

<body text=#000000 bgColor=#ffffff topMargin=0 rightMargin=0>
    <table width=666 cellspacing=0 cellpadding=0 border=0>
        <tr>
            <td valign=top class=cp>
                <div align="CENTER">Instruções de Impressão</div>
            </TD>
        </TR>
        <!-- ... -->
    </table>

    <table cellspacing=0 cellpadding=0 width=666 border=0>
        <tbody>
            <tr>
                <td class=ct width=150>
                    <img height="56px" width="178px" src="assets/images/<?= htmlspecialchars($empresa['foto']) ?>" alt="Company logo">
                </td>
                <!-- ... -->
            </tr>
        </tbody>
    </table>

    <!-- ... -->
</body>
</html>
