/*!
 * Bootstrap-select v1.6.3 (https://silviomoreto.github.io/bootstrap-select/)
 *
 * Copyright 2013-2014 bootstrap-select
 * Licensed under MIT (https://github.com/silviomoreto/bootstrap-select/blob/master/LICENSE)
 */
(function ($) {
  // Default options for selectpicker plugin
  $.fn.selectpicker.defaults = {
    noneSelectedText: 'No items selected', // Default noneSelectedText in English
    noneResultsText: 'No results found', // Default noneResultsText in English
    countSelectedText: '{0} of {1} selected', // Default countSelectedText in English
    maxOptionsText: [
      'Limit reached (max {n} items)', // Default maxOptionsText in English for single select
      'Group limit reached (max {n} groups)' // Default maxOptionsText in English for multiple select
    ],
    multipleSeparator: ', ' // Default multipleSeparator in English
  };

  // Set the default options based on the current language
  function setDefaultsBasedOnLanguage() {
    var language = $.fn.selectpicker.Constructor.prototype.options.language;
    if (language) {
      $.fn.selectpicker.defaults.noneSelectedText = language.noneSelectedText || $.fn.selectpicker.defaults.noneSelectedText;
      $.fn.selectpicker.defaults.noneResultsText = language.noneResultsText || $.fn.selectpicker.defaults.noneResultsText;
      $.fn.selectpicker.defaults.countSelectedText = language.countSelectedText || $.fn.selectpicker.defaults.countSelectedText;
      $.fn.selectpicker.defaults.maxOptionsText = [
        language.maxOptionsTextSingle || $.fn.selectpicker.defaults.maxOptionsText[0],
        language.maxOptionsTextMulti || $.fn.selectpicker.defaults.maxOptionsText[1]
      ];
      $.fn.selectpicker.defaults.multipleSeparator = language.multipleSeparator || $.fn.selectpicker.defaults.multipleSeparator;
    }
  }

  // Initialize the setDefaultsBasedOnLanguage function
  set
