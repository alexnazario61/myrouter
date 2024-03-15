<?php 
    /*
    Função CRUD
    Cadastro, Edição, Exclusão de Servidores.
    Ultima Atualização: 18/11/2014
    */

    // Initialize the session variable for the company ID
    $idempresa = $_SESSION['empresa'];

    // Decode the GET request for the ID and store it in a variable
    @$getId = base64_decode($_GET['id']); 

    // If the ID is set, query the database for the server with the matching ID and company
    if(@$getId){ 
        $alterar = $mysqli->query("SELECT * FROM servidores WHERE id = + $getId AND empresa = '$idempresa'");
        $campo = mysqli_fetch_array($alterar);
    }

    // If the cadastrar submit button is set, insert a new server into the database
    if(isset ($_POST['cadastrar'])){ 
        // Assign the submitted form data to variables
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
        $tiporouter = "MIKROTIK";
        $portaftp = $_POST['portaftp'];

        // Initialize a new crud object and insert the new server into the database
        $crud = new crud('servidores');  // tabela como parametro
        $crud->inserir("empresa,servidor,ip,porta,login,senha,secret,tipo,lat,lng,interface,tiporouter,portaftp", "'$empresa','$servidor','$ip','$porta','$login','$senha','$secret','$tipo','$lat','$lng','$interface','$tiporouter','$portaftp'");

        // Query the database for the last inserted ID
        $query = $mysqli->query("SELECT MAX(ID) as id FROM servidores");
        $dados = mysqli_fetch_assoc($query);
        $idservidorerpmk = $dados['id'];

        // Insert a new radius server into the database with the last inserted ID
        $crud = new crud('nas');  // tabela como parametro
        $crud->inserir("nasname,shortname,type,secret,community,description,idservidorerpmk", "'$ip','localhost','other','$secret','public','$servidor','$idservidorerpmk'");

        // Redirect the user to the index page with a success message
        header("Location: index.php?app=Servidores&reg=1");					
    }

    // If the editar submit button is set, update the server with the matching ID in the database
    if(isset ($_POST['editar'])){
        // Assign the submitted form data to variables
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
        $portaftp = $_POST['portaftp'];

        // Initialize a new crud object and update the server with the matching ID in the database
        $crud = new crud('servidores'); // instancia classe com as operações crud, passando o nome da tabela como parametro
        $crud->atualizar("servidor='$servidor',ip='$ip',porta='$porta',login='$login',senha='$senha',secret='$secret',tipo='$tipo',lat='$lat',lng='$lng',interface='$interface',portaftp='$portaftp'", "id='$servidorid'");

        // Update the radius server with the matching ID in the database
        $crud = new crud('nas'); // instancia classe com as operações crud, passando o nome da tabela como parametro
        $crud->atualizar("nasname='$ip',shortname='localhost',type='other',secret='$secret',description='$servidor'", "idservidorerpmk='$servidorid'");

        // Redirect the user to the index page with a success message
        header("Location: index.php?app=Servidores&reg=2");
    }

    // If the Ex delete button is set and the ID is not empty, delete the server with the matching ID from the database
    if ((isset($_GET["Ex"])) && ($_GET["Ex"] == "Del")) {
        $id = base64_decode($_GET['id']); // pega id para exclusao caso exista
        $crud = new crud('servidores'); // tabela como parametro
        $crud->excluir("id = $id"); // exclui o registro com o id que foi passado

        // Delete the radius server with the matching ID from the database
        $crud = new crud('nas'); // tabela como parametro
        $crud->excluir("idservidorerpmk = $id"); // exclui o registro com o id que foi passado

        // Redirect the user to the index page with a success message
        header("Location: index.php?app=Servidores&reg=3");
    }
?>
