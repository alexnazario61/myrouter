<?php 
    // Function CRUD (Create, Read, Update, Delete)
    // Permission Assignment
    // Last Updated: 03/02/2015

    // Get the current user's company ID from the session
    $idempresa = $_SESSION['empresa'];

    // Get the user ID from the GET request and decode it from base64
    @$getId = base64_decode($_GET['id']); 
    if(@$getId){

        // Query to fetch the user's permissions from the database
        $alterar = $mysqli->query("SELECT * FROM permissoes WHERE usuario = '$getId'");

        // Fetch the permission data as an array
        $campo = mysqli_fetch_array($alterar);

    }

    // Check if the form to edit permissions has been submitted
    if(isset ($_POST['editar'])){

        // Assign the permission values to variables
        $permissaoid = $_POST['permissaoid'];

        // ... (other permission variables)

        // Update the user's permissions in the database
        $sql = "UPDATE `permissoes` SET financeiro='$financeiro',f1='$f1',f2='$f2',f3='$f3',assinaturas='$assinaturas',a1='$a1',a2='$a2',faturas='$faturas',ft1='$ft1',ft2='$ft2',clientes='$clientes',c1='$c1',c2='$c2',tecnicos='$tecnicos',t1='$t1',t2='$t2',fornecedores='$fornecedores',fo1='$fo1',fo2='$fo2',ordemservico='$ordemservico',os1='$os1',os2='$os2',planos='$planos',p1='$p1',p2='$p2',equipamentos='$equipamentos',e1='$e1',e2='$e2',ferramentas='$ferramentas',fr1='$fr1',fr2='$fr2',fr3='$fr3',fr4='$fr4',fr5='$fr5',fr6='$fr6',mikrotik='$mikrotik',mk1='$mk1',mk2='$mk2',mk3='$mk3',mk4='$mk4',mk5='$mk5',mk6='$mk6',mk7='$mk7',mk8='$mk8',mk9='$mk9',mk10='$mk10',cupons='$cupons',cu1='$cu1',cu2='$cu2',relatorios='$relatorios',r1='$r1',r2='$r2',r3='$r3',r4='$r4',r5='$r5',r6='$r6',r7='$r7',home='$home' WHERE codigo ='$permissaoid'";

        // Execute the query
        echo mysql_query($sql);

        // Redirect the user to the permissions page
        header("Location: index.php?app=Permissoes&reg=2");
    }

    // Get the user ID from the GET request and decode it from base64
    $idu = base64_decode($_GET['id']);

    // Query to fetch the user's permissions from the database
    $alterar = $mysqli->query("SELECT * FROM permissoes WHERE codigo = '$idu'");

    // Fetch the permission data as an array
    $campo = mysqli_fetch_array($alterar);

?>
