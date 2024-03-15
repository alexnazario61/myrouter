$(function(){ // Document ready shorthand

   // Set the default URL for all editable elements
   $.fn.editable.defaults.url = '/post'; 

   // Enable/Disable functionality for the #enable button
   $('#enable').click(function() {
       $('#user .editable').editable('toggleDisabled');
   });    

   // Define editable elements with specific configurations
   $('#username').editable({
       url: '/post',
       type: 'text',
       pk: 1,
       name: 'username',
       title: 'Enter username'
   });

   // ... More editable elements with specific configurations

   // Address editable element with custom display and validation
   $('#address').editable({
       url: '/post',
       value: {
           city: "Moscow", 
           street: "Lenina", 
           building: "12"
       },
       validate: function(value) {
           if(value.city == '') return 'city is required!'; 
       },
       display: function(value) {
           if(!value) {
               $(this).empty();
               return; 
           }
           var html = '<b>' + $('<div>').text(value.city).html() + '</b>, ' + $('<div>').text(value.street).html() + ' st., bld. ' + $('<div>').text(value.building).html();
           $(this).html(html); 
       }
   });

   // Event handler for the hidden event on editable elements
   $('#user .editable').on('hidden', function(e, reason){
       if(reason === 'save' || reason === 'nochange') {
           var $next = $(this).closest('tr').next().find('.editable');
           if($('#autoopen').is(':checked')) {
               setTimeout(function() {
                   $next.editable('show');
               }, 300); 
           } else {
               $next.focus();
           } 
       }
   });

});
