<div class="breadcrumb clearfix">
  <ul>
    <li><a href="index.php?app=Dashboard">Dashboard</a></li> <!-- Link to the Dashboard page -->
    <li class="active">Clientes</li> <!-- Current page title -->
  </ul>
</div>

<?php if($permissao['c1'] == S) { ?> <!-- Check if the user has permission to access this page -->

<?php if ($_GET['reg'] == '1') { ?> <!-- Check if a client has been successfully registered -->
	<div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
	<i class="fa fa-times-circle"></i></button> <!-- Close button for the success message -->
        <strong>Atenção!</strong> Cliente cadastrado com sucesso. <!-- Success message for client registration -->
	</div>
<?php } ?>

<!-- Similar conditional statements for client update and deletion -->

<div class="page-header">
  <h1>Clientes</h1> <!-- Page title -->
</div>

<div class="row" id="powerwidgets">
  <div class="col-md-12 bootstrap-grid"> 
    
    <div class="powerwidget blue" id="" data-widget-editbutton="false">
    
      <header>
        <h2>Gerenciar<small>Clientes</small></h2> <!-- Title of the page section -->
      </header>

      <div class="inner-spacer">
        
        <!-- Button group for exporting table data -->
        <div class="btn-group">
          <button class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-bars"></i> EXPORTAR </button> <!-- Dropdown toggle button for export options -->
          <ul class="dropdown-menu " role="menu">
            <li><a href="#" onClick ="$('#table-1').tableExport({type:'json',escape:'false'});"> <img src='assets/images/json.png' width='24px'> JSON</a></li> <!-- Export as JSON -->
            <li class="divider"></li> <!-- Divider between export options -->
            <li><a href="#" onClick ="$('#table-1').tableExport({type:'xml',escape:'false',ignoreColumn:'[6]'});"> <img src='assets/images/xml.png' width='24px'> XML</a></li> <!-- Export as XML -->
            <li><a href="#" onClick ="$('#table-1').tableExport({type:'sql'});"> <img src='assets/images/sql.png' width='24px'> SQL</a></li> <!-- Export as SQL -->
            <li class="divider"></li> <!-- Divider between export options -->
            <li><a href="#" onClick ="$('#table-1').tableExport({type:'csv',escape:'false'});"> <img src='assets/images/csv.png' width='24px'> CSV</a></li> <!-- Export as CSV -->
            <li><a href="#" onClick ="$('#table-1').tableExport({type:'txt',escape:'false'});"> <img src='assets/images/txt.png' width='24px'> TXT</a></li> <!-- Export as TXT -->
            <li class="divider"></li> <!-- Divider between export options -->
            <li><a href="#" onClick ="$('#table-1').tableExport({type:'excel',escape:'false'});"> <img src='assets/images/xls.png' width='24px'> XLS</a></li> <!-- Export as Excel -->
            <li><a href="#" onClick ="$('#table-1').tableExport({type:'doc',escape:'false'});"> <img src='assets/images/word.png' width='24px'> Word</a></li> <!-- Export as Word -->
            <li><a href="#" onClick ="$('#table-1').tableExport({type:'powerpoint',escape:'false'});"> <img src='assets/images/ppt.png' width='24px'> PowerPoint</a></li> <!-- Export as PowerPoint -->
            <li class="divider"></li> <!-- Divider between export options -->
            <li><a href="#" onClick ="$('#table-1').tableExport({type:'png',escape:'false'});"> <img src='assets/images/png.png' width='24px'> PNG</a></li> <!-- Export as PNG -->
            <li><a href="#" onClick ="$('#table-1').tableExport({type:'pdf',pdfFontSize:'7',escape:'false'});"> <img src='assets/images/pdf.png' width='24px'> PDF</a></li> <!-- Export as PDF -->
          </ul>
        </div>

        <!-- Spacer elements -->
        <br><br>

        <!-- Table displaying client information -->
        <table class="table table-striped table-hover" id="table-1">
          <thead>
            <tr>
              <th>Nome</th> <!-- Column for client name -->
              <th>CPF/CNPJ</th> <!-- Column for client CPF/CNPJ -->
              <th>Telefone</th> <!-- Column for client phone number -->
              <th>Endereço</th> <!-- Column for client address -->
              <th>Cidade</th> <!-- Column for client city -->
              <th>Status</th> <!-- Column for client status -->
              <th width="155">Ações</th> <!-- Column for available actions (edit, delete, etc.) -->
            </tr>
          </thead>
          <tbody>
          <?php
            $idempresa = $_SESSION['empresa']; // Get the current user's company ID
            $consultas = $mysqli->query("SELECT * FROM clientes WHERE empresa = '$idempresa'"); // Query to fetch clients for the current user's company
            while($campo = mysqli_fetch_array($consultas)){ // Loop through the fetched clients
