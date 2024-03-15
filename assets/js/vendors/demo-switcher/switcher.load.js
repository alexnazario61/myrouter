/*
 * Smart Demo Switcher v1.5
 * A plugin for switching between different stylesheets for demonstration purposes.
 * 
 * Copyright 2008 - 2014 Milan Petrovic (email: milan@gdragon.info)
 *
 * http://www.dev4press.com
 * http://www.millan.rs
 *
 */

// Create a global variable to store the Smart Demo Switcher object
var smartDemoSwitcherObj;

// Start the Smart Demo Switcher module as a self-invoking function
(function ($, window, document, undefined) {

    // Extend the Smart Demo Switcher Load object with a new Loader object
    smartDemoSwitcher.Loader = smartDemoSwitcher.Load.extend({

        // Define the display properties
        display: {
            style: "light", // The style of the display
            location: "right", // The location of the display
            initOpen: false, // Whether the display is initially open
            buttonContent: '<i class="fa fa-tint"></i>', // The content of the display button
            formHeaderContent: '<h4>ORB</h4>' // The content of the form header
        },

        // Define the stylesheets properties
        stylesheets: {
            main: {
                columns: 2, // The number of columns in the stylesheet list
                title: true, // Whether to display a title for the stylesheet list
                boxShape: "circle", // The shape of the boxes in the stylesheet list
                titleContent: "<h5>Styles</h5>", // The content of the stylesheet list title
                selector: "#demo-styles", // The selector for the stylesheet list container
                default: 'css/styles.css', // The default stylesheet
                list: [ // The list of available stylesheets
                    {file: 'css/styles-brown.css', name: 'Brown', colors: ['#b66d4a']},
                    {file: 'css/styles-green.css', name: 'Green', colors: ['#3c9474']},
                    {file: 'css/styles-blue.css', name: 'Blue', colors: ['#00425c']},
                    {file: 'css/styles-purple.css', name:
