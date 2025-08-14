<?php
// Set your API base URL
$apiBaseUrl = 'http://localhost:8000/api';

// Endpoint for updating instrument as admin
$endpoint = '/instruments-update-admin';

// Get admin token from get-admin-token.php
$adminToken = "34|9KitS6N1Wo0HvmTM4ezaGSCzka5biuXTVVpF5XPj1e79617f"; // Kendi admin token'ınızla değiştirin

// Set your data - replace the ID with an actual instrument ID from your database
$instrumentId = 36; // Var olan bir enstrüman ID'si

// Create cURL request for form-data format
$ch = curl_init($apiBaseUrl . $endpoint);

// Set form data
$formData = [
    'id' => $instrumentId,
    'name' => "Form Data ile Güncellenen Enstrüman " . time(),
    'category' => "Yaylı",
    'description' => "Form data ile güncellendi"
];

// Set cURL options for form-data
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: application/json',
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
