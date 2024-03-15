<?php

declare(strict_types=1);

namespace Cnab\Retorno;

use Cnab\Format\YamlLoad;

class CodigoOcorrencia
{
    /**
     * Returns the name of the ocorrence code for a given bank code and ocorrence code.
     * It currently only supports the CNAB400 format.
     *
     * @param int                     $codigoBanco     The bank code
     * @param int                     $codigoOcorrencia The ocorrence code
     * @param string                  $format          The format of the ocorrence code, either 'cnab400' (default)
     * @return string                 The name of the ocorrence code
     * @throws \Exception If the format is not supported or the bank code or ocorrence code is invalid.
     */
    public function getNome(int $codigoBanco, int $codigoOcorrencia, string $format = 'cnab400'): string
    {
        // Convert the format, bank code, and ocorrence code to lowercase and integers
        $format = strtolower($format);

        // Load the format from a YAML file
        $yamlLoad = new YamlLoad();
        $array = $yamlLoad->loadFormat($format, 'retorno/codigo_ocorrencia');

        // Check if the bank code and ocorrence code exist in the array
        if ($array !== null && array_key_exists($codigoBanco, $array) && array_key_exists($codigoOcorrencia, $array[$codigoBanco])) {
            // Return the name of the ocorrence code
            return $array[$codigoBanco][$codigoOcorrencia];
        }

        // If the bank code or ocorrence code do not exist in the array, throw an exception
        throw new \Exception("The format '{$format}' is not supported or the bank code '{$codigoBanco}' or ocorrence code '{$codigoOcorrencia}' is invalid.");
    }
}
