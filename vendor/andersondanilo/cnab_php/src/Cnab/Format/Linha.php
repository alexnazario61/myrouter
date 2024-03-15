<?php

namespace Cnab\Format;

class Linha
{
    private array $fields = [];
    public bool  $lastError = false;

    public function __set(string $key, $valor): void
    {
        if (!array_key_exists($key, $this->fields)) {
            throw new \InvalidArgumentException("Field '$key' does not exist");
        }

        $this->fields[$key]->set($valor);
    }

    public function __get(string $key): string
    {
        if (!array_key_exists($key, $this->fields)) {
            throw new \InvalidArgumentException("Field '$key' does not exist");
        }

        return $this->fields[$key]->getValue() ?? '';
    }

    public static function cmpSortFields(Field $field1, Field $field2): int
    {
        return $field1->posStart > $field2->posStart ? 1 : -1;
    }

    public function addField(string $nome, int $posStart, int $posEnd, string $format, $default = false, array $options = []): void
    {
        foreach ($this->fields as $key => $field) {
            $currentPosStart = $field->posStart;
            $currentPosEnd = $field->posEnd;

            if (
                ($posStart >= $currentPosStart && $posStart <= $currentPosEnd) ||
                ($posEnd <= $currentPosEnd && $posEnd >= $currentPosStart) ||
                ($currentPosStart >= $posStart && $currentPosStart <= $posEnd) ||
                ($currentPosEnd <= $posEnd && $currentPosEnd >= $posStart)
            ) {
                unset($this->fields[$key]);
            }
        }

        $this->fields[$nome] = new Field($this, $nome, $format, $posStart, $posEnd, $options);

        if ($default !== false) {
            $this->fields[$nome]->set($default);
        }
    }

    public function loadFromString(string $text): void
    {
        foreach ($this->fields as $field) {
            $picture = Picture::decode(
                substr($text, $field->posStart - 1, $field->length),
                $field->format,
                $field->options
            );

            $field->set($picture);
        }
    }

    public function getEncoded(): string
    {
        if ($this->validate()) {
            $maxPosEnd = 0;
            $dados = '';
            $fields = $this->fields;
            usort($fields, [self::class, 'cmpSortFields']);
            $lastField = null;

            foreach ($fields as $field) {
                if ($lastField && $field->posStart != @$lastField->posEnd + 1) {
                    throw new \Exception("Gap between {$lastField->nome} and {$field->nome}");
                }

                $dados .= $field->getEncoded();

                if ($field->posEnd > $maxPosEnd) {
                    $maxPosEnd = $field->posEnd;
                }

                $lastField = $field;
            }

            if (strlen($dados) !== $maxPosEnd) {
                throw new \Exception("Line length is " . strlen($dados) . " and max pos_end is $maxPosEnd");
            }

            return $dados;
        } else {
            return false;
        }
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public function validate(): bool
    {
        foreach ($this->fields as $fieldName => $field) {
            if ($field->getValue() === null || $field->getValue() === false) {
                $this->lastError = "$fieldName cannot be null or false";
                return false;
            }
        }

        return true;
    }

    public function existField(string $name): bool
    {
        return array_key_exists($name, $this->fields);
    }

    public function dump(): string
    {
        $dump  = '';
        $dump .= PHP_EOL;
        $dump .= '============= Dump ==============';
        $dump .= PHP_EOL;

        foreach ($this->fields as $fieldName => $field) {
            $dump .= $fieldName . ': ';
            $dump .= $field->getValue();
            $dump .= PHP_EOL;
        }

        return $dump;
