
<?php

// Enable error reporting for debugging purposes
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ERROR | E_PARSE | E_WARNING );

// Require necessary files
require_once 'conexao.class.php';
require_once 'conexao.php';
require_once 'crud.class.php';
require_once 'mikrotik.class.php';

// Get the company information from the database
$empresa1 = $mysqli->query("SELECT * FROM empresa WHERE id = '1'");
$Cempresa = mysqli_fetch_array($empresa1);
$dias_bloc = $Cempresa['dias_bloc'];

// Connect to the database
$con = new conexao(); // instancia classe de conxao
$con->connect(); // abre conexao com o banco

// Get the list of unpaid invoices that are overdue by the number of days specified in the company settings
$sxd = $mysqli->query("select * from financeiro  where  date_add(vencimento, interval '$dias_bloc' day) < now() and   situacao = 'N'");

// Loop through each overdue invoice
while($daa = mysqli_fetch_array($sxd)){
 
 // Count the number of overdue invoices
 $verificazeros = mysqli_num_rows($sxd);

 // If there are any overdue invoices
 if($verificazeros > 0) {

 // Update the invoice status to 'B' (blocked)
 $idprd = $daa['id'];
 $crud = new crud('financeiro'); // instancia classe com as operações crud, passando o nome da tabela como parametro
 $crud->atualizar("situacao='B'", "id='$idprd'");

 // Get the associated client information
 $codass = $daa['pedido'];
 $ccss = $mysqli->query("SELECT * FROM assinaturas WHERE pedido = '$codass'");
 $cliente = mysqli_fetch_array($ccss);

 // Get the client's ID
 $ccvbv = $cliente['cliente'];
 $ccsscv = $mysqli->query("SELECT * FROM clientes WHERE id = '$ccvbv'");
 $vcsms = mysqli_fetch_array($ccsscv);

 // Get the plan information
 $plano = $cliente['plano'];
 $ppss = $mysqli->query("SELECT * FROM planos WHERE id = '$plano'");
 $plano = mysqli_fetch_array($ppss);

 // Get the server information
 $servidor = $plano['servidor'];
 $ssrv = $mysqli->query("SELECT * FROM servidores WHERE id = '$servidor'");
 $servidor = mysqli_fetch_array($ssrv);

 // If the client has autobloqueio enabled
 if($cliente['autobloqueio'] == 'S') {

 // Block the client's access
 echo 'block  ';
 echo $cliente['login'];

 // Determine the type of connection (hotspot, PPPoE, or IPARP) and block it accordingly
 if($cliente['tipo'] == 'HOTSPOT') {
 // Connect to the MikroTik router and disable the user's hotspot session
 $API = new routeros_api();
 $API->debug = false;
 if ($API->connect(''.$servidor['ip'].'', ''.$servidor['login'].'', ''.$servidor['senha'].''))
 {

 // Get the user's hotspot session information
 $username = $cliente['login'];

 $API->write('/ip/hotspot/active/print', false);
 $API->write('?=user='.$username.'');
 $res = $API->read($res);

 // Disable the user's hotspot session
 $user_login = $res['1'];
 if(!empty($user_login)){
 $API->write('/ip/hotspot/active/remove', false);
 $API->write($user_login);
 $res = $API->read($res);
 }
 }
 $API->disconnect();
 }

 if($cliente['tipo'] == 'PPPoE') {
 // Connect to the MikroTik router and disable the user's PPPoE session
 $API = new routeros_api();
 $API->debug = false;
 if ($API->connect(''.$servidor['ip'].'', ''.$servidor['login'].'', ''.$servidor['senha'].''))
 {
 $username = $cliente['login'];
 $API->write('/ppp/active/print',false);
 $API->write('?=name='.$username.'');
 $res = $API->read($res);

 // Disable the user's PPPoE session
 $user_login = $res['1'];
 if(!empty($user_login)){
 $API->write('/ppp/active/remove',false);
 $API->write($user_login);
 $res = $API->read($res);
 }
 }
 $API->disconnect();
 }

 if($cliente['tipo'] == 'IPARP') {
 // Connect to the MikroTik router and disable the user's IPARP session
 $API = new routeros_api();
 $API->debug = false;
 if ($API->connect(''.$servidor['ip'].'', ''.$servidor['login'].'', ''.$servidor['senha'].''))
 {
 $API->
