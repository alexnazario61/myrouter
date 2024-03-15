// Variable to hold the XMLHttpRequest object
let req;

function validarLogin(campo, valor) {
  // Verificar o Browser
  // Modern browsers
  if (window.XMLHttpRequest) {
    req = new XMLHttpRequest();
  }
  // Internet Explorer
  else if (window.ActiveXObject) {
    req = new ActiveXObject("Microsoft.XMLHTTP");
  }

  // URL for the request
  const url = `ajax/login.php?campo=${campo}&valor=${valor}`;

  // Open the request
  req.open("Get", url, true);

  // Callback function when the response is received
  req.onreadystatechange = function() {
    // Display "Verificando" while loading
    if (req.readyState === 1) {
      document.getElementById('campo_login').innerHTML = '<font color="gray">Verificando...</font>';
    }

    // Check if the Ajax request was successful
    if (req.readyState === 4 && req.status === 200) {
      // Response from the server
      const resposta = req.responseText;

      // Display the response
      document.getElementById('campo_login').innerHTML = resposta;
    }
  };

  req.send();
}
