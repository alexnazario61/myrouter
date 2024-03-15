<?php
namespace Cnab\Remessa\Cnab240;

class HeaderArquivo extends \Cnab\Format\Linha
{
    /**
     * Constructor for the HeaderArquivo class.
     *
     * @param \Cnab\Remessa\IArquivo $arquivo The remittance archival object that this header belongs to.
     */
    public function __construct(\Cnab\Remessa\IArquivo $arquivo)
    {
        // Load the YAML configuration for the CNAB 240 header based on the bank code and layout version.
        $yamlLoad = new \Cnab\Format\YamlLoad($arquivo->codigo_banco, $arquivo->layoutVersao);
        $yamlLoad->load($this, 'cnab240', 'header_arquivo');
    }
}
