<?php
// Start the session
session_start();

// Start output buffering
ob_start();

// Set the content type to text/html with ISO-8859-1 charset
header("Content-Type: text/html; charset=ISO-8859-1", true);

// Include the database connection class
include("config/conexao.class.php");

// Query to get the company version from the database
$empresaversao = $mysqli->query("SELECT * FROM empresa WHERE id = '1'");

// Fetch the company version data
$empresav = mysqli_fetch_array($empresaversao);

// Get the company version
$versao = $empresav['versao'];

// Check if the user submitted the login form
if ($_POST['operacao'] == 'login') {
  // Assign the submitted login, ssl, and md5-hashed password to variables
  $login = $_POST['login'];
  $ssl = $_POST['ssl'];
  $senha = md5($_POST['senha']);

  // Query to check the user's login and password in the database
  $confirmacao = $mysqli->query("SELECT * FROM usuarios WHERE login = '$login' AND senha = '$senha' AND status = 'S'");

  // Get the number of rows returned by the query
  $contagem = mysqli_num_rows($confirmacao);

  // Fetch the user data from the query result
  $linha = mysqli_fetch_array($confirmacao);

  // If the user exists, set session variables and redirect to the dashboard
  if ( $contagem == 1 ) {
    $_SESSION['login'] = $linha['login']; // Login do Usuário
    $_SESSION['id'] = $linha['id']; // ID do Usuário
    $_SESSION['nivel'] = $linha['nivel']; // Nível de Permissão
    echo "<script>location.href='index.php'</script>"; //Acessa o Painel

    // Log the user's login action
    $ip = $_SERVER['REMOTE_ADDR']; // Salva o IP do visitante
    $hora = date('Y-m-d H:i:s'); // Salva a data e hora atual (formato MySQL)
    $sql = $mysqli->query("INSERT INTO log (admin,ip,data,acao,detalhes,query) VALUES ('$login', '".$ip."', '".$hora."','ACESSOU O SISTEMA','ACESSOU O SISTEMA', NULL)");

  } else {
    // If the login or password is incorrect, show an error message
    echo '<script>
            alert ("LOGIN OU SENHA ESTÃO INVALIDOS!");
            document.location.href = ("login.php");
          </script>';
  }
}
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>MyRouter ERP | Login</title>
<link href="assets/css/styles.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
</head>

<body>
<div class="colorful-page-wrapper">
  <div class="center-block">
    <div class="login-block">
      <!-- Login form -->
    </div>
    
    <div class="copyrights"> MyRouter ERP Para Provedores &copy; <?php echo date('Y'); ?> / <?php echo'Versão '?><?php echo @$empresav['versao']; ?> <br>
      </div>
  </div>
</div>

<!--Scripts--> 
<!--JQuery--> 
<script type="text/javascript" src="assets/js/vendors/jquery/jquery.min.js"></script> 
<script type="text/javascript" src="assets/js/vendors/jquery/jquery-ui.min.js"></script> 
<script type="text/javascript" src="assets/js/vendors/forms/jquery.form.min.js"></script> 
<script type="text/javascript" src="assets/js/vendors/forms/jquery.validate.min.js"></script> 
<script type="text/javascript" src="assets/js/vendors/forms/jquery.maskedinput.min.js"></script> 
<script type="text/javascript" src="assets/js/vendors/jquery-steps/jquery.steps.min.js"></script> 
<script type="text/javascript" src="assets/js/vendors/nanoscroller/jquery.nanoscroller.min.js"></script> 
<script type="text/javascript" src="assets/js/vendors/sparkline/jquery.sparkline.min.js"></script> 
<script type="text/javascript" src="assets/js/scripts.js"></script>

</body>
</html>
