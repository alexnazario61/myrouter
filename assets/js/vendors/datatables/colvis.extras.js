/* 
 * File:   colvis.extras.js  
 * Version: 	1.1.2
 * Created: 	12/01/2013
 * Modified:	25/07/2013
 * Authors:	Drew Taylor 
 * 		(search this file for "Drew"), 
 * 		STWI 
 * 		(search this file for "STWI") 
 *		Thanks to STWI for the base iMaxRows integration! 
 * 		If anyone knows how to contact STWI or what the acronym stands email me. 
 *              Code was found in forums but can no longer find the thread.
 * 				
 * Language: 	Javascript
 * Contact:	tay.drew@hotmail.ca 
 * Description: ColVis extension which allows for toggling button types and different menu layout integrations.
 * 		Button extensions for Twitter Bootstrap buttons; i.e.  <button class="btn">
 * 		For use with non-Bootstrap integrations add these button classes to your CSS: 
 * 		"btn" (basic buttons), "btn-group" (groups of buttons), "btn-primary" (ColVis menu button, sShowAll, bRestore), 
 * 		"btn-danger" (bClose).
 *
 */

(function($) {

  /**
   * ColVis provides column visiblity control for DataTables
   * @class ColVis
   * @constructor
   * @param {object} DataTables settings object
   */
  ColVis = function(oDTSettings, oInit) {
    // Santity check that we are a new instance
    if (!this.CLASS || this.CLASS != "ColVis") {
      console.error("Warning: ColVis must be initialised with the keyword 'new'");
    }

    if (typeof oInit == 'undefined') {
      oInit = {};
    } // Default options

    this.s = {
      dt: oDTSettings,
      oInit: oInit,
      activate: "click",
      sAlign: "left",
      buttonText: "Show / hide columns",
      hidden: true,
      aiExclude: [],
      abOriginal: [],
      bShowAll: true,
      sShowAll: "Show All",
      bRestore: false,
      sRestore: "Last Saved",
      bClose: true,
      sClose: "x",
      bExtras: false,
      bLabel: false,
      bLabelPost: false,
      sLabel: "Viewing options:",
      iOverlayFade: 500,
      fnLabel: null,
      sSize: "auto",
      bCssPosition: false,
      iMaxRows: -1,
    };

    this.dom = {
      wrapper: null,
      button: null,
      collection: null,
      background: null,
      catcher: null,
      buttons: [],
      restore: null,
    };

    ColVis.aInstances.push(this);
    this._fnConstruct();
    return this;
  };

  ColVis.prototype = {
    /* Public methods */
    fnRebuild: function() {
      /* Remove the old buttons */
      for (var i = this.dom.buttons.length - 1; i >= 0; i--) {
        if (this.dom.buttons[i] !== null) {
          this.dom.collection.removeChild(this.dom.buttons[i]);
        }
      }
      this.dom.buttons.splice(0, this.dom.buttons.length);

      this.dom.collection.removeChild(nSpanHR);

      if (this.dom.restore) {
        this.dom.restore.parentNode.appendChild(this.dom.restore);
      }

      /* Re-add them (this is not the optimal way of doing this, it is fast and effective) */
      this._fnAddButtons();

      /* Update the checkboxes */
      this._fnDrawCallback();
    },

    _fnConstruct: function() {
      this._fnApplyCustomisation();

      this.dom.wrapper = document.createElement('div');
      this.dom.wrapper.className = "ColVis TableTools";

      if (this.s.bLabel) {
        this.dom.wrapper.appendChild(this._fnTextLabel());
      }

      this.dom.button = this._fnDomBaseButton(this.s.buttonText);
      this.dom.button.className += " ColVis_MasterButton btn btn-primary";
      this.dom.wrapper.appendChild(this.dom.button);

      if (this.s.bLabelPost) {
        this.dom.wrapper.appendChild(this._fnTextLabel());
      }

      this.dom.catcher = this._fnDomCatcher();
      this.dom.collection = this._fnDomCollection();
      this.dom.background = this._fnDomBackground();

      this._fnAddButtons();

      for (var i = 0, iLen = this.s.abOriginal.length; i < iLen; i++) {
        this.s.abOriginal.push(this.s.dt.aoColumns[i].bVisible);
      }

      this.s.dt.aoDrawCallback.push({
        fn: function() {
          this._fnDrawCallback.call(this);
        }.bind(this),
        sName: "ColVis",
      });

      this.s.dt.oInstance.oApi._fnSaveState(this.s.dt);

      $(this.s.dt.oInstance).bind("column-reorder", function(e, oSettings, oReorder) {
        for (
          i = 0, iLen = that.s.aiExclude.length;
          i < iLen;
          i++
        ) {
          that.s.aiExclude[i] = oReorder.aiInvertMapping[that.s.aiExclude[i]];
        }

        var mStore = that.s.abOriginal.splice(oReorder.iFrom, 1)[0];
