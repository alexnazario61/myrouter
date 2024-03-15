// Variável que receberá o objeto XMLHttpRequest
// This variable will hold the XMLHttpRequest object
var req;

function validarCPF(campo, valor) {
 
// Verificar o Browser
// Function to check the browser
// Firefox, Google Chrome, Safari and others
if(window.XMLHttpRequest) {
   // Create a new XMLHttpRequest object for modern browsers
   req = new XMLHttpRequest();
}
// Internet Explorer
else if(window.ActiveXObject) {
   // Create a new ActiveXObject for Internet Explorer
   req = new ActiveXObject("Microsoft.XMLHTTP");
}
 
// Aqui vai o valor e o nome do campo que pediu a requisição.
// The value and name of the field that made the request will go here
var url = "ajax/cpf.php?campo="+campo+"&valor="+valor;
 
// Chamada do método open para processar a requisição
// Call the open method to process the request
req.open("Get", url, true);
 
// Quando o objeto recebe o retorno, é chamada a seguinte função;
// When the object receives the return, the following function is called
req.onreadystatechange = function() {
 
	// Exibe a mensagem "Verificando" enquanto carrega
	// Display the message "Verifying" while loading
	if(req.readyState == 1) {
		// Set the content of the element with id 'campo_cpf' to 'Verifying...'
		document.getElementById('campo_cpf').innerHTML = '<font color="gray">Verificando...</font>';
	}
 
	// Verifica se o Ajax realizou todas as operações corretamente
	// Check if the Ajax request was successful
	if(req.readyState == 4 && req.status == 200) {
	// Resposta retornada pelo validacao.php (pagina de conexão com o BD)
	// Response returned by validacao
