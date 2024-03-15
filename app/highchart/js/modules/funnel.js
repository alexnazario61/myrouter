/*
  Highcharts funnel module, Beta
 (c) 2010-2012 Torstein Hønsi
 License: www.highcharts.com/license
*/
(function (d) {
  var utils = d.getOptions().plotOptions,
    plotOptions = d.seriesTypes,
    merge = d.merge,
    each = d.each,
    extendClass = d.extendClass,
    translate = function () {};

  utils.funnel = merge(utils.pie, {
    center: ["50%", "50%"],
    width: "90%",
    neckWidth: "30%",
    height: "100%",
    neckHeight: "25%",
    dataLabels: {
      connectorWidth: 1,
      connectorColor: "#606060",
    },
    size: true,
    states: {
      select: {
        color: "#C0C0C0",
        borderColor: "#000000",
        shadow: false,
      },
    },
  });

  plotOptions.funnel = extendClass(plotOptions.pie, {
    type: "funnel",
    animate: translate,
    translate: function () {
      var getWidthAt = function (k) {
          var a = this.chart.plotWidth,
            b = this.chart.plotHeight;
          return "%$".test(k)
            ? (a * parseInt(k, 10)) / 100
            : parseInt(k, 10);
        },
        getX = function (k, a) {
          var q = this.getWidthAt(k);
          return this.center[0] + (a ? -1 : 1) * (q / 2 + this.options.dataLabels.distance);
        },
        i,
        q,
        j,
        r,
        s,
        v,
        w,
        x,
        u = this.options.dataLabels.position === "left" ? 1 : 0,
        y,
        m,
        A,
        n,
        l,
        t,
        o;

      this.getWidthAt = getWidthAt;
      this.center = [this.center[0], this.center[1], this.options.height];
      this.centerX = this.center[0];

      each(this.data, function (a) {
        o = null;
        x = this.center[2] / this.data.length;
        m = this.center[1] - x / 2 + this.plotHeight / 2;
        l = m + x;
        i = this.getWidthAt(m);
        return (
          (this.yAxis.reversed
            ? (j = this.yAxis.toPixels(this.y))
            : (j = this.yAxis.toPixels(this.y) - this.plotHeight)),
          j > this.plotHeight - i
            ? ((i = this.getWidthAt(this.plotHeight - i)),
              (m = this.plot
