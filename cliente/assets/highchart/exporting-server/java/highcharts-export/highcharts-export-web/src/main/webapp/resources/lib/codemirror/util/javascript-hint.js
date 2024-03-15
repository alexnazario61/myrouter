(function () {
  // Defines a higher-order function named `forEach` that takes an array and a function as arguments.
  // It iterates over the array and applies the function to each element.
  function forEach(arr, f) {
    for (var i = 0, e = arr.length; i < e; ++i) f(arr[i]);
  }

  // Defines a function named `arrayContains` that checks if a given array contains a specific item.
  // It uses the `indexOf` method if available, and falls back to a linear search otherwise.
  function arrayContains(arr, item) {
    if (!Array.prototype.indexOf) {
      var i = arr.length;
      while (i--) {
        if (arr[i] === item) {
          return true;
        }
      }
      return false;
    }
    return arr.indexOf(item) != -1;
  }

  // Defines the main function `scriptHint` for providing code completions in JavaScript mode.
  function scriptHint(editor, keywords, getToken) {
    // Find the token at the cursor
    var cur = editor.getCursor(), token = getToken(editor, cur), tprop = token;
    // If it's not a 'word-style' token, ignore the token.
    if (!/^[\w$_]*$/.test(token.string)) {
      token = tprop = {start: cur.ch, end: cur.ch, string: "", state: token.state,
                       className: token.string == "." ? "property" : null};
    }
    // If it is a property, find out what it is a property of.
    while (tprop.className == "property") {
      tprop = getToken(editor, {line: cur.line, ch: tprop.start});
      if (tprop.string != ".") return;
      tprop = getToken(editor, {line: cur.line, ch: tprop.start});
      if (tprop.string == ')') {
        var level = 1;
        do {
          tprop = getToken(editor, {line: cur.line, ch: tprop.start});
          switch (tprop.string) {
          case ')': level++; break;
          case '(': level--; break;
          default: break;
          }
        } while (level > 0);
        tprop = getToken(editor, {line: cur.line, ch: tprop.start});
        // If the property is a function, update the token class name to 'function'.
        if (tprop.className == 'variable')
          tprop.className = 'function';
        else return; // no clue
      }
      if (!context) var context = [];
      context.push(tprop);
    }
    // Return the code completions list, the range of the token, and the range of the completions.
    return {list: getCompletions(token, context, keywords),
            from: {line: cur.line, ch: token.start},
            to: {line: cur.line, ch: token.end}};
  }

  // Registers the `scriptHint` function as the JavaScript code completion function for CodeMirror.
  CodeMirror.javascriptHint = function(editor) {
    return scriptHint(editor, javascriptKeywords,
                      function (e, cur) {return e.getTokenAt(cur);});
  };

  // Defines a helper function `getCoffeeScriptToken` for getting CoffeeScript-style tokens.
  function getCoffeeScriptToken(editor, cur) {
    // This getToken, it is for coffeescript, imitates the behavior of
    // getTokenAt method in javascript.js, that is, returning "property"
    // type and treat "." as indepenent token.
    var token = editor.getTokenAt(cur);
    if (cur.ch == token.start + 1 && token.string.charAt(0) == '.') {
      token.end = token.start;
      token.string = '.';
      token.className = "property";
    }
    else if (/^\.[\w$_]*$/.test(token.string)) {
      token.className = "property";
      token.start++;
      token.string = token.string.replace(/\./, '');
    }
    return token;
  }

  // Registers the `scriptHint` function as the CoffeeScript code completion function for CodeMirror.
  CodeMirror.coffeescriptHint = function(editor) {
    return scriptHint(editor, coffeescriptKeywords, getCoffeeScriptToken);
  };

  // Defines an array of string methods as string properties.
  var stringProps = ("charAt charCodeAt indexOf lastIndexOf substring substr slice trim trimLeft trimRight " +
                     "toUpperCase toLowerCase split concat match replace search").split(" ");
  // Defines an array of array methods as array properties.
  var arrayProps = ("length concat join splice push pop shift unshift slice reverse sort indexOf " +
                    "lastIndexOf every some filter forEach map reduce reduceRight ").split(" ");
  // Defines an array of function properties.
  var funcProps = "prototype apply call bind".split(" ");
  // Defines an array of JavaScript keywords.
  var javascriptKeywords = ("break case catch continue debugger default delete do else false finally for function " +
                  "if in instanceof new null return switch throw true try typeof var void while with").split(" ");
  // Defines an array of CoffeeScript keywords.
  var coffeescriptKeywords = ("and break catch class continue delete do else extends false finally for " +
                  "if in instanceof isnt new no not null of off on or return switch then throw true try typeof until void while with yes").split(" ");

  // Defines a function for getting code completions based on the current token, context, and keywords.
  function getCompletions(token, context, keywords) {
    var found = [], start = token.string;
    // Helper function for adding a completion if it starts with the current input.
    function maybeAdd(str) {
      if (str.indexOf(start) == 0 && !arrayContains(
