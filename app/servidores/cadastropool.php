<?php
session_start();
require_once 'crud.php';
require_once 'db_connect.php';

$idempresa = $_SESSION['empresa'];

// Gerar número de pedido
$query_numero = $mysqli->query("SELECT * FROM ippool ORDER BY id DESC LIMIT 1");
$row_numero = mysqli_fetch_array($query_numero);
$numero = str_pad($row_numero['id'] + 1, 5, 0, STR_PAD_LEFT);
$pedido = $numero;

$crud = new crud('ippool');

if (isset($_GET['Ex']) && $_GET['Ex'] == 'Del') {
    $id = base64_decode($_GET['id']);
    $pedido = base64_decode($_GET['pedido']);
    $servidor = base64_decode($_GET['servidor']);
    $nome = base64_decode($_GET['pool']);

    $crud_radippool = new crud('radippool');
    $crud_radippool->excluir("pedido = $pedido");

    $crud->excluir("id = $id");

    header("Location: index.php?app=Pool&reg=3");
}

if (isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $ranges = $_POST['ranges'];
    $servidor = $_POST['servidor'];

    $crud->inserir("nome, ranges, servidor, pedido", " '$nome', '$ranges', '$servidor', '$pedido'");

    $query_servidor = $mysqli->query("SELECT * FROM servidores WHERE id = '$servidor'");
    $servidor_data = mysqli_fetch_array($query_servidor);

    $crud_radippool = new crud('radippool');
    $crud_radippool->inserir("pool_name, framedipaddress, pedido", " '$nome', '$ranges', '$pedido'");

    header("Location: index.php?app=Pool&reg=1");
}
?>

<div class="breadcrumb clearfix">
    <ul>
        <li><a href="?app=Dashboard">Dashboard</a></li>
        <li><a href="?app=ControleBanda">Mikrotik</a></li>
        <li class="active">Controle de IP</li>
    </ul>
</div>

<div class="page-header">
    <h1>Cadastro<small> Novo Pool</small></h1>
</div>

<div class="powerwidget red" id="most-form-elements" data-widget-editbutton="false">
    <header>
        <h2>Cadastro<small>Controle de IPPool</small></h2>
    </header>
    <div class="inner-spacer">
        <form action="" method="POST" class="orb-form">
            <fieldset>
                <section class="col col-6">
                    <label class="label">Servidor Mikrotik</label>
                    <label class="select">
                        <select id="servidor" name="servidor" class="form-control" required>
                            <option value="">Selecione</option>
                            <?php
                            $query_servidor = $mysqli->query("SELECT * FROM servidores WHERE empresa = '$idempresa'");
                            while ($servidor_data = mysqli_fetch_array($query_servidor)) {
                            ?>
                                <option value="<?php echo $servidor_data['id']; ?>" <?php if ($campo['servidor'] == $servidor_data['id']) {
                                                                                    echo "selected";
                                                                                } ?>><?php echo $servidor_data['servidor']; ?> | <?php echo $servidor_data['ip']; ?></option>
                            <?php } ?>
                        </select>
                    </label>
                </section>

                <section class="col col-3">
                    <label class="label">Nome da Pool IP</label>
                    <label class="input">
                        <input type="text" name="nome" required>
                    </label>
                </section>

                <section class="col col-3">
                    <label class="label">IP do Seguimento</label>
                    <label class="input"> <i class="icon-append fa fa-question"></i>
                        <label class="input">
                            <input type="text" placeholder="10.50.30.1" name="ranges" required>
                            <b class="tooltip tooltip-top-right">Caso você esteja cadastrando POOL para uso Dinâmico em rede Roteada, você deverá cadastrar apenas um IP por vez.</b>
                        </label>
                    </label>
                </section>
            </fieldset>
            <footer>
                <input type="submit" name="cadastrar" class="btn btn-success" value="Cadastrar">
            </footer>
        </form>
    </div>
</div>
