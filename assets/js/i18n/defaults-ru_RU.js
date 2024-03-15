/*!
 * Bootstrap-select v1.6.3 (https://silviomoreto.github.io/bootstrap-select/)
 *
 * Copyright 2013-2014 bootstrap-select
 * Licensed under MIT (https://github.com/silviomoreto/bootstrap-select/blob/master/LICENSE)
 */
(function ($) {
  // Default options for selectpicker plugin
  $.fn.selectpicker.defaults = {
    noneSelectedText: 'Nothing selected', // Default noneSelectedText in English
    noneResultsText: 'No results found', // Default noneResultsText in English
    countSelectedText: 'Selected {0} of {1}', // Default countSelectedText in English
    maxOptionsText: [
      'Limit reached ({n} {var} maximum)', // Default maxOptionsText in English for single select
      'Group limit reached ({n} {var} maximum)', // Default maxOptionsText in English for multiple select within a group
      ['items', 'item'] // Default maxOptionsText in English for multiple select
    ],
    multipleSeparator: ', ' // Default multipleSeparator
  };

  // Set the default noneSelectedText to the localized version
  function setDefaultNoneSelectedText() {
    if ($.fn.selectpicker.defaults.noneSelectedText === 'Ничего не выбрано') {
      $.fn.selectpicker.defaults.noneSelectedText = chrome.i18n.getMessage('noneSelectedText');
    }
  }

  // Set the default noneResultsText to the localized version
  function setDefaultNoneResultsText() {
    if ($.fn.selectpicker.defaults.noneResultsText === 'Совпадений не найдено') {
      $.fn.selectpicker.defaults.noneResultsText = chrome.i18n.getMessage('noneResultsText');
    }
  }

  // Set the default countSelectedText to the localized version
  function setDefaultCountSelectedText() {
    if ($.fn.selectpicker.defaults.countSelectedText === 'Выбрано {0} из {1}') {
      $.fn.selectpicker.defaults.countSelectedText
