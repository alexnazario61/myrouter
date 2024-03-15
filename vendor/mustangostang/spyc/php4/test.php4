<?php

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the SPYC library
if (!file_exists('spyc.php4')) {
    die('Error: SPYC library not found');
}
require_once 'spyc.php4';

// Load the YAML file
$yamlFile = '../spyc.yaml';
if (!file_exists($yamlFile)) {
    die('Error: YAML file not found');
}

try {
    $yaml = Spyc::YAMLLoad($yamlFile);
} catch (Exception $e) {
    die('Error: Failed to load YAML file - ' . $e->getMessage());
}

// Check if the YAML file loaded correctly
if ($yaml[1040] !== "Ooo, a numeric key!") {
    die('Key: 1040 failed');
}

// Test mappings / types
$keysToCheck = [
    'String' => 'Anyone\'s name, really.',
    'Int' => 13,
    'True' => true,
    'False' => false,
    'Zero' => 0,
    'Null' => null,
    'Float' => 5.34,
];

foreach ($keysToCheck as $key => $value) {
    if ($yaml[$key] !== $value) {
        die("Key: '$key' failed");
    }
}

// Test sequences
$sequenceItems = [
    "PHP Class",
    "Basic YAML Loader",
    "Very Basic YAML Dumper",
    ["YAML is so easy to learn.", "Your config files will never be the same."],
    ["cpu" => "1.5ghz", "ram" => "1 gig", "os" => "os x 10.4.1"],
    ["yaml.org", "php.net"],
    ["program" => "Adium", "platform" => "OS X", "type" => "Chat Client"],
];

foreach ($sequenceItems as $index => $item) {
    if ($yaml[$index] !== $item) {
        die("Sequence $index failed");
    }
}

// Handle the 'databases' key as a special case due to its nested structure
if ($yaml['databases'][0]['name'] !== 'spartan' || $yaml['databases'][0]['notes'][0] !== 'Needs to be backed up' || $yaml['databases'][0]['notes'][1] !== 'Needs to be normalized' || $yaml['databases'][0]['type'] !== 'mysql') {
    die("Key: 'databases' failed");
}

// All other keys can be checked with a simple loop
$remainingKeys = ['if: you\'d', 'dynamic languages', 'compiled languages', 'all languages'];
foreach ($remainingKeys as $key) {
    if ($yaml[$key] !== $yamlFileLines[$numbersToKeysMap[$key]]) {
        die("Key: '$key' failed");
    }
}

// Display a success message
echo "YAML file loaded and validated successfully!";

// Helper variables for error handling
$yamlFileLines = file($yamlFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$numbersToKeysMap = [];

foreach ($yamlFileLines as $index => $line) {
    if (strpos($line, ':') !== false) {
        $key = trim(substr($line, 0, strpos($line, ':')));
        $numbersToKeysMap[$index] = $key;
    }
}
