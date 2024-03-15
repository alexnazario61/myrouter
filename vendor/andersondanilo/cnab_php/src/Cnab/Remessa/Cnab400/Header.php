<?php
// Namespace for CNAB 400 remessa header classes
namespace Cnab\Remessa\Cnab400;

// Header class representing the header of a CNAB 400 remessa file
class Header extends \Cnab\Format\Linha
{
    // Constructor for the Header class
    //
    // @param \Cnab\Remessa\IArquivo $arquivo The remessa file object
    public function __construct(\Cnab\Remessa\IArquivo $arquivo)
    {
        // Get the codigo_banco value from the remessa file object
        $codigo_banco = $arquivo->codigo_banco;

        // Load the YAML file for the CNAB 400 remessa header based on the codigo_banco
        $yamlLoad = new \Cnab\Format\YamlLoad($codigo_banco);
        $yamlLoad->load($this, 'cnab400', 'remessa/header_arquivo');
    }
}
