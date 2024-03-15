/*!
 * classie v1.0.1
 * class helper functions
 * from bonzo https://github.com/ded/bonzo
 */

/*jshint browser: true, strict: true, undef: true */
/*global define: false */

(function (window) {

  'use strict';

  // class helper functions from bonzo (https://github.com/ded/bonzo)

  function classReg(className) {
    return new RegExp('(^|\\s+)' + className + '(\\s+|$)');
  }

  let hasClass, addClass, removeClass;

  if ('classList' in document.documentElement) {
    hasClass = function (elem, c) {
      return elem.classList.contains(c);
    };
    addClass = function (elem, c) {
      if (!hasClass(elem, c)) {
        elem.classList.add(c.trim());
      }
    };
    removeClass = function (elem, c) {
      elem.classList.remove(c.trim());
    };
  } else {
    hasClass = function (elem, c) {
      return classReg(c).test(elem.className);
    };
    addClass = function (elem, c) {
      if (!hasClass(elem, c)) {
        elem.className = elem.className.trim() + ' ' + c.trim();
      }
    };
    removeClass = function (elem, c) {
      elem.className = elem.className.replace(classReg(c), ' ').replace(/(^\s+|\s+$)/g, '');
    };
  }

  function toggleClass(elem, c) {
    const fn = hasClass(elem, c) ? removeClass : addClass;
    fn(elem, c);
  }

  const classie = {
    // full names
    hasClass,
    addClass,
    removeClass,
    toggleClass,
    // short names
    has: hasClass,
    add: addClass,
    remove: removeClass,
    toggle: toggleClass
  };

  // transport
  if (typeof define === 'function' && define.amd) {
    // AMD
    define(classie);
  } else if (typeof window !== 'undefined') {
    // browser global
    window.classie = classie;
  }

}(typeof window !== 'undefined' ? window : global));
