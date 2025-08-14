<?php
// Set your API base URL
$apiBaseUrl = 'http://localhost:8000/api';

// Endpoint for updating instrument as admin
$endpoint = '/instruments-update-admin';

// Get admin token
$adminToken = "34|9KitS6N1Wo0HvmTM4ezaGSCzka5biuXTVVpF5XPj1e79617f"; // Kendi admin token'ınızla değiştirin

// Set your data
$instrumentId = 36; // Var olan bir enstrüman ID'si

// Method 1: Using x-www-form-urlencoded content type
$ch = curl_init($apiBaseUrl . $endpoint);

// Form data
$formData = http_build_query([
    'id' => $instrumentId,
    'name' => 'URL Encoded Form ile Güncellenen Enstrüman ' . time(),
    'category' => 'Yaylı',
    'description' => 'URL encoded form data ile güncellendi'
]);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: application/json',
    'Content-Type: application/x-www-form-urlencoded',
    'Authorization: Bearer ' . $adminToken
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, $formData);

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
    echo $response . "\n";
    $jsonResponse = json_decode($response, true);
    if ($jsonResponse && isset($jsonResponse['success']) && $jsonResponse['success']) {
        echo "\nEnstrüman başarıyla güncellendi!\n";
    }
}

// Close cURL connection
curl_close($ch);
