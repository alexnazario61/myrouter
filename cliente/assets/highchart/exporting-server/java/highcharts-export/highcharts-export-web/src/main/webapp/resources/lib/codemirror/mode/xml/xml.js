CodeMirror.defineMode("xml", function(config, parserConfig) {
  const indentUnit = config.indentUnit;
  const htmlKludges = parserConfig.htmlMode
    ? {
        autoSelfClosers: {
          area: true,
          base: true,
          br: true,
          col: true,
          command: true,
          embed: true,
          frame: true,
          hr: true,
          img: true,
          input: true,
          keygen: true,
          link: true,
          meta: true,
          param: true,
          source: true,
          track: true,
          wbr: true,
        },
        implicitlyClosed: {
          dd: true,
          li: true,
          optgroup: true,
          option: true,
          p: true,
          rp: true,
          rt: true,
          tbody: true,
          td: true,
          tfoot: true,
          th: true,
          tr: true,
        },
        contextGrabbers: {
          dd: { dd: true, dt: true },
          dt: { dd: true, dt: true },
          li: { li: true },
          option: { option: true, optgroup: true },
          optgroup: { optgroup: true },
          p: {
            address: true,
            article: true,
            aside: true,
            blockquote: true,
            dir: true,
            div: true,
            dl: true,
            fieldset: true,
            footer: true,
            form: true,
            h1: true,
            h2: true,
            h3: true,
            h4: true,
            h5: true,
            h6: true,
            header: true,
            hgroup: true,
            hr: true,
            menu: true,
            nav: true,
            ol: true,
            p: true,
            pre: true,
            section: true,
            table: true,
            ul: true,
          },
          rp: { rp: true, rt: true },
          rt: { rp: true, rt: true },
          tbody: { tbody: true, tfoot: true },
          td: { td: true, th: true },
          tfoot: { tbody: true },
          th: { td: true, th: true },
          thead: { tbody: true, tfoot: true },
          tr: { tr: true },
        },
        doNotIndent: { pre: true },
        allowUnquoted: true,
        allowMissing: true,
      }
    : {
        autoSelfClosers: {},
        implicitlyClosed: {},
        contextGrabbers: {},
        doNotIndent: {},
        allowUnquoted: false,
        allowMissing: false,
      };
  const alignCDATA = parserConfig.alignCDATA;

  let tagName, type;

  function inText(stream, state) {
    // ... (rest of the function remains the same)
  }

  function inTag(stream, state) {
    // ... (rest of the function remains the same)
  }

  function inAttribute(quote) {
    // Fixed a missing parenthesis in the return statement
    return function(stream, state) {
      while (!stream.eol()) {
        if (stream.next() == quote) {
          state.tokenize = inTag;
          break;
        }
      }
      return "string";
    };
  }

  // ... (rest of the functions remain the same)

  return {
    startState: function() {
      // ... (rest of the function remains the same)
    },

    token: function(stream, state) {
      // ... (rest of the function remains the same)
    },

    indent: function(state, textAfter, fullLine) {
      // ... (rest of the function remains the same)
    },

    electricChars: "/",
  };
});

CodeMirror.defineMIME("text/xml", "xml");
CodeMirror.defineMIME("application/xml", "xml");
if (!CodeMirror.mimeModes.hasOwnProperty("text/html"))
  CodeMirror.defineMIME("text/html", { name: "xml", htmlMode: true });

