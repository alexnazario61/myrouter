'use strict';

(function ($) {

  /**
   * Default options for selectpicker plugin
   * @namespace
   * @memberof jQuery.fn.selectpicker
   */
  $.fn.selectpicker.defaults = {
    /**
     * Text to display when no options are selected
     * @type {String}
     * @default 'Nic není vybráno'
     */
    noneSelectedText: 'Nic není vybráno',

    /**
     * Text to display when there are no results found
     * @type {String}
     * @default 'Žádné výsledky'
     */
    noneResultsText: 'Žádné výsledky',

    /**
     * Text to display when some options are selected
     * @type {String|Array}
     * @default ['Limit překročen ({n} {var} max)', 'Limit skupiny překročen ({n} {var} max)', ['položek', 'položka']]
     */
    maxOptionsText: [
      'Limit překročen ({n} {var} max)',
      'Limit skupiny překročen ({n} {var} max)',
      ['položek', 'položka']
    ],

    /**
     * Text to display as a separator between multiple selected options
     * @type {String}
     * @default ', '
     */
    multipleSeparator: ', '
  };

}(jQuery));

