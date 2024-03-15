<?php
namespace Cnab\Remessa\Cnab240;

class SegmentoQ extends \Cnab\Format\Linha
{
    /**
     * Constructs a new instance of the SegmentoQ class.
     * @param \Cnab\Remessa\IArquivo $arquivo The remittance archival object that this segment belongs to.
     */
    public function __construct(\Cnab\Remessa\IArquivo $arquivo)
    {
        // Load the YAML configuration for this segment based on the bank code and layout version
        $yamlLoad = new \Cnab\Format\YamlLoad($arquivo->codigo_banco, $arquivo->layoutVersao);
        
        // Load the configuration for this segment from the YAML file
        $yamlLoad->load($this, 'cnab240', 'remessa/detalhe_segmento_q');
    }
}

