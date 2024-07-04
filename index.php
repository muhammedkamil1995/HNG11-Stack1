<?php
header('Content-Type: application/json');

// Function to get the real client IP address
function getClientIp() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    } elseif (isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
        $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    } else {
        $ipaddress = 'UNKNOWN';
    }
    return $ipaddress;
}

$client_ip = getClientIp();

// Function to get the location based on IP address
function getLocation($ip) {
    // Handle localhost and IPv6 loopback addresses
    if ($ip === "::1" || $ip === "127.0.0.1" || $ip === "UNKNOWN") {
        return ["city" => "Localhost"];
    }

    $url = "http://ipinfo.io/{$ip}/json";
    $json = file_get_contents($url);
    $details = json_decode($json, true);
    return $details;
}

$location_details = getLocation($client_ip);

$location = isset($location_details['city']) ? $location_details['city'] : "Unknown";
$temperature = 11; // Static temperature for now

$visitor_name = isset($_GET['visitor_name']) ? filter_input(INPUT_GET, 'visitor_name', FILTER_SANITIZE_SPECIAL_CHARS) : 'Guest';

// Create the response array
$response = array(
    "client_ip" => $client_ip,
    "location" => $location,
    "greeting" => "Hello, $visitor_name!, the temperature is $temperature degrees Celsius in $location."
);

// Output the JSON response
echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);