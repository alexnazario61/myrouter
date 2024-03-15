/*!
 * Bootstrap-select v1.6.3
 * http://silviomoreto.github.io/bootstrap-select/
 *
 * Copyright 2013-2014 bootstrap-select
 * Licensed under MIT (https://github.com/silviomoreto/bootstrap-select/blob/master/LICENSE)
 */

// Default options for the selectpicker plugin
(function ($) {
  $.fn.selectpicker.defaults = {
    /**
     * The text to display when no options are selected
     * @type {string}
     */
    noneSelectedText: 'Nothing selected',

    /**
     * The text to display when there are no matching results
     * @type {string}
     */
    noneResultsText: 'No results match',

    /**
     * The function to format the count of selected items
     * @param {number} numSelected - The number of selected items
     * @param {number} numTotal - The total number of options
     * @return {string}
     */
    countSelectedText: function (numSelected, numTotal) {
      // If there is only one selected item, return the singular format
      if (numSelected === 1) {
        return numSelected + " item selected";
      }

      // Otherwise, return the plural format
      return numSelected + " items selected";
    },

    /**
     * The text to display when the limit of options or group options is reached
     * @param {number} numAll - The total number of options
     * @param {number} numGroup - The number of group options
     * @return {string}
     */
    maxOptionsText: function (numAll, numGroup) {
      const arr = [
        (numAll === 1) ? 'Limit reached (1 item max)' : 'Limit reached ({n} items max)',
        (numGroup === 1) ? 'Group limit reached (1 item max)' : 'Group limit reached ({n} items max)',
      ];

      // Return the appropriate format string based on the context
      return arr[+(numGroup > 0)];
    },

    /**
     * The text for the "Select All" button
     * @type {string}
     */
    selectAllText: 'Select All',

    /**
     * The text for the "Deselect All" button
     * @type {string}
     */
    deselectAllText: 'Deselect All',

    /**
     * The separator for multiple selected options
     * @type {string}
     */
    multipleSeparator: ', '
  };
}(jQuery));

