/***************************************************************
 * Set the defaults for DataTables initialisation             *
 ***************************************************************/
$.extend( true, $.fn.dataTable.defaults, {
	"sDom":
		"<'row'<'col-xs-6'l><'col-xs-6'f>r>"+ // Layout template for the table control elements
		"t"+ // The table itself
		"<'row'<'col-xs-6'i><'col-xs-6'p>>", // Layout template for the table information and pagination elements
	"oLanguage": { // Configuration for the language and text used in the table
		"sLengthMenu": "_MENU_ Registros" // Text for the length menu, allowing users to select the number of records per page
	}
} );


/**************************************************************************
 * Default class modification                                              *
 **************************************************************************/
$.extend( $.fn.dataTableExt.oStdClasses, { // Extend the default classes used by DataTables
	"sWrapper": "dataTables_wrapper form-inline", // Wrapper class for the table and its controls
	"sFilterInput": "form-control input-sm", // Class for the filter input element
	"sLengthSelect": "form-control input-sm" // Class for the length select element
} );


/*******************************************************************************************
 * In DataTables 1.10, use the pagination renderers to draw the Bootstrap paging, instead *
 * of using a custom plugin                                                                 *
 *******************************************************************************************/
if ( $.fn.dataTable.Api ) { // Check if DataTables 1.10 or higher is being used
	$.fn.dataTable.defaults.renderer = 'bootstrap'; // Set the default renderer to 'bootstrap'
	$.fn.dataTable.ext.renderer.pageButton.bootstrap = function ( settings, host, idx, buttons, page, pages ) { // Define the 'bootstrap' renderer for the pagination buttons
		var api = new $.fn.dataTable.Api( settings ); // Create a new DataTables API instance
		var classes = settings.oClasses; // Get the classes object for the table
		var lang = settings.oLanguage.oPaginate; // Get the language object for the pagination text
		var btnDisplay, btnClass;


		var attach = function( container, buttons ) { // Function to attach the pagination buttons to the container
			var i, ien, node, button;
			var clickHandler = function ( e ) { // Function to handle the button click event
				e.preventDefault();
				if ( e.data.action !== 'ellipsis' ) { // If the button is not an ellipsis (for indicating a page range)
					api.page( e.data.action ).draw( false ); // Change the page and redraw the table
				}
			};


			for ( i=0, ien=buttons.length ; i<ien ; i++ ) { // Loop through the buttons
				button = buttons[i];


				if ( $.isArray( button ) ) { // If the button is an array (for indicating a page range)
					attach( container, button ); // Recursively attach the buttons in the array
				}
				else {
					btnDisplay = ''; // Initialize the button display text
					btnClass = ''; // Initialize the button class


					switch ( button ) { // Set the button display text and class based on the button type
						case 'ellipsis':
							btnDisplay = '&hellip;';
							btnClass = 'disabled';
							break;


						case 'first':
							btnDisplay = lang.sFirst;
							btnClass = button + (page > 0 ?
								'' : ' disabled');
							break;


						case 'previous':
							btnDisplay = lang.sPrevious;
							btnClass = button + (page > 0 ?
								'' : ' disabled');
							break;


						case 'next':
							btnDisplay = lang.sNext;
							btnClass = button + (page < pages-1 ?
								
