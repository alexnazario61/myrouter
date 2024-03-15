<?php

// Class Map
class ClassMap
{
    // Property to store the class map
    private $classMap;

    // Constructor to initialize the class map
    public function __construct(array $map)
    {
        $this->classMap = $map;
    }

    // Function to get the class map
    public function getClassMap(): array
    {
        return $this->classMap;
    }
}
