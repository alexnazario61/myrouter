<?php
// Include the database connection class
require_once("config/conexao.class.php");

// Define the SQL query to fetch all hotspots with status 'S'
$sql = $mysqli->query("SELECT * FROM hotspots WHERE status = 'S'");
?>
<html><title>HotSpot</title>
<head><body>
<center>
<table width="100%"><tr><td>

<!-- Define the main table for displaying the hotspots -->
<table border="0" style="font-family:verdana; font-size:12; page-break-before: always;" >
<font face="verdana" size="2"><b> Configure sua página de impressão para o formato paisagem.</b></font><br>
	<font face="verdana" size="1">
							Instructions for configuring the font size for Microsoft Internet Explorer and Firefox.
						</font><br>
		<font face="verdana" size="1">
							Microsoft Internet Explorer: View -&gt; Text Size -&gt; Medium
						</font><br>
		<font face="verdana" size="1">
							Firefox: Tools -&gt; Options -&gt; Content -&gt; Fonts & Colors -&gt; Size -&gt; 12
						</font><br><br>

<?php
// Calculate the total number of hotspots
$total = mysqli_num_rows($sql);
?>
<?php
// Define the number of columns for the table displaying the hotspots
$colunas = "3";
?>

<?php
// If there are any hotspots
if ($total>0) {
    // Loop through the hotspots
    for ($i = 0; $i < $total; $i++) {
        // Start a new row every $colunas hotspots
        if (($i%$colunas)==0) {
            echo "</tr>";
            echo "<tr>";
        }
        // Fetch the hotspot data
        $dados = mysqli_fetch_array($sql);
        $nome = $dados["comentario"];
        $login = $dados["login"];
        $tempo = $dados["uptime"];
        $valor = $dados["valor"];
        $senha = $dados["senha"];
?>

<!-- Define a table cell for each hotspot -->
<td style="border:0px solid;padding:5px;" width="317" height="147" background="assets/images/hotspot.png" valign="top" bgcolor="#eeeeee">
<br><font size="1">  
<br><br></font>
<b>HOTSPOT</b> 
<br>
<b>LOGIN:</b> <?php echo $login; ?> <br>
<b>DURAÇÃO:</b> 
<?
// Convert the uptime in
