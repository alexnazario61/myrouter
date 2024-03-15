<?php

// Retrieve the current user's session data, specifically the 'empresa' value
$idempresa = $_SESSION['empresa'];

// Decode the 'id' parameter from the GET request and store it in $getId
@$getId = base64_decode($_GET['id']);

// If $getId is set, execute the following code block
if (@$getId) {
    // Query the 'lc_fixas' table to retrieve records where the 'id' matches $getId and 'empresa' matches $idempresa
    $alterar = $mysqli->query("SELECT * FROM lc_fixas WHERE id = + $getId AND empresa = '$idempresa'");
    // Fetch the retrieved record as an associative array and store it in $campo
    $campo = mysqli_fetch_array($alterar);
}

// Check if the 'cadastrar' POST variable is set
if (isset($_POST['cadastrar'])) {
    // Assign the 'empresa', 'descricao_fixa', 'dia_vencimento', 'valor_fixa', and 'cat' values from the POST request to their respective variables
    $empresa = $_SESSION['empresa'];
    $descricao_fixa = $_POST['descricao_fixa'];
    $dia_vencimento = $_POST['dia_vencimento'];
    $valor_fixa = $_POST['valor_fixa'];
    $cat = $_POST['cat'];

    // Instantiate the 'crud' class, passing the 'lc_fixas' table name as a parameter
    $crud = new crud('lc_fixas');
    // Call the 'inserir' method of the 'crud' class, passing the column names and their respective values as arguments
    $crud->inserir("empresa,descricao_fixa,dia_vencimento,valor_fixa,cat", "'$empresa','$descricao_fixa','$dia_vencimento','$valor_fixa','$cat'");

    // Redirect the user to the 'index.php' page with the specified query parameters
    header("Location: index.php?app=ContasFixas&reg=1");
}

// Check if the 'editar' POST variable is set
if (isset($_POST['editar'])) {
    // Assign the 'descricao_fixa', 'dia_vencimento', 'valor_fixa', and 'cat' values from the POST request to their respective variables
    $descricao_fixa = $_POST['descricao_fixa'];
    $dia_vencimento = $_POST['dia_vencimento'];
    $valor_fixa = $_POST['valor_fixa'];
    $cat = $_POST['cat'];

    // Instantiate the 'crud' class, passing the 'lc_fixas' table name as a parameter
    $crud = new crud('lc_fixas');
    // Call the 'atualizar' method of the 'crud' class, passing the column names and their respective values as arguments
    $crud->atualizar("descricao_fixa='$descricao_fixa',dia_vencimento='$dia_vencimento',valor_fixa='$valor_fixa',cat='$cat'", "id='$getId'");

    // Redirect the user to the 'index.php' page with the specified query parameters
    header("Location: index.php?app=ContasFixas&reg=2");
}

// Check if the 'Ex' GET variable is set and equals 'Del'
if ((isset($_GET["Ex"])) && ($_GET["Ex"] == "Del")) {
    // Decode the 'id' parameter from the GET request and store it in $id
    $id = base64_decode($_GET['id']);

    // Instantiate the 'crud' class, passing the 'lc_fixas' table name as a parameter
    $crud = new crud('lc_fixas');
    // Call the 'excluir' method of the 'crud' class, passing the WHERE clause as an argument
    $crud->excluir("id = $id");

    // Redirect the user to the 'index.php' page with the specified query parameters
    header("Location: index.php?app=ContasFixas&reg=3");
}

// Define the 'Trim' JavaScript function, which removes leading and trailing whitespace from a string
function Trim(str) {
    return str.replace(/^\s+|\s+$/g, "");
}

?>

<!-- Breadcrumb section -->
<div class="breadcrumb clearfix">
  <ul>
    <li><a href="dashboard">Dashboard</a></li>
    <li><a href="?app=Planos">Contas Fixas</a></li>
    <li class="active">Cadastro</li>
  </ul>
</div>

<!-- Display the page content only if the user has the required permission -->
<?php if ($permissao['p2'] == S) { ?>

<div class="page-header">
  <h1>Cadastro<small> Contas Fixas</small></h1>
</div>

<div class="powerwidget orange" id="most-form-elements" data-widget-editbutton="false">
  <header>
    <h2>Cadastro<small>Contas Fixas</small></h2>
  </header>
  <div class="inner-spacer">
    <!-- Form for inserting or updating records -->
    <form action="" method="POST" class="orb-form">
      <fieldset>

        <!-- Column with the 'Descrição' label and input field -->
        <section class="col col-4">
          <label class="label">Descrição</label>
          <label class="input">
            <input type="text" name="descricao_fixa" value="<?php echo @$campo['descricao_fixa']; ?>" required>
          </label>
        </section>

