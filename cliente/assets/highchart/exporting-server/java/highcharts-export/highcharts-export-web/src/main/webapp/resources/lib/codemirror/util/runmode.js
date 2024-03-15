CodeMirror.runMode = function(string, modespec, callback, options) {
  // Validate parameters
  if (typeof modespec !== 'string' || typeof callback !== 'function') {
    throw new Error('Invalid parameters: modespec and callback must be provided and be a string and a function, respectively');
  }

  function esc(str) {
    return str.replace(/[<&]/g, function(ch) { return ch == "<" ? "&lt;" : "&amp;"; });
  }

  // Get the mode object
  let mode;
  try {
    mode = CodeMirror.getMode(CodeMirror.defaults, modespec);
  } catch (e) {
    throw new Error(`Invalid modespec: ${modespec}`);
  }

  // Set default options
  const defaultOptions = {
    tabSize: CodeMirror.defaults.tabSize
  };
  options = Object.assign({}, defaultOptions, options);

  // Set up the callback function
  const isNode = callback.nodeType === 1;
  if (isNode) {
    let node = callback;
    let accum = [];
    let col = 0;
    callback = function(text, style) {
      if (text == "\n") {
        accum.push("<br>");
        col = 0;
        return;
      }
      let escaped = "";
      for (let pos = 0;;) {
        let idx = text.indexOf("\t", pos);
        if (idx === -1) {
          escaped += esc(text.slice(pos));
          col += text.length - pos;
          break;
        } else {
          col += idx - pos;
          escaped += esc(text.slice(pos, idx));
          let size = options.tabSize - col % options.tabSize;
          col += size;
          for (let i = 0; i < size; ++i) escaped += " ";
          pos = idx + 1;
        }
      }

      if (style) 
        accum.push("<span class=\"cm-" + esc(style) + "\">" + escaped + "</span>");
      else
        accum.push(escaped);
    };
  }

  // Split the input string into lines
  const lines = CodeMirror.splitLines(string);

  // Initialize the state object
  let state = CodeMirror.startState(mode);

  // Process each line
  for (let
