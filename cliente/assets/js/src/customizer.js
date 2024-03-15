/*!
 * Bootstrap Customizer (http://getbootstrap.com/customize/)
 * Copyright 2011-2014 Twitter, Inc.
 *
 * Licensed under the Creative Commons Attribution 3.0 Unported License. For
 * details, see http://creativecommons.org/licenses/by/3.0/.
 */

/* global JSZip, less, autoprefixer, saveAs, UglifyJS, __configBridge, __js, __less, __fonts */

window.onload = function () {
  'use strict';
  const cw = `/*!\
 * Bootstrap v3.3.1 (http://getbootstrap.com)\
 * Copyright 2011-${new Date().getFullYear()} Twitter, Inc.\
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)\
 */\n\n`

  const supportsFile = (window.File && window.FileReader && window.FileList && window.Blob)
  const importDropTarget = $('#import-drop-target')

  function showError(msg, err) {
    $('<div id="bsCustomizerAlert" class="bs-customizer-alert">\
        <div class="container">\
          <a href="#bsCustomizerAlert" data-dismiss="alert" class="close pull-right" aria-label="Close" role="button"><span aria-hidden="true">&times;</span></a>\
          <p class="bs-customizer-alert-text"><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span><span class="sr-only">Warning:</span>${msg}</p>\
          ${err.extract ? `<pre class="bs-customizer-alert-extract">${err.extract.join('\n')}</pre>` : ''}\
        </div>\
      </div>`).appendTo('body').alert()
    throw err
  }

  function showSuccess(msg) {
    $('<div class="bs-callout bs-callout-info">\
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
      ${msg}\
    </div>`).insertAfter('.bs-customize-download')
  }

  function showCallout(msg, showUpTop) {
    const callout = $('<div class="bs-callout bs-callout-danger">\
       <h4>Attention!</h4>\
      <p>${msg}</p>\
    </div>')

    if (showUpTop) {
      callout.appendTo('.bs-docs-container')
    } else {
      callout.insertAfter('.bs-customize-download')
    }
  }

  function showAlert(type, msg, insertAfter) {
    $('<div class="alert alert-' + type + '">' + msg + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>')
      .insertAfter(insertAfter)
  }

  function getQueryParam(key) {
    key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, '\\$&') // escape RegEx meta chars
    const match = location.search.match(new RegExp('[?&]' + key + '=([^&]+)(&|$)'))
    return match && decodeURIComponent(match[1].replace(/\+/g, ' '))
  }

  function createGist(config
