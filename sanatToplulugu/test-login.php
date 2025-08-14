<?php

// Login kullanıcı bilgileri
$credentials = [
    "email" => "test@example.com", // Kendi email adresinizi girin
    "password" => "password"        // Kendi şifrenizi girin
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://localhost/sanatToplulugu/public/api/login");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($credentials));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Accept: application/json"
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Login (HTTP code: " . $httpCode . ")\n";
echo "Response:\n";
echo $response . "\n";

// JSON yanıtını ayrıştır
$data = json_decode($response, true);

// Token'ı yazdır
if (isset($data['data']['token'])) {
    echo "\nYour access token: " . $data['data']['token'] . "\n";
    echo "\nBu token'ı test-post-instrument.php dosyasında \$token değişkenine yerleştirin.\n";
} else {
    echo "\nToken alınamadı. Lütfen e-posta ve şifre bilgilerinizi kontrol edin.\n";
}
