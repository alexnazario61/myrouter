<?php

// Include the Spyc library for YAML parsing
require_once ("../Spyc.php");

// Define the IndentTest class that extends PHPUnit_Framework_TestCase
class IndentTest extends PHPUnit_Framework_TestCase {

    // Declare a protected property $Y to store the loaded YAML data
    protected $Y;

    // Define the setUp method that gets called before each test method is run
    protected function setUp() {
      // Load the YAML data from the indent_1.yaml file
      $this->Y = Spyc::YAMLLoad("indent_1.yaml");
    }

    // Define the testIndent_1 method that tests the indentation of the 'root' key in the YAML data
    public function testIndent_1() {
      // Assert that the 'root' key has the expected indentation values
      $this->assertEquals (array ('child_1' => 2, 'child_2' => 0, 'child_3' => 1), $this->Y['root']);
    }

    // Define the testIndent_2 method that tests the indentation of the 'root2' key in the YAML data
    public function testIndent_2() {
      // Assert that the 'root2' key has the expected indentation values
      $this->assertEquals (array ('child_1' => 1, 'child_2' => 2), $this->Y['root2']);
    }

    // Define the testIndent_3 method that tests the indentation of the 'display' key in the YAML data
    public function testIndent_3() {
      // Assert that the 'display' key has the expected indentation values
      $this->assertEquals (array (array ('resolutions' => array (1024 => 768, 1920 => 1200), 'producer' => 'Nec')), $this->Y['display']);
    }

    // Define the testIndent_4 method that tests the indentation of the 'displays' key in the YAML data
    public function testIndent_4() {
      // Assert that the 'displays' key has the expected indentation values
      $this->assertEquals (array (
          array ('resolutions' => array (1024 => 768)),
          array ('resolutions' => array (1920 => 1200)),
        ), $this->Y['displays']);
    }

    // Define the testIndent_5 method that tests the indentation of the 'nested_hashes_and_seqs' key in the YAML data
    public function testIndent_5() {
      // Assert that the 'nested_hashes_and_seqs' key has the expected indentation values
      $this->assertEquals (array (array (
        'row' => 0,
        'col' => 0,
        '
