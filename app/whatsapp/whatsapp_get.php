<?php

// Validate if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get the 'phone' and 'message' parameters from the GET request
    // with proper sanitization to prevent XSS attacks
    $phone = filter_input(INPUT_GET, 'phone', FILTER_SANITIZE_NUMBER_INT);
    $message = filter_input(INPUT_GET, 'message', FILTER_SANITIZE_STRING);

    // Check if both 'phone' and 'message' parameters have values
    if ($phone !== false && $message !== false) {
        // Construct the international phone number
        $internationalPhoneNumber = '55' . $phone;

        // Construct the shell command using the yowsup-cli tool
        $shellCommand = "yowsup-cli demos -s {$internationalPhoneNumber} -m '{$message}' -c /etc/whatsapp/whatsapp.conf";

        // Execute the shell command with proper error handling
        $output = [];
        $returnValue = null;
        exec($shellCommand, $output, $returnValue);

        // Check if the command executed successfully
        if ($returnValue === 0) {
            // Display a success message
            echo "MESSAGE SENT";
        } else {
            // Display an error message
            echo "MESSAGE FAILED TO SEND";
        }
    } else {
        // Display an error message
        echo "MISSING REQUIRED PARAMETERS";
    }
} else {
    // Display an error message
    echo "INVALID REQUEST METHOD";
}

?>
