<?php
namespace Cnab\Remessa\Cnab240;

class HeaderArquivo extends \Cnab\Format\Linha
{
    /**
     * Constructor for the HeaderArquivo class.
     *
     * @param \Cnab\Remessa\IArquivo $arquivo The remittance archive object.
     */
    public function __construct(\Cnab\Remessa\IArquivo $arquivo)
    {
        // Load the YAML file for the specified bank code and layout version.
        $yamlLoad = new \Cnab\Format\YamlLoad($arquivo->codigo_banco, $arquivo->layoutVersao);
        
        // Load the header_arquivo format from the YAML file into this object.
        $yamlLoad->load($this, 'cnab240', 'header_arquivo');
    }
}
