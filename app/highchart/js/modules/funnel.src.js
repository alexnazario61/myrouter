/**
 * Highcharts funnel module, Beta
 *
 * (c) 2010-2012 Torstein Hønsi
 *
 * License: www.highcharts.com/license
 */

/*global Highcharts */
(function (Highcharts) {

  'use strict';

  // create shortcuts
  const defaultOptions = Highcharts.getOptions(),
    defaultPlotOptions = defaultOptions.plotOptions,
    seriesTypes = Highcharts.seriesTypes,
    merge = Highcharts.merge,
    noop = function () {},
    each = Highcharts.each;

  // set default options
  defaultPlotOptions.funnel = merge(defaultPlotOptions.pie, {
    center: ['50%', '50%'],
    width: '90%',
    neckWidth: '30%',
    height: '100%',
    neckHeight: '25%',
    dataLabels: {
      connectorWidth: 1,
      connectorColor: '#606060'
    },
    size: true, // to avoid adapting to data label size in Pie.drawDataLabels
    states: {
      select: {
        color: '#C0C0C0',
        borderColor: '#000000',
        shadow: false
      }
    }
  });

  seriesTypes.funnel = Highcharts.extendClass(seriesTypes.pie, {

    type: 'funnel',
    animate: noop,

    translate: function () {
      const series = this,
        chart = series.chart,
        plotWidth = chart.plotWidth,
        plotHeight = chart.plotHeight,
        options = series.options,
        center = options.center,
        centerX = (typeof center[0] === 'string' ? parseFloat(center[0]) / 100 : center[0]) * plotWidth,
        centerY = (typeof center[1] === 'string' ? parseFloat(center[1]) / 100 : center[1]) * plotHeight,
        width = (typeof options.width === 'string' ? parseFloat(options.width) / 100 : options.width) * plotWidth,
        height = (typeof options.height === 'string' ? parseFloat(options.height) / 100 : options.height) * plotHeight,
        neckWidth = (typeof options.neckWidth === 'string' ? parseFloat(options.neckWidth) / 100 : options.neckWidth) * plotWidth,
        neckHeight = (typeof options.neckHeight === 'string' ? parseFloat(options.neckHeight) / 100 : options.neckHeight) * plotHeight,
        neckY = height - neckHeight,
        data = series.data,
        getWidthAt,
        cumulative = 0;

      // Return the width at a specific y coordinate
      series.getWidthAt = getWidthAt = y => neckWidth + (width - neckWidth) * ((height - neckHeight - y) / (height - neckHeight));
      series.getX = y => centerX + (options.dataLabels.position === 'left' ? -1 : 1) * ((getWidthAt(y) / 2) + options.dataLabels.distance);

      // Expose
      series.center = [centerX, centerY, height];
      series.centerX = centerX;

      each(data, function (point, i) {
        const fraction = cumulative + point.y / series.pointsTotal;
        const y1 = centerY - height / 2 + cumulative * height;
        const y3 = y1 + fraction * height;
        const x1 = centerX - getWidthAt(y1) / 2;
        const x2 = x1 + getWidthAt(y1);
        const x3 = centerX - getWidthAt(y3) / 2;
        const x4 = x3 + getWidthAt(y3);

        // the entire point is within the neck
        if (y1 > neckY) {
          x1 = x3 = centerX - neckWidth / 2;
          x2 = x4 = centerX + neckWidth / 2;
        }

        // the base of the neck
        if (y3 > neckY) {
          const y5 = neckY;
          const x5 = centerX - getWidthAt(y5) / 2;
          const x6 = x5 + getWidthAt(y5);

          point.shapeType = 'path';
          point.shapeArgs = {
            d: [
              'M', x1, y1,
              'L', x2, y1,
              'L', x4, y3,
              'L', x3, y3,
              'Z',
              'M', x5, y5,
              'L', x6, y5
            ]
              .join(',')
          };

          point.plotX = centerX;
          point.plotY = (y1 + (y5 || y3)) / 2;
          point.labelPos = seriesTypes.pie.prototype.dataLabelPosition.call(series, i, point.plotX, point.plotY);

          cumulative = fraction;
        }
      });
    },

    drawPoints: function () {
      const series = this;

      each(series.data, function (point) {
        if (!point.graphic) {
          point.graphic = series.chart.renderer.path(point.shapeArgs.d)
            .attr({
              fill: point.color,
              stroke: series.options.borderColor,
              'stroke-width': series.options.borderWidth
            })
            .add(series.group);
        } else {
          point.graphic.animate(point.shapeArgs);
        }
      });
    },

    drawDataLabels: function () {
      const series = this,
        data = series.data,
        labelDistance = series.options.dataLabels.distance,
        leftSide,
        sign,
        point,
        i = data.length;

      series.center
