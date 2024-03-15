<?php

namespace Cnab\Retorno\Cnab240;

use Cnab\Format\YamlLoad;
use Cnab\Retorno\IArquivo;

class TrailerArquivo extends \Cnab\Format\Linha
{
    /**
     * @var IArquivo $arquivo The associated arquivo object
     */
    private $arquivo;

    /**
     * TrailerArquivo constructor.
     * @param IArquivo $arquivo The associated arquivo object
     */
    public function __construct(IArquivo $arquivo)
    {
        $this->arquivo = $arquivo;

        $yamlLoad = new YamlLoad($this->arquivo->codigo_banco, $this->arquivo->layoutVersao);
        $yamlLoad->load($this, 'cnab240', 'trailer_arquivo');
    }

    /**
     * Get the associated arquivo object
     * @return IArquivo
     */
    public function getArquivo(): IArquivo
    {
        return $this->arquivo;
    }
}
