<div class="breadcrumb clearfix">
    <ul>
        <li><a href="index.php?app=Dashboard">Dashboard</a></li>
        <li class="active">Ubiquiti</li>
    </ul>
</div>
<?php
// Check if the user has permission to access this page
if($permissao['cu1'] == S) {
?>

    <?php 
    // Display success messages based on the GET parameter 'reg'
    if ($_GET['reg'] == '1') {
        echo '        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                <i class="fa fa-times-circle"></i></button>
            <strong>Atenção!</strong> Registro cadastrado com sucesso. </div>';
    }
    if ($_GET['reg'] == '2') {
        echo '        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                <i class="fa fa-times-circle"></i></button>
            <strong>Atenção!</strong> Registro alterado com sucesso. </div>';
    }
    if ($_GET['reg'] == '3') {
        echo '        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                <i class="fa fa-times-circle"></i></button>
            <strong>Atenção!</strong> Registro excluído com sucesso. </div>';
    }
     ?>

        <div class="page-header">
          <h1>Ubiquiti</h1>
        </div>
        
        <div class="row" id="powerwidgets">
          <div class="col-md-12 bootstrap-grid"> 
            
            <div class="powerwidget blue" id="" data-widget-editbutton="false">
            
              <header>
                <h2>Gerenciar<small>UBNT</small></h2>
              </header>
              
              <div class="inner-spacer">
    // Export button with various options for exporting the table data
    <button class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown">
	<i class="fa fa-bars"></i> EXPORTAR </button>
	<ul class="dropdown-menu " role="menu">
	<li><a href="#" onClick ="$('#table-1').tableExport({type:'json',escape:'false'});"> <img src='assets/images/json.png' width='24px'> JSON</a></li>
	<li class="divider"></li>
	<li><a href="#" onClick ="$('#table-1').tableExport({type:'xml',escape:'false',ignoreColumn:'[7]'});"> <img src='assets/images/xml.png' width='24px'> XML</a></li>
	<li><a href="#" onClick ="$('#table-1').tableExport({type:'sql'});"> <img src='assets/images/sql.png' width='24px'> SQL</a></li>
	<li class="divider"></li>
	<li><a href="#" onClick ="$('#table-1').tableExport({type:'csv',escape:'false'});"> <img src='assets/images/csv.png' width='24px'> CSV</a></li>
	<li><a href="#" onClick ="$('#table-1').tableExport({type:'txt',escape:'false'});"> <img src='assets/images/txt.png' width='24px'> TXT</a></li>
	<li class="divider"></li>

	<li><a href="#" onClick ="$('#table-1').tableExport({type:'excel',escape:'false'});"> <img src='assets/images/xls.png' width='24px'> XLS</a></li>
	<li><a href="#" onClick ="$('#table-1').tableExport({type:'doc',escape:'false'});"> <img src='assets/images/word.png' width='24px'> Word</a></li>
	<li><a href="#" onClick ="$('#table-1').tableExport({type:'powerpoint',escape:'false'});"> <img src='assets/images/ppt.png' width='24px'> PowerPoint</a></li>
	<li class="divider"></li>
	<li><a href="#" onClick ="$('#table-1').tableExport({type:'png',escape:'false'});"> <img src='assets/images/png.png' width='24px'> PNG</a></li>
	<li><a href="#" onClick ="$('#table-1').tableExport({type:'pdf',pdfFontSize:'7',escape:'false'});"> <img src='assets/images/pdf.png' width='24px'> PDF</a></li>
		</ul>
		</div>	<br>
	      <br>
                <table class="table table-striped table-hover" id="table-1">
                  <thead>
                    <tr>
                      <th>Cliente</th>
                      <th>Ip</th>
                      <th>Mac</th>
                      <th>CCQ</th>
                      <th>RX</th>
                      <th>TX</th>
                      <th>Sinal</th>
                      <th>DOWN</th>
                      <th>UP</th>
                      <th>Periodo</th>
                      <th>Ação</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php

        // Query to fetch data from the 'assinaturas' table where 'ip_ubnt' is not empty
        $consultas = $mysqli->query("SELECT
