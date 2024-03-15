/*
  Highcharts funnel module, Beta

 (c) 2010-2012 Torstein Hønsi

 License: www.highcharts.com/license
*/
(function (d) {
  var u = d.getOptions().plotOptions,
    p = d.seriesTypes,
    D = d3.merge,
    B = function () {},
    z = d.each;

  u.funnel = D(u.pie, {
    center: ["50%", "50%"],
    width: "90%",
    neckWidth: "30%",
    height: "100%",
    neckHeight: "25%",
    dataLabels: {
      connectorWidth: 1,
      connectorColor: "#606060"
    },
    size: !0,
    states: {
      select: {
        color: "#C0C0C0",
        borderColor: "#000000",
        shadow: !1
      }
    }
  });

  p.funnel = d.extendClass(p.pie, {
    type: "funnel",
    animate: B,
    translate: function () {
      var a = function (k, a) {
          return /%$/.test(k) ? a * parseInt(k, 10) / 100 : parseInt(k, 10);
        },
        g = 0,
        e = this.chart,
        f = e.plotWidth,
        e = e.plotHeight,
        h = 0,
        c = this.options,
        C = c.center,
        b = a(C[0], f),
        d = a(C[0], e),
        p = a(c.width, f),
        i,
        q,
        j = a(c.height, e),
        r = a(c.neckWidth, f),
        s = a(c.neckHeight, e),
        v = j - s,
        a = this.data,
        w,
        x,
        u = c.dataLabels.position === "left" ? 1 : 0,
        y,
        m,
        A,
        n,
        l,
        t,
        o;

      this.getWidthAt = q = function (k) {
        return k > j - s || j === s ? r : r + (p - r) * ((j - s - k) / (j - s));
      };

      this.getX = function (k, a) {
        return b + (a ? -1 : 1) * (q
