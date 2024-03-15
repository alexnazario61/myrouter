/**
 * jsPDF
 * (c) 2009 James Hall
 * 
 * Some parts based on FPDF.
 */

class jsPDF {
  constructor() {
    // Private properties
    this.version = '20090504';
    this.buffer = '';

    this.pdfVersion = '1.3'; // PDF Version
    this.defaultPageFormat = 'a4';
    this.pageFormats = {
      // Size in mm of various paper formats
      a3: [841.89, 1190.55],
      a4: [595.28, 841.89],
      a5: [420.94, 595.28],
      letter: [612, 792],
      legal: [612, 1008],
    };
    this.textColor = '0 g';
    this.page = 0;
    this.objectNumber = 2; // 'n' Current object number
    this.state = 0; // Current document state
    this.pages = [];
    this.offsets = []; // List of offsets
    this.lineWidth = 0.200025; // 2mm
    this.pageHeight;
    this.k; // Scale factor
    this.unit = 'mm'; // Default to mm for units
    this.fontNumber; // TODO: This is temp, replace with real font handling
    this.documentProperties = {};
    this.fontSize = 16; // Default font size
    this.pageFontSize = 16;

    // Initilisation 
    this.k = this.getScaleFactor(this.unit);

    // Private functions
    this.newObject = function () {
      //Begin a new object
      this.objectNumber++;
      this.offsets[this.objectNumber] = this.buffer.length;
      this.out(`${this.objectNumber} 0 obj`);
    };

    this.putHeader = function () {
      this.out('%PDF-' + this.pdfVersion);
    };

    this.putPages = function () {
      for (let n = 1; n <= this.page; n++) {
        this.newObject();
        this.out(`<</Type /Page`);
        this.out(`/Parent 1 0 R`);
        this.out(`/Resources 2 0 R`);
        this.out(`/Contents ${this.objectNumber + 1} 0 R>>`);
        this.out('endobj');

        //Page content
        const p = this.pages[n];
        this.newObject();
        this.out(`<</Length ${p.length}>>`);
        this.putStream(p);
        this.out('endobj');
      }
      this.offsets[1] = this.buffer.length;
      this.out('1 0 obj');
      this.out(`<<`);
      this.putResourceDictionary();
      this.out(`>>`);
      this.out('endobj');
    };

    this.putStream = function (str) {
      this.out('stream');
      this.out(str);
      this.out('endstream');
    };

    this.putResources = function () {
      this.putFonts();
      this.putImages();

      //Resource dictionary
      this.newObject();
      this.out('<<');
      this.putResourceDictionary();
      this.out('>>');
      this.out('endobj');
    };

    this.putFonts = function () {
      // TODO: Only supports core font hardcoded to Helvetica
      this.newObject();
      this.fontNumber = this.objectNumber;
      const name = 'Helvetica';
      this.out(`<</Type /Font`);
      this.out(`/BaseFont /${name}`);
      this.out('/Subtype /Type1');
      this.out('/Encoding /WinAnsiEncoding');
      this.out('>>');
      this.out('endobj');
    };

    this.putImages = function () {
      // TODO
    };

    this.putResourceDictionary = function () {
      this.out('/ProcSet [/PDF /Text /ImageB /ImageC /ImageI]');
      this.out('/Font <<');
      // Do this for each font, the '1' bit is the index of the font
      // fontNumber is currently the object number related to 'putFonts'
      this.out(`/F1 ${this.fontNumber} 0 R`);
      this.out('>>');
      this.out('/XObject <<');
      this.putXobjectDict();
      this.out('>>');
    };

    this.putXobjectDict = function () {
      // TODO
      // Loop through images
    };

    this.putInfo = function () {
      this.out
