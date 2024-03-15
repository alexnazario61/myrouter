<?php
$idmk = isset($_GET['id']) ? base64_decode($_GET['id']) : null;
if (!$idmk) {
    exit(header('Location: index.php?app=Servidores'));
}

$conexaomk = $mysqli->prepare("SELECT * FROM servidores WHERE id = ?");
$conexaomk->bind_param('i', $idmk);
$conexaomk->execute();
$result = $conexaomk->get_result();
$mk = $result->fetch_assoc();
if (!$mk) {
    exit(header('Location: index.php?app=Servidores'));
}

$API = new routeros_api();
$API->debug = false;
if (!$API->connect($mk['ip'], $mk['login'], $mk['senha'])) {
    exit(header('Location: index.php?app=Servidores'));
}

$ARRAY = $API->comm("/interface/print");
$ii = 0;
foreach ($ARRAY as $first) {
    // output code here
}
$API->disconnect();

$conexaomk->close();
$mysqli->close();
?>

<div class="breadcrumb clearfix">
  <!-- breadcrumb code here -->
</div>

<?php if ($permissao['mk5'] == 'S') { ?>

<div class="page-header">
  <h1>Interfaces<small><?php echo htmlspecialchars($mk['servidor']); ?></small></h1>
</div>

<!-- rest of the code here -->

<?php } else { ?>

<div class="page-header">
  <h1>Permissão <small>Negada!</small></h1>
</div>

<div class="row" id="powerwidgets">
  <!-- error message code here -->
</div>

<?php } ?>
