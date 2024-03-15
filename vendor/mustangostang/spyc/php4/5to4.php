<?php

// The function php5to4 converts PHP 5 code to PHP 4 compatible code.
// It takes two arguments: the source file path and the destination file path.
php5to4 ("../spyc.php", 'spyc-latest.php4');

function php5to4 ($src, $dest) {
  // Reads the contents of the source file.
  $code = file_get_contents ($src);
  
  // Replaces public, private, or protected variables with var variables.
  $code = preg_replace ('#(public|private|protected)\s+\$#i', 'var \$', $code);
  
  // Replaces public, private, or protected static variables with var variables.
  $code = preg_replace ('#(public|private|protected)\s+static\s+\$#i', 'var \$', $code);
  
  // Replaces public, private, or protected functions with regular functions.
  $code = preg_replace ('#(public|private|protected)\s+function#i', 'function', $code);
  
  // Replaces public, private, or protected static functions with regular functions.
  $code = preg_replace ('#(public|private|protected)\s+static\s+function#i', 'function', $code);
  
  // Replaces throw new Exception with trigger\_error.
  $code = preg_replace ('#throw new Exception\\(([^)]*)\\)#i', 'trigger_error($1,E_USER_ERROR)', $code);
  
  // Replaces self:: with $this->.
  $code = str_replace ('self::', '$this->', $code);
  
  // Opens the destination file and writes the modified code to it.
  $f = fopen ($dest, 'w');
  fwrite($f, $code);
  fclose ($f);
  
  // Prints a message indicating that the code has been written to the destination file.
  print "Written to $dest.\n";
}
