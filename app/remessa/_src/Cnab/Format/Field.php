<?php

namespace Cnab\Format;

/**
 * Field represents a field in a CNAB file.
 */
class Field
{
    public ?string $name;
    public string $format;
    public ?string $valueDecoded;
    public ?string $valueEncoded;
    public int $posStart;
    public int $posEnd;
    public int $length;

    /**
     * @throws \InvalidArgumentException
     */
    public function __construct(
        string $name,
        string $format,
        int $posStart,
        int $posEnd,
        int $length,
        array $options = []
    ) {
        if (!Picture::isValidFormat($format)) {
            throw new \InvalidArgumentException("'$format' is not a valid format on $name");
        }

        $this->name = $name;
        $this->format = $format;
        $this->posStart = $posStart;
        $this->posEnd = $posEnd;
        $this->length = $length;

        if (Picture::getLength($format) > $length) {
            throw new \Exception("Picture length of '$name' needs more positions than $posStart : $posEnd");
        }
    }

    /**
     * @throws \Exception
     */
    public function set(?string $value): void
    {
        if ($value === false || is_null($value) || $value === '') {
            throw new \Exception("'$this->name' cannot be false, null or empty");
        }

        $this->valueDecoded = $value;

        try {
            $this->valueEncoded = Picture::encode($value, $this->format, []);
        } catch (\Exception $e) {
            trigger_error("Error in field '$this->name': " . $e->getMessage(), E_USER_NOTICE);
            throw $e; // for displaying the backtrace
        }

        if (strlen($this->valueEncoded) !== $this->length) {
            throw new \Exception("'$this->name' has length " . strlen($this->valueEncoded) . ", but the field needs length $this->length");
        }
    }

    public function getValue(): ?string
    {
        return $this->valueDecoded;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEncoded(): ?string
    {

