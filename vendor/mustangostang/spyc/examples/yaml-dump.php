<?php

namespace MyProject\Spyc;

declare(strict_types=1);

use Spyc;

#
#    S P Y C
#      A Simple PHP YAML Class
#
# Feel free to dump an array to YAML, and then to load that YAML back into an
# array. This is a good way to test the limitations of the parser and maybe
# learn some basic YAML.
#

$array = [
    'Sequence item',
    'The Key' => 'Mapped value',
    ['A sequence', 'of a sequence'],
    ['first' => 'A sequence', 'second' => 'of mapped values'],
    'Mapped' => ['A sequence', 'which is mapped'],
    'A Note' => 'What if your text is too long?',
    'Another Note' => 'If that is the case, the dumper will probably fold your text by using a block. Kinda like this.',
    'The trick?' => 'The trick is that we overrode the default indent, 2, to 4 and the default wordwrap, 40, to 60.',
    'Old Dog' => "And if you want\n to preserve line breaks, \ngo ahead!",
    'key:withcolon' => "Should support this to",
];

$spyc = new Spyc();
$yaml = $spyc->YAMLDump($array, 4, 60);
