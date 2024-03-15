<?php
namespace Cnab\Retorno\Cnab240;

class SegmentoT extends \Cnab\Format\Linha
{
    /**
     * Constructs a new SegmentoT object.
     * 
     * @param \Cnab\Retorno\IArquivo $arquivo The input arquivo object.
     */
    public function __construct(\Cnab\Retorno\IArquivo $arquivo)
    {
        // Load the YAML configuration for this segmento based on the bank code and layout version.
        $yamlLoad = new \Cnab\Format\YamlLoad($arquivo->codigo_banco, $arquivo->layoutVersao);
        $yamlLoad->load($this, 'cnab240', 'retorno/detalhe_segmento_t');
    }
}
