// CodeMirror's tagRangeFinder function
// Copyright (C) 2011 by Daniel Glazman <daniel@glazman.org>
// released under the MIT license (../../LICENSE) like the rest of CodeMirror

// This function is used to find the range of a tag in the CodeMirror editor.
// It takes three arguments:
//   - cm: the CodeMirror editor instance
//   - line: the line number where the tag starts
//   - hideEnd: an optional boolean flag indicating whether to hide the end of the tag range

CodeMirror.tagRangeFinder = function(cm, line, hideEnd) {
  // Regular expression for matching XML tag names
  var xmlNAMERegExp = new RegExp("^[" + nameStartChar + "][" + nameChar + "]*");

  // Loop through the line text to find the tag range
  while (/* loop conditions */) {
    // Find the position of the '<' character
    pos = lineText.indexOf("<", pos);
    if (-1 == pos) // no tag on line
      return;

    // Check if the tag is a closing tag
    if (pos + 1 < lineText.length && lineText[pos + 1] == "/") {
      pos++;
      continue;
    }

    // Check if the tag has a valid name
    if (!lineText.substr(pos + 1).match(xmlNAMERegExp)) {
      pos++;
      continue;
    }

    // Find the position of the '>' character
    gtPos = lineText.indexOf(">", pos + 1);

    // Check if the end of the tag is in the current line or a following line
    if (-1 == gtPos) {
      // Loop through the following lines to find the end of the tag
      var l = line + 1;
      while (l < lastLine) {
        // Get the text of the current line
        var lt = cm.getLine(l);

        // Find the position of the '>' character
        gt = lt.indexOf(">");

        // Check if the end of the tag is in the current line
        if (-1 != gt) {
          // Check if the tag is empty
          var str = lineText.substr(slash, gt - slash + 1);
          if (!str.match( /\/\s*\>/ )) {
            // If the tag is not empty, return the line number
            if (hideEnd === true) l++;
            return l;
          }
        }

        l++;
      }

      // If the end of the tag is not found, return null
      return;
    }

    // Process the tag content and attributes
    // ...

    // Check if the tag is closed in the current line
    if (-1 != lineText.indexOf("</" + tag + ">", pos)) {
      found = false;
    }

    // If the tag is not closed in the current line, continue the search
    if (!found)
      pos++;
  }
};

// The remaining functions are not directly related to the tagRangeFinder function,
// but they are used in conjunction with it to provide folding functionality for CodeMirror.

// CodeMirror's braceRangeFinder function
// This function is used to find the range of a brace-delimited block in the CodeMirror editor.
// It takes three arguments:
//   - cm: the CodeMirror editor instance
//   - line: the line number where the block starts
//   - hideEnd: an optional boolean flag indicating whether to hide the end of the block range

CodeMirror.braceRangeFinder = function(cm, line, hideEnd) {
  // Loop through the line text to find the start of the block
  for (;;) {
    // Find the position of the '{' character
    // Check if the character is not inside a comment or a string
    // ...
    break;
  }

  // If the start of the block is not found, return null
  if (startChar == null) return;

  // Loop through the following lines to find the end of the block
  for (/* loop conditions */) {
    // Get the text of the current line
    // Find the position of the '}' character
    // Check if the character is not inside a comment or a string
    // ...
  }

  // If the end of the block is not found, return null
  if (end == null) return;

  // If the end of the block is on the next line, increment the line number
  if (end == line + 1) end++;

  // Return the line number of the end of the block
  return end;
};

// CodeMirror's indentRangeFinder function
// This function is used to find the range of an indented block in the CodeMirror editor.
// It takes two arguments:
//   - cm: the CodeMirror editor instance
//   - line: the line number where the block starts

CodeMirror.indentRangeFinder = function(cm, line) {
  // Get the indentation of the current line
  var myIndent = cm.getLineHandle(line).indentation();

  // Loop through the following lines to find the end of the block
  for (/* loop conditions */) {
    // Get the text of the current line
    // Check if the line is empty or not
    // Get the indentation of the current line
    // Check if the indentation is less than or equal to the indentation of the starting line
    // ...
  }

  // If the end of the block is not found, return null
  if (!last) return null;

  // Return the line number of the end of the block
  return last + 1;
};

// CodeMirror's newFoldFunction function
// This function is used to create a new folding function for CodeMirror.
// It takes three arguments:
//   - rangeFinder: the range finder function to use for finding the folding range
//   - markText: the text to display for the folding marker
//   - hideEnd: an optional boolean flag indicating whether to hide the end of the folding range

CodeMirror.newFoldFunction = function(rangeFinder, markText, hideEnd) {
  // Array to store the folded
