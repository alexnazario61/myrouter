/* The code is MIT licensed */

(function($) {
  $.fn.extend({
    tableExport: function(options) {
      const defaults = {
        separator: ',',
        ignoreColumn: [],
        tableName: 'myrouter',
        type: 'csv',
        delimiter: ';',
        columnNames: false,
        filename: 'exportData',
        escape: true,
        htmlContent: false,
        consoleLog: false,
      };

      const options = $.extend(defaults, options);
      const table = this;

      if (options.type === 'csv' || options.type === 'txt') {
        const csvContent = createCSVContent(table, options);
        if (options.consoleLog) {
          console.log(csvContent);
        }
        downloadFile(options.type, csvContent, options.filename);
      } else if (options.type === 'sql') {
        const sqlContent = createSQLContent(table, options);
        if (options.consoleLog) {
          console.log(sqlContent);
        }
        downloadFile(options.type, sqlContent, options.filename);
      } else if (options.type === 'json') {
        const jsonContent = createJSONContent(table, options);
        if (options.consoleLog) {
          console.log(jsonContent);
        }
        downloadFile(options.type, jsonContent, options.filename);
      } else if (options.type === 'xml') {
        const xmlContent = createXMLContent(table, options);
        if (options.consoleLog) {
          console.log(xmlContent);
        }
        downloadFile(options.type, xmlContent, options.filename);
      } else if (
        options.type === 'excel' ||
        options.type === 'doc' ||
        options.type === 'powerpoint'
      ) {
        const htmlContent = createHTMLContent(table, options);
        if (options.consoleLog) {
          console.log(htmlContent);
        }
        downloadFile(options.type, htmlContent, options.filename);
      } else if (options.type === 'png') {
        createPNGImage(table, options);
      } else if (options.type === 'pdf') {
        createPDFFile(table, options);
      } else {
        console.error(`Invalid export type: ${options.type}`);
      }

      function createCSVContent(table, options) {
        const header = getHeader(table, options);
        const baseContent = header + '\n' + getRows(table, options);
        return baseContent;
      }

      function createSQLContent(table, options) {
        const header = getHeader(table, options);
        const columnNames = options.columnNames ? getColumnNames(table) : '';
        const baseContent = `table ${header} (${columnNames}) \n${getRows(
          table,
          options
        )};`;
        return baseContent;
      }

      function createJSONContent(table, options) {
        const header = getHeader(table, options);
        const rows = getRows(table, options);
        const jsonContent = JSON.stringify([{ header, rows }]);
        return jsonContent;
      }

      function createXMLContent(table, options) {
        const header = getHeader(table, options);
        const rows = getRows(table, options);
        const xmlContent = `<?xml version="1.0" encoding="ISO-8859-1"?>
          <ERPMK>
            <tabela>
              ${header}
            </tabela>
            <data>
              ${rows}
            </data>
          </ERPMK>`;
        return xmlContent;
      }

      function createHTMLContent(table, options) {
        const header = getHeader(table, options);
        const rows = getRows(table, options);
        const htmlContent = `<table>${header}${rows}</table>`;
        return htmlContent;
      }

      function createPNGImage(table, options) {
        html2canvas(table, {
          onrendered: function(canvas) {
            const img = canvas.toDataURL('image/png');
            window.open(img);
          },
        });
      }

      function createPDFFile(table, options) {
        const doc = new jsPDF('P', 'pt', 'a4', true);
        doc.setFontSize(options.pdfFontSize);
        const header = getHeader(table, options);
        const rows = getRows(table, options);
        addHeader(doc, header, options);
        addRows(doc, rows, options);
        doc.output('datauri');
      }

      function getHeader(table, options) {
        const header = table
          .find('thead')
          .find('tr')
          .map(function() {
            return $(this)
              .find('th')
              .not(':hidden')
              .map(function(index) {
                if (options.ignoreColumn.indexOf(index) === -1) {
                  return parseString($(this), options);
                }
              })
              .get()
              .join(options.delimiter);
          })
          .get()
          .join('\n');
        return header;
      }

      function getColumnNames(table) {
        const columnNames = table
          .find('thead')
          .find('tr')
          .first()
          .find('th')
          .
