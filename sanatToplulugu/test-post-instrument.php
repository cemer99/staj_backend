<?php

// Test token
$token = "16|CjoQve1ifGrTkO9oqf5Vyl0P1ujfZkcFjNEHGbrwd6bedb0f"; // Buraya kendi access token'ınızı yerleştiriniz

// Önce enstrümanları listeleyelim
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/api/instruments");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Accept: application/json"
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Enstrüman Listesi (HTTP code: " . $httpCode . ")\n";
echo "Response:\n";
echo $response . "\n\n";

// Şimdi bir enstrüman ekleyelim
$data = [
    "instrument_id" => 1 // İlk enstrümanı kullanıyoruz
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/api/my-instruments");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Accept: application/json",
    "Authorization: Bearer " . $token
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Enstrüman Ekleme (HTTP code: " . $httpCode . ")\n";
echo "Response:\n";
echo $response . "\n";
