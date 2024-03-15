/**
 * @license Highcharts JS v3.0.5 (2013-08-23)
 * Prototype adapter
 *
 * @author Michael Nelson, Torstein Hønsi.
 *
 * Feel free to use and modify this script.
 * Highcharts license: www.highcharts.com/license.
 */

// JSLint options:
/*global Effect, Class, Event, Element, $, $$, $A */

// Adapter interface between prototype and the Highcharts charting library
var HighchartsAdapter = (function () {

    var hasEffect = typeof Effect !== 'undefined';

    return {

        /**
         * Initialize the adapter. This is run once as Highcharts is first run.
         * @param {Object} pathAnim The helper object to do animations across adapters.
         */
        init: function (pathAnim) {
            if (hasEffect) {
                /**
                 * Animation for Highcharts SVG element wrappers only
                 * @param {Object} element
                 * @param {Object} attribute
                 * @param {Object} to
                 * @param {Object} options
                 */
                Effect.HighchartsTransition = Class.create(Effect.Base, {
                    initialize: function (element, attr, to, options) {
                        var from,
                            opts;

                        this.element = element;
                        this.key = attr;
                        from = element.attr ? element.attr(attr) : $(element).getStyle(attr);

                        // special treatment for paths
                        if (attr === 'd') {
                            this.paths = pathAnim.init(
                                element,
                                element.d,
                                to
                            );
                            this.toD = to;

                            // fake values in order to read relative position as a float in update
                            from = 0;
                            to = 1;
                        }

                        opts = Object.extend((options || {}), {
                            from: from,
                            to: to,
                            attribute: attr
                        });
                        this.start(opts);
                    },
                    setup: function () {
                        HighchartsAdapter._extend(this.element);
                        // If this is the first animation on this object, create the _highcharts_animation helper that
                        // contain pointers to the animation objects.
                        if (!this.element._highchart_animation) {
                            this.element._highchart_animation = {};
                        }

                        // Store a reference to this animation instance.
                        this.element._highchart_animation[this.key] = this;
                    },
                    update: function (position) {
                        var paths = this.paths,
                            element = this.element,
                            obj;

                        if (paths) {
                            position = pathAnim.step(paths[0], paths[1], position, this.toD);
                        }

                        if (element.attr) { // SVGElement

                            if (element.element) { // If not, it has been destroyed (#1405)
                                element.attr(this.options.attribute, position);
                            }

                        } else { // HTML, #409
                            obj = {};
                            obj[this.options.attribute] = position;
                            $(element).setStyle(obj);
                        }
                    },
                    finish: function () {
                        // Delete the property that holds this animation now that it is finished.
                        // Both canceled animations and complete ones gets a 'finish' call.
                        if (this.element && this.element._highchart_animation) { // #1405
                            delete this.element._highchart_animation[this.key];
                        }
                    }
                });
            }
        },

        /**
         * Run a general method on the framework, following jQuery syntax
         * @param {Object} el The HTML element
         * @param {String} method Which method to run on the wrapped element
         */
        adapterRun: function (el, method) {
            // This currently works for getting inner width and height. If adding
            // more methods later, we need a conditional implementation for each.
            return parseInt($(el).getStyle(method), 10);
        },

        /**
         * Downloads a script and executes a callback when done.
         * @param {String} scriptLocation
         * @param {Function} callback
         */
        getScript: function (scriptLocation, callback) {
            var head = $$('head')[0]; // Returns an array, so pick the first element.
            if (head) {
                // Append a new 'script' element, set its type and src attributes, add a 'load' handler that calls the callback
                head.appendChild(new Element('script', {
                    type: 'text/javascript',
                    src: scriptLocation
                }).observe('load', callback));
            }
        },

        /**
         * Custom events in prototype needs to be namespaced. This method adds a namespace 'h:' in front of
         * events that are not recognized as native.
         */
        addNS: function (eventName) {
            var HTMLEvents = /^(?:load|unload|abort|error|select|change|submit|reset|focus|blur|resize|scroll)$/,
                MouseEvents = /^(?:click|mouse(?:down|up|over|move|out))$/;
            return (HTMLEvents.test(eventName) || MouseEvents.test(eventName)) ?
                eventName :
                'h:' + eventName;
        },

        // el needs an event to be attached. el is not necessarily a dom element
        addEvent: function (el, event, fn) {
            if (el.addEventListener || el
