<?php

namespace Cnab\Remessa\Cnab240;

use Cnab\Format\Linha;
use Cnab\Format\YamlLoad;
use Cnab\Remessa\IArquivo;

class SegmentoP extends Linha
{
    public function __construct(IArquivo $arquivo)
    {
        $yamlLoad = new YamlLoad($arquivo->codigo_banco, $arquivo->layoutVersao);
        $yamlLoad->load($this, 'cnab240', 'remessa/detalhe_segmento_p');
    }
}
