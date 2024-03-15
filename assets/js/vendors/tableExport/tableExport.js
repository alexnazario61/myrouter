/* The MIT License (MIT)

Copyright (c) 2014 https://github.com/kayalshri/

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.*/

(function ($) {
    $.fn.extend({
        tableExport: function (options) {
            // Check for jQuery dependency
            if (!$) {
                throw new Error('jQuery is not loaded');
            }

            // Check for html2canvas and jsPDF dependencies
            if (typeof html2canvas === 'undefined') {
                throw new Error('html2canvas is not loaded');
            }
            if (typeof jsPDF === 'undefined') {
                throw new Error('jsPDF is not loaded');
            }

            // Default settings
            const defaults = {
                separator: ',',
                ignoreColumn: [],
                tableName: 'yourTableName',
                type: 'csv',
                pdfFontSize: 14,
                pdfLeftMargin: 20,
                escape: 'true',
                htmlContent: 'false',
                consoleLog: 'false'
            };

            // Merge default and user-provided settings
            const settings = $.extend(defaults, options);

            // Check for table element
            if (!this.is('table')) {
                throw new Error('The selected element is not a table');
            }

            // Check for empty table
            if ($(this).find('tr').length === 0) {
                throw new Error('The table is empty');
            }

            // Check for empty ignoreColumn array
            if (settings.ignoreColumn.length === 0) {
                throw new Error('The ignoreColumn array is empty');
            }

            // Check for unsupported file type
            if (!['csv', 'txt', 'sql', 'json', 'xml', 'excel', 'doc', 'powerpoint', 'png', 'pdf'].includes(settings.type)) {
                throw new Error('Unsupported file type');
            }

            // Check for invalid table structure
            const tableStructure = $(this).find('thead, tbody');
            if (tableStructure.length !== 2) {
                throw new Error('Invalid table structure');
            }

            // Check for invalid column index in ignoreColumn array
            for (const index of settings.ignoreColumn) {
                if (index < 0 || index >= $(this).find('thead tr th').length) {
                    throw new Error(`Invalid column index in ignoreColumn array: ${index}`);
                }
            }

            // Check for invalid row index in ignoreColumn array
            if (settings.ignoreColumn.some(index => index < 0 || index >= $(this).find('tbody tr').length)) {
                throw new Error('Invalid row index in ignoreColumn array');
            }

            // Check for invalid column index in table data
            $(this).find('tbody tr').each((index, row) => {
                if ($(row).find('td').length !== $(this).find('thead tr th').length - settings.ignoreColumn.length) {
                    throw new Error(`Invalid column index in table data: row ${index}`);
                }
            });

            // Check for invalid row index in table data
            if ($(this).find('tbody tr').length !== $(this).find('tr').not('thead tr').length) {
               
