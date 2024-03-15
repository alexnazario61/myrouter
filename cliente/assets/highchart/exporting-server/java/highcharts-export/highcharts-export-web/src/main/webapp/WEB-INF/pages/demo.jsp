<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%>
<%@ taglib prefix="spring" uri="http://www.springframework.org/tags"%>
<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Highcharts export server</title>
<link rel="stylesheet" type="text/css" href="resources/css/demo.css" />
<link rel="stylesheet" type="text/css"
	href="resources/lib/codemirror/codemirror.css" />
<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
<script src="resources/lib/codemirror/codemirror.js"></script>
<script src="resources/lib/codemirror/mode/javascript/javascript.js"></script>
<script src="resources/lib/codemirror/mode/xml/xml.js"></script>
<script>
	// Document ready function, executed when the DOM is fully loaded
	$(document).ready(function() {

		// Function to enable CodeMirror editor for a given textarea
	
