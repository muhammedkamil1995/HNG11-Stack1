<?php
header('Content-Type: application/json');

// Get the visitor's name from the query parameter
$visitor_name = isset($_GET['visitor_name']) ? $_GET['visitor_name'] : 'Guest';

// Get the client's IP address
$client_ip = $_SERVER['REMOTE_ADDR'];

// For the purpose of this task, we'll set a static location and temperature
$location = "New York";
$temperature = 11; // in Celsius

// Create the response array
$response = array(
    "client_ip" => $client_ip,
    "location" => $location,
    "greeting" => "Hello, $visitor_name!, the temperature is $temperature degrees Celsius in $location"
);


// Output the JSON response
echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);