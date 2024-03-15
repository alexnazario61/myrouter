/*!
 * Bootstrap-select v1.6.3 (http://silviomoreto.github.io/bootstrap-select/)
 *
 * Copyright 2013-2014 bootstrap-select
 * Licensed under MIT (https://github.com/silviomoreto/bootstrap-select/blob/master/LICENSE)
 */

// Start of an Immediately Invoked Function Expression (IIFE) that passes jQuery as a parameter
(function ($) {
  // Set the default options for the selectpicker plugin
  $.fn.selectpicker.defaults = {
    // The text to display when no options are selected
    noneSelectedText: 'No option selected', // Default: 'Nothing selected'
    // The text to display when there are no results for a search
    noneResultsText: 'No results found', // Default: 'No results found'
    // The text to display when one or more options are selected
    countSelectedText: '{1}(s) selected from {0}', // Default: '{0} of {1} selected'
    // The maximum number of options that can be selected, and the text to display when this limit is reached
    maxOptionsText: [
      'Limit reached ({n} {var} maximum)', // Default: 'Limit reached ({n} {var})'
      'Group limit reached ({n} {var} maximum)', // Default: 'Group limit reached ({n} {var})'
      ['item', 'items'] // Default: ['item', 'items']
    ],
    // The separator used to join multiple selected options
    multipleSeparator: ', ' // Default: ', '
  };
// End of the IIFE
}(jQuery));
