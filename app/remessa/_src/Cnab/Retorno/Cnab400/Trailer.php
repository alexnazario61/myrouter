<?php
namespace Cnab\Retorno\Cnab400;

class Trailer extends \Cnab\Format\Linha
{
    /**
     * Constructor for the Trailer class.
     *
     * @param \Cnab\Retorno\IArquivo $arquivo The input arquivo object.
     */
    public function __construct(\Cnab\Retorno\IArquivo $arquivo)
    {
        // Load the YAML configuration for the specific bank and layout version
        $yamlLoad = new \Cnab\Format\YamlLoad($arquivo->codigo_banco, $arquivo->layoutVersao);

        // Load the configuration for the CNAB400 return trailer file
        $yamlLoad->load($this, 'cnab400', 'retorno/trailer_arquivo');
    }	
}

