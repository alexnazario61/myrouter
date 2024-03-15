<?php

namespace Spyc;

/**
 * Spyc -- A Simple PHP YAML Class
 * @version 0.5.1
 * @author Vlad Andersen <vlad.andersen@gmail.com>
 * @author Chris Wanstrath <chris@ozmm.org>
 * @link http://code.google.com/p/spyc/
 * @copyright Copyright 2005-2006 Chris Wanstrath, 2006-2011 Vlad Andersen
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @package Spyc
 */

class Spyc
{
    const REMPTY = "\0\0\0\0\0";

    // ... (rest of the class code)

}

class SpycHelper
{
    public static function loadFile($file)
    {
        return Spyc::YAMLLoad($file);
    }

    public static function loadString($string)
    {
        return Spyc::YAMLLoadString($string);
    }

    // ... (add more helper functions here)
}

// Enable use of Spyc from command line
// The syntax is the following: php Spyc.php spyc.yaml

define('SPYC_FROM_COMMAND_LINE', false);

do {
    if (!SPYC_FROM_COMMAND_LINE) break;
    if (empty($_SERVER['argc']) || $_SERVER['argc'] < 2) break;
    if (empty($_SERVER['PHP_SELF']) || $_SERVER['PHP_SELF'] != 'Spyc.php') break;
    $file = $argv[1];
    printf("Spyc loading file: %s\n", $file);
    print_r(SpycHelper::loadFile($file));
} while (0);
