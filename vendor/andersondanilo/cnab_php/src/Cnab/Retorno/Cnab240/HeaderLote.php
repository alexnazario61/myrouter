<?php
namespace Cnab\Retorno\Cnab240;

class HeaderLote extends \Cnab\Format\Linha
{
    /**
     * Constructor for the HeaderLote class.
     *
     * @param \Cnab\Retorno\IArquivo $arquivo The arquivo object that this header lote belongs to.
     */
    public function __construct(\Cnab\Retorno\IArquivo $arquivo)
    {
        // Load the YAML file for the specified bank code and layout version.
        $yamlLoad = new \Cnab\Format\YamlLoad($arquivo->codigo_banco, $arquivo->layoutVersao);
        
        // Load the header_lote format from the YAML file into this object.
        $yamlLoad->load($this, 'cnab240', 'header_lote');
    }
}
