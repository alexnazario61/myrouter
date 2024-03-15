<?php
require_once 'config/conexao.class.php';
$con = new conexao();
$con->connect();

$idsici = base64_decode($_GET['sici']);
$stmt = $con->prepare("SELECT * FROM sici WHERE id = ?");
$stmt->bind_param("i", $idsici);
$stmt->execute();
$result = $stmt->get_result();
$sici = $result->fetch_assoc();
$rowCount = $result->num_rows;

if ($rowCount > 0) {
    $arquivo = "XML/sici$idsici.xml";

    $ponteiro = fopen($arquivo, "w");
    if (!$ponteiro) {
        die("Error opening file: " . $arquivo);
    }

    // Generating XML using heredoc syntax
    $xml = <<<XML
<?xml version='1.0' encoding='utf-8'?>
<root>
  <UploadSICI ano="{$sici['ano']}" mes="{$sici['mes']}">
    <Outorga fistel="{$sici['outorga']}">
XML;

    // Generating Indicador elements for IEM4, IEM5, IEM9, and IEM10
    // ...

    $xml .= "</Outorga></UploadSICI></root>";

    if (fwrite($ponteiro, $xml) === false) {
        die("Error writing to file: " . $arquivo);
    }

    fclose($ponteiro);
}

header("Location: assets/download.php?arquivo=../XML/sici" . base64_decode($_GET['sici']) . ".xml");
exit;
?>
<script>
document.location.href = ("assets/download.php?arquivo=../XML/sici<?php echo base64_decode($_GET['sici']); ?>.xml");
</script>
