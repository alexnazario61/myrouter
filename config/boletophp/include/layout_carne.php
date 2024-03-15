<?php
// Database connection
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT * FROM empresa WHERE id = 1";
$result = $conn->query($query);
$empresa = $result->fetch_assoc();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .cp { font-weight: bold; font-size: 9px; }
        .ti { font-size: 8px; }
        .ld { font-weight: bold; font-size: 14px; }
        .ct { font-size: 8px; }
        .cn { font-size: 8px; }
        .bc { font-weight: bold; font-size: 20px; }
        .ld2 { font-weight: bold; font-size: 10px; }
        .style1 { font-size: 7px; }
    </style>
</head>
<body>
    <div class="folha">
        <table width="500" height="300" border="0">
            <tr>
                <td width="188" height="20" valign="top" scope="col">
                    <span class="campo">
                        <img src="assets/images/<?php echo $empresa['foto']; ?>" width="145" height="30" alt="Company logo">
                    </span>
                </td>
                <td width="140" colspan="9" rowspan="10" valign="top" scope="col">
                    <table width="666" height="32" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="cp" width="150">
                                <span class="campo">
                                    <img src="assets/images/<?php echo $empresa['foto']; ?>" width="145" height="30" alt="Company logo">
                                </span>
                            </td>
                            <td width="3" valign="bottom">
                                <img height="22" src="config/boletophp/imagens/3.png" width="2" alt="Separator">
                            </td>
                            <td class="ld" align="center" width="453" valign="bottom">
                                <span class="campotitulo"><?php echo $dadosboleto["cedente"]; ?></span>
                            </td>
                        </tr>
                        <!-- Other table rows -->
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
