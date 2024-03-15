<?php
session_start();
require_once 'crud.php';
$crud = new crud('notafiscal');

$idpuser = htmlspecialchars($logado['nome']);
$idempresa = htmlspecialchars($_SESSION['empresa']);
$getId = isset($_GET['id']) ? base64_decode($_GET['id']) : '';

if (isset($getId)) {
    $stmt = $mysqli->prepare("SELECT * FROM notafiscal WHERE id = ?");
    $stmt->bind_param('i', $getId);
    $stmt->execute();
    $campo = $stmt->get_result()->fetch_assoc();
    $dataemissao = date('d/m/Y', strtotime($campo['emissao']));
}

if (isset($_POST['editar'])) {
    $nnota = htmlspecialchars($_POST['nnota']);
    $clientenome = htmlspecialchars($_POST['clientenome']);
    $clientecpf = htmlspecialchars($_POST['clientecpf']);
    $clienterg = htmlspecialchars($_POST['clienterg']);
    $descricao = htmlspecialchars($_POST['descricao']);
    $valorservicos = htmlspecialchars($_POST['valorservicos']);
    $situacao = htmlspecialchars($_POST['situacao']);

    $crud->atualizar("clientenome=?, clientecpf=?, clienterg=?, descricao=?, valorservicos=?, situacao=?, emissao=?", "id=?", "s:100, s:14, s:14, s:100, s:10, s:1, s:10, i:$getId", "$clientenome, $clientecpf, $clienterg, $descricao, $valorservicos, $situacao, $dataemissao, $getId");

    $getCliente = base64_encode($getId);
    header("Location: index.php?app=NFSe&reg=5");
    exit;
}
?>
<script src="https://raw.githubusercontent.com/digitalBush/jquery.maskedinput/1.4.0/dist/jquery.maskedinput.min.js"></script>
<script type="text/javascript">
    function BuscarLogin() {
        var cliente = $('#cliente').val();
        if (cliente) {
            var UrlSearch = 'app/os/busca_login_cliente.php?cliente=' + cliente;
            $.get(UrlSearch, function(dataReturn) {
                $('#load_login_cliente').html(dataReturn);
            });
        }
    }
</script>
<script>
    $(function() {
        $('.cpf').focusout(function() {
            var cpfcnpj, element;
            element = $(this);
            element.unmask();
            cpfcnpj = element.val().replace(/\D/g, '');
            if (cpfcnpj.length > 11) {
                element.mask("99.999.999/999?9-99");
            } else {
                element.mask("999.999.999-99?9-99");
            }
        }).trigger('focusout');


    });
    jQuery(function($) {
        $(".data").mask("99/99/9999");
    });

    jQuery(function($) {
        $(".hora").mask("99:99:99");
    });

</script>
<script type="text/javascript" src="http://cidades-estados-js.googlecode.com/files/cidades-estados-1.0.js"></script>
<script type="text/javascript">
    window.onload = function() {
        new dgCidadesEstados({
            estado: document.getElementById('estado'),
            cidade: document.getElementById('cidade')
        });
    }
</script>
<script type="text/javascript" src="ajax/funcslogin.js"></script>
<script type="text/javascript" src="ajax/funcscpf.js"></script>


<div class="breadcrumb clearfix">
    <ul>
        <li><a href="dashboard">Dashboard</a></li>
        <li><a href="?app=NFSe">Nota Fiscal</a></li>
        <li class="active">Editar</li>
    </ul>
</div>

<?php if ($permissao['os2'] == S) { ?>

    <div class="page-header">
        <h1>Editar<small> Nota Fiscal</small></h1>
    </div>

    <div class="powerwidget blue" id="most-form-elements" data-widget-editbutton="false">
        <header>
            <h2>Editar<small>Nota Fiscal</small></h2>
        </header>
        <div class="inner-spacer">
            <form action="" method="POST" class="orb-form">
                <fieldset>
                    <section class="col col-2">
                        <label class="label">Número da Nota</label>
                        <label class="input">
                            <input type="text" name="nnota" readonly value="<?php echo htmlspecialchars(@$campo['nnota']); ?>">
                        </label>
                    </section>

                    <section class="col col-6">
                        <label class="label">Nome/Razão Social</label>
                        <label class="input">
                
