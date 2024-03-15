// Variable to hold the XMLHttpRequest object
let req;

function validarIP(campo, valor) {
  // Check if the browser supports XMLHttpRequest
  if (window.XMLHttpRequest) {
    req = new XMLHttpRequest();
  }
  // If the browser is Internet Explorer
  else if (window.ActiveXObject) {
    req = new ActiveXObject("Microsoft.XMLHTTP");
  }

  // URL for the request
  const url = `ajax/ip.php?campo=${campo}&valor=${valor}`;

  // Open the request
  req.open("Get", url, true);

  // Process the response
  req.onreadystatechange = function() {
    // Display "Verifying..." message while loading
    if (req.readyState === 1) {
      document.getElementById('campo_ip').innerHTML = '<p style="color:gray;">Verificando...</p>';
    }

    // Check if the Ajax request was successful
    if (req.readyState === 4 && req.status === 200) {
      // Process the response
      const response = req.responseText;
      // Display the response
      document.getElementById('campo_ip').innerHTML = response;
    }
  };
}

