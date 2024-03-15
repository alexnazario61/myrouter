<?php
namespace Cnab\Retorno;

class CodigoOcorrencia
{
    /**
     * This method returns the name of the ocorrence code for a given bank code and ocorrence code.
     * It currently only supports the CNAB400 format.
     *
     * @param int $codigo_banco The bank code
     * @param int $codigo_ocorrencia The ocorrence code
     * @param string $format The format of the ocorrence code, either 'cnab400' (default)
     * @return string The name of the ocorrence code
     *
     * @throws \Exception If the format is not supported
     */
    public function getNome($codigo_banco, $codigo_ocorrencia, $format='cnab400')
    {
        // Convert the format, bank code, and ocorrence code to lowercase and integers
        $format             = strtolower($format);
        $codigo_banco       = (int)$codigo_banco;
        $codigo_ocorrencia  = (int)$codigo_ocorrencia;

        // Load the format from a YAML file
        $yamlLoad           = new \Cnab\Format\YamlLoad($codigo_banco);
        $array              = $yamlLoad->loadFormat($format, 'retorno/codigo_ocorrencia');

        // Check if the bank code and ocorrence code exist in the array
        if(array_key_exists($codigo_banco, $array) && array_key_exists($codigo_ocorrencia, $array[$codigo_banco]))
        {
            // Return the name of the ocorrence code
            return $array[$codigo_banco][$codigo_ocorrencia];
        }

        // If the bank code or ocorrence code do not exist in the array, throw an exception
        throw new \Exception("The format '{$format}' is not supported or the bank code or ocorrence code is invalid.");
    }
}
