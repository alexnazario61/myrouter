<!DOCTYPE html>
<html lang="en" xmlns:th="http://www.thymeleaf.org">
<head>
    <meta charset="UTF-8">
    <title>Highcharts Export Server</title>
    <link rel="stylesheet" type="text/css" href="/resources/css/demo.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div id="top">
        <a href="https://www.highcharts.com" title="Highcharts Home Page" id="logo">
            <img alt="Highcharts Home Page" src="/resources/Highcharts-icon-160px.png" border="0">
        </a>
        <h1>Highcharts Export Server</h1>
    </div>
    <div id="wrap">
        <h3 th:if="${message != null}">Oops..,</h3>
        <p th:if="${message != null}" th:text="${message}"></p>
    </div>
</body>
</html>
