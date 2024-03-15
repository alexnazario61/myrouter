// This code defines a self-invoking anonymous function that creates a module for opening simple dialogs on top of an editor.
(function() {

  // The dialogDiv function creates and configures a dialog element with the given template string.
  function dialogDiv(cm, template) {
    // Get the wrapper element of the CodeMirror editor instance.
    var wrap = cm.getWrapperElement();

    // Create a new div element for the dialog and insert it before the first child of the wrapper element.
    var dialog = wrap.insertBefore(document.createElement("div"), wrap.firstChild);

    // Add the "CodeMirror-dialog" class to the dialog element.
    dialog.className = "CodeMirror-dialog";

    // Set the innerHTML of the dialog element to the template string wrapped in a div.
    dialog.innerHTML = '<div>' + template + '</div>';

    // Return the created dialog element.
    return dialog;
  }

  // The openDialog function defines a new CodeMirror extension that opens a dialog with the given template string and a callback function.
  CodeMirror.defineExtension("openDialog", function(template, callback) {
    // Create a dialog element using the dialogDiv function.
    var dialog = dialogDiv(this, template);

    // Initialize a closed flag and a reference to the CodeMirror editor instance.
    var closed = false, me = this;

    // The close function removes the dialog element from its parent node and sets the closed flag to true.
    function close() {
      if (closed) return;
      closed = true;
      dialog.parentNode.removeChild(dialog);
    }

    // Get the first input element in the dialog and connect it to a keydown event handler.
    var inp = dialog.getElementsByTagName("input")[0];
    if (inp) {
      CodeMirror.connect(inp, "keydown", function(e) {
        // If the key pressed is Enter or Esc, prevent the default behavior and close the dialog.
        if (e.keyCode == 13 || e.keyCode == 27) {
          CodeMirror.e_stop(e);
          close();

          // Set the focus back to the CodeMirror editor instance and call the callback function with the input value if the key pressed is Enter.
          me.focus();
          if (e.keyCode == 13) callback(inp.value);
        }
      });

      // Set the focus to the input element and connect it to a blur event handler that closes the dialog.
      inp.focus();
      CodeMirror.connect(inp, "blur", close);
    } else {
      // If there is no input element, get the first button element and connect it to click and blur event handlers that close the dialog.
      var button = dialog.getElementsByTagName("button")[0];
      if (button) {
        CodeMirror.connect(button, "click", function() {
          close();
          me.focus();
        });
        button.focus();
        CodeMirror.connect(button, "blur", close);
      }
    }

    // Return the close function to allow the user to close the dialog programmatically.
    return close;
  });

  // The openConfirm function defines a new CodeMirror extension that opens a dialog with the given template string and an array of callback functions for each button.
  CodeMirror.defineExtension("openConfirm", function(template, callbacks) {
    // Create a dialog element using the dialogDiv function.
    var dialog = dialogDiv(this, template);

    // Initialize a closed flag, a reference to the CodeMirror editor instance, and a blurring counter.

