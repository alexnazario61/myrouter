<?php
// Namespace for Cnab remessa Cnab240 classes
namespace Cnab\Remessa\Cnab240;

// SegmentoP class representing a line in a Cnab240 remessa file
class SegmentoP extends \Cnab\Format\Linha
{
    // Constructor for SegmentoP class
    //
    // @param \Cnab\Remessa\IArquivo $arquivo The remessa file object
    public function __construct(\Cnab\Remessa\IArquivo $arquivo)
    {
        // Load Yaml configuration for Cnab240 remessa file segmento P
        $yamlLoad = new \Cnab\Format\YamlLoad($arquivo->codigo_banco, $arquivo->layoutVersao);
        $yamlLoad->load($this, 'cnab240', 'remessa/detalhe_segmento_p');
    }
}
