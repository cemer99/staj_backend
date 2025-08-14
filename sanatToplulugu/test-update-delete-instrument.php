<?php

// Test token
$token = "21|pz0oOtaGB5sqMyyBLgttiMFNo7odCW0X6ABI301t09ce0ff9"; // Buraya kendi access token'ınızı yerleştiriniz

// Önce enstrümanlarımızı listeleyelim mevcut ID'yi bulmak için
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/api/my-instruments");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Accept: application/json",
    "Authorization: Bearer " . $token
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Enstrüman Listesi (HTTP code: " . $httpCode . ")\n";
echo "Response:\n";
echo $response . "\n\n";

// Kullanıcıdan güncellenecek ID'yi alalım
echo "Lütfen güncellemek istediğiniz enstrümanın ID'sini girin: ";
$handle = fopen("php://stdin", "r");
$id = trim(fgets($handle));
fclose($handle);

// Şimdi enstrümanı güncelleyelim
$data = [
    "id" => (int)$id, // ID'yi integer olarak dönüştürerek gönderiyoruz
    "instrument_id" => 3 // Enstrümanı Keman olarak değiştirelim
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/api/my-instruments-update");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Accept: application/json",
    "Authorization: Bearer " . $token
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Enstrüman Güncelleme (HTTP code: " . $httpCode . ")\n";
echo "Response:\n";
echo $response . "\n";

// Şimdi bir enstrüman silelim
echo "\nLütfen silmek istediğiniz enstrümanın ID'sini girin: ";
$handle = fopen("php://stdin", "r");
$id = trim(fgets($handle));
fclose($handle);

$data = [
    "id" => (int)$id // ID'yi integer olarak dönüştürerek gönderiyoruz
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/api/my-instruments");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Accept: application/json",
    "Authorization: Bearer " . $token
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Enstrüman Silme (HTTP code: " . $httpCode . ")\n";
echo "Response:\n";
echo $response . "\n";

// Güncellenmiş listeyi tekrar görelim
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/api/my-instruments");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Accept: application/json",
    "Authorization: Bearer " . $token
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "\nGüncellenmiş Enstrüman Listesi (HTTP code: " . $httpCode . ")\n";
echo "Response:\n";
echo $response . "\n";
