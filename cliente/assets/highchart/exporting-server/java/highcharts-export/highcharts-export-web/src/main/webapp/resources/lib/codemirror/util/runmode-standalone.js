/*
Just enough of CodeMirror to run runMode under node.js
This module contains a subset of CodeMirror functionality, specifically for running
runMode under node.js.
*/

// Utility function to split a string into an array of lines
function splitLines(string) {
  return string.split(/\r?\n|\r/);
}

// StringStream constructor - creates a new StringStream object
function StringStream(string) {
  this.pos = this.start = 0;
  this.string = string;
}

// Prototype for StringStream object
StringStream.prototype = {
  // Check if the position is at the end of the string
  eol: function () {
    return this.pos >= this.string.length;
  },

  // Check if the position is at the start of the string
  sol: function () {
    return this.pos == 0;
  },

  // Peek at the next character in the string
  peek: function () {
    return this.string.charAt(this.pos) || null;
  },

  // Get the next character in the string and increment the position
  next: function () {
    if (this.pos < this.string.length) return this.string.charAt(this.pos++);
  },

  // Consume the next character if it matches the given match parameter
  eat: function (match) {
    var ch = this.string.charAt(this.pos);
    if (typeof match == "string") var ok = ch == match;
    else var ok = ch && (match.test ? match.test(ch) : match(ch));
    if (ok) {++this.pos; return ch;}
  },

  // Consume characters while they match the given match parameter
  eatWhile: function (match) {
    var start = this.pos;
    while (this.eat(match)){}
    return this.pos > start;
  },

  // Consume whitespace characters
  eatSpace: function() {
    var start = this.pos;
    while (/[\s\u00a0]/.test(this.string.charAt(this.pos))) ++this.pos;
    return this.pos > start;
  },

  // Move the position to the end of the string
  skipToEnd: function() {this.pos = this.string.length;},

  // Move the position to the first occurrence of the given character
  skipTo: function(ch) {
    var found = this.string.indexOf(ch, this.pos);
    if (found > -1) {this.pos = found; return true;}
  },

  // Decrement the position by the given number
  backUp: function(n) {this.pos -= n;},

  // Get the column number of the current position
  column: function() {return this.start;},

  // Get the indentation level of the current position
  indentation: function() {return 0;},

  // Match the given pattern and consume it if consume is true
  match: function(pattern, consume, caseInsensitive) {
    if (typeof pattern == "string") {
      function cased(str) {return caseInsensitive ? str.toLowerCase() : str;}
      if (cased(this.string).indexOf(cased(pattern), this.pos) == this.pos) {
        if (consume !== false) this.pos += pattern.length;
        return true;
      }
    }
    else {
      var match = this.string.slice(this.pos).match(pattern);
      if (match && consume !== false) this.pos += match[0].length;
      return match;
    }
  },

  // Get the current substring of the string
  current: function(){return this.string.slice(this.start, this.pos);}
};

// Export StringStream object
exports.StringStream = StringStream;

// startState function - creates a new state object for the given mode
exports.startState = function(mode, a1, a2) {
  return mode.startState ? mode.startState(a1, a2) : true;
};

// modes object - stores mode factories
var modes = exports.modes = {}, mimeModes = exports.mimeModes = {};

// defineMode function - adds a new mode factory to the modes object
exports.defineMode = function(name, mode) { modes[name] = mode; };

// defineMIME function - adds a new MIME type to the mimeModes object
exports.defineMIME = function(mime, spec) { mimeModes[mime] = spec; };

// getMode function - returns a mode object based on the given options and spec
exports.getMode = function(options, spec) {
  if (typeof spec == "string" && mimeModes.hasOwnProperty(spec))
    spec = mimeModes[spec];
  if (typeof spec == "string")
    var mname = spec, config = {};
  else if (spec != null)
    var mname = spec.name, config = spec;
  var mfactory = modes[mname];
  if (!mfactory) throw new Error("Unknown mode: " + spec);
  return mfactory(options, config
