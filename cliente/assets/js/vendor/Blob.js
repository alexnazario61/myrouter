/* Blob.js
 * A Blob implementation.
 * 2014-07-24
 *
 * By Eli Grey, <http://eligrey.com>
 * By Devin Samarin, <https://github.com/dsamarin>
 * License: X11/MIT
 *   See <https://github.com/eligrey/Blob.js/blob/master/LICENSE.md>
 */

/*global self, unescape */
/*jslint bitwise: true, regexp: true, confusion: true, es5: true, vars: true, white: true,
  plusplus: true */

// The Blob constructor is defined using a self-executing anonymous function
(function (view) {
	"use strict";

	// Check if the Blob and URL objects are already available in the view (i.e., global scope)
	view.URL = view.URL || view.webkitURL;

	if (view.Blob && view.URL) {
		// If both Blob and URL are available, check if the Blob constructor works as expected
		try {
			new Blob;
			return; // If it does, exit the function
		} catch (e) {}
	}

	// Define a fallback BlobBuilder implementation
	var BlobBuilder = view.BlobBuilder || view.WebKitBlobBuilder || view.MozBlobBuilder || (function(view) {
		// ... (BlobBuilder implementation)
	}(view));

	// Define the Blob constructor using the fallback BlobBuilder
	view.Blob = function(blobParts, options) {
		// ... (Blob constructor implementation)
	};
}(typeof self !== "undefined" && self || typeof window !== "undefined" && window || this.content || this));

