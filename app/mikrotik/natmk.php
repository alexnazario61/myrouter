<?php

// Check if the form has been submitted
if(isset ($_POST['cadastrar'])){

    // Assign form data to variables
    $chain = $_POST['chain'];
    $dstaddress = $_POST['dstaddress'];
    $srcaddress = $_POST['srcaddress'];
    $naosrcaddresslist = $_POST['naosrcaddresslist'];
    $srcaddresslist = $_POST['srcaddresslist'];
    $naodstaddresslist = $_POST['naodstaddresslist'];
    $dstaddresslist = $_POST['dstaddresslist'];
    $protocolo = $_POST['protocolo'];
    $naointerfacein = $_POST['naointerfacein'];
    $interfacein = $_POST['interfacein'];
    $naointerfaceout = $_POST['naointerfaceout'];
    $interfaceout = $_POST['interfaceout'];
    $dstport = $_POST['dstport'];
    $toaddresses = $_POST['toaddresses'];
    $toports = $_POST['toports'];
    $conteudo = $_POST['conteudo'];
    $comentario = $_POST['comentario'];
    $servidor = $_POST['servidor'];
    $cliente = $_POST['cliente'];
    $action = $_POST['action'];

    // Concatenate srcaddresslist variables
    $srcaddresslistFull = $naosrcaddresslist.$srcaddresslist;

    // Concatenate dstaddresslist variables
    $dstaddresslistFull = $naodstaddresslist.$dstaddresslist;

    // Concatenate interfacein variables
    $interfaceinFull = $naointerfacein.$interfacein;

    // Concatenate interfaceout variables
    $interfaceoutFull = $naointerfaceout.$interfaceout;

    // Create a new instance of the crud class and insert form data into the 'firewall' table
    $crud = new crud('firewall');  // Pass table name as parameter
    $crud->inserir("chain,dstaddress,srcaddress,naosrcaddresslist,srcaddresslist,naodstaddresslist,dstaddresslist,protocolo,naointerfacein,interfacein,naointerfaceout,interfaceout,dstport,toaddresses,toports,cliente,conteudo,comentario,servidor,action", "'$chain','$dstaddress','$srcaddress','$naosrcaddresslist','$srcaddresslist','$naodstaddresslist','$dstaddresslist','$protocolo','$naointerfacein','$interfacein','$naointerfaceout','$interfaceout','$dstport','$toaddresses','$toports','$cliente','$conteudo','$comentario','$servidor','$action'");

    // Query the 'servidores' table to retrieve server details
    $servidor = $mysqli->query("SELECT * FROM servidores WHERE id = '$servidor'");

    // Fetch server data from the result set
    $mk = mysqli_fetch_array($servidor);

    // Create a new instance of the routeros_api class
    $API = new routeros_api();

    // Disable API debugging
    $API->debug = false;

    // Connect to the MikroTik router
    if ($API->connect(''.$mk[ip].'', ''.$mk[login].'', ''.$mk[senha].''))
    {

        // Write NAT configuration to the router
        $API->write('/ip/firewall/nat/add',false);
        $API->write('=chain='.$chain.'',false);
        $API->write('=action='.$action.'',false );
        if($comentario !='') {
            $API->write('=comment='.$comentario.'', false);
        }
        if($conteudo !='') {
            $API->write('=content='.$conteudo.'',false);
        }
        if($srcaddress !='') {
            $API->write('=src-address='.$srcaddress.'',false);
        }
        if($dstaddress !=''){
            $API->write('=dst-address='.$dstaddress.'',false );
        }

        if($srcaddresslist !='') {
            $API->write('=src-address-list='.$srcaddresslistFull.'', false);
        }
        if($dstaddresslist !=''){
            $API->write('=dst-address-list='.$dstaddresslistFull.'',false );
        }

        if($interfacein !='') {
            $API->write('=in-interface='.$interfaceinFull.'', false);
        }

        if($interfaceout !='') {
            $API->write('=out-interface='.$interfaceoutFull.'', false);
        }

        if($toaddresses !='') {
            $API->write('=to-addresses='.$toaddresses.'',false);
        }
        if($toports !='') {
            $API->write('=to-ports='.$toports.'',false);
        }
        $API->write('=protocol='.$protocolo.'',false );
        $API->write('=dst-port='.$dstport.'',false );
        $API->write('=disabled=no' );

        // Read the router's response
        $ARRAY = $API->read();
  
    }

    // Redirect the user to the index page
    header("Location: index.php?app=NatMKPRINT&reg=1");
}

// Check if the 'Ex' and 'id' GET parameters are set
if ((isset($_GET["Ex"])) && ($_GET["Ex"] == "Del")) {

    // Decode the 'id' and 'srv' GET parameters
    $id = base64_decode($_GET['id']);
    $servidor = base64_decode($_GET['srv']);

    // Create a new instance of the crud class and delete the record with the specified ID
    $crud = new crud('firewall');  // Pass table name as parameter
    $crud->excluir("id = $id"); // Delete record with the specified ID

    // Query the 'servidores' table
