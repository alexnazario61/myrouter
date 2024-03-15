<style>
  @font-face {
    font-family: "codigo";
    src: url("../../assets/BarcodeFont.ttf") format("truetype");
  }

  /* Load the .eot font file for Internet Explorer */
  @font-face {
    font-family: "codigo";
    src: url("../../assets/BarcodeFont.eot");
    format("embedded-opentype");
    font-weight: normal;
    font-style: normal;
  }
</style>

<!-- Breadcrumb for navigation -->
<div class="breadcrumb clearfix">
  <ul>
    <li><a href="index.php?app=Dashboard">Dashboard</a></li>
    <li class="active">Clientes</li>
  </ul>
</div>

<?php
// Check if the user has permission to access this page
if ($permissao['e1'] == 'S') {
  // Display success, info, or danger messages if necessary
  if (isset($_GET['reg']) && $_GET['reg'] == '1') {
    echo '
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
        <i class="fa fa-times-circle"></i></button>
      <strong>Atenção!</strong> Equipamento cadastrado com sucesso.
    </div>
    ';
  } elseif (isset($_GET['reg']) && $_GET['reg'] == '2') {
    echo '
    <div class="alert alert-info alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
        <i class="fa fa-times-circle"></i></button>
      <strong>Atenção!</strong> Equipamento alterado com sucesso.
    </div>
    ';
  } elseif (isset($_GET['reg']) && $_GET['reg'] == '3') {
    echo '
    <div class="alert alert-danger alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
        <i class="fa fa-times-circle"></i></button>
      <strong>Atenção!</strong> Equipamento excluído com sucesso.
    </div>
    ';
  }
}
?>

<div class="page-header">
  <h1>Equipamentos</h1>
</div>

<div class="row" id="powerwidgets">
  <div class="col-md-12 bootstrap-grid">

    <!-- Button to navigate to the equipment creation page -->
    <a href="index.php?app=CadastroEquipamento" class="btn btn-info">Cadastro</a>

    <p></p>

    <!-- PowerWidget container -->
    <div class="powerwidget" id="" data-widget-editbutton="false">
      <header>
        <h2>Gerenciar<small>Equipamentos</small></h2>
      </header>

      <!-- Widget content -->
      <div class="inner-spacer">

        <!-- Export options dropdown -->
        <div class="btn-group">
          <button class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-bars"></i> EXPORTAR
          </button>
          <ul class="dropdown-menu" role="menu">
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
            <li><a href="#" onClick ="$('#table-1').tableExport({type:'png',escape:'false'});"> <img src='assets/images/png.png' width='24px'> PNG</a></li>
            <li><a href="#" onClick ="$('#table-1').tableExport({type:'pdf',pdfFontSize:'7',escape:'false'});"> <img src='assets/images/pdf.png' width='24px'> PDF</a></li>
          </ul>
        </div>

        <!-- Spacer elements -->
        <br>
