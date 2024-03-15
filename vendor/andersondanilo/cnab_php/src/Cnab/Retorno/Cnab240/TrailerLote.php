<?php
// Define the namespace for the file
namespace Cnab\Retorno\Cnab240;

// Define the TrailerLote class which extends the \Cnab\Format\Linha abstract class
class TrailerLote extends \Cnab\Format\Linha
{
    // Define the constructor method for the TrailerLote class
    public function __construct(\Cnab\Retorno\IArquivo $arquivo)
    {
        // Create a new instance of the \Cnab\Format\YamlLoad class, passing in the bank code and layout version
        $yamlLoad = new \Cnab\Format\YamlLoad($arquivo->codigo_banco, $arquivo->layoutVersao);

        // Load the trailer_lote configuration for the cnab240 layout using the YamlLoad instance
        $yamlLoad->load($this, 'cnab240', 'trailer_lote');
    }
}
