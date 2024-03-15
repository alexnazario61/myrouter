(function (Highcharts) {
	// Save the seriesTypes object of Highcharts in a variable
	var seriesTypes = Highcharts.seriesTypes,
		// Save the each function of Highcharts in a variable
		each = Highcharts.each;

	// Extend the map series type with a new series type called heatmap
	seriesTypes.heatmap = Highcharts.extendClass(seriesTypes.map, {
		// Set the colorKey to 'z'
		colorKey: 'z',
		// Set the pointArrayMap to an array containing 'y' and 'z'
		pointArrayMap: ['y', 'z'],
		// Define the translate function
		translate: function () {
			var series = this,
				options = series.options,
				// Initialize dataMin to the maximum possible number value
				dataMin = Number.MAX_VALUE,
				// Initialize dataMax to the minimum possible number value
				dataMax = Number.MIN_VALUE;

			// Generate the points for the series
			series.generatePoints();

			// Iterate over each point in the series data array
			each(series.data, function (point) {
				var x = point.x, // Get the x value of the point
					y = point.y, // Get the y value of the point
					value = point.z, // Get the z value of the point
					xPad = (options.colsize || 1) / 2, // Calculate the x-axis padding
					yPad = (options.rowsize || 1) / 2; // Calculate the y-axis padding

				// Set the path property of the point to a square path
				point.path = [
					'M', x - xPad, y - yPad,
					'L', x + xPad, y - yPad,
					'L
