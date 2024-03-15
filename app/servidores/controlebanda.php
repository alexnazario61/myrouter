<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['username'])) {
    header('Location: index.php?app=Login');
    exit();
}

$reg = isset($_GET['reg']) ? trim($_GET['reg']) : null;

if (!empty($reg)) {
    if ($reg == 1) {
        echo '<div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                </button>
                <strong>Atenção!</strong> QUEUE cadastrado com sucesso.
              </div>';
    } elseif ($reg == 2) {
        echo '<div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                </button>
                <strong>Atenção!</strong> QUEUE alterado com sucesso.
              </div>';
    } elseif ($reg == 3) {
        echo '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                </button>
                <strong>Atenção!</strong> QUEUE excluído com sucesso.
              </div>';
    }
}

$mysqli = new mysqli($host, $user, $password, $database);

if ($mysqli->connect_errno) {
    echo '<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                <i class="fa fa-times-circle"></i>
            </button>
            <strong>Erro!</strong> Falha na conexão com o banco de dados.
          </div>';
    exit();
}

$consultas = $mysqli->query("SELECT * FROM controlebanda ORDER BY id DESC");

echo '
    <div class="breadcrumb clearfix">
      <ul>
        <li><a href="index.php?app=Dashboard">Dashboard</a></li>
        <li class="active">Controle de Banda</li>
      </ul>
    </div>

    <div class="page-header">
      <h1>Controle<small>Banda</small></h1>
    </div>

    <a href="?app=CadastroBanda" class="btn btn-info">CRIAR REGRA</a>
    <br><br>

    <div class="row" id="powerwidgets">
      <div class="col-md-12 bootstrap-grid">
        <div class="powerwidget" id="" data-widget-editbutton="false">
          <header>
            <h2>Gerenciar<small>Controle de Banda</small></h2>
          </header>
          <div class="inner-spacer">
            <div class="btn-group">
              <button class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bars"></i> EXPORTAR
              </button>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#" onClick ="$("#table-1").tableExport({type:\'json\',escape:\'false\'});"> <img src="assets/images/json.png" width="24px" alt="JSON"> JSON</a></li>
                <li class="divider"></li>
                <li><a href="#" onClick ="$("#table-1").tableExport({type:\'xml\',escape:\'false\'});"> <img src="assets/images/xml.png" width="24px" alt="XML"> XML</a></li>
                <li><a href="#" onClick ="$("#table-1").tableExport({type:\'sql\'});"> <img src="assets/images/sql.png" width="24px" alt="SQL"> SQL</a></li>
                <li class="divider"></li>
                <li><a href="#" onClick ="$("#table-1").tableExport({type:\'csv\',escape:\'false\'});"> <img src="assets/images/csv.png" width="24px" alt="CSV"> CSV</a></li>
                <li><a href="#" onClick ="$("#table-1").tableExport({type:\'txt\',escape:\'false\'});"> <img src="assets/images/txt.png" width="24px" alt="TXT"> TXT</a></li>
                <li class="divider"></li>
                <li><a href="#" onClick ="$("#table-1").tableExport({type:\'excel\',escape:\'false\'});"> <img src="assets/images/xls.png" width="24px" alt="Excel"> Excel</a></li>
                <li><a href="#" onClick ="$("#table-1").tableExport({type:\
