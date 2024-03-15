<?php
namespace Cnab\Remessa\Cnab240;

use Cnab\Format\Linha;
use Cnab\Format\YamlLoad;

class TrailerLote extends Linha
{
    /**
     * Constructs a TrailerLote object with the given remessa arquivo.
     *
     * @param \Cnab\Remessa\IArquivo $arquivo The remessa arquivo that this trailer lote belongs to.
     */
    public function __construct(IArquivo $arquivo)
    {
        // Load the YAML file for the trailer lote format based on the bank code and layout version.
        $yamlLoader = new YamlLoad($arquivo->codigo_banco, $arquivo->layoutVersao);

        // Load the trailer lote format into this object.
        $yamlLoader->load($this, 'cnab240', 'trailer_lote');
    }
}
