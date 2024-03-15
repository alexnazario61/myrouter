/**
 Typeahead.js input, based on [Twitter Typeahead](http://twitter.github.io/typeahead.js).   
 It is mainly a replacement of typeahead in Bootstrap 3.

 @class typeaheadjs
 @extends text
 @since 1.5.0
 @final
 @example
 <a href="#" id="country" data-type="typeaheadjs" data-pk="1" data-url="/post" data-title="Input country"></a>
 <script>
 $(function(){
     $('#country').editable({
         value: 'ru',
         typeahead: {
             name: 'country',
             local: [
                 {value: 'ru', tokens: ['Russia']}, 
                 {value: 'gb', tokens: ['Great Britain']}, 
                 {value: 'us', tokens: ['United States']}
             ],
             template: function(item) {
                 return item.tokens[0] + ' (' + item.value + ')'; 
             } 
         }
     });
 });
 </script>
 */
(function ($) {
    "use strict";

    var Typeaheadjs = function (options) {
        this.init('typeaheadjs', options, Typeaheadjs.defaults);
    };

    $.fn.editableutils.inherit(Typeaheadjs, $.fn.editabletypes.text);

    Typeaheadjs.prototype.render = function () {
        this.renderClear();
        this.setClass();
        this.setAttr('placeholder');

        // initialize typeahead
        var typeaheadConfig = this.options.typeahead;
        this.$input.typeahead(typeaheadConfig);

        // copy `input-sm | input-lg` classes to placeholder input
        if ($.fn.editableform.engine === 'bs3') {
            var inputSize = this.$input.prop('class').match(/input-(sm|lg)/);
            if (inputSize) {
                this.$input.siblings('input.tt-hint').addClass(inputSize[1]);
            }
        }
    };

    Typeaheadjs.defaults = $.extend({}, $.fn.editabletypes.list.defaults, {
        /**
         @property tpl 
         @default <input type="text">
         **/
        tpl: '<input type="text">',
        /**
         Configuration of typeahead itself. 
         [Full list of options](https://github.com/twitter/typeahead.js#dataset).

         @property typeahead 
         @type object
         @default null
         **/
        typeahead: null,
        /**
         Whether to show `clear` button 

         @property clear 
         @type boolean
         @default true        
         **/
        clear: true
    });

    $.fn.editabletypes.typeaheadjs = Typeaheadjs;

}(window.jQuery));
