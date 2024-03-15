// Variável que receberá o objeto XMLHttpRequest
// This variable will hold the XMLHttpRequest object, which is used to make AJAX requests.
var req;

function validarLogin(campo, valor) {
 
// Verificar o Browser
// This block checks if the user's browser supports the XMLHttpRequest object.
if(window.XMLHttpRequest) {
   req = new XMLHttpRequest();
}
// If the browser is Internet Explorer, it uses the ActiveXObject instead.
else if(window.ActiveXObject) {
   req = new ActiveXObject("Microsoft.XMLHTTP");
}

// Aqui vai o valor e o nome do campo que pediu a requisição.
// This line creates the URL for the AJAX request, including the field name and value as parameters.
var url = "ajax/logintecnicos.php?campo="+campo+"&valor="+valor;

// Chamada do método open para processar a requisição
// This line opens the connection to the server using the GET method.
req.open("Get", url, true);

// Quando o objeto recebe o retorno, é chamada a seguinte função;
// This block defines the function to be called when the AJAX request returns a response.
req.onreadystatechange = function() {
 
	// Exibe a mensagem "Verificando" enquanto carrega
	// This block displays the message "Verificando..." while the AJAX request is being processed.
	if(req.readyState == 1) {
		document.getElementById('campo_login').innerHTML = '<font color="gray">Verificando...</font>';
	}
 
	// Verifica se o Ajax realizou todas as operações corretamente
	// This block checks if the AJAX request was successful.
	if(req.readyState == 4 && req.status == 200) {
	// Resposta retornada pelo validacao.php (pagina de conexão com o BD)
	// This line gets
