/*
  html2canvas 0.4.1 <http://html2canvas.hertzen.com>
  Copyright (c) 2013 Niklas von Hertzen

  Released under MIT License
*/

(function (window, document, undefined) {
  "use strict";

  const _html2canvas = {};
  let previousElement,
    computedCSS,
    html2canvas;

  _html2canvas.Util = {
    log: function (a) {
      if (_html2canvas.logging && window.console && window.console.log) {
        window.console.log(a);
      }
    },

    trimText: (function (isNative) {
      return function (input) {
        return isNative.apply(input) || input.trim();
      };
    })(String.prototype.trim),

    asFloat: function (v) {
      return parseFloat(v);
    },

    parseTextShadows: function (value) {
      if (!value || value === "none") {
        return [];
      }

      const shadows = value.match(TEXT_SHADOW_PROPERTY),
        results = [];
      for (let i = 0; shadows && (i < shadows.length); i++) {
        const s = shadows[i].match(TEXT_SHADOW_VALUES);
        results.push({
          color: s[0],
          offsetX: s[1] ? s[1].replace("px", "") : 0,
          offsetY: s[2] ? s[2].replace("px", "") : 0,
          blur: s[3] ? s[3].replace("px", "") : 0
        });
      }
      return results;
    },

    parseBackgroundImage: function (value) {
      const whitespace = " \r\n\t",
        method,
        definition,
        prefix,
        prefix_i,
        block,
        results = [],
        c,
        mode = 0,
        numParen = 0,
        quote,
        args;

      const appendResult = function () {
        if (method) {
          if (definition.substr(0, 1) === '"') {
            definition = definition.substr(1, definition.length - 2);
          }
          if (definition) {
            args.push(definition);
          }
          if (
            /^-?[0-9]+\.?[0-9]*(?:px)?$/i.test(value) === false &&
            /^-?\d/.test(value)
          ) {
            // Remember the original definition
            const originalDefinition = definition;

            // Put in the new value to get a computed value out
            if (rsLeft) {
              element.runtimeStyle.left = element.currentStyle.left;
            }
            definition = "";
            if (value !== "transparent" && value !== "rgba(0, 0, 0, 0)") {
              definition = "rgb(0, 0, 0)";
            }
            block += ` ${value || 0}px`;
            args.push(definition);

            // Revert the changed values
            definition = originalDefinition;
            if (rsLeft) {
              element.runtimeStyle.left = rsLeft;
            }
          }
          results.push({
            prefix: prefix,
            method: method.toLowerCase(),
            value: block,
            args: args
          });
        }
        args = []; //for some odd reason, setting .length = 0 didn't work in safari
        method = prefix = definition = block = "";
      };

      appendResult();
      for (let i = 0, ii = value.length; i < ii; i++) {
        c = value[i];
        if (mode === 0 && whitespace.indexOf(c) > -1) {
          continue;
        }
        switch (c) {
          case '"':
            if (!quote) {
              quote = c;
            } else if (quote === c) {
              quote = null;
            }
            break;

          case "(":
            if (quote) {
              break;
            } else if (mode === 0) {
              mode = 1;
              block += c;
              continue;
            } else {
              numParen++;
            }
            break;

          case ")":
            if (quote) {
              break;
            } else if (mode === 1) {
              if (numParen === 0) {
                mode = 0;
                block += c;
                appendResult();
                continue;
              } else {
                numParen--;
              }
            }
            break;

          case ",":
            if (quote) {
              break;
            } else if (mode === 0) {
              appendResult();
              continue;
            } else if (mode === 1) {
              if (numParen === 0 && method.substr(0, 4) !== "url(") {
                args.push(definition);
                definition = "";
                block += c;
                continue;
              }
            }
            break;
        }

        block += c;
        if (mode === 0) {
          method += c;
        } else {
          definition += c;
        }
      }
      appendResult();

      return results;
    },

    Bounds: function (element) {
      const clientRect = element.getBoundingClientRect();

      // TODO: add scroll position to bounds, so no scrolling of window necessary
      const bounds = {
        top: clientRect.top,
        bottom: clientRect.bottom || clientRect.top + clientRect.height,
        left: clientRect.left,
        width: element.offsetWidth,
        height: element.offsetHeight
      };

      return bounds;
    },

    OffsetBounds: function (element) {
      const parent =
        element.offsetParent && _html2canvas.Util.OffsetBounds(element.offsetParent);

      return {
        top: element.offsetTop + (parent
