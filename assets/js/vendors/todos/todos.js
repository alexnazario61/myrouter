// Attach the isBound function to the jQuery prototype, allowing it to be called on any jQuery object
$.fn.isBound = function (type, fn) {
    // Retrieve the data associated with the type parameter from the jQuery object's data store
    var data = this.data('todos')[type];
    // If the data is undefined or has a length of 0, return false
    if (data === undefined || data.length === 0) {
        return false;
    }
    // Check if the fn parameter is in the data array and return the result
    return (-1 !== $.inArray(fn, data));
};

// Document ready function, executed when the DOM is fully loaded
$(document).ready(function () {
    // Define the runBind function, which binds event listeners to the .remove and .toggle elements
    function runBind() {
        // On click event for .remove elements
        $('.remove').on('click', function (e) {
            // Set the $currentListItem variable to the parent li element of the clicked .remove element
            $currentListItem = $(this).closest('li');
            // Remove the $currentListItem element
            $currentListItem.remove();
        });

        // On click event for .toggle elements
        $('.toggle').on('click', function (e) {
            // Set the $currentListItemLabel variable to the label element within the parent li element of the clicked .toggle element
            $currentListItemLabel = $(this).closest('li').find('label');
            // If the data attribute of $currentListItemLabel is equal to 'done'
            if ($currentListItemLabel.attr('data') == 'done') {
                // Set the data attribute to an empty string and remove the text decoration
                $currentListItemLabel.attr('data', '');
                $currentListItemLabel.css('text-decoration', 'none');
            } else {
                // Otherwise, set the data attribute to 'done' and add a line-through text decoration
                $currentListItemLabel.attr('data', 'done');
                $currentListItemLabel.css('text-decoration', 'line-through');
            }
        });
    }

    // Set the $todoList variable to the jQuery object representing the #todo-list element
    $todoList = $('#todo-list');

    // On keypress event for the #new-todo element
    $('#new-todo').keypress(function (e) {
        // If the key pressed is the Enter key
        if (e.which === EnterKey) {
            // Remove any existing event listeners from the .remove and .toggle elements
            $('.remove').off('click');
            $('.toggle').off('click');

            // Set the todos variable to the current HTML content of the $todoList element
            var todos = $todoList.html();

            // Add a new list item to the todos variable
            todos += "" +
                "<li>" +
                "<div class='view'>" +
                "<input class='toggle' type='checkbox'>" +
                "<label data=''>" + " " + $('#new-todo').val() + "</label>" +
                "<a class='remove'></a>" +
                "</div>" +
                "</li>";

            // Clear the #new-todo input field
            $(this).val('');

            // Set the HTML content of the $todoList element to the todos variable
            $todoList.html(todos);

            // Call the runBind function to bind event listeners
            runBind();

            // Show the #taskslist element
            $('#taskslist').show();
        }
    }); // end if

    // On click event for the #add-todo element
   
