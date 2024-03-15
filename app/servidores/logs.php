<?php
// Decode the 'id' parameter from GET request
$idmk = base64_decode($_GET['id']);

// Query the 'servidores' table in the database to fetch server details
$conexaomk = $mysqli->query("SELECT * FROM servidores WHERE id = '$idmk'");

// Fetch the server details into an associative array
$mk = mysqli_fetch_array($conexaomk);
?>

<div class="breadcrumb clearfix">
  <!-- Breadcrumb navigation links -->
</div>

<?php if($permissao['mk6'] == S) { ?>
<div class="page-header">
  <!-- Page title -->
</div>

<div class="row" id="powerwidgets">
  <!-- Container for the table -->
  <div class="col-md-12 bootstrap-grid">
    <!-- Powerwidget element for the table -->
    <div class="powerwidget" id="" data-widget-editbutton="false">
      <header>
        <!-- Widget header with the table title -->
        <h2>Tabela de Logs </h2>
      </header>
      <div class="inner-spacer">
        <!-- Table container -->
        <table class="table table-striped table-hover" id="table-1">
          <thead>
            <!-- Table header row -->
            <tr>
              <th>ID</th>
              <th>Timer</th>
              <th>Ação</th>
              <th>Política</th>
            </tr>
          </thead>
          <tbody>
            <!-- Table body rows generated dynamically based on Mikrotik server logs -->
            <?php
            // Connect to the Mikrotik server using the routeros_api class
            $API = new routeros_api();
            $API->debug = false;
            if ($API->connect(''.$mk['ip'].'', ''.$mk['login'].'', ''.$mk['senha'].'')) {
              // Fetch logs from the Mikrotik server
              $ARRAY = $API->comm("/system/history/print");

              // Loop through the logs and generate table rows
              for ($i = 0; $i < count($ARRAY); ++$i) {
                $first = $ARRAY[$i];
            ?>
              <tr>
                <td><?php echo $first['by']; ?></td>
                <td><?php echo $first['time']; ?></td>
                <td><?php echo $first['action']; ?></td>
                <td><?php echo $first['policy']; ?></td>
              </tr>
            <?php
              }
              // Disconnect from the Mikrotik server
              $API->disconnect();
            }
            ?>
          </tbody>
          <tfoot>
            <!-- Table footer row -->
            <tr>
              <th>ID</th>
              <th>Timer</th>
              <th>Ação</th>
              <th>Política</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>
<?php } else { ?>
<div class="page-header">
  <!-- Page title when the user doesn't have permission -->
</div>

<div class="row" id="powerwidgets">
  <div class="col-md-12 bootstrap-grid">
    <!-- Alert box when the user doesn't have permission -->
    <div class="alert alert-danger alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
        <i class="fa fa-times-circle"></i></button>
      <strong>Atenção!</strong> Você não possui permissão para esse modulo.
    </div>
  </div>
</div>
<?php } ?>
