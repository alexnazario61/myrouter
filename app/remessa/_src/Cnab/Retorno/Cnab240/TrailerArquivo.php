<?php
// Define a namespace for the TrailerArquivo class
namespace Cnab\Retorno\Cnab240;

// Define the TrailerArquivo class that extends the \Cnab\Format\Linha class
class TrailerArquivo extends \Cnab\Format\Linha
{
    // Define the constructor method for the TrailerArquivo class
    public function __construct(\Cnab\Retorno\IArquivo $arquivo)
    {
        // Create a new instance of the YamlLoad class, passing the bank code and layout version
        $yamlLoad = new \Cnab\Format\YamlLoad($arquivo->codigo_banco, $arquivo->layoutVersao);

        // Load the trailer_arquivo format from the cnab240 file
        $yamlLoad->load($this, 'cnab240', 'trailer_arquivo');
    }
}
