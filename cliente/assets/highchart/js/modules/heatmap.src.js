(function (Highcharts) {
  // Save the seriesTypes object of Highcharts in a variable
  const seriesTypes = Highcharts.seriesTypes;
  const each = Highcharts.each;

  // Extend the map series type with a new series type called heatmap
  seriesTypes.heatmap = Highcharts.extendClass(seriesTypes.map, {
    // Set the colorKey to 'z'
    colorKey: 'z',

    // Set the pointArrayMap to an array containing 'y' and 'z'
    pointArrayMap: ['y', 'z'],

    // Define the translate function
    translate: function () {
      const series = this;
      const options = series.options;
      let dataMin = Number.MAX_VALUE;
      let dataMax = Number.MIN_VALUE;

      // Generate the points for the series
      series.generatePoints();

      // Iterate over each point in the series data array
      each(series.data, function (point) {
        const x = point.x, // Get the x value of the point
              y = point.y, // Get the y value of the point
              value = point.z, // Get the z value of the point
              xPad = (options.colsize || 1) / 2, // Calculate the x-axis padding
              yPad = (options.rowsize || 1) / 2; // Calculate the y-axis padding

        // Set the path property of the point to a square path
        point.path = [
          'M', x - xPad, y - yPad,
          'L', x + xPad, y - yPad,
          'L', x + xPad, y + yPad,
          'L', x - xPad, y + yPad,
          'Z'
        ];

        // Update the dataMin and dataMax values
        if (value < dataMin) {
          dataMin = value;
        }
        if (value > dataMax) {
          dataMax = value;
        }
      });

      // Set the dataMin and dataMax values for the series
      series.dataMin = dataMin;
      series.dataMax = dataMax;
    }
  });
}(Highcharts));
