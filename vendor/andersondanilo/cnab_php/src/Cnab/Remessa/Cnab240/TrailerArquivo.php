<?php
// Define the namespace for this class
namespace Cnab\Remessa\Cnab240;

// TrailerArquivo class extends \Cnab\Format\Linha, meaning it inherits properties and methods from the Linha class
class TrailerArquivo extends \Cnab\Format\Linha
{
    // Constructor method for the TrailerArquivo class
    public function __construct(\Cnab\Remessa\IArquivo $arquivo)
    {
        // Create a new instance of the YamlLoad class, passing in the bank code and layout version as arguments
        $yamlLoad = new \Cnab\Format\YamlLoad($arquivo->codigo_banco, $arquivo->layoutVersao);

        // Load the trailer_arquivo configuration for the specified bank and layout version using the YamlLoad instance
        $yamlLoad->load($this, 'cnab240', 'trailer_arquivo');
    }
}
