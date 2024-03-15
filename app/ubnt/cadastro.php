<?php
// Function CRUD (Create, Read, Update, Delete) for managing servers.

// Get the current user's session variable 'empresa'
session_start();
$idempresa = $_SESSION['empresa'];

// Get the decoded 'id' from the GET request
$id = isset($_GET['id']) ? base64_decode($_GET['id']) : null;

// If 'id' is set in the GET request
if ($id) {
    // Query to select all fields from the 'servidores' table where 'id' matches the GET request and 'empresa' matches the current user's session variable
    $alterar = $mysqli->query("SELECT * FROM servidores WHERE id = $id AND empresa = '$idempresa'");

    // Store the result of the query in the 'campo' variable
    $campo = $alterar->fetch_array();
}

// If the 'cadastrar' button is set in the POST request
if (isset($_POST['cadastrar'])) {
    // Assign the values from the POST request to variables
    $empresa = $_SESSION['empresa'];
    $servidor = $_POST['servidor'];
    $ip = $_POST['ip'];
    $porta = $_POST['porta'];
    $login = $_POST['login'];
    $senha = $_POST['senha'];
    $secret = $_POST['secret'];
    $tipo = $_POST['tipo'];
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    $interface = $_POST['interface'];
    $tiporouter = $_POST['tiporouter'];

    // Create a new instance of the 'crud' class and insert the values into the 'servidores' table
    $crud = new crud('servidores'); // tabela como parametro
    $crud->inserir("empresa, servidor, ip, porta, login, senha, secret, tipo, lat, lng, interface, tipoRouter", " '$empresa', '$servidor', '$ip', '$porta', '$login', '$senha', '$secret', '$tipo', '$lat', '$lng', '$interface', 'UBIQUITI'");

    // Query to get the maximum ID from the 'servidores' table
    $query = $mysqli->query("SELECT MAX(ID) as id FROM servidores");

    // Store the result of the query in the 'dados' variable
    $dados = $query->fetch_assoc();

    // Assign the maximum ID to the 'idservidorerpmk' variable
    $idservidorerpmk = $dados['id'];

    // Create a new instance of the 'crud' class and insert the values into the 'nas' table
    $crud = new crud('nas'); // tabela como parametro
    $crud->inserir("nasname, shortname, type, secret, community, description, idservidorerpmk", " '$ip', 'localhost', 'other', '$secret', 'public', '$servidor', '$idservidorerpmk'");

    // Redirect to the 'index.php' page with the specified query parameters
    header("Location: index.php?app=ServidoresUBNT&reg=1");
}

// If the 'editar' button is set in the POST request
if (isset($_POST['editar'])) {
    // Assign the values from the POST request to variables
    $servidor = $_POST['servidor'];
    $ip = $_POST['ip'];
    $porta = $_POST['porta'];
    $login = $_POST['login'];
    $senha = $_POST['senha'];
    $secret = $_POST['secret'];
    $tipo = $_POST['tipo'];
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    $interface = $_POST['interface'];
    $servidorid = $_POST['servidorid'];

    // Create a new instance of the 'crud' class and update the values in the 'servidores' table
    $crud = new crud('servidores'); // instancia classe com as operações crud, passando o nome da tabela como parametro
    $crud->atualizar("servidor='$servidor', ip='$ip', porta='$porta', login='$login', senha='$senha', secret='$secret', tipo='$tipo', lat='$lat', lng='$lng', interface='$interface'", "id='$servidorid'");

    // Create a new instance of the 'crud' class and update the values in the 'nas' table
    $crud = new crud('nas'); // instancia classe com as operações crud, passando o nome da tabela como parametro
    $crud->atualizar("nasname='$ip', shortname='localhost', type='other', secret='$secret', description='$servidor'", "idservidorerpmk='$servidorid'");

    // Redirect to the 'index.php' page with the specified query parameters
    header("Location: index.php?app=ServidoresUBNT&reg=2");
}

// If the 'Ex' parameter is set in the GET request and its value is 'Del'
if (isset($_GET["Ex"]) && $_GET["Ex"] == "Del") {
    // Decode the 'id' parameter from the GET request and assign it to the 'id' variable
    $id = isset($_GET['id']) ? base64_decode($_GET['id']) : null; // pega id para exclusao caso exista

    // Create a new instance of the 'crud' class and delete the row with the specified ID from the 'servidores' table
    $crud = new crud('servidores'); // tabela como parametro
    $crud->excluir("id = $id"); // exclui o registro com o id que foi passado

    // Create a new instance of the 'crud' class and delete the row with the specified ID from the 'nas' table

