<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Highcharts export server</title>
    <link rel="stylesheet" type="text/css" href="<c:url value="/resources/css/demo.css" />" />
    <link rel="stylesheet" type="text/css" href="<c:url value="/resources/lib/codemirror/codemirror.css" />" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<c:url value="/resources/lib/codemirror/codemirror.js" />"></script>
    <script src="<c:url value="/resources/lib/codemirror/mode/javascript/javascript.js" />"></script>
    <script src="<c:url value="/resources/lib/codemirror/mode/xml/xml.js" />"></script>
    <script src="<c:url value="/resources/js/demo.js" />"></script>
</head>
<body>
    <div id="top">
        <a href="<c:url value="http://www.highcharts.com" />" title="Highcharts Home Page" id="logo"><img alt="Highcharts Home Page" src="<c:url value="/resources/Highcharts-icon-160px.png" />" border="0"></a>
        <h1>Highcharts Export Server</h1>
    </div>
    <div id="wrap">
        <form id="exportForm" action="." method="POST">
            <p>Use this page to experiment with the different options.</p>
            <div id="options">
                <label for="options">Options</label>
                <div id="oneline" class="info">Specify here your Highcharts configuration object.</div>
                <textarea id="options" name="options" rows="12" cols="30">
{
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    series: [
        {
            data: [29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]
        }
    ]
}
                </textarea>
            </div>
            <div id="svg"></div>
            <label for="type">Image file format</label>
            <select name="type">
                <option value="image/png">image/png</option>
                <option value="image/jpeg">image/jpeg</option>
                <option value="image/svg+xml">image/svg+xml</option>
                <option value="application/pdf">application/pdf</option>
            </select>
            <br>
            <label for="width">Width</label>
            <div class="info">The exact pixel width of the exported image. Defaults to chart.width or 600px. Maximum width is set to 2000px</div>
            <input id="width" name="width" type="text" value="">
            <br>
            <label for="scale">Scale</label>
            <div class="info">Give in a scaling factor for a higher image resolution. Maximum scaling is set to 4x. Remember that the width parameter has a higher precedence over scaling.</div>
            <input id="scale" name="scale" type="text" value="">
            <br>
            <label for="constructor">Constructor</label>
            <div class="info">
                This will be either 'Chart' or 'StockChart' depending on if you want a Highcharts or an HighStock chart.
            </div>
            <select name="constr">
                <option value="Chart">Chart</option>
                <option value="StockChart">StockChart</option>
            </select>
            <br>
            <label for="callback">Callback</label>
            <div id="oneline" class="info">The callback will be fired after the chart is created.</div>
            <textarea id="callback" name="callback" rows="12" cols="30">
function(chart) {
    chart.renderer.arc(200, 150, 100, 50, -Math.PI, 0).attr({
        fill : '#FCFFC5',
        stroke : 'black',
        'stroke-width' : 1
    }).add();
}
                </textarea>
            <input id="submit" type="submit" value="Generate Image">
        </form>
    </div>
    <div id="toggle">
        <label for="svg">Svg Content</label>
        <div id="oneline
