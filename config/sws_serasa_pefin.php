<?php

/**
 * SERASA class represents a WebService that connects to the SERASA API.
 */
class SERASA extends WebService
{
    /**
     * Constants for the URL of the TEST-DRIVE environment.
     */
    const URI_LOCATION = 'http://www.soawebservices.com.br/webservices/test-drive/serasa/pefin.asmx';
    const URI_LOCATION_WSDL = 'http://www.soawebservices.com.br/webservices/test-drive/serasa/pefin.asmx?WSDL';

    /* Constants for the URL of the PRODUCTION environment (currently commented out). */
    // const URI_LOCATION = 'http://www.soawebservices.com.br/webservices/producao/serasa/pefin.asmx';
    // const URI_LOCATION_WSDL = 'http://www.soawebservices.com.br/webservices/producao/serasa/pefin.asmx?WSDL';

    /**
     * @var int $traceEnabled Indicates whether tracing is enabled or not.
     */
    private $_traceEnabled = 1;

    /**
     * SERASA constructor initializes the WebService with the WSDL location and options.
     */
    public function __construct()
    {
        $options = [
            'location' => SERASA::URI_LOCATION,
            'trace' => $this->_traceEnabled,
            'style' => SOAP_RPC,
            'use' => SOAP_ENCODED,
        ];

        parent::__construct(SERASA::URI_LOCATION_WSDL, $options);
    }

    /**
     * getSerasaPefin method sends a SOAP request to the SERASA API with the provided Pefin object and returns the response.
     *
     * @param Pefin $Pefin The Pefin object containing the request parameters.
     * @return Pefin The Pefin object containing the response parameters.
     */
    public function getSerasaPefin(Pefin $Pefin)
    {
        $result = $this->callMethod('Pefin', ['parameters' => Util::objectToArray($Pefin)]);
        return Util::arrayToObject($result->{$this->getLastCalledMethod() . 'Result'}, $Pefin);
    }
}

/**
 * Credenciais class represents the authentication credentials required to access the SERASA API.
 */
class Credenciais
{
    /**
     * @var string $Email The email address used for authentication.
     */
    public $Email;

    /**
     * @var string $Senha The password used for authentication.
     */
    public $Senha;
}

/**
 * AlertaDocumentos class represents the alert document information returned by the SERASA API.
 */
class AlertaDocumentos extends ClassMap
{
    /**
     * @var string $Mensagem The message associated with the alert document.
     */
    public $Mensagem;

    /**
     * @var string $DDD1 The DDD of the first phone number.
     */
    public $DDD1;

    /**
     * @var string $Fone1 The first phone number.
     */
    public $Fone1;

    /**
     * @var string $DDD2 The DDD of the second phone number.
     */
    public $DDD2;

    /**
     * @var string $Fone2 The second phone number.
     */
    public $Fone2;

    /**
     * @var string $DDD3 The DDD of the third phone number.
     */
    public $DDD3;

    /**
     * @var string $Fone3 The third phone number.
     */
    public $Fone3;

    /**
     * AlertaDocumentos constructor initializes the ClassMap with the property types.
     */
    public function __construct()
    {
        parent::__construct([
            'Mensagem' => 'string',
            'DDD1' => 'string',
            'Fone1' => 'string',
            'DDD2' => 'string',
            'Fone2' => 'string',
            'DDD3' => 'string',
            'Fone3' => 'string'
        ]);
    }
}

/**
 * PendenciasFinanceiras class represents the financial pending information returned by the SERASA API.
 */
class PendenciasFinanceiras extends ClassMap
{
    /**
     * @var string $DataOcorrencia The date of the occurrence.
     */
    public $DataOcorrencia;

    /**
     * @var string $Modalidade The modality.
     */
    public $Modalidade;

    /**
     * @var string $Avalista The guarantor.
     */
    public $Avalista;

    /**
     * @var string $Valor The value.
     */
    public $Valor;

    /**
     * @var string $Contrato The contract.
     */
    public $Contrato;

    /**
     * @var string $Origem The origin.
     */
    public $Origem;

    /**
     * @var string $Sigla The acronym.
     */
    public $Sigla;

    /**
     * PendenciasFinanceiras constructor initializes the ClassMap with the property types.
     */
    public function __construct()
    {
        parent::__construct([
            'DataOcorrencia' => 'string',
            'Modalidade' => 'string',
            'Avalista' => 'string',
            'Valor' => 'string',
            'Contrato' => 'string',
            'Origem' => 'string',
            'Sigla' => 'string'
        ]);
    }
}

/**
 * PendenciasVarejo class represents the retail pending information returned by the SERASA API.
 */
class PendenciasVarejo extends ClassMap
{
    /**
     * @var string $CodigoCompens
