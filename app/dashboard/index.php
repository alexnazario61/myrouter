<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Add your CSS files here -->
</head>
<body>
    <div class="breadcrumb clearfix">
        <ul>
            <li><a href="">Dashboard</a></li>
            <li class="active">Bem Vindo - <?php echo $idpuser = $logado['nome']; ?></li>
        </ul>
    </div>

    <?php
    $homePermission = $permissao['home'] == 'S';

    if ($homePermission) {
        $resultClientTotal = $mysqli->query("SELECT id FROM clientes");
        $numCliente_rows = mysqli_num_rows($resultClientTotal);

        $resultSuporteAberto = $mysqli->query("SELECT id FROM ordemservicos WHERE encerrado ='N'");
        $numSuporteAberto_rows = mysqli_num_rows($resultSuporteAberto);

        $dataAno = date('Y');
        $dataMes = date('m');
        $resultFinanceiro = $mysqli->query("SELECT id FROM financeiro WHERE situacao ='N' AND ano = '$dataAno' AND mes = '$dataMes'");
        $numFinanceiro_rows = mysqli_num_rows($resultFinanceiro);

        $sql = "SELECT SUM(valor) as SOMA FROM financeiro WHERE situacao ='N' AND ano = '$dataAno' AND mes = '$dataMes'";
        $exec = $mysqli->query($sql);
        $rows = mysqli_fetch_assoc($exec);
        $rowsvalor = $rows["SOMA"];

        $empresa1 = $mysqli->query("SELECT dias_bloc FROM empresa WHERE id = '1'");
        $Cempresa = mysqli_fetch_array($empresa1);
        $dias_bloc = $Cempresa['dias_bloc'];

        $sxd = $mysqli->query("SELECT id FROM  financeiro WHERE situacao = 'B'");
        $verificaBloqueios = mysqli_num_rows($sxd);
    }
    ?>

    <!-- Add your CSS files here -->
    <link rel="stylesheet" type="text/css" href="assets/localweb/stylesheets/locastyle.css">

    <?php if ($homePermission): ?>
        <div class="ls-box ls-board-box">
            <header class="ls-info-header">
                <h2 class="ls-title-3">Resumo</h2>
            </header>
            <div id="sending-stats" class="row">
                <div class="col-sm-6 col-md-3">
                    <div class="ls-box">
                        <h6 class="ls-title-4">Total de Clientes Cadastrados</h6>
                        <strong><?php echo "$numCliente_rows";?></strong>
                        <a href="index.php?app=Clientes" aria-label="Listar Clientes" class="ls-btn ls-btn-sm" title="Listar Clientes">Listar Clientes</a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="ls-box">
                        <h6 class="ls-title-4">Ordem de Serviço Abertas</h6>
                        <strong><?php echo "$numSuporteAberto_rows";?></strong>
                        <a href="index.php?app=OrdemServicos"  aria-label="Listar OS" class="ls-btn ls-btn-sm" title="Listar OS">Listar OS</a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="ls-box">
                        <h6 class="ls-title-4">Faturas Abertas Mês Atual</h6>
                        <strong><?php echo "$numFinanceiro_rows";?></strong>
                        <small>Valor à Receber - Sem Juros</small>
                        <small>R$<?php echo number_format($rowsvalor,2,',','.');?></small>

                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="ls-box">
                        <h6 class="ls-title-4 ls-color-danger">Boletos Vencidos</h6>
                        <strong class="ls-color-theme"><?php
                            if($verificaBloqueios == ''){
                                echo "0";
                            }else{
                            echo "$verificaBloqueios"; }
                            ?></strong>
                        <small>Superior à <?php echo "$dias_bloc" ?> dias de atrazo</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="powerwidgets">
            <div class="col-md-12 bootstrap-grid">
                <div class="powerwidget green" id="">
                    <header>
                        <h2>Faturas do Mês<small> MyRouter ERP</small></h2>
                    </header>
                    <div class="inner-spacer">
                        <table class="table table-striped table-hover" id="table-1">
                            <thead>
                                <tr>
                                    <th>Fatura</th>
                                    <th>Cliente</th>
                                    <th>Plano</th>
                
