<?php
// Set the content type to text/html and charset to ISO-8859-1
header("Content-Type: text/html; charset=ISO-8859-1", true);

// Require necessary classes for database connection and operations
require_once 'config/conexao.class.php';
require_once 'config/crud.class.php';
require_once 'config/mikrotik.class.php';

// Instantiate the database connection class and open a connection
$con = new conexao(); // instancia classe de conxao
$con->connect(); // abre conexao com o banco

// Decode the provided invoice number from base64
$idcliente = base64_decode($_GET['id']);

// Retrieve the invoice details from the database
$imp = $mysqli->query("SELECT * FROM notafiscal WHERE nnota = '$idcliente'");
$csos = mysqli_fetch_array($imp);

// Retrieve the client's details from the database
$idcliente = $csos['cliente'];
$cli = $mysqli->query("SELECT * FROM clientes WHERE id = '$idcliente'");
$cliente = mysqli_fetch_array($cli);

// Retrieve the company's details from the database
$emp = $mysqli->query("SELECT * FROM empresa WHERE id = '1'");
$empresa = mysqli_fetch_array($emp);

// Format the invoice date
$data_emissao = date('d/m/Y',strtotime($csos['emissao']));

// Start the HTML output
?>
<html>
<title>Nota Fiscal <?php echo $csos['nnota']; ?> - <?php echo $csos['clientenome']; ?></title>

// Define the CSS styles for the invoice
<style type="text/css">
...
</style>

// Define the CSS styles for the barcode
<style>
@font-face {
    font-family: "codigo";
    src: url("assets/BarcodeFont.ttf") format("truetype");
}
</style>

<!--[if IE]>
<style>
@font-face {
    font-family: "codigo";
    src: url("assets/BarcodeFont.eot");
}
</style>
<![endif]-->

// Define the CSS styles for the table borders
<style type="text/css">
...
</style>

<center>
<table width="800"><tr><td>

// Display the invoice header
<table style="border:1px solid #666666; padding: 2px 1px 2px 4px;" width="100%">
...
</table>

// Display the invoice details
<table class="borderTable" width="100%">
...
</table>

// Display the client and company details
<table class="borderTable"  width="100%"><tr>
...
</tr></table>

// Display the service details
<table class="borderTable"  width="100%"><tr>
...
</tr></table>

// Display the total value of the invoice
<table class="borderTable"  width="100%"><tr><td>
...
</td></tr></table>

// Display the barcode
<table class="bordasimples" width="100%">
...
</table>

// Display the additional information
<table class="borderTable"  width="100%"><tr><td>
...
</td></tr></table>

// Display the table with tax information
<table class="borderTable"  width="100%"><tr><td>
...
</td></tr></table>

// Display the CFOP code and invoice status
<table class="borderTable"  width="100%"><tr><td>
...
</td></tr></table>

</html>
