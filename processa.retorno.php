session_start();
ob_start();

require_once 'vendor/autoload.php';
require_once 'config/conexao.class.php';
require_once 'config/crud.class.php';
require_once 'config/mikrotik.class.php';


$idpuser = $logado['nome']; // pegar nome do login da sessão
ini_set("allow_url_fopen", 1);
ini_set("display_errors", 1);
error_reporting(E_ALL);
ini_set("track_errors", "1");
header("Content-Type: text/html; charset=ISO-8859-1", true);


$cnabFactory = new Cnab\Factory();
$con = new conexao();
$con->connect();


$_UP['extensoes'] = array('ret', 'RET');
$tiporet = $_FILES['arquivo']['type'];
$extensao = strtolower(@end(explode('.', $_FILES['arquivo']['name'])));
if (array_search($extensao, $_UP['extensoes']) === false) {
    header("Location: index.php?app=Retorno&reg=2");
}


else {
    $upfile = $_FILES['arquivo']['tmp_name'];
    $arquivo = $cnabFactory->createRetorno($upfile);

    function fndata($string) {
        // Converts numbers with leading zeros to their respective numeric values
    }

    foreach($arquivo->listDetalhes() as $detalhe) {
        // Extracting and formatting data from each record
    }
}


if ($detalhe->getCodigo() == 6) {
    // Processing records with codigo 6
}


header("Location: index.php?app=Retorno&reg=1");
