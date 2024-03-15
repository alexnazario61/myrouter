<?php
// Connect to the database and select the row with id = 1 from the "empresa" table
$empresaboleto = $mysqli->query("SELECT * FROM empresa WHERE id = '1'");
// Fetch the result into an associative array
$emp_retorno = mysqli_fetch_array($empresaboleto);
// Get the value of the "bancos_codigo" column from the fetched row
$linkretorno = $emp_retorno['bancos_codigo'];

// Determine the link based on the value of $linkretorno
if ($linkretorno == 756) {
    $link1 = "index.php?app=ProcessarRetornoSicoob";
} else {
    $link1 = "index.php?app=ProcessarRetorno";
}
?>

<div class="breadcrumb clearfix">
<!-- Breadcrumb navigation -->
<ul>
<li><a href="index.php?app=Dashboard">Dashboard</a></li>
<li class="active">Financeiro</li>
</ul>
</div>

<?php
// Display a success message if $_GET['reg'] == '1'
if ($_GET['reg'] == '1') {
?>
<div class="alert alert-success alert-dismissable">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
<i class="fa fa-times-circle"></i></button>
<strong>Atenção!</strong> Arquivo de retorno processado com sucesso. </div>
<?php
}
// Display an error message if $_GET['reg'] == '2'
if ($_GET['reg'] == '2') {
?>
<div class="alert alert-danger alert-dismissable">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
<i class="fa fa-times-circle"></i></button>
<strong>Atenção!</strong> Arquivo de Retorno Inválido ou já processado. </div>
<?php
}
?>

<div class="page-header">
<!-- Page header -->
<h1>Retorno <small>Envio do arquivo bancário</small></h1>  
</div>

<div class="row" id="powerwidgets">
<!-- Row container -->
<div class="col-md-12 bootstrap-grid"> 
<!-- Column container -->

<div class="powerwidget green" id="" data-widget-editbutton="false">
<!-- Widget container -->
<header>
<h2>Gerenciar<small>Faturas</small></h2>
</header>
<div class="inner-spacer">

<h3>Observações Importantes</h3>
<!-- Heading for important notes -->
<p>
<strong>
» Selecione um arquivo com extensão .RET com padrão CNAB240 ou CNAB400.</strong><br/>
<!-- Instruction for selecting a file -->
</span></p><br/>

<!-- Form for uploading the file -->
<form action="<?php echo $link1; ?>" method="post" enctype="multipart/form-data">
<input name="arquivo" class="btn btn-info" type="file" /><br/><br/>

<div class="controlsa">
<!-- Submit button and hidden field -->
<button type="submit" class="btn btn-success" id="btnsubmit" >
<i class="fa fa-thumbs-up icon-white"></i> Processar Arquivo</button>
<input type="hidden" value="ENVIAR" name="funcao">
</div>
</form>

</div>
</div>

</div>
</div>

