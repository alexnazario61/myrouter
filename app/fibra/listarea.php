<div class="breadcrumb clearfix">
    <ul>
        <li><a href="index.php?app=Dashboard">Dashboard</a></li>
        <li><a href="?app=Fibra">Fibra</a></li> <!-- Link to Fibra page -->

        <li class="active">No</li> <!-- Current page indicator -->
    </ul>
</div>

<?php 
// Check if user has permission 'e1'
if($permissao['e1'] == S) { ?>

    <?php 
    // Check if 'reg' GET parameter is set to 1, 2, or 3
    if ($_GET['reg'] == '1') { ?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                <i class="fa fa-times-circle"></i></button> 
            <strong>Atenção!</strong> No cadastrado com sucesso. <!-- Success message for creating a new record -->
        </div>
    <?php } elseif ($_GET['reg'] == '2') { ?>
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                <i class="fa fa-times-circle"></i></button> 
            <strong>Atenção!</strong> Area alterada com sucesso. <!-- Success message for updating a record -->
        </div>
    <?php } elseif ($_GET['reg'] == '3') { ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                <i class="fa fa-times-circle"></i></button> 
            <strong>Atenção!</strong> No excluído com sucesso. <!-- Success message for deleting a record -->
        </div>
    <?php } ?>
        
        <div class="page-header">
          <h1>Nos</h1> <!-- Page title -->
        </div>
        
        <div class="row" id="powerwidgets">
          <div class="col-md-12 bootstrap-grid"> 
            
            <div class="powerwidget" id="" data-widget-editbutton="false">
              <header>
                <h2>Gerenciar<small>Fibra</small></h2> <!-- Title of the manage page for Fibra -->
              </header>
              <div class="inner-spacer">
              
                    <div class="btn-group">
	<button class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown">
	<i class="fa fa-bars"></i> EXPORTAR </button> <!-- Button to export table data -->
	<ul class="dropdown-menu " role="menu">
	<li><a href="#" onClick ="$('#table-1').tableExport({type:'json',escape:'false'});"> <img src='assets/images/json.png' width='24px'> JSON</a></li> <!-- Export as JSON -->
	<li class="divider"></li>
	<li><a href="#" onClick ="$('#table-1').tableExport({type:'xml',escape:'false'});"> <img src='assets/images/xml.png' width='24px'> XML</a></li> <!-- Export as XML -->
	<li><a href="#" onClick ="$('#table-1').tableExport({type:'sql'});"> <img src='assets/images/sql.png' width='24px'> SQL</a></li> <!-- Export as SQL -->
	<li class="divider"></li>
	<li><a href="#" onClick ="$('#table-1').tableExport({type:'csv',escape:'false'});"> <img src='assets/images/csv.png' width='24px'> CSV</a></li> <!-- Export as CSV -->
	<li><a href="#" onClick ="$('#table-1').tableExport({type:'txt',escape:'false'});"> <img src='assets/images/txt.png' width='24px'> TXT</a></li> <!-- Export as TXT -->
	<li class="divider"></li>				
								
	<li><a href="#" onClick ="$('#table-1').tableExport({type:'excel',escape:'false'});"> <img src='assets/images/xls.png' width='24px'> XLS</a></li> <!-- Export as XLS -->
	<li><a href="#" onClick ="$('#table-1').tableExport({type:'doc',escape:'false'});"> <img src='assets/images/word.png' width='24px'> Word</a></li> <!-- Export as Word -->
	<li><a href="#" onClick ="$('#table-1').tableExport({type:'powerpoint',escape:'false'});"> <img src='assets/images/ppt.png' width='24px'> PowerPoint</a></li> <!-- Export as PowerPoint -->
	<li class="divider"></li>
	<li><a href="#" onClick ="$('#table-1').tableExport({type:'png',escape:'false'});"> <img src='assets/images/png.png' width='24px'> PNG</a></li> <!-- Export as PNG -->
	<li><a href="#" onClick ="$('#table-1').tableExport({type:'pdf',pdfFontSize:'7',escape:'false'});"> <img src='assets/images/pdf.png' width='24px'> PDF</a></li> <!-- Export as PDF -->
		</ul>
		</div>	<br>
	      <br>
              
                <table class="table table-striped table-hover" id="table-1">
                  <thead>
                    <tr>
                      <th>Cidade</th> <!-- Column for city name -->
                      <th>lat</th> <!-- Column for latitude -->
                      
