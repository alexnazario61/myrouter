<div class="breadcrumb clearfix">
  <ul>
    <li><a href="index.php?app=Dashboard">Dashboard</a></li> <!-- Link to the Dashboard page -->
    <li class="active">Fornecedores</li> <!-- Current page, "Fornecedores" -->
  </ul>
</div>

<?php if($permissao['fo1'] == S) { ?> <!-- PHP if statement to check if the user has permission to view this page -->

<?php if ($_GET['reg'] == '1') { ?> <!-- PHP if statement to check if the registration was successful -->
	<div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
	<i class="fa fa-times-circle"></i></button> <!-- Close button for the success message -->
        <strong>Atenção!</strong> Fornecedor cadastrado com sucesso. <!-- Success message for the registration -->
	</div>
<?php } ?>

<!-- Similar PHP if statements for alteration and deletion success messages -->

<div class="page-header">
  <h1>Fornecedores</h1> <!-- Page title -->
</div>

<div class="row" id="powerwidgets">
  <div class="col-md-12 bootstrap-grid"> 
    
    <div class="powerwidget" id="" data-widget-editbutton="false">
      <header>
        <h2>Gerenciar<small>Fornecedores</small></h2> <!-- Widget title -->
      </header>
      <div class="inner-spacer">

        <!-- Button group for exporting table data -->
        <div class="btn-group">
          <button class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-bars"></i> EXPORTAR </button> <!-- Button to export table data -->
          <ul class="dropdown-menu " role="menu">
            <li><a href="#" onClick ="$('#table-1').tableExport({type:'json',escape:'false'});"> <img src='assets/images/json.png' width='24px'> JSON</a></li> <!-- JSON export option -->
            <li class="divider"></li> <!-- Divider -->
            <li><a href="#" onClick ="$('#table-1').tableExport({type:'xml',escape:'false'});"> <img src='assets/images/xml.png' width='24px'> XML</a></li> <!-- XML export option -->
            <li><a href="#" onClick ="$('#table-1').tableExport({type:'sql'});"> <img src='assets/images/sql.png' width='24px'> SQL</a></li> <!-- SQL export option -->
            <li class="divider"></li> <!-- Divider -->
            <li><a href="#" onClick ="$('#table-1').tableExport({type:'csv',escape:'false'});"> <img src='assets/images/csv.png' width='24px'> CSV</a></li> <!-- CSV export option -->
            <li><a href="#" onClick ="$('#table-1').tableExport({type:'txt',escape:'false'});"> <img src='assets/images/txt.png' width='24px'> TXT</a></li> <!-- TXT export option -->
            <li class="divider"></li> <!-- Divider -->
            <li><a href="#" onClick ="$('#table-1').tableExport({type:'excel',escape:'false'});"> <img src='assets/images/xls.png' width='24px'> XLS</a></li> <!-- XLS export option -->
            <li><a href="#" onClick ="$('#table-1').tableExport({type:'doc',escape:'false'});"> <img src='assets/images/word.png' width='24px'> Word</a></li> <!-- Word export option -->
            <li><a href="#" onClick ="$('#table-1').tableExport({type:'powerpoint',escape:'false'});"> <img src='assets/images/ppt.png' width='24px'> PowerPoint</a></li> <!-- PowerPoint export option -->
            <li class="divider"></li> <!-- Divider -->
            <li><a href="#" onClick ="$('#table-1').tableExport({type:'png',escape:'false'});"> <img src='assets/images/png.png' width='24px'> PNG</a></li> <!-- PNG export option -->
            <li><a href="#" onClick ="$('#table-1').tableExport({type:'pdf',pdfFontSize:'7',escape:'false'});"> <img src='assets/images/pdf.png' width='24px'> PDF</a></li> <!-- PDF export option -->
          </ul>
        </div> <!-- End of button group -->

        <br>
        <br>

        <!-- Table displaying the list of suppliers -->
        <table class="table table-striped table-hover" id="table-1">
          <thead>
            <tr>
              <th>Código</th> <!-- Supplier code -->
              <th>Nome</th> <!-- Supplier name -->
              <th>CPF/CNPJ</th> <!-- Supplier CPF or CNPJ -->
              <th>Telefone</th> <!-- Supplier phone number -->
              <th>Endereço</th> <!-- Supplier address -->
              <th>Cidade</th> <!-- Supplier city -->
              <th>Status</th> <!-- Supplier status (active or blocked) -->
              <th width="80">Ações</th> <!-- Actions that can be performed on the supplier (edit and delete) -->
            </tr>
          </thead>
          <tbody>
          <?php
            $idempresa = $_SESSION['empresa'];
            $consultas = $mysqli->query("SELECT * FROM fornecedores WHERE empresa = '$idempresa'");
            while($campo = mysqli_fetch_array($consultas)){
          ?>
            <tr>
              <td><?php echo $campo['codigo']; ?>
