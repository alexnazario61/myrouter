/**
 * Dark blue theme for Highcharts JS
 * @author Torstein Hønsi
 */

(function (Highcharts) {
  'use strict';

  Highcharts.theme = {
    // Define custom colors for the charts
    colors: [...],

    // Configuration for the chart container
    chart: {
      // Background color and border properties
      backgroundColor: {...},
      borderColor: '#000000',
      borderWidth: 2,
      // Additional class name for the container
      className: 'dark-container',
      // Plot background, border, and other properties
      plotBackgroundColor: 'rgba(255, 255, 255, .1)',
      plotBorderColor: '#CCCCCC',
      plotBorderWidth: 1,
    },

    // Configuration for the chart title and subtitle
    title: {...},
    subtitle: {...},

    // Configuration for the x and y axes
    xAxis: {...},
    yAxis: {...},

    // Tooltip configuration
    tooltip: {...},

    // Toolbar configuration
    toolbar: {...},

    // Plot options for different chart types
    plotOptions: {...},

    // Legend configuration
    legend: {...},

    // Credits configuration
    credits: {...},

    // Labels configuration
    labels: {...},

    // Navigation configuration
    navigation: {...},

    // Configuration for scroll charts
    rangeSelector: {...},
    navigator: {...},
    scrollbar: {...},

    // Additional special color definitions
    legendBackgroundColor: 'rgba(0, 0, 0, 0.5)',
    legendBackgroundColorSolid: 'rgb(35, 35, 70)',
    dataLabelsColor: '#444',
    textColor: '#C0C0C0',
    maskColor: 'rgba(255,255,255,0.3)',
  };

  // Apply the theme to Highcharts
  var highchartsOptions = Highcharts.setOptions(Highcharts
