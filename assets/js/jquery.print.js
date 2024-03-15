(function ($) {
  // Create a jQuery plugin that prints the given element.
  $.fn.print = function () {
    // If there's more than one element in the collection,
    // print only the first one.
    if (this.length > 1) {
      this.first().print();
      return;
    }

    // If there's no element, do nothing.
    if (!this.length) {
      return;
    }

    // Create a random name for the print frame.
    const frameName = `printer-${Date.now()}`;

    // Create an iframe with the new name.
    const $frame = $(`<iframe name="${frameName}"></iframe>`);

    // Style the iframe and append it to the body.
    $frame
      .css({
        width: "1px",
        height: "1px",
        position: "absolute",
        left: "-9999px",
        "font-family": "Verdana",
        "font-size": "12px",
        color: "#000000",
      })
      .appendTo("body");

    // Get a reference to the window and document of the iframe.
    const frameWindow = window.frames[frameName];
    const frameDocument = frameWindow.document;

    // Copy the styles from the current document to the iframe.
    const $styleDiv = $("<div>").append($("style").clone());
    frameDocument.write(`
      <!DOCTYPE html>
      <html>
        <head>
          <title>${document.title}</title>
          ${$styleDiv.html()}
          <link href="../css/styles.css" rel="stylesheet" type="text/css">
        </head>
        <body>
          ${this.first().html()}
        </body>
      </html>
    `);

    // Print the iframe and remove it after a minute.
    frameWindow.print();
    setTimeout(() => $frame.remove(), 60 * 1000);
  };
})(jQuery);
