// Variável que receberá o objeto XMLHttpRequest
// This variable will hold the XMLHttpRequest object
var req;

function validarIP(campo, valor) {
  
  // Verificar o Browser
  // Function to check the browser
  if(window.XMLHttpRequest) {
      // If the browser supports XMLHttpRequest, create a new instance
      req = new XMLHttpRequest();
  }
  // If the browser is Internet Explorer
  else if(window.ActiveXObject) {
      // Create a new ActiveXObject instance for XMLHttpRequest
      req = new ActiveXObject("Microsoft.XMLHTTP");
  }
  
  // Aqui vai o valor e o nome do campo que pediu a requisição.
  // The value and the name of the field that requested the request
  var url = "ajax/ip.php?campo="+campo+"&valor="+valor;

  // Chamada do método open para processar a requisição
  // Call the open method to process the request
  req.open("Get", url, true);

  // Quando o objeto recebe o retorno, é chamada a seguinte função;
  // When the object receives the return, the following function is called
  req.onreadystatechange = function() {

      // Exibe a mensagem "Verificando" enquanto carrega
      // Display "Verifying" message while loading
      if(req.readyState == 1) {
          document.getElementById('campo_ip').innerHTML = '<font color="gray">Verificando...</font>';
      }

      // Verifica se o Ajax realizou todas as operações corretamente
      // Check if the Ajax has completed all operations correctly
      if(req.readyState == 4 && req.status == 200) {
          // Resposta retornada pelo validacao.php (pagina de conexão com o BD)
          // Response returned by validacao.php (page for connecting to the database)
          var resposta = req.responseText;

          // Resposta na div do campo que
