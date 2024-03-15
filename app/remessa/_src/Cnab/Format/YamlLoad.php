<?php
namespace Cnab\Format;

use Cnab\Factory;

class YamlLoad
{
    // The bank code
    public $codigo_banco = null;
    
    // The path to the format directory
    public $formatPath;
    
    // The version of the layout
    public $layoutVersao;

    // Constructor function to initialize the object with the bank code and layout version
    public function __construct($codigo_banco, $layoutVersao = null)
    {
        $this->codigo_banco = $codigo_banco;
        $this->layoutVersao = $layoutVersao;
        $this->formatPath = Factory::getCnabFormatPath();
    }

    // Function to validate that there are no collisions between the fields
    public function validateCollision($fields)
    {
        // Loop through each field
        foreach ($fields as $name => $field)
        {
            $pos_start = $field['pos'][0];
            $pos_end = $field['pos'][1];

            // Loop through each field again, excluding the current one
            foreach ($fields as $current_name => $current_field)
            {
                if ($current_name === $name)
                    continue;

                $current_pos_start = $current_field['pos'][0];
                $current_pos_end = $current_field['pos'][1];

                // Check if the start position of the current field is greater than the end position
                if ($current_pos_start > $current_pos_end)
                {
                    throw new \DomainException("No campo $current_name a posição inicial ($current_pos_start) deve ser menor ou igual à posição final ($current_pos_end)");
                }

                // Check if the positions of the current field and the current iteration field overlap
                if (
                    (
                        $pos_start >= $current_pos_start && $pos_start <= $current_pos_end
                    ) ||
                    (
                        $pos_end <= $current_pos_end && $pos_end >= $current_pos_start
                    )
                )
                {
                    throw new \DomainException("O campo $name colide com o campo $current_name");
                }
            }

            // If there are no collisions, return true
            return true;
        }
    }

    // Function to validate the structure of the YAML array
    public function validateArray($array)
    {
        // Check if the array is empty or if it doesn't have a 'generic' key
        if (empty($array) || empty($array['generic']))
            throw new \Exception('arquivo yaml sem campo "generic"');

        // Loop through each key in the array
        foreach ($array as $key => $fields)
        {
            // Call the validateCollision function to check for collisions
            $this->validateCollision($fields);
        }

        // If there are no collisions, return true
        return true;
    }

    // Function to load the fields from the YAML array into the CNAB line object
    public function loadArray(Linha $cnabLinha, $array)
    {
        // Call the validateArray function to check for collisions
        $this->validateArray($array);

        // Define the keys to loop through
        $keys = array('generic');
        if (array_key_exists(sprintf('%03d', $this->codigo_banco), $array))
            $keys[] = sprintf('%03d', $this->codigo_banco);

        // Loop through each key in the array
        foreach ($array as $key => $fields)
        {
            // Check if the key is one of the keys to loop through
            if (in_array($key, $keys))
            {
                // Loop through each field in the current key
                foreach ($fields as $name => $info)
                {
                    // Get the field information
                    $picture = $info['picture'];
                    $start = $info['pos'][0];
                    $end = $info['pos'][1];
                    $default = isset($info['default']) ? $info['default'] : false;
                    $options = $info;

                    // Add the field to the CNAB line object
                    $cnabLinha->addField($name, $start, $end, $picture, $default, $options);
                }
            }
        }
    }

    // Function to load a YAML file
    public function loadYaml($filename)
    {
        // Check if the file exists
        if (file_exists($filename))
            return spyc_load_file($filename);
        else
            return null;
    }

    // Function to load the format from the YAML files
    public function loadFormat($cnab, $filename)
    {
        // Get the bank code as a 3-digit string
        $banco = sprintf('%03d', $this->codigo_banco);

        // Define the file paths
        $filenamePadrao = $this->formatPath . '/' . $cnab . '/generic/' . $filename . '.yml';
        $filenameEspecifico = $this->formatPath . '/' . $cnab . '/' . $banco . '/' . $filename . '.yml';

        // Check if the layout version is set and if the bank code is 104
        if ($this->layoutVersao != null && $this->codigo_banco == 104)
        {
            // Use a different file path when the bank has multiple layout versions
            $filenameEspecifico = $this->formatPath . '/' . $cnab . '/' . $banco . '/' . $this->layoutVersao . '/' . $filename . '.yml';
        }

        // Check if the standard file and the specific file exist
        if (!file_exists($filenamePadrao) && !file_exists($filenameEspecifico))
            throw new \Exception('Arquivo não encontrado ' .
