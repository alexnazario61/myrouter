<?php

namespace Cnab\Retorno\Cnab240;

use Cnab\Format\Linha;
use Cnab\Format\YamlLoad;
use Cnab\Retorno\IArquivo;

class TrailerArquivo extends Linha
{
    public function __construct(IArquivo $arquivo)
    {
        $yamlLoader = new YamlLoad($arquivo->getCodigoBanco(), $arquivo->getLayoutVersao());
        $yamlLoader->load($this, 'cnab240', 'trailer_arquivo');
    }
}
