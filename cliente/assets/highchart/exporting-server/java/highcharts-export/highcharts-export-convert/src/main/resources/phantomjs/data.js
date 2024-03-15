// Data plugin for Highcharts
// (c) 2023 Coding Manager
// Version 1.1

function dataPlugin(chart) {
  // Add series from data object
  chart.addSeries = function(seriesOptions) {
    const series = this.series.length ? this.series[this.series.length - 1] : null;
    const data = seriesOptions.data;

    // Check if data is defined
    if (data === undefined) {
      console.error("Data is not defined in the series options.");
      return;
    }

    // Process data
    const processedData = Array.isArray(data)
      ? data
      : data.length
      ? data.map((item) => (typeof item === "object" && "y" in item ? item : { x: item, y: null }))
      : [];

    // Add series options with processed data
    seriesOptions.data = processedData;
    chart.series.push(new Highcharts.Series(seriesOptions));
  };

  // Update series data from data object
  chart.updateSeriesData = function(seriesIndex, data) {
    // Check if series index is valid
    if (seriesIndex < 0 || seriesIndex >= this.series.length) {
      console.error("Invalid series index.");
      return;
    }

    // Process data
    const processedData = Array.isArray(data)
      ? data
      : data.length
      ? data.map((item) => (typeof item === "object" && "y" in item ? item : { x: item, y: null }))
      : [];

    // Update series data
    this.series[seriesIndex].setData(processedData);
  };
}

// Initialize the plugin
if (Highcharts) {
  Highcharts.seriesTypes.line.prototype.data = dataPlugin;
}
