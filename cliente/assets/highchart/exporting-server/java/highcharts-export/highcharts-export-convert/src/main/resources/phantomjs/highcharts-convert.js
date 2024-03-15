/**
 * Highcharts PhantomJS Converter
 * 
 * This script converts Highcharts charts to various formats using PhantomJS.
 * 
 * @license Highcharts JS v3.0.1 (2012-11-02)
 *           (c) 20013-2014 Highsoft AS
 *           www.highcharts.com/license
 * 
 * @author Gert Vaartjes
 * @version 2.0.1
 */

/*jslint white: true */
/*global window, require, phantom, console, $, document, Image, Highcharts, clearTimeout, clearInterval, options, cb */

(function () {
    'use strict';

    // Configuration
    const CONFIG = {
        HIGHCHARTS: 'highcharts.js',
        HIGHCHARTS_MORE: 'highcharts-more.js',
        HIGHCHARTS_DATA: 'data.js',
        JQUERY: 'jquery.1.9.1.min.js',
        TIMEOUT: 2000 // 2 seconds timeout for loading images
    };

    // Helper function to pick the first defined value from a list
    function pick(...args) {
        for (let i = 0; i < args.length; i++) {
            const arg = args[i];
            if (arg !== undefined && arg !== null && arg !== 'null' && arg != '0') {
                return arg;
            }
        }
    }

    // Map command line arguments to an object
    function mapCLArguments() {
        const map = {};
        const args = system.args;

        if (args.length < 1) {
            console.log('Commandline Usage: highcharts-convert.js -infile URL -outfile filename -scale 2.5 -width 300 -constr Chart -callback callback.js');
            console.log(', or run PhantomJS as server: highcharts-convert.js -host 127.0.0.1 -port 1
