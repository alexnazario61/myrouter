/*!
 * Bootstrap-select v1.6.3 (http://silviomoreto.github.io/bootstrap-select/)
 *
 * Copyright 2013-2014 bootstrap-select
 * Licensed under MIT (https://github.com/silviomoreto/bootstrap-select/blob/master/LICENSE)
 *
 * This script is a jQuery plugin that enhances the default functionality of the HTML
 * select element, providing customizable dropdowns with Bootstrap styling.
 */

// Define the default options for the selectpicker function
(function ($) {
  $.fn.selectpicker.defaults = {
    // The text to display when no options are selected
    noneSelectedText: 'Нічого не вибрано',

    // The text to display when there are no results found
    noneResultsText: 'Збігів не знайдено',

    // The text to display when one or more options are selected
    countSelectedText: 'Вибрано {0} із {1}',

    // The text to display when the maximum number of options is reached
    maxOptionsText: [
      // The text for a single selection
      'Досягнута межа ({n} {var} максимум)',

      // The text for a group of selections
      'Досягнута межа в групі ({n} {var} максимум)',

      // The singular and plural forms of the word for the items
      ['items', 'item']
    ],

    // The separator for multiple selected options
    multipleSeparator: ', '
  };
}(jQuery));
