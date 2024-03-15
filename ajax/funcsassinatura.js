// Function to validate login for subscriptions
async function validarLoginAssinaturas(campo, valor) {
  try {
    // URL for the request
    const url = `ajax/assinatura.php?campo=${campo}&valor=${valor}`;

    // Send the request and wait for a response
    const response = await fetch(url);

    // If the request was successful, parse the response as text
    if (response.ok) {
      const resposta = await response.json();

      // Update the 'campo_login' element with the response
      document.getElementById('campo_login').innerHTML = resposta.mensagem;
    } else {
      // If the request was not successful, show an error message
      document.getElementById('campo_login').innerHTML =
        'Erro na requisição. Por favor, tente novamente.';
    }
  } catch (error) {
    // If there was an error with the request, show an error message
    document.getElementById('campo_login').innerHTML =
      'Erro no processamento da requisição. Por favor, tente novamente.';
  }
}
