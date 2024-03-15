<?php
namespace Cnab\Remessa\Cnab240;

class HeaderLote extends \Cnab\Format\Linha
{
    /**
     * Constructor for the HeaderLote class.
     *
     * @param \Cnab\Remessa\IArquivo $arquivo The remittance file object.
     */
    public function __construct(\Cnab\Remessa\IArquivo $arquivo)
    {
        // Load the YAML file for the bank and layout version.
        $yamlLoad = new \Cnab\Format\YamlLoad($arquivo->codigo_banco, $arquivo->layoutVersao);
        
        // Load the header_lote format from the YAML file into this object.
        $yamlLoad->load($this, 'cnab240', 'header_lote');
    }
}
