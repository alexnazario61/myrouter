<?php
// Decode the id from GET request
$idmk = base64_decode($_GET['id']);

// Query the database for the server details based on the id
$conexaomk = $mysqli->query("SELECT * FROM servidores WHERE id = '$idmk'");

// Fetch the server details into an associative array
$mk = mysqli_fetch_array($conexaomk);

// Check if the rmid parameter in the GET request is equal to "Ok"
if ($_GET['rmid'] == "Ok") {

    // Decode the id from GET request
    $idmk = base64_decode($_GET['id']);

    // Query the database for the server details based on the id
    $conexaomk = $mysqli->query("SELECT * FROM servidores WHERE id = '$idmk'");

    // Fetch the server details into an associative array
    $mk = mysqli_fetch_array($conexaomk);

    // Decode the user from GET request
    $user = base64_decode($_GET['user']);

    // Initialize the routeros_api class
    $API = new routeros_api();

    // Set debug mode to false
    $API->debug = false;

    // Connect to the Mikrotik router
    if ($API->connect(''.$mk[ip].'', ''.$mk[login].'', ''.$mk[senha].'')) {

        // Write the command to remove the active hotspot user
        $API->write('/ip/hotspot/active/remove',false);

        // Write the user id to be removed
        $API->write('=.id='.$user.'' );

        // Read the response from the router
        $ARRAY = $API->read();

        // Get the reference id from GET request
        $ref = $_GET['id'];
    }

    // Redirect to the index page with the specified query parameters
    header("Location: index.php?app=Wireless&id=$ref&reg=1");	
}

?>
        <div class="breadcrumb clearfix">
          <ul>
            <li><a href="index.php?app=Dashboard">Dashboard</a></li>
            <li><a href="index.php?app=Servidores">Mikrotik</a></li>
            <li class="active">Wireless</li>
          </ul>
        </div>
        
        <?php if($permissao['mk8'] == S) { ?>
        
         <?php if ($_GET['reg'] == '1') { ?>
	<div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
	<i class="fa fa-times-circle"></i></button>
        <strong>Atenção!</strong> Usuário derrubado do HotSpot. </div>
	<?php } ?>
        
        <div class="page-header">
          <h1>Wireless<small><?php echo $mk['servidor']; ?></small></h1>
        </div>
               
        <div class="row" id="powerwidgets">
          <div class="col-md-12 bootstrap-grid"> 
            
            <div class="powerwidget" id="" data-widget-editbutton="false">
              <header>
                <h2>Tabela Usuários Conectados </h2>
              </header>
              <div class="inner-spacer">
              
                // Export button with various options
                <div class="btn-group">
	<button class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown">
	<i class="fa fa-bars"></i> EXPORTAR </button>
	<ul class="dropdown-menu " role="menu">
	<li><a href="#" onClick ="$('#table-1').tableExport({type:'json',escape:'false'});"> <img src='assets/images/json.png' width='24px'> JSON</a></li>
	<li class="divider"></li>
	<li><a href="#" onClick ="$('#table-1').tableExport({type:'xml',escape:'false'});"> <img src='assets/images/xml.png' width='24px'> XML</a></li>
	<li><a href="#" onClick ="$('#table-1').tableExport({type:'sql'});"> <img src='assets/images/sql.png' width='24px'> SQL</a></li>
	<li class="divider"></li>
	<li><a href="#" onClick ="$('#table-1').tableExport({type:'csv',escape:'false'});"> <img src='assets/images/csv.png' width='24px'> CSV</a></li>
	<li><a href="#" onClick ="$('#table-1').tableExport({type:'txt',escape:'false'});"> <img src='assets/images/txt.png' width='24px'> TXT</a></li>
	<li class="divider"></li>				
								
	<li><a href="#" onClick ="$('#table-1').tableExport({type:'excel',escape:'false'});"> <img src='assets/images/xls.png' width='24px'> XLS</a></li>
	<li><a href="#" onClick ="$('#table-1').tableExport({type:'doc',escape:'false'});"> <img src='assets/images/word.png' width='24px'> Word</a></li>
	<li><a href="#" onClick ="$('#table-1').tableExport({type:'powerpoint',escape:'false'});"> <img src='assets/images/ppt.png' width='24px'> PowerPoint</a></li>
	<li class="divider"></li>
	<li><a href="#" onClick ="$('#table-1').tableExport({type:'png',escape:'false'});"> <img src='assets/images/png.png' width='24px'> PNG
