<?php

// Admin token'ı (get-admin-token.php'den aldığınız token ile değiştirin)
$adminToken = "32|Lhdk6PECjFNZkshzFdRbyzF6HygpQlPgPrAkj42Ee4ad2c24";

// Enstrüman ID'si (test-admin-routes.php'den oluşturulan bir enstrümanın ID'si)
$instrumentId = 36;

// Enstrümanı güncellemek için
$updateData = [
    "name" => "Güncellenmiş Test Enstrüman",
    "category" => "Yaylı",
    "description" => "Güncellenmiş açıklama"
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/api/instruments/{$instrumentId}");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($updateData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Accept: application/json",
    "Authorization: Bearer {$adminToken}"
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Enstrüman Güncelleme (HTTP code: " . $httpCode . ")\n";
echo "Response:\n";
echo $response . "\n";

// Enstrümanı silmek için
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/api/instruments/{$instrumentId}");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Accept: application/json",
    "Authorization: Bearer {$adminToken}"
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "\nEnstrüman Silme (HTTP code: " . $httpCode . ")\n";
echo "Response:\n";
echo $response . "\n";
