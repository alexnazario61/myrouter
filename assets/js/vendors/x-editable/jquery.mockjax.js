/*!
 * MockJax - jQuery Plugin to Mock Ajax requests
 *
 * Version:  1.5.0pre
 * Released:
 * Home:   http://github.com/appendto/jquery-mockjax
 * Author:   Jonathan Sharp (http://jdsharp.com)
 * License:  MIT,GPL
 *
 * Copyright (c) 2011 appendTo LLC.
 * Dual licensed under the MIT or GPL licenses.
 * http://appendto.com/open-source-licenses
 */
(function($) {
	var _ajax = $.ajax,
		mockHandlers = [],
		CALLBACK_REGEX = /=\?(&|$)/, 
		jsc = (new Date()).getTime();

	// Parse the given XML string.
	function parseXML(xml) {
		if ( window['DOMParser'] == undefined && window.ActiveXObject ) {
			DOMParser = function() { };
			DOMParser.prototype.parseFromString = function( xmlString ) {
		
