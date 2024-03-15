<?php 
// Function CRUD: This function is used for creating, reading, updating, and deleting clients.
// Last Updated: 18/11/2014

$idempresa = $_SESSION['empresa'];
@$getId = base64_decode($_GET['id']); 

// Check if the GET request has an id, if so, fetch the client data from the database
if(@$getId){ 
    $alterar = $mysqli->query("SELECT * FROM fib_no WHERE id = + $getId AND empresa = '$idempresa'");
    $campo = mysqli_fetch_array($alterar);
}

// Check if the cadastrar submit button is clicked
if(isset ($_POST['cadastrar'])){
    $desc_ponto = $_POST['desc_ponto'];
    $cor = $_POST['cor'];
    $esplinha = $_POST['esplinha'];
    $empresa = $_POST['empresa'];
    
    // Create a new instance of the crud class and insert the client data into the database
    $crud = new crud('fib_no');  // tabela como parametro
    $crud->inserir("empresa,desc_ponto,cor,esplinha","'$empresa','$desc_ponto','$cor','$esplinha'");
    
    // Redirect the user to the client list page with a success message
    header("Location: index.php?app=ListaNo&reg=1");
}

// Check if the editar submit button is clicked
if(isset ($_POST['editar'])){
    $idcliente = $_POST['idno'];
    $desc_ponto = $_POST['desc_ponto'];
    $cor = $_POST['cor'];
    $esplinha = $_POST['esplinha'];
    $empresa = $_POST['empresa'];
    
    // Create a new instance of the crud class and update the client data in the database
    $crud = new crud('fib_no'); // instancia classe com as operações crud, passando o nome da tabela como parametro
    $crud->atualizar("desc_ponto='$desc_ponto',cor='$cor',esplinha='$esplinha'", "id='$idcliente'");
    
    // Redirect the user to the client list page with a success message
    header("Location: index.php?app=ListaNo&reg=2");
}

// Check if the Ex delete button is clicked and delete the client from the database
if ((isset($_GET["Ex"])) && ($_GET["Ex"] == "Del")) {
    $id = base64_decode($_GET['id']); // pega id para exclusao caso exista

    // Create a new instance of the crud class and delete the client data from the database
    $crud = new crud('fib_no'); // tabela como parametro
    $crud->excluir("id = $id"); // exclui o registro com o id que foi passado

    $crud = new crud('fib_elementos'); // tabela como parametro
    $crud->excluir("id_no = $id"); // exclui o registro com o id que foi passado

    // Redirect the user to the client list page with a success message
    header("Location: index.php?app=ListaNo&reg=4");

}
?>

<!-- Include the jquery.maskedinput.min.js library for input masking -->
<script src="assets/js/jquery.maskedinput.min.js"></script>
<script>
jQuery(function($){
   $(".data").mask("99/99/9999");
});
</script>

<!-- Include the jquery.maskedinput.min.js library for input masking -->
<script src="assets/js/jquery.maskedinput.min.js"></script>
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

$(function() {
    $('.maskcel').focusout(function() {
        var maskcelular, element;
        element = $(this);
        element.unmask();
        maskcelular = element.val().replace(/\D/g, '');
        if (maskcelular.length > 11) {
            element.mask("(999)99999-9999");
        } else {
            element.mask("(999)9999-9999?9");
        }
    }).trigger('focusout');


});

jQuery(function($){
   $(".nascimento").mask("99/99/9999");
   $(".cel").mask("(999) 99999-9999");
   $(".tel").mask("(999) 9999-9999");
   $(".cep").mask("99999-999");
});
</script>

<!-- Include the bootstrap-colorpicker.js library for color picker input -->
<script type="text/javascript" src="assets/js/bootstrap-colorpicker.js"></script>

<script>
    $(function(){
        $('.color').colorpicker();
    });
</script>

<!-- Include the Trim function for removing white spaces from strings -->
<script type="text/javascript">
    function Trim(str){
        return str.replace(/^\s+|\s+$/g,"");
    }

