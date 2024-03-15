/**
 * Grid theme for Highcharts JS
 * This theme defines various visual properties for Highcharts charts, such as colors,
 * font styles, and grid line widths. It can be applied to customize the appearance of charts.
 * @author Torstein Hønsi
 */

// Set the Highcharts theme object with various visual properties
Highcharts.theme = {
    // Define an array of colors to be used in the chart
    colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
    chart: {
        // Define the background color using a linear gradient
        backgroundColor: {
            linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
            stops: [
                [0, 'rgb(255, 255, 255)'],
                [1, 'rgb(240, 240, 255)']
            ]
        },
        // Set the border width for the chart
        borderWidth: 2,
        // Define the plot background color
        plotBackgroundColor: 'rgba(255, 255, 255, .9)',
        // Enable plot shadows
        plotShadow: true,
        // Set the plot border width
        plotBorderWidth: 1
    },
    title: {
        // Define the title style
        style: {
            // Set the color to black
            color: '#000',
            // Use a bold font with the specified size and family
            font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
        }
    },
    subtitle: {
        style: {
            // Set the color to a dark gray
            color: '#666666',
            // Use a bold font with the specified size and family
            font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
        }
    },
    xAxis: {
        // Set the grid line width
        gridLineWidth: 1,
        // Define the line color
        lineColor: '#000',
        // Define the tick color
        tickColor: '#000',
        // Define the labels style
        labels: {
            style: {
                // Set the color to black
                color: '#000',
                // Use the specified font size, family, and style
                font: '11px Trebuchet MS, Verdana, sans-serif'
            }
        },
        // Define the title style
        title: {
            style: {
                // Set the color to a darker gray
                color: '#333',
                // Use a bold font
