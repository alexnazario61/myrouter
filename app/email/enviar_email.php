<?php
// Database configuration
$host = "localhost";
$usuario = "username";
$senha = "password";
$banco = "database";

// Connect to the database
$conn = new mysqli($host, $usuario, $senha, $banco);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the parameters from the URL
$clienteemail = base64_decode($_GET['cliente']);
$fatura2 = base64_decode($_GET['fatura']);

// Select the client from the database
$sql3 = $conn->prepare("SELECT * FROM clientes WHERE id=?");
$sql3->bind_param("s", $clienteemail);
$sql3->execute();
$result3 = $sql3->get_result();
$cli = $result3->fetch_assoc();
$EmailCliente = $cli['email'];
$NomeCliente = $cli['nome'];

// Select the invoice from the database
$sql4 = $conn->prepare("SELECT * FROM financeiro WHERE id=?");
$sql4->bind_param("s", $fatura2);
$sql4->execute();
$result4 = $sql4->get_result();
$fin = $result4->fetch_assoc();
$CampoValor = $fin['valor'];
$CampoLink = $fin['linkGerencia'];
$CampoVencimento = date('d/m/Y', strtotime($fin['vencimento']));
$Camponfatura = $fin['id'];

// Select the company from the database
$sql5 = $conn->prepare("SELECT * FROM empresa WHERE id=?");
$sql5->bind_param("s", 1);
$sql5->execute();
$result5 = $sql5->get_result();
$emp = $result5->fetch_assoc();
$NomeEmpresa = $emp['empresa'];

// Include the PHPMailer library
require 'PHPMailerAutoload.php';

// Select the email configuration from the database
$sql = $conn->prepare("SELECT * FROM maile");
$sql->execute();
$result = $sql->get_result();
$linha = $result->fetch_assoc();

// Initialize the PHPMailer object
$mail = new PHPMailer;

// Set the email parameters
$mail->isSMTP();
$mail->Host = $linha['servidor'];
$mail->SMTPAuth = true;
$mail->Username = $linha['email'];
$mail->Password = $linha['senha'];
$mail->SMTPSecure = $linha['smtpsecure'];
$mail->Port = $linha['porta'];
$mail->From = $linha['email'];
$mail->FromName = $NomeEmpresa;

// Set the email recipient
$mail_send = filter_var($EmailCliente, FILTER_VALIDATE_EMAIL);
$mail->addAddress($mail_send, $NomeCliente);

// Set the email subject and body
$subject = htmlspecialchars($linha['assunto']);
$body = htmlspecialchars($linha['corpo']);

// Replace the placeholders with the actual values
$search = array('[NomeCliente]', '[valor]', '[vencimento]', '[numeroFatura]', '[Descricaodafatura]', '[link]', '[endereco]', '[email]', '[avisofataberto]', '[NomeEmpresa]', '[referencia]');
$replace = array($NomeCliente, number_format($CampoValor, 2, ',', '.'), $CampoVencimento, $Camponfatura, $referente, $CampoLink, $endereco, $email, $avisofataberto, $NomeEmpresa, 'Fatura de Mensalidade');
$texto = str_replace($search, $replace, $body);
$mail->Subject = $subject;
$mail->Body = $texto;

// Send the email
if (!$mail->send()) {
    echo "Erro: " . utf8_decode($mail->ErrorInfo);
    echo "<br />";
    echo '<meta http-equiv="refresh" content="0;URL=../../index.php?app=Financeiro&reg=6" />';
} else {
    echo "<br />";
    echo '<meta http-equiv="refresh" content="0;URL=../../index.php?app=Financeiro&reg=5" />';
}

// Close the database connection
$conn->close();
?>
