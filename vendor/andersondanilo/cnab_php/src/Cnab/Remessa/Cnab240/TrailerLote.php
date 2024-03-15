<?php
namespace Cnab\Remessa\Cnab240;

/**
 * TrailerLote class representing the trailer of a lote in a CNAB 240 remittance file.
 * This class extends the \Cnab\Format\Linha class and is responsible for formatting and parsing the trailer of a lote.
 */
class TrailerLote extends \Cnab\Format\Linha
{
    /**
     * Constructs a TrailerLote object with the given remittance file.
     *
     * @param \Cnab\Remessa\IArquivo $arquivo The remittance file that this trailer lote belongs to.
     */
    public function __construct(\Cnab\Remessa\IArquivo $arquivo)
    {
        // Load the YAML file for the trailer lote based on the bank code and layout version.
        $yamlLoad = new \Cnab\Format\YamlLoad($arquivo->codigo_banco, $arquivo->layoutVersao);
        $yamlLoad->load($this, 'cnab240', 'trailer_lote');
    }
}
