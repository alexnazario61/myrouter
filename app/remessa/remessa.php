<?php 

// Get the current date as a formatted string
$data_h = date("Y-m-d");

// Query to select all records from the 'faturas' table
$muda = mysql_query("SELECT * FROM faturas") or die(mysql_error());

// Loop through the query results
while($conf = mysql_fetch_array($muda)){
	// Get the invoice date from the current record
	$data_v =  $conf['data_venci'];

	// Check if the invoice date is later than the current date
	if(strtotime($data_v) > strtotime($data_h)){
		// Query to update the status of invoices that meet the condition
		// $baixa = mysql_query("UPDATE faturas SET situacao = 'V' WHERE situacao != 'B' AND data_venci < DATE(NOW())");
	}
}

?>

<script src="app/remessa/js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">

// Function to check/uncheck all checkboxes
function marcardesmarcar(){
   if ($("#todos").attr("checked")){
      $('.marcar').each(
         function(){
            $(this).attr("checked", true);
         }
      );
   }else{
      $('.marcar').each(
         function(){
            $(this).attr("checked", false);
         }
      );
   }
}

// Function to open a new window with a specified URL
function NovaJanela(pagina,nome,w,h,scroll){
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
	win = window.open(pagina,nome,settings);
	}
window.name = "main";

// Function to validate checkboxes
function validaCheckbox(v){ 
    todos = document.getElementsByTagName('input'); 
    for(x = 0; x < todos.length; x++) { 
        if (todos[x].checked){ 
            return true; 
        } 
    } 
    alert("Selecione pelo menos uma fatura!"); 
    return false; 
}

// Function to validate date fields
function datas() {
var datai = formu.datai.value;
var dataf = formu.dataf.value; 

if (datai == "") {
alert('Escolha uma data inicial.');
formu.datai.focus();
return false;
}
if (dataf == "") {
alert('Escolha uma data final.');
formu.dataf.focus();
return false;
}
}

</script>

<script>
    $(document).ready(function () {
        $(".data").datepicker({
            dateFormat: 'dd/mm/yy',
            dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
            dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
            dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
            monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            nextText: 'Proximo',
            prevText: 'Anterior'
        });
      });
    </script>



<div id="forms">

<?php
// Query to select all records from the 'empresa' table
$res = mysql_query("SELECT * FROM empresa");
$list = mysql_fetch_array($res);

// Check if the bank is not ITAU and display a warning message
if($list['banco'] != '4' || $list['banco'] != '2'){
echo '
<div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
	<i class="fa fa-times-circle"></i></button>
        <strong>Atenção!</strong> Este sistema gera remessa somente para o banco ITAU. Por favor ative o banco para gerar o arquivo de remessa. </div>';
exit;
}

?>

<form name="form" action="app/remessa/gerar_remessa.php" method="post" enctype="multipart/form-data" onsubmit="return validaCheckbox();">
<input name="pg" type="hidden" value="<?php echo $_GET['pg'] ?>">

<?php
// Check if the form has been submitted and the 'pesquizar' field is not empty
if(isset($_POST['pesquizar']) && $_POST['pesquizar'] != ""){
$pesquisar = $_POST['pesquizar'];
// Query to search for records in the 'faturas' table based on the search term
$sql_1 = "SELECT * ,date_format(data_venci, '%d/%m/%Y') AS data FROM faturas WHERE situacao ='P' AND (nome LIKE '%$pesquisar%' OR num_doc LIKE '%$pesquisar%' OR nosso_numero LIKE '%$pesquisar%')";
}
// Check if the 'datai' and 'dataf' fields are not empty
elseif(isset($_POST['
