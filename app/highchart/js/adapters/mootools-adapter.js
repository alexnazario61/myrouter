<!DOCTYPE html>
<html>
<head>
    <title>My Chart</title>
    <script src="https://code.highcharts.com/highcharts.js"></script>
</head>
<body>
    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

    <script>
        // Prepare JSON data
        var data = [29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4];

        // Create the chart
        Highcharts.chart('container', {
            title: {
                text: 'My Chart'
            },
            series: [{
                data: data
            }]
        });
    </script>
</body>
</html>
