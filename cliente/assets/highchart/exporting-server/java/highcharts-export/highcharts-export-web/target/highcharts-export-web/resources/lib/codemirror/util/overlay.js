// Utility function that allows modes to be combined. The mode given
// as the base argument takes care of most of the normal mode
// functionality, but a second (typically simple) mode is used, which
// can override the style of text. Both modes get to parse all of the
// text, but when both assign a non-null style to a piece of code, the
// overlay wins, unless the `combine` argument was true, in which case
// the styles are combined.

// `overlayParser` is the old, deprecated name
const overlayMode = (base, overlay, combine = false) => ({
  name: `overlay-mode(${base.name}, ${overlay.name})`,

  startState() {
    return {
      baseState: CodeMirror.startState(base),
      overlayState: CodeMirror.startState(overlay),
      basePos: 0,
      overlayPos: 0,
    };
  },

  copyState(state) {
    return {
      baseState: CodeMirror.copyState(base, state.baseState),
      overlayState: CodeMirror.copyState(overlay, state.overlayState),
      basePos: state.basePos,
      overlayPos: state.overlayPos,
    };
  },

  token(stream, state) {
    if (stream.start === state.basePos) {
      state.baseState = base.token(stream, state.baseState);
      state.basePos = stream.pos;
    }

    if (stream.start === state.overlayPos) {
      stream.pos = stream.start;
      state.overlayState = overlay.token(stream, state.overlayState);
      state.overlayPos = stream.pos;
    }

    stream.pos = Math.min(state.basePos, state.overlayPos);

    if (stream.eol()) {
      state.basePos = state.overlayPos = 0;
    }

    const baseCur = state.baseState ? state.baseState.token : null;
    const overlayCur = state.overlayState ? state.overlayState.token : null;

    if (overlayCur == null) return baseCur;

    if (baseCur != null && combine) {
      return `${baseCur} ${overlayCur}`;
    }

    return overlayCur;
  },

  indent(state, textAfter) {
    return base.indent(state.baseState, textAfter);
  },

  electricChars: base.electricChars,

  innerMode(state) {
    return { state: state.baseState, mode: base };
  },

  blankLine(state) {
    if (base.blankLine) base.blankLine(state.baseState);
    if (overlay.blankLine) overlay.blankLine(state.overlayState);
  },
});

