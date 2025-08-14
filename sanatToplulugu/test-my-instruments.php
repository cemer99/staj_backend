<?php

// Bu basit test scripti, /my-instruments endpoint'ini test eder
// Token değerini güncellemeyi unutmayın!

$token = '14|47L5HH3mUGSYlAIMXCRDVgeTG2kyVsGJlIdGzrl06d642a46';
$url = 'http://localhost:8000/api/my-instruments';

// cURL kullanarak istek oluştur
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: application/json',
    'Content-Type: application/json',
    'Authorization: Bearer ' . $token
]);

// İsteği gönder ve yanıtı al
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Kodlama bilgisini görüntüle
$encoding = mb_detect_encoding($response, 'UTF-8, ISO-8859-1, ISO-8859-9, ASCII', true);
echo "Detected encoding: " . $encoding . "\n\n";

// JSON yanıtını çözümle
$jsonResponse = json_decode($response, true);

// Hata kontrolü
if (json_last_error() !== JSON_ERROR_NONE) {
    echo "JSON parse error: " . json_last_error_msg() . "\n";
    echo "Raw response: \n" . $response . "\n";
    exit;
}

// Başarı durumunu kontrol et
if ($httpCode >= 200 && $httpCode < 300) {
    echo "SUCCESS (HTTP code: $httpCode)\n";
} else {
    echo "ERROR (HTTP code: $httpCode)\n";
}

// Yanıtı formatlı olarak görüntüle
echo "Response:\n";
echo json_encode($jsonResponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
