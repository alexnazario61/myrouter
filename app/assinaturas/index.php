// Breadcrumb for navigation
<div class="breadcrumb clearfix">
  <ul>
    <li><a href="index.php?app=Dashboard">Dashboard</a></li>
    <li class="active">Assinaturas</li>
  </ul>
</div>

<?php 
// Check if the user has permission to access this page
if($permissao['a2'] == S) {

  // Display success messages based on GET parameters
  if ($_GET['reg'] == '1') {
    echo '
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
        <i class="fa fa-times-circle"></i></button>
      <strong>Atenção!</strong> Assinatura cadastrada com sucesso. </div>';
  }
  if ($_GET['reg'] == '2') {
    echo '
    <div class="alert alert-info alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
        <i class="fa fa-times-circle"></i></button>
      <strong>Atenção!</strong> Assinatura alterada com sucesso. </div>';
  }
  if ($_GET['reg'] == '3') {
    echo '
    <div class="alert alert-danger alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
        <i class="fa fa-times-circle"></i></button>
      <strong>Atenção!</strong> Assinatura excluída com sucesso. </div>';
  }

  // Page header for Assinaturas
  echo '
  <div class="page-header">
    <h1>Assinaturas</h1>
  </div>';

  // Display table with assinatura information
  echo '
  <div class="row" id="powerwidgets">
    <div class="col-md-12 bootstrap-grid">
      <div class="powerwidget" id="" data-widget-editbutton="false">
        <header>
          <h2>Gerenciar<small>Assinaturas</small></h2>
        </header>

        // Status indicators with different colors
        <div style="padding:10px;background:#4682B4;width:16.66%;color:#ffffff;">&nbsp;Aguardando&nbsp;</div>
        <div style="padding:10px;background:#008000;width:16.66%;color:#ffffff;">&nbsp;Instalado&nbsp;</div>
        <div style="padding:10px;background:#FF0000;width:16.66%;color:#ffffff;">&nbsp;Cancelado&nbsp;</div>
        <div style="padding:10px;background:#FF4500;width:16.66%;color:#ffffff;">&nbsp;Não Encontrado&nbsp;</div>
        <div style="padding:10px;background:#FF7F50;width:16.66%;color:#ffffff;">&nbsp;Sem Equipamento&nbsp;</div>
        <div style="padding:10px;background:#9400D3;width:16.66%;color:#ffffff;">&nbsp;Desinstalação&nbsp;</div>

        // Table showing assinatura details
        <div class="inner-spacer">
          <table class="table table-striped table-hover" id="table-1">
            <thead>
              <tr>
                <th>Login</th>
                <th>Cliente</th>
                <th>Plano</th>
                <th>Servidor</th>
                <th>Valor</th>
                <th>Situação</th>
                <th>Status</th>
                <th width="160">Ações</th>
              </tr>
            </thead>
            <tbody>';

  // Fetch assinatura data from the database
  $idempresa = $_SESSION['empresa'];
  $consultas = $mysqli->query("SELECT * FROM assinaturas WHERE empresa = '$idempresa'");
  while($campo = mysqli_fetch_array($consultas)){

    // Set the background color based on the assinatura situation
    if ($campo['situacao'] == 'S') {
      $cor = "4682B4;color:#ffffff;";
    }
    if ($campo['situacao'] == 'I') {
      $cor = "008000;color:#ffffff;";
    }
    if ($campo['situacao'] == 'C') {
      $cor = "FF0000;color:#ffffff;";
    }
    if ($campo['situacao'] == 'N') {
      $cor = "FF4500;color:#ffffff;";
    }
    if ($campo['situacao'] == 'F') {
      $cor = "FF7F50;color:#ffffff;";
    }
    if ($campo['situacao'] == 'D') {
      $cor = "9400D3;color:#ffffff;";
    }
    if ($campo['status'] == 'N') {
      $cor = "FF0000;color:#ffffff;";
    }

    echo '
    <tr>
      <td style="background:#'.$cor.'">'.$campo['login'].'</td>
      <td style="background:#'.$cor.'">'.$vcliente['nome'].'</td>
      <td style="background:#'.$cor.'">'.$vplano['nome'].'</td>
      <td style="background:#
