<?php 

// Check if the 'cadastrar' button is set in the POST request
if(isset ($_POST['cadastrar'])){ 

    // Function to convert date format
    function converteData($data){
        (!strstr($data,'/')) ? sscanf($data,'%d-%d-%d',$y,$m,$d) : sscanf($data,'%d/%d/%d',$d,$m,$y);
        return (!strstr($data,'/')) ? sprintf('%d/%d/%d',$d,$m,$y) : sprintf('%d-%d-%d',$y,$m,$d);
    }

    // Set the current date as dataemissao
    $dataemissao = date('d/m/Y');
    $formdata = date('Y-m-d', strtotime(converteData($dataemissao)));

    // Set variables for lote, inscricaomunicipal, codservico, codtributo, etc.
    // These variables are used to store information for the nota fiscal

    // Set the status as '1'
    $status = '1';

    // Set the values for valordeducoes, valorpis, valorcofins, valorinss, valorir, valoresisentos, outrosvalores, valorcsll, issretido, valoresis, icms, aliquota, descontoi, descontoc, vscom, codmunicipio, cnpj, anorps, mesrps, quantidadecontratada, quantidadefornecida, grupotensao, situacao
    // These variables are used to store various values related to the nota fiscal

    $nome_arquivo = $chavekey['estado']."00".$tipo.date('y').date('m')."N"."M"."."."001";

    // Set the notaNFe as 1 and initialize the i variable for the while loop
    $notaNFe = 1;
    $i = 0;

    // Query to select all records from the clientes table where nf is 'S'
    $consultas = $mysqli->query("SELECT * FROM clientes WHERE nf = 'S'");

    // While loop to iterate through each record fetched by the query
    while($campo = mysqli_fetch_array($consultas)){
        $i++;

        // Generate the numero nota
        $numeronfe = str_pad($notaNFe, 9, 0, STR_PAD_LEFT);// tamanho 9
        $notaNFe++;

        // Set the n_nfe and nnota variables
        $n_nfe =$numeronfe;
        $nnota = $n_nfe;

        // Generate the assinaturadigital using the formdata, nnota, and vscom
        $assinaturadigital = md5($formdata."T".$nnota);
        $cod_digital_registro = md5($formdata.$nnota.$vscom);

        // Set the clienteid variable to store the id of the current client
        $clienteid = $campo['id'];

        // Query to select all records from the assinaturas table where cliente is equal to clienteid
        $assinaturas = $mysqli->query("SELECT * FROM assinaturas WHERE cliente = '$clienteid'");

        // Fetch the first record from the assinaturas query
        $assinatura = mysqli_fetch_array($assinaturas);

        // Set the planoid variable to store the id of the current plan
        $planoid = $assinatura['plano'];

        // Query to select all records from the planos table where id is equal to planoid
        $planos = $mysqli->query("SELECT * FROM planos WHERE id = '$planoid'");

        // Fetch the first record from the planos query
        $plano = mysqli_fetch_array($planos);

        // Set the variables for clientecpf, clienterg, clientenome, clienteendereco, clientenumero, clientecomplemento, clientebairro, clientecidade, clienteuf, clientecep, clienteemail, idcliente, clientecfop, tipoassinante, tipoutilizacao, clientetelefone
        // These variables are used to store information related to the client

        // Set the qtdrps variable to the current value of i
        $qtdrps = $i;

        // Set the infrps variable to "RPS".$qtdrps
        $infrps = "RPS".$qtdrps;

        // Set the descricao variable to the name of the current plan
        $descricao = $plano['nome'];

        // Calculate the valorservicos based on the desconto, acrescimo, and plano['preco']

        // Insert the record into the notafiscal table
        $crud = new crud('notafiscal');  // tabela como parametro
        $crud->inserir("lote,nlote,nnota,assinaturadigital,inscricaomunicipal,qtdrps,infrps,numero,serie,tipo,emissao,naturezaop,opsimples,ic,status,valorservicos,valordeducoes,valorpis,valorcofins,valorinss,valorir,valoresisentos,outrosvalores,valorcsll,issretido,valoriss,valoroutros,icms,aliquota,descontoi,descontoc,vscom,descricao,codmunicipio,cnpj,cliente,clientecpf,clienterg,clientenome,clientetelefone,clienteendereco,clientenumero,clientecomplemento,clientebairro,clientecidade,clienteuf,clientecep,clienteemail,anorps,mesrps,codtributo,codservico,diavencimento,cfop,tipoassinante,tip
