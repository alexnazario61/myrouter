/*!
 * Bootstrap-select v1.6.3 (http://silviomoreto.github.io/bootstrap-select/)
 *
 * Copyright 2013-2014 bootstrap-select
 * Licensed under MIT (https://github.com/silviomoreto/bootstrap-select/blob/master/LICENSE)
 */

// Start of an Immediately Invoked Function Expression (IIFE) that takes `$` as a parameter
(function ($) {
  // Set the default options for the jQuery selectpicker plugin
  $.fn.selectpicker.defaults = {
    // The text to display when no options are selected
    noneSelectedText: 'Nu a fost selectat nimic',

    // The text to display when there are no results found
    noneResultsText: 'Nu exista niciun rezultat',

    // The text to display when some options are selected
    countSelectedText: '{0} din {1} selectat(e)',

    // The text to display when the maximum number of options has been reached
    maxOptionsText: [
      // The text for single select with a limit
      'Limita a fost atinsa ({n} {var} max)',

      // The text for group select with a limit
      'Limita de grup a fost atinsa ({n} {var} max)',

      // An array for translating the words 'item' and 'items'
      ['iteme', 'item']
    ],

    // The separator for multiple selected options
    multipleSeparator: ', '
  };
// End of the IIFE, passing the jQuery object as an argument
}(jQuery));
