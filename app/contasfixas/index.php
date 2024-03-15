<div class="breadcrumb clearfix">
  <ul>
    <!-- The 'Dashboard' link will take the user to the index.php page of the Dashboard application. -->
    <li><a href="index.php?app=Dashboard">Dashboard</a></li>
    <!-- The 'Contas Fixas' link is currently active, indicating that the user is on the 'Contas Fixas' page. -->
    <li class="active">Contas Fixas</li>
  </ul>
</div>

<!-- Check if the user has permission to view this page. If not, display a warning message and stop further processing. -->
<?php if($permissao['p1'] == S) { ?>

<!-- Display success, info, or danger messages based on the value of the 'reg' GET parameter. -->
<?php if ($_GET['reg'] == '1') { ?>
<div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
    <i class="fa fa-times-circle"></i></button>
  <strong>Atenção!</strong> Conta Fixa cadastrado com sucesso. </div>
<?php } ?>
<?php if ($_GET['reg'] == '2') { ?>
<div class="alert alert-info alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
    <i class="fa fa-times-circle"></i></button>
  <strong>Atenção!</strong> Conta Fixa alterado com sucesso. </div>
<?php } ?>
<?php if ($_GET['reg'] == '3') { ?>
<div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
    <i class="fa fa-times-circle"></i></button>
  <strong>Atenção!</strong> Conta Fixa excluído com sucesso. </div>
<?php } ?>
<?php if ($_GET['reg'] == '4') { ?>
<div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
    <i class="fa fa-times-circle"></i></button>
  <strong>Atenção!</strong> Existe assinaturas para esse plano, não é possível remover. </div>
<?php } ?>

<div class="page-header">
  <!-- The page title is 'Contas' with a small subtitle of 'Fixas'. -->
  <h1>Contas<small>Fixas</small></h1>
</div>

<div class="row" id="powerwidgets">
  <div class="col-md-12 bootstrap-grid">

    <!-- A PowerWidget container for managing Contas Fixas. -->
    <div class="powerwidget" id="" data-widget-editbutton="false">
      <header>
        <!-- The widget header has a title of 'Gerenciar Contas Fixas'. -->
        <h2>Gerenciar<small>Contas Fixas</small></h2>
      </header>
      <div class="inner-spacer">

        <!-- A button group for exporting the table data in various formats. -->
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
            <li><a href="#" onClick ="$('#table-1').tableExport({type:'png',escape:'false'});"> <img src='assets/images/png.png' width='24px'> PNG</a></li>
            <li><a href="#" onClick ="$('#table-1').tableExport({type:'pdf',pdfFontSize:'7',escape:'false'});"> <img src='assets/images/pdf.png' width='24px'> PDF</a></li
