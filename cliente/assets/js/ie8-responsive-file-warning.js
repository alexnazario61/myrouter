// Prevent false-positive bug reports about responsive styling not working in IE8 when using file protocol.
if (window.location.protocol === 'file:' && /Trident/.test(navigator.userAgent)) {
  window.alert('ERROR: Bootstrap\'s responsive CSS is disabled when using the file protocol in Internet Explorer 8.\nSee https://getbootstrap.com/getting-started/ for details.');
}

