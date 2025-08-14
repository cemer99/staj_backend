<?php
// Set your API base URL
$apiBaseUrl = 'http://localhost/sanatToplulugu/public/api';

// Endpoint for deleting user instrument
$endpoint = '/my-instruments-delete';

// Authorization token (replace with your actual token)
$token = 'YOUR_AUTH_TOKEN_HERE';

// Set your data - replace the ID with an actual user_instruments ID from your database
$id = 1; // Replace with a valid ID from your user_instruments table that you want to delete

// Method 1: Using JSON format for DELETE request
$ch = curl_init($apiBaseUrl . $endpoint);

// JSON data
$jsonData = json_encode([
    'id' => (int)$id
]);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json',
    'Authorization: Bearer ' . $token
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

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
