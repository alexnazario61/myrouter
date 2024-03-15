<?php
/**
 * This script defines a PHP class named "ExampleClass".
 *
 * The class contains a constructor method that accepts an array of key-value pairs
 * as its only argument. The constructor initializes several class properties using
 * the values from the input array.
 *
 * ExampleClass also contains a public method named "doSomething" that takes
 * two arguments: a string and an integer. This method simply prints out the
 * string and the integer, separated by a space, to the console.
 *
 * @author    Edielson
 * @created   25/01/16
 * @version   1.0
 */
class ExampleClass
{
    /** @var string The name of the object. */
    private $name;

    /** @var int The age of the object. */
    private $age;

    /**
     * ExampleClass constructor.
     *
     * @param array $config An associative array of configuration options.
     */
    public function __construct(array $config)
    {
        $this->name = $config['name'];
        $this->age = $config['age'];
    }

    /**
     * Performs some action with the given string and integer.
     *
     * @param string $string The string to be processed.
     * @param int    $integer The integer to be processed.
     */
    public function doSomething($string, $integer)
    {
        echo $string . ' ' . $integer;
    }
}
