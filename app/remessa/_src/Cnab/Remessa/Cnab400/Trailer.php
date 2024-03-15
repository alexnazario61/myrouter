<?php

namespace Cnab\Remessa\Cnab400;

use Cnab\Format\Linha;
use Cnab\Format\YamlLoad;
use Cnab\Remessa\IArquivo;

class Trailer extends Linha
{
    public function __construct(IArquivo $arquivo)
    {
        $codigoBanco = $arquivo->getCodigoBanco();
        $yamlLoad = new YamlLoad($codigoBanco);
        $yamlLoad->load($this, 'cnab400', 'remessa/trailer_arquivo');
    }
}
