<?php

// Test token - kendi token'ınızı buraya yazın
$token = "16|CjoQve1ifGrTkO9oqf5Vyl0P1ujfZkcFjNEHGbrwd6bedb0f";

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
    "id" => (int)$id, // ID'yi body'de gönderiyoruz - integer olarak dönüştürüyoruz
    "instrument_id" => 3 // Enstrümanı Keman (ID:3) olarak değiştir
];

echo "Gönderilecek veri: " . json_encode($data) . "\n";

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
