<?php

namespace Cnab\Retorno\Cnab240;

use Cnab\Format\Linha;
use Cnab\Format\YamlLoad;
use Cnab\Retorno\IArquivo;

class TrailerLote extends Linha
{
    public function __construct(IArquivo $arquivo)
    {
        $yamlLoader = new YamlLoad($arquivo->codigoBanco, $arquivo->layoutVersao);
        $yamlLoader->load($this, 'cnab240', 'trailer_lote');
    }
}
