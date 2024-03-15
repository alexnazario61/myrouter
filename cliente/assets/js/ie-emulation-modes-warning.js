// This code is intended to prevent false-positive bug reports about Bootstrap not working properly in old versions of Internet Explorer (IE)
// due to people testing using IE's unreliable emulation modes.

// This immediately-invoked function expression (IIFE) is used to encapsulate the code and prevent it from polluting the global scope.
(function () {
  'use strict'; // This line sets the strict mode for the code, which helps to catch common errors and makes the code run faster.

  // This function checks the user agent string for the presence of MSIE and returns the major version number if found.
  function emulatedIEMajorVersion() {
    var groups = /MSIE ([0-9.]+)/.exec(window.navigator.userAgent);
    if (groups === null) {
      return null; // If the MSIE string is not found, null is returned.
    }
    var ieVersionNum = parseInt(groups[1], 10);
    var ieMajorVersion = Math.floor(ieVersionNum);
    return ieMajorVersion; // The major version number is returned.
  }

  // This function detects the actual version of IE in use, even if it's in an older-IE emulation mode.
  function actualNonEmulatedIEMajorVersion() {
    var jscriptVersion = new Function('/*@cc_on return @_jscript_version; @*/')(); // This line uses conditional compilation to detect the version of JScript.
    if (jscriptVersion === undefined) {
      return 11; // If JScript version is not detected, it is assumed to be IE11 or higher.
    }
    if (jscriptVersion < 9) {
      return 8; // If JScript version is less than 9, it is assumed to be IE8 or lower.
    }
    return jscriptVersion; // Otherwise, the JScript version is returned.
  }

  var ua = window.navigator.userAgent; // This line gets the user agent string from the browser.

  // This if statement checks if the user agent string contains "Opera" or "Presto", and if so, the function returns without doing anything.
  if (ua.indexOf('Opera') > -1 || ua.indexOf('Presto') > -1) {
    return;
  }

  var emulated = emulatedIEMajorVersion(); // This line gets the emulated IE major version.
  if (emulated === null) {
    return; // If the emulated IE major version is null, the function returns.
  }

  var nonEmulated = actualNonEmulatedIEMajorVersion(); // This line gets the actual non-emulated IE major version.

  // This if statement checks if the emulated and non-emulated IE major versions are not the same.
  if (emulated !== nonEmulated) {
    window.alert('WARNING: You appear to be using IE' + nonEmulated + ' in IE' + emulated + ' emulation mode.\nIE emulation modes can behave significantly differently from ACTUAL older versions of IE.\nPLEASE DON\'T FILE BOOTSTRAP BUGS based on testing in IE emulation modes!');
  }
})();
