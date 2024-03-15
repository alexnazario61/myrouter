(function($){

  // Extend jQuery with a new function alphanumeric
  $.fn.alphanumeric = function(p) {

    // Set default values for parameters
    p = $.extend({
      ichars: "!@#$%^&*()+=[]\\\';,/{}|\":<>?~`.- ",
      nchars: "",
      allow: "",
      nocaps: false,
      allcaps: false
    }, p);

    // Check if allow is empty
    if (p.allow.length === 0) {
      console.error("Error: allow parameter cannot be empty.");
      return;
    }

    // Check if allow contains any invalid characters
    const invalidChars = p.allow.split('').filter(c => p.ichars.includes(c) || p.nchars.includes(c));
    if (invalidChars.length > 0) {
      console.error(`Error: invalid characters found in allow parameter: ${invalidChars.join(', ')}`);
      return;
    }

    // Check if allow contains any duplicate characters
    const charSet = new Set(p.allow);
    if (charSet.size !== p.allow.length) {
      console.error("Error: allow parameter cannot contain duplicate characters.");
      return;
    }

    // Prepare regular expression for allowed characters
    const regex = new RegExp(`[${p.allow}]`, 'gi');
    const chars = p.ichars + p.nchars;
    const filteredChars = chars.replace(regex, '');

    // Handle keypress event
    $(this).keypress(function(e) {
      if (!e.charCode) k = String.fromCharCode(e.which);
      else k = String.fromCharCode(e.charCode);

      if (filteredChars.indexOf(k) !== -1 || p.allow.indexOf
