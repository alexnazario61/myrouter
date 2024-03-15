<?php
namespace Cnab\Retorno;

use Cnab\Format\YamlLoad;

class CodigoOcorrencia
{
    /**
     * @var YamlLoad
     */
    private $yamlLoad;

    /**
     * CodigoOcorrencia constructor.
     * @param YamlLoad $yamlLoad
     */
    public function __construct(YamlLoad $yamlLoad)
    {
        $this->yamlLoad = $yamlLoad;
    }

    /**
     * @param int $codigoBanco
     * @param int $codigoOcorrencia
     * @param string $format
     * @return string|null
     */
    public function getNome(int $codigoBanco, int $codigoOcorrencia, string $format = 'cnab400'): ?string
    {
        $format = strtolower($format);

        $array = $this->yamlLoad->loadFormat($format, 'retorno/codigo_ocorrencia');

        if (isset($array[$codigoBanco][$codigoOcorrencia])) {
            return $array[$codigoBanco][$codigoOcorrencia];
        }

        return null;
    }
}
