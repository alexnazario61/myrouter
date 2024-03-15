/*!
 * Bootstrap-select v1.6.3 (http://silviomoreto.github.io/bootstrap-select/)
 *
 * Copyright 2013-2014 bootstrap-select
 * Licensed under MIT (https://github.com/silviomoreto/bootstrap-select/blob/master/LICENSE)
 */

// Defining the default options for the selectpicker plugin
(function ($) {
  $.fn.selectpicker.defaults = {
    // The text to display when no options are selected
    noneSelectedText: 'Nothing selected',

    // The text to display when there are no matching results
    noneResultsText: 'No results match',

    // The function to format the count of selected items
    countSelectedText: function (numSelected, numTotal) {
      // If there is only one selected item, return the singular format
      if (numSelected == 1) {
        return numSelected + " item selected";
      }
      // Otherwise, return the plural format
      else {
        return numSelected + " items selected";
      }
    },

    // The text to display when the limit of options or group options is reached
    maxOptionsText: function (numAll, numGroup) {
      var arr = [];

      // Create an array with two format strings: one for all options and one for group options
      arr[0] = (numAll == 1) ? 'Limit reached ({n} item max)' : 'Limit reached ({n} items max)';
      arr[1] = (numGroup == 1) ? 'Group limit reached ({n} item max)' : 'Group limit reached ({n} items max)';

      // Return the appropriate format string based on the context
      return arr[+(numGroup > 0)];
    },

    // The text for the "Select All" button
    selectAllText: 'Select All',

    // The text for the "Deselect All" button
    deselectAllText: 'Deselect All',

    // The separator for multiple selected options
    multipleSeparator: ', '
  };
}(jQuery));

