<?php
 
// Include the database connection file
include ("../config/conexao.php");

// Require the necessary classes
require_once '../config/conexao.class.php';
require_once '../config/crud.class.php';
require_once '../config/mikrotik.class.php';
require_once '../config/librouteros/RouterOS.php';

// Check if XML data is set in the POST request
if(isset($_POST['xml'])){
 /**
 * Transformando o XML em Objeto
 */
 // Transform XML string to an Object using simplexml_load_string()
 $objXml = simplexml_load_string($_POST['xml']);

 // Extract necessary data from the XML object
 $nome = $objXml->cliente->cliente;
 $chave = $objXml->cobranca->chave;
 $retorno = $objXml->cobranca->retorno;
 $numeroPedido = $objXml->cobranca->documento;
 $valorPago = $objXml->cobranca->valorPago;
 $pag = $objXml->cobranca->pag;

 /**
 * Capturar dados dos itens
 */
 // Initialize an array with the XML object
 $produtos = array($objXml);

 // Loop through the 'cobranca' elements in the XML object
 foreach($objXml->cobranca as $item){
	  $retorno = $item->retorno;		 
      $chave = $item->chave;
	  
      // Convert the status to uppercase
      $status = strtoupper($item->status);

      // If the status is 'I', change it to 'N'
	   if($status == "I"){
			$status = "N";  
		  }

		  // Set the total value and current date
		  $total = $item->total;
	      $data = date('Y-m-d'); 

		  // Update the financeiro table with the new data
		  $sql = $mysqli->query("UPDATE financeiro SET pagamento_fn='$data', situacao='$status', recebido='$total' WHERE chave='$chave'");

      /////////////////////////////////////////

      // Function to format numbers by replacing the first 0 in each part of the number
      function fndata($string)
      {
          $string = str_replace('01','1',$string);
          $string = str_replace('02','2',$string);
          $string = str_replace('03','3',$string);
          $string = str_replace('04','4',$string);
          $string = str_replace('05','5',$string);
          $string = str_replace('06','6',$string);
          $string = str_replace('07','7',$string);
          $string = str_replace('08','8',$string);
          $string = str_replace('09','9',$string);
          return $string;

      }

      // Get the current day, month, and year
      $diannc = date('d');
      $mesnnc = date('m');
      $fndia = fndata($diannc);
      $fnmes = fndata($mesnnc);
      $fnano = date('Y');

      // Extract the formatted valorPago
      $n1 = substr($total,0,-2);
      $n2 = substr($total,-2);
      $vpago = $n1.'.'.$n2;

      // Query the financeiro table to get the pedboleto and pedidofin
      $lcm = $mysqli->query("SELECT * FROM financeiro WHERE chave='$chave'");
      $row = mysqli_num_rows($lcm);

      // Fetch the first row of the query result
      $row1 = mysqli
