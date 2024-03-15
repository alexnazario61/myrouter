(() => {
  const commentStarts = {
    css: "/*",
    javascript: "/*",
    xml: "<!--"
  };

  const commentEnds = {
    css: "*/",
    javascript: "*/",
    xml: "-->"
  };

  const wordWrapChars = {
    css: [";", "{", "}"],
    javascript: [";", "{", "}"],
    xml: [">"]
  };

  const nonBreakableRegexes = [
    /for\s*?\((.*?)\)/,
    /"(.*?)("|$)/,
    /'(.*?)('|$)/,
    /\/\*(.*?)(\*\/|$)/,
    /\/\/.*/
  ];

  const reLinesSplitter = /(;|\{|\})([^\r\n;])/g;
  const reProcessedPortion = /(^\\s*?<|^[^<]*?)(.+)(>\\s*?$|[^>]*?$)/;
  const reOpenBrackets = /< /g;
  const reCloseBrackets = /(>)([^\r\n])/g;

  const extendMode = (modeName, extensions) => {
    const mode = CodeMirror.getMode(null, modeName);
    const extendedMode = CodeMirror.extendMode(mode, extensions);
    CodeMirror.defineMode(modeName, extendedMode);
  };

  const jsNonBreakableBlocks = text => {
    const nonBreakableBlocks = [];
    let curPos = 0;

    for (const regex of nonBreakableRegexes) {
      while (curPos < text.length) {
        const m = text.substr(curPos).match(regex);
        if (m) {
          nonBreakableBlocks.push({
            start: curPos + m.index,
            end: curPos + m.index + m[0].length
          });
          curPos += m.index + Math.max(1, m[0].length);
        } else {
          break;
        }
      }
    }

    nonBreakableBlocks.sort((a, b) => a.start - b.start);
    return nonBreakableBlocks;
  };

  extendMode("css", {
    commentStart: commentStarts.css,
    commentEnd: commentEnds.css,
    wordWrapChars: wordWrapChars.css,
    autoFormatLineBreaks: function (text) {
      return text.replace(reLinesSplitter, "$1\n$2");
    }
  });

  extendMode("javascript", {
    commentStart: commentStarts.javascript,
    commentEnd: commentEnds.javascript,
    wordWrapChars: wordWrapChars.javascript,
    autoFormatLineBreaks: function (text) {
      const nonBreakableBlocks = jsNonBreakableBlocks(text);
      let curPos = 0;
      let res = "";

      for (const block of nonBreakableBlocks) {
        if (block.start > curPos) {
          res += text.substring(curPos, block.start).replace(reLinesSplitter, "$1\n$2");
          curPos = block.start;
        }

        if (block.start <= curPos && block.end >= curPos) {
          res += text.substring(curPos, block.end);
          curPos = block.end;
        }
      }

      if (curPos < text.length) {
        res += text.substr(curPos).replace(reLinesSplitter, "$1\n$2");
      }

      return res;
    }
  });

  extendMode("xml", {
    commentStart: commentStarts.xml,
    commentEnd: commentEnds.xml,
    wordWrapChars: wordWrapChars.xml,
    autoFormatLineBreaks: function (text) {
      const lines = text.split("\n");

      for (let i = 0; i < lines.length; i++) {
        const mToProcess = lines[i].match(reProcessedPortion);

        if (mToProcess && mToProcess.length > 3) {
          lines[i] =
            mToProcess[1] +
            mToProcess[2].replace(reOpenBrackets, "\n$&").replace(reCloseBrackets, "$1\n$2") +
            mToProcess[3];
        }
      }

      return lines.join("\n");
    }
  });

  const localModeAt = (cm, pos) =>
    CodeMirror.innerMode(cm.getMode(), cm.getTokenAt(pos).state).mode;

  const enumerateModesBetween = (cm, line, start, end) => {
    const outer = cm.getMode();
    let text = cm.getLine(line);

    if (end == null) end = text.length;

    if (!outer.innerMode)
      return [{ from: start, to: end, mode: outer }];

    const state = cm.getTokenAt({ line: line, ch: start }).state;
    const mode = CodeMirror.innerMode(outer, state).mode;

    const found = [];
    let stream = new CodeMirror.StringStream(text);
    stream.pos = stream.start = start;

    for (;;) {
      outer.token(stream, state);
      const curMode = CodeMirror.innerMode(outer, state).mode;

      if (curMode != mode) {
        const cut = stream.start;

        if (mode.name == "xml" && text.charAt(stream.pos - 1) == ">") cut = stream.pos;

        found.push({ from: start, to: cut, mode: mode });
        start = cut;
        mode = curMode;
      }

      if (stream.pos >= end) break;
      stream.start = stream.pos;
    }

    if (start < end)
      found.push({ from: start, to: end, mode
