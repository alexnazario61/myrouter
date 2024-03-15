<?php

namespace Cnab\Remessa\Cnab240;

use Cnab\Format\Linha;
use Cnab\Format\YamlLoad;
use Cnab\Remessa\IArquivo;

class TrailerArquivo extends Linha
{
    public function __construct(IArquivo $arquivo)
    {
        $yamlLoad = new YamlLoad($arquivo->codigoBanco, $arquivo->layoutVersao);
        $yamlLoad->load($this, 'Cnab240', 'trailer_arquivo');
    }
}
