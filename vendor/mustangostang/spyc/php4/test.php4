<?php
// ------------------------------------------------------------------------------
// SPYC - a simple PHP YAML class
// 
// Version: 0.3
// Author: Chris Wanstrath (chris@ozmm.org)
// Website: http://www.yaml.org, http://spyc.sourceforge.net/
// License: MIT License (http://www.opensource.org/licenses/mit-license.php)
// Copyright: (c) 2005-2006 Chris Wanstrath
// 
// This script demonstrates how to use the SPYC library to load and validate a
// YAML file. It checks various types of keys, sequences, and mappings.
// ------------------------------------------------------------------------------

// Enable error reporting
error_reporting(E_ALL);

// Include the SPYC library
include('spyc.php4');

// Load the YAML file
$yaml = Spyc::YAMLLoad('../spyc.yaml');

// Check if the YAML file loaded correctly
if ($yaml[1040] != "Ooo, a numeric key!")
	die('Key: 1040 failed');

// Test mappings / types
if ($yaml['String'] != "Anyone's name, really.")
	die('Key: String failed');

if ($yaml['Int'] !== 13)
	die('Key: Int failed');

if ($yaml['True'] !== true)
	die('Key: True failed');

if ($yaml['False'] !== false)
	die('Key: False failed');

if ($yaml['Zero'] !== 0)
	die('Key: Zero failed');

if (isset($yaml['Null']))
	die('Key: Null failed');

if ($yaml['Float'] !== 5.34)
	die('Key: Float failed');

// Test sequences
if ($yaml[0] != "PHP Class")
	die('Sequence 0 failed');

if ($yaml[1] != "Basic YAML Loader")
	die('Sequence 1 failed');

if ($yaml[2] != "Very Basic YAML Dumper")
	die('Sequence 2 failed');

// A sequence of a sequence
if ($yaml[3] != array("YAML is so easy to learn.", "Your config files will never be the same."))
	die('Sequence 3 failed');

// Sequence of mappings
if ($yaml[4] != array("cpu" => "1.5ghz", "ram" => "1 gig", "os" => "os x 10.4.1"))
	die('Sequence 4 failed');

// Mapped sequence
if ($yaml['domains'] != array("yaml.org", "php.net"))
	die("Key: 'domains' failed");

// A sequence like this.
if ($yaml[5] != array("program" => "Adium", "platform" => "OS X", "type" => "Chat Client"))
	die('Sequence 5 failed');

// A folded block as a mapped value
if ($yaml['no time'] != "There isn't any time for your tricks!\nDo you understand?")
	die("Key: 'no time' failed");

// A literal block as a mapped value
if ($yaml['some time'] != "There is nothing but time\nfor your tricks.")
	die("Key: 'some time' failed");

// Crazy combinations
if ($yaml['databases'] != array( array("name" => "spartan", "notes" =>
																			array( "Needs to be backed up",
																						 "Needs to be normalized" ),
																			 "type" => "mysql" )))
  die("Key: 'databases' failed");

// You can be a bit tricky
if ($yaml["if: you'd"] != "like")
	die("Key: 'if: you'd' failed");

// Inline sequences
if ($yaml[6] != array("One", "Two", "Three", "Four"))
	die("Sequence 6 failed");

// Nested Inline Sequences
if ($yaml[7] != array("One", array("Two", "And", "Three"), "Four", "Five"))
	die("Sequence 7 failed");

// Nested Nested Inline Sequences
if ($yaml[8] != array( "This", array("Is", "Getting", array("Ridiculous", "Guys")),
									"Seriously", array("Show", "Mercy")))
	die("Sequence 8 failed");

// Inline mappings
if ($yaml[9] != array("name" => "chris", "age" => "young", "brand" => "lucky strike"))
	die("Sequence 9 failed");

// Nested inline mappings
if ($yaml[10] != array("name" => "mark", "age" => "older than chris",
											 "brand" => array("marlboro", "lucky strike")))
	die("Sequence 10 failed");

// References -- they're shaky, but functional
if ($yaml['dynamic languages'] != array('Perl', 'Python', 'PHP', 'Ruby'))
	die("Key: 'dynamic languages' failed");

if ($yaml['compiled languages'] != array('C/C++', 'Java'))
	die("Key: 'compiled languages' failed");

if ($yaml['all languages'] != array(
																		array('Perl', 'Python', 'PHP', 'Ruby'),
																		array('C/C++', 'Java')
																	 ))
	die("Key: 'all languages' failed");

// Added in .2.2: Escaped quotes
if ($yaml[11] != "you know
