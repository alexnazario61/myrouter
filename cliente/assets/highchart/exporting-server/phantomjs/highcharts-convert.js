/**
 * Highcharts PhantomJS Converter
 *
 * This script converts Highcharts charts to various formats using PhantomJS.
 *
 * @license Highcharts JS v3.0.1 (2012-11-02)
 *
 * (c) 2013-2014
 *
 * Author: Gert Vaartjes
 *
 * License: www.highcharts.com/license
 *
 * version: 2.0.1
 */

/*jslint white: true */
/*global window, require, phantom, console, $, document, Image, Highcharts, clearTimeout, clearInterval, options, cb */

(function () {
    'use strict';

    // Configuration
    const config = {
        HIGHCHARTS: 'highstock.js',
        HIGHCHARTS_MORE: 'highcharts-more.js',
        HIGHCHARTS_DATA: 'data.js',
        JQUERY: 'jquery.1.9.1.min.js',
        TIMEOUT: 2000 // 2 seconds timeout for loading images
    };

    // Helper functions

    /**
     * Returns the first argument that is not undefined, null, or an empty string.
     *
     * @param {...*} args - Variable number of arguments to check.
     * @returns {*} The first non-empty argument.
     */
    function pick(...args) {
        for (const arg of args) {
            if (arg !== undefined && arg !== null && arg !== '') {
                return arg;
            }
        }
    }

    /**
     * Maps command line arguments to an object.
     *
     * @returns {Object} An object containing the command line arguments.
     */
    function mapCLArguments() {
        const args = {};
        const argList = system.args;

        if (argList.length < 1) {
            console.log('Commandline Usage: highcharts-convert.js -infile URL -outfile filename -scale 2.5 -width 300 -constr Chart -callback callback.js');
            console.log(', or run PhantomJS as server: highcharts-convert.js -host 127.0.0.1 -port 1234');
            phantom.exit();
        }

        for (const arg in argList) {
            if (argList.hasOwnProperty(arg)) {
                const key = argList[arg].substr(1);
                if (key === 'infile' || key === 'callback' || key === 'dataoptions' || key === 'globaloptions' || key === 'customcode') {
                    // Get string from file
                    try {
                        args[key] = fs.read(argList[parseInt(arg, 10) + 1]);
                    } catch (e) {
                        console.log(`Error: cannot find file, ${argList[parseInt(arg, 10) + 1]}`);
                        phantom.exit();
                    }
                } else {
                    args[key] = argList[arg];
                }
            }
        }

        return args;
    }

    // Main function

    /**
     * Renders a Highcharts chart and exports it to a file.
     *
     * @param {Object} params - An object containing the command line arguments.
     * @param {boolean} runsAsServer - Whether the script is running as a server.
     * @param {function} exitCallback - A callback function to call when rendering is complete.
     */
    function render(params, runsAsServer, exitCallback) {
        const page = require('webpage').create();
        const messages = {
            imagesLoaded: 'Highcharts.images.loaded',
            optionsParsed: 'Highcharts.options.parsed',
            callbackParsed: 'Highcharts.cb.parsed'
        };

        page.onConsoleMessage = function (msg) {
            /*
             * Ugly hack, but only way to get messages out of the 'page.evaluate()'
             * sandbox. If any, please contribute with improvements on this!
             */

            if (msg === messages.imagesLoaded) {
                window.imagesLoaded = true;
            }
            /* more ugly hacks, to check options or callback are properly parsed */
            if (msg === messages.optionsParsed) {
                window.optionsParsed = true;
            }

            if (msg === messages.callbackParsed) {
                window.callbackParsed = true;
            }
        };

        page.onAlert = function (msg) {
            console.log(msg);
        };

        // Scale and clip the page
        function scaleAndClipPage(svg) {
            const zoom = 1;
            const pageWidth = pick(params.width, svg.width);
            let clipwidth;
            let clipheight;

            if
