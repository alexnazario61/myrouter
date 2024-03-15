<?php
namespace Cnab\Remessa\Cnab240;

class TrailerLote extends \Cnab\Format\Linha
{
    /**
     * Constructs a TrailerLote object with the given remessa arquivo.
     *
     * @param \Cnab\Remessa\IArquivo $arquivo The remessa arquivo that this trailer lote belongs to.
     */
    public function __construct(\Cnab\Remessa\IArquivo $arquivo)
    {
        // Load the YAML file for the trailer lote format based on the bank code and layout version.
        $yamlLoad = new \Cnab\Format\YamlLoad($arquivo->codigo_banco, $arquivo->layoutVersao);
        
        // Load the trailer lote format into this object.
        $yamlLoad->load($this, 'cnab240', 'trailer_lote');
    }
}
