<?php

declare(strict_types=1);

namespace Cnab\Format;

use Cnab\Factory;
use Cnab\Linha;
use Symfony\Component\Yaml\Yaml;

class YamlLoad
{
    // The bank code
    public int $codigo_banco;

    // The path to the format directory
    public string $formatPath;

    // The version of the layout
    public ?string $layoutVersao;

    // Constructor function to initialize the object with the bank code and layout version
    public function __construct(int $codigo_banco, ?string $layoutVersao = null)
    {
        $this->codigo_banco = $codigo_banco;
        $this->layoutVersao = $layoutVersao;
        $this->formatPath = Factory::getCnabFormatPath();
    }

    // Function to validate that there are no collisions between the fields
    public function validateCollision(array $fields): void
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
              
