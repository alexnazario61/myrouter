<?php 
    /*
    Função CRUD para Técnicos
    - Cadastro, Edição, Exclusão
    - Última atualização: 17/11/2014
    - A função verifica se um ID foi passado via GET para decidir se será uma operação de cadastro ou edição.
    */
    
    // Inicializa a sessão e define a variável $idempresa com o ID da empresa da sessão atual
    $idempresa = $_SESSION['empresa'];

    // Decodifica e armazena o ID e o código recebidos via GET em suas respectivas variáveis
    @$getId = base64_decode($_GET['id']);
    @$codigoEdit = base64_decode($_GET['codigo']);

    // Verifica se o ID foi passado via GET
    if(@$getId){
        
        // Consulta a tabela tecnicos no banco de dados com o ID recebido e armazena o resultado em $alterar
        $alterar = $mysqli->query("SELECT * FROM tecnicos WHERE id = + $getId AND empresa = '$idempresa'");

        // Converte o resultado da consulta em um array e armazena em $campo
        $campo = mysqli_fetch_array($alterar);
    }

    // Verifica se o formulário de cadastro foi submetido
    if(isset ($_POST['cadastrar'])){

        // Atribui os valores dos campos do formulário às respectivas variáveis
        $empresa = $_SESSION['empresa'];
        $codigo = rand(9,999999);
        // ... (restante do código omitido para reduzir o tamanho da resposta)

        // Insere os dados nos bancos de dados tecnicos, usuarios e permissoes
        $crud = new crud('tecnicos');
        $crud->inserir(...);

        $sergkey = md5($senha);
        $salt = base64_encode($senha);

        $crud = new crud('usuarios');
        $crud->inserir(...);

        $crud = new crud('permissoes');
        $crud->inserir("codigo", "'$ultimoid'");

        // Insere os dados no banco de dados radreply e radcheck para configurar o acesso do usuário ao Mikrotik via radius
        $crud = new crud('radreply');
        $crud->inserir(...);

        $crud = new crud('radcheck');
        $crud->inserir(...);

        // Redireciona o usuário para a página index.php com as informações do registro
        header("Location: index.php?app=Tecnicos&reg=1");
    }

    // ... (restante do código omitido para reduzir o tamanho da resposta)

?>

<script src="assets/js/jquery.maskedinput.min.js" xmlns="http://www.w3.org/1999/html"></script>
<script>
$(function() {
 // ... (restante do código omitido para reduzir o tamanho da resposta)
});
</script>
<script type="text/javascript" src="assets/js/cidades-estados-1.0.js"></script>
<script type="text/javascript">
window.onload = function() {
  new dgCidadesEstados({
    estado: document.getElementById('estado'),
    cidade: document.getElementById('cidade')
  });
}
</script>
<script type="text/javascript" src="ajax/funcslogintecnicos.js"></script>

<div class="breadcrumb clearfix">
  <ul>
    <li><a href="dashboard">Dashboard</a></li>
    <li><a href="?app=Tecnicos">Técnicos</a></li>
    <li class="active">Cadastro</li>
  </ul>
</div>

<?php if($permissao['t2'] == S) { ?>

<div class="page-header">
  <h1>Cadastro<small> Novo Técnico</small></h1>
</div>

<div class="powerwidget orange" id="most-form-elements" data-widget-editbutton="false">
  <header>
    <h2>Cadastro<small>Funcionário</small></h2>
  </header>
  <div class="inner-spacer">
    <form action="" method="POST" class="orb-form">
      <!-- ... (restante do código omitido para reduzir o tamanho da resposta) -->
    </form>
  </div>
</div>

<?php } else { ?>

<div class="page-header">
  <h1>Permissão <small>Negada!</small></h1>  
</div>

<div class="row" id="powerwidgets">
  <div class="col-md-12 bootstrap-grid">

    <div class="alert alert-danger alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
	<i class="fa fa-times-circle"></i></button>
      <strong>Atenção!</strong> Você não possui permissão para esse modulo. </div>

  </div></div>

<?php } ?>
