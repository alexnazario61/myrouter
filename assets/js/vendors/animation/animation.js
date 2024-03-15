/* Bootstrap: modal.js v3.1.1 Revised by DazeinCreative
 * http://getbootstrap.com/javascript/#modals
 * http://themeforest.net/user/DazeinCreative
 * 
 * Copyright 2011-2014 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 */

+function ($) {
 'use strict';

 // MODAL CLASS DEFINITION
 // ======================

 // Modal constructor
 var Modal = function (element, options) {
   this.options = options;
   this.$element = $(element);
   this.$backdrop = null;
   this.isShown = null;

   if (this.options.remote) {
     this.$element.find('.modal-content').load(this.options.remote, $.proxy(function () {
       this.$element.trigger('loaded.bs.modal');
     }, this));
   }
 };

 // Default options for the Modal
 Modal.DEFAULTS = {
   backdrop: true,
   keyboard: true,
   show: true,
   easein: 'fadeInLeft', // Added easein property
   easeout: 'fadeOutLeft' // Added easeout property
 };

 // ... (rest of the Modal class methods)

 // ... (rest of the modal.js code)

 // Add animation to the tab
 function enhanceTab(tab, tabContent, easein) {
   // ... (rest of the enhanceTab function)
 }

 // Add animation to the popover
 $("a[rel=popover]").popover().click(function (e) {
   // ... (rest of the popover click event handler)
 });

}(jQuery);

// Invoke the enhanceTab and popover animation functions when the DOM is ready
$(function () {
  // ... (rest of the DOM ready function)
});
