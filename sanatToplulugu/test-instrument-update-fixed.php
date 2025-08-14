<?php
// Set your API base URL
$apiBaseUrl = 'http://localhost/sanatToplulugu/public/api';

// Endpoint for updating user instrument
$endpoint = '/my-instruments-update';

// Set your data - replace the ID with an actual user_instruments ID from your database
$data = [
    'id' => 1, // Replace with a valid ID from your user_instruments table
    'instrument_id' => 2, // Replace with a valid instrument ID
];

// Create cURL request
$ch = curl_init($apiBaseUrl . $endpoint);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json'
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Execute cURL request
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Check for errors
if (curl_errno($ch)) {
    echo 'cURL error: ' . curl_error($ch) . "\n";
} else {
    // Print the response
    echo "HTTP Status Code: $httpCode\n";
    echo "Response Body:\n";
    $jsonResponse = json_decode($response, true);
    echo json_encode($jsonResponse, JSON_PRETTY_PRINT);
}

// Close cURL connection
curl_close($ch);
