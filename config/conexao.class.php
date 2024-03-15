// CONEXAO PADRÃO
require_once("conexao.php"); 

// ...

$mysqli = new mysqli($host,$usuario,$senha,$banco) or die("Não é Possivel Conecta ao Banco de Dados");

$cn=mysql_connect($host, $login_db, $senha_db);
mysql_select_db($database);

class conexao
{
    // ...
}


function extenso($valor=0, $maiusculas=false) {
    // ...
}

function acento($string)
{
  // ...
}

function Moeda($value){
    return number_format($value, 2, ",", ".");
};


function convdata($dataform, $tipo){
    // ...
}

function diasEntreData($date_ini, $date_end){
    // ...
}


// Função Backups

// ...

function smtpmailer($para, $de, $de_nome, $assunto, $corpo) { 
    // ...
}
