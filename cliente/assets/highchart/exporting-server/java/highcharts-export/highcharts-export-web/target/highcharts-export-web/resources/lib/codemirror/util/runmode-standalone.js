/*
Just enough of CodeMirror to run runMode under node.js
This module contains a subset of CodeMirror functionality, specifically for running
runMode under node.js. It includes functions for splitting strings into lines,
creating a StringStream object, and defining and getting modes for syntax highlighting.
*/

// Split a string into lines, handling both \n and \r\n line breaks
function splitLines(string) {
  return string.split(/\r?\n|\r/);
}

// StringStream class for reading a string character by character
function StringStream(string) {
  this.pos = this.start = 0;
  this.string = string;
}

StringStream.prototype = {
  // Check if the end of the string has been reached
  eol: function() {
    return this.pos >= this.string.length;
  },

  // Check if the current position is at the start of the string
  sol: function() {
    return this.pos == 0;
  },

  // Peek at the next character in the string without advancing the position
  peek: function() {
    return this.string.charAt(this.pos) || null;
  },

  // Advance the position and return the next character
  next: function() {
    if (this.pos < this.string.length) return this.string.charAt(this.pos++);
  },

  // Consume a character if it matches the given match string or regular expression
  eat: function(match) {
    var ch = this.string.charAt(this.pos);
    if (typeof match == "string") var ok = ch == match;
    else var ok = ch && (match.test ? match.test(ch) : match(ch));
    if (ok) {
      ++this.pos;
      return ch;
    }
  },

  // Consume characters while they match the given match string or regular expression
  eatWhile: function(match) {
    var start = this.pos;
    while (this.eat(match)) {}
    return this.pos > start;
  },

  // Consume whitespace characters
  eatSpace: function() {
    var start = this.pos;
    while (/[\s\u00a0]/.test(this.string.charAt(this.pos))) ++this.pos;
    return this.pos > start;
  },

  // Skip to the end of the string
  skipToEnd: function() {
    this.pos = this.string.length;
  },

  // Skip to the next occurrence of the given character
  skipTo: function(ch) {
    var found = this.string.indexOf(ch, this.pos);
    if (found > -1) {
      this.pos = found;
      return true;
    }
  },

  // Move the position back by the given number of characters
  backUp: function(n) {
    this.pos -= n;
  },

  // Return the current column (number of characters from the start of the line)
  column: function() {
    return this.start;
  },

  // Return the current indentation level (number of leading whitespace characters)
  indentation: function() {
    return 0;
  },

  // Match the given pattern, consuming it if consume is true
  match: function(pattern, consume, caseInsensitive) {
    if (typeof pattern == "string") {
      function cased(str) {
        return caseInsensitive
          ? str.toLowerCase()
          : str;
      }
      if (
        cased(this.string).indexOf(cased(pattern), this.pos) == this.pos
      ) {
        if (consume !== false) this.pos += pattern.length;
        return true;
      }
    } else {
      var match = this.string.slice(this.pos).match(pattern);
      if (match && consume !== false) this.pos += match[0].length;
      return match;
    }
  },

  // Return the current substring from the start position to the current position
  current: function() {
    return this.string.slice(this.start, this.pos);
  },
};

// Export the StringStream object
exports.StringStream = StringStream;

// Default start state function
exports.startState = function(mode, a1, a2) {
  return mode.startState ? mode.startState(a1, a2) : true;
};

// Mode and MIME mode objects
var modes = exports.modes = {},
  mimeModes = exports.mimeModes = {};

// Define a new mode
exports.defineMode = function(name, mode) {
  modes[name] = mode;
};

// Define a new MIME mode
exports.defineMIME = function(mime, spec) {
  mimeModes[mime] = spec;
};

// Get a mode object based on the given options and mode specification
exports.getMode = function(options, spec) {
  if (typeof spec == "string" && mimeModes.hasOwnProperty(spec))
    spec = mimeModes[spec];
  if (typeof spec == "string")
   
