<?php
namespace Cnab\Retorno\Cnab240;

class HeaderArquivo extends \Cnab\Format\Linha
{
    // Constructor method for the HeaderArquivo class, which takes an instance of the IArquivo interface as a parameter
    public function __construct(\Cnab\Retorno\IArquivo $arquivo)
    {
        // Create a new instance of the YamlLoad class, passing in the bank code and layout version as parameters
        $yamlLoad = new \Cnab\Format\YamlLoad($arquivo->codigo_banco, $arquivo->layoutVersao);
        
        // Load the configuration for the header_arquivo section of the CNAB240 format using the YamlLoad instance
        $yamlLoad->load($this, 'cnab240', 'header_arquivo');
    }

    // Method to retrieve the account number field, if it exists
    public function getConta()
    {
        if($this->existField('conta'))
            return $this->conta;
        else
            return null;
    }

    // Method to retrieve the account DAC field, if it exists
    public function getContaDac()
    {
        if($this->existField('conta_dv'))
            return $this->conta_dv;
        else
            return null;
    }

    // Method to retrieve the convenio code field, if it exists
    public function getCodigoConvenio() {
        if ($this->existField('codigo_convenio'))
            return $this->codigo_convenio;
        else
            return null;
    }
}

