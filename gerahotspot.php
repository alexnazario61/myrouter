<?php

// Include the RouterOS API class
require('../routeros_api.class.php');

// Create a new instance of the API class
$API = new routeros_api();
$API->debug = true;

// Get the user input from the POST request
$name = $_POST['nome'];
$cpf = $_POST['cpf'];
$telephone = $_POST['ddd'] . $_POST['fone'];
$password = rand(1000, 9999);

// Build the URL for the SMS API
$smsUrl = "http://torpedus.com.br/sms/index.php?app=webservices&u=#user&p=#password&ta=pv&to=55$telephone&msg=Ol%C3%A1+$name+seu+usu%C3%A1rio+$cpf+sua+senha+$password";

// Initialize cURL
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $smsUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the cURL request
$smsResponse = curl_exec($ch);

// Close the cURL session
curl_close($ch);

// Define the server details
$ip = 'Ip from server where API is located';
$username = 'User';
$password = 'password';

// Connect to the RouterOS API
if ($API->connect($ip, $username, $password)) {
    // Add the new hotspot user
    $API->comm("/ip/hotspot/user/add", [
        "name" => $cpf,
        "password" => $password,
        "server" => "server",
        "profile" => "default",
    ]);

    // Disconnect from the RouterOS API
    $API->disconnect();
}

?>
