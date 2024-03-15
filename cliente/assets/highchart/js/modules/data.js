// Data plugin for Highcharts
// (c) 2023 Coding Officer
// Last revision 1.0

function dataPlugin(chart) {
  // Check if Highcharts object is passed
  if (!(this instanceof Highcharts.Chart)) return;

  // Add series to chart
  chart.series.push({
    type: 'scatter',
    data: []
  });

  // Process data
  this.process = function(data) {
    // Clear series data
    chart.series[chart.series.length - 1].setData([]);

    // Process data
    data.forEach(function(point) {
      chart.series[chart.series.length - 1].addPoint([
        point[0],
        point[1]
      ]);
    });
  };
}

// Add dataPlugin to Highcharts namespace
Highcharts.dataPlugin = dataPlugin;
