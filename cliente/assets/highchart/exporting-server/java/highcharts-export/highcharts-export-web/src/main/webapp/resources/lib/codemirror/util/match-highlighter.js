/**
 * Define match-highlighter commands. Depends on searchcursor.js
 * Use by attaching the following function call to the onCursorActivity event:
 *   myCodeMirror.matchHighlight(minChars);
 * And including a special span.CodeMirror-matchhighlight css class (also optionally a separate one for .CodeMirror-focused -- see demo matchhighlighter.html)
 */
(function() {
  /**
   * @constant
   * @type {number}
   * @default 2
   */
  const DEFAULT_MIN_CHARS = 2;

  /**
   * MatchHighlightState object constructor
   * @constructor
   */
  function MatchHighlightState() {
    this.marked = [];
  }

  /**
   * Get MatchHighlightState object for the given CodeMirror instance
   * @param {CodeMirror} cm - The CodeMirror instance
   * @returns {MatchHighlightState}
   */
  function getMatchHighlightState(cm) {
    return cm._matchHighlightState || (cm._matchHighlightState = new MatchHighlightState());
  }

  /**
   * Clear all the marks in the CodeMirror instance
   * @param {CodeMirror} cm - The CodeMirror instance
   * @returns {void}
   */
  function clearMarks(cm) {
    const state = getMatchHighlightState(cm);
    for (let i = 0; i < state.marked.length; ++i) {
      state.marked[i].clear();
    }
    state.marked = [];
  }

  /**
   * Mark the matches in the CodeMirror instance
   * @param {CodeMirror} cm - The CodeMirror instance
   * @param {string} className - The class name for the marked text
   * @param {number} [minChars=DEFAULT_MIN_CHARS] - The minimum number of characters required for highlighting
   * @returns {void}
   */
  function markDocument(cm, className, minChars = DEFAULT_MIN_CHARS) {
    if (typeof minChars !== 'number') {
      console.error('minChars must be a number');
      return;
    }

    clearMarks(cm);

    if (cm.somethingSelected() && cm.getSelection().replace(/^\s+|\s+$/g, "").length >= minChars) {
      const state = getMatchHighlightState(cm);
      const query = cm.getSelection();
     
