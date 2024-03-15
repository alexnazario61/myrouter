/*
Axis Labels Plugin for flot.
http://github.com/markrcote/flot-axislabels

Copyright (c) 2010 Xuan Luo
Permission is hereby granted, free of charge, to any person obtaining
a copy of this software and associated documentation files (the
"Software"), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

(function ($) {
    const options = {};

    function canvasSupported() {
        return !!document.createElement('canvas').getContext;
    }

    function canvasTextSupported() {
        if (!canvasSupported()) {
            return false;
        }
        const dummy_canvas = document.createElement('canvas');
        const context = dummy_canvas.getContext('2d');
        return typeof context.fillText == 'function';
    }

    function css3TransitionSupported() {
        const div = document.createElement('div');
        return typeof div.style.MozTransition != 'undefined' ||
            typeof div.style.OTransition != 'undefined' ||
            typeof div.style.webkitTransition != 'undefined' ||
            typeof div.style.transition != 'undefined';
    }

    class AxisLabel {
        constructor(axisName, position, padding, plot, opts) {
            this.axisName = axisName;
            this.position = position;
            this.padding = padding;
            this.plot = plot;
            this.opts = opts;
            this.width = 0;
            this.height = 0;
        }

        delete() {}
    }

    class CanvasAxisLabel extends AxisLabel {
        constructor(axisName, position, padding, plot, opts) {
            super(axisName, position, padding, plot, opts);
        }

        calculateSize() {
            if (!this.opts.axisLabelFontSizePixels)
                this.opts.axisLabelFontSizePixels = 10;
            if (!this.opts.axisLabelFontFamily)
                this.opts.axisLabelFontFamily = 'sans-serif';

            const textWidth = this.opts.axisLabelFontSizePixels + this.padding;
            const textHeight = this.opts.axisLabelFontSizePixels + this.padding;
            if (this.position == 'left' || this.position == 'right') {
                this.width = this.opts.axisLabelFontSizePixels + this.padding;
                this.height = 0;
            } else {
                this.width = 0;
                this.height = this.opts.axisLabelFontSizePixels + this.padding;
            }
        }

        draw(box) {
            const ctx = this.plot.getCanvas().getContext('2d');
            ctx.save();
            ctx.font = `${this.opts.axisLabelFontSizePixels}px ${this.opts.axisLabelFontFamily}`;
            const width = ctx.measureText(this.opts.axisLabel).width;
            const height = this.opts.axisLabelFontSizePixels;
            let x, y, angle = 0;
            if (this.position == 'top') {
                x = box.left + box.width / 2 - width / 2;
                y = box.top + height * 0.72;
            } else if (this.position == 'bottom') {
                x = box.left + box.width / 2 - width / 2;
                y = box.top + box.height - height * 0.72;
            } else if (this.position == 'left') {
                x = box.left + height * 0.72;
                y = box.height / 2 + box.top + width / 2;
                angle = -Math.PI / 2;
            } else if (this.position == 'right') {
                x = box.left + box.width - height * 0.72;
                y = box.height / 2 + box.top - width / 2;
                angle = Math.PI / 2;
            }
            ctx.translate(x, y);
            ctx.rotate(angle);
            ctx.fillText(this.opts.axisLabel, 0, 0);
            ctx.restore();
        }
    }

    class HtmlAxisLabel extends AxisLabel {
        constructor(axisName, position, padding, plot, opts) {
            super(axisName, position, padding, plot, opts);
            this.elem = null;
        }

        calculateSize() {
            const elem = $('<div class="axisLabels" style="position:absolute;">' +
                        this.opts.axisLabel + '</div>');
            this.plot.getPlaceholder().append(elem);
            // store height and width of label itself, for use in draw()
            this.labelWidth = elem.outerWidth(true);
            this.labelHeight = elem.outerHeight(true);

