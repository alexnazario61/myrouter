(function (Highcharts) {
    var seriesTypes = Highcharts.seriesTypes,
        each = Highcharts.each;

    seriesTypes.heatmap = Highcharts.extendClass(seriesTypes.map, {
        colorKey: 'z',
        pointArrayMap: ['y', 'z'],

        translate: function () {
            var series = this,
                options = series.options,
                dataMin = Number.MAX_VALUE,
                dataMax = Number.MIN_VALUE;

            series.generatePoints();

            each(series.data, function (point) {
                var x = point.x,
                    y = point.y,
                    value = point.z,
                    xPad = (options.colsize || 1) / 2,
                    yPad = (options.rowsize || 1) / 2;

                if (typeof options.colsize !== 'number' || options.colsize <= 0) {
                    console.error('options.colsize must be a positive number');
                    return;
                }

                if (typeof options.rowsize !== 'number' || options.rowsize <= 0) {
                    console.error('options.rowsize must be a positive number');
                    return;
                }

                if (typeof value !== 'number') {
                    console.error('point.z must be a number');
                    return;
                }

                point.path = [
                    'M', x - xPad, y - yPad,
                    'L', x + xPad, y
