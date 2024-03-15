/**
 * Skies theme for Highcharts JS
 * This theme, created by Torstein Hønsi, is applied to Highcharts charts to 
 * customize their appearance with a 'skies' design.
 */

// Set the Highcharts theme to the 'skies' theme
Highcharts.theme = {
	// Define the colors for the chart
	colors: ["#514F78", "#42A07B", "#9B5E4A", "#72727F", "#1F949A", "#82914E", "#86777F", "#42A07B"],
	chart: {
		// Apply the 'skies' class to the chart
		className: 'skies',
		// Set the border width of the chart
		borderWidth: 0,
		// Enable plot shadow
		plotShadow: true,
		// Set the plot background image
		plotBackgroundImage: '/demo/gfx/skies.jpg',
		// Define the plot background color using a linear gradient
		plotBackgroundColor: {
			linearGradient: [0, 0, 250, 500],
			stops: [
				[0, 'rgba(255, 255, 255, 1)'],
				[1, 'rgba(255, 255, 255, 0)']
			]
		},
		// Set the plot border width
		plotBorderWidth: 1
	},
	title: {
		// Style the title text
		style: {
			color: '#3E576F',
			font: '16px Lucida Grande, Lucida Sans Unicode, Verdana, Arial, Helvetica, sans-serif'
		}
	},
	subtitle: {
		style: {
			color: '#6D869F',
			font: '12px Lucida Grande, Lucida Sans Unicode, Verdana, Arial, Helvetica, sans-serif'
		}
	},
	xAxis: {
		// Set grid line width, line color, tick color, and labels color
		gridLineWidth: 0,
		lineColor: '#C0D0E0',
		tickColor: '#C0D0E0',
		labels: {
			style: {
				color: '#666',
				fontWeight: 'bold'
			}
		},
		// Style the x-axis title
		title: {
			style: {
				color: '#666',
			
