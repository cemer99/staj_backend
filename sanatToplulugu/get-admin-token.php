<?php

// Bu script bir admin token almak için kullanılır

// Kullanıcı giriş bilgileri
$credentials = [
    "email" => "admin@example.com", // Admin kullanıcı email
    "password" => "password"        // Admin kullanıcı şifresi
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/api/login");
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

echo "Admin Login (HTTP code: " . $httpCode . ")\n";
echo "Response:\n";
echo $response . "\n";

// JSON yanıtını ayrıştır
$data = json_decode($response, true);

// Token'ı yazdır
if (isset($data['data']['token'])) {
    echo "\nAdmin access token: " . $data['data']['token'] . "\n";
    echo "\nBu token'ı test-admin-routes.php ve diğer admin endpoint testleri için kullanabilirsiniz.\n";
    echo "Not: Token her giriş yapıldığında değişir. Her seferinde yeni token almalısınız.\n";
} else {
    echo "\nAdmin token alınamadı. Lütfen e-posta ve şifre bilgilerinizi kontrol edin.\n";
    echo "Kullanıcının admin olduğundan emin olmak için make-user-admin.php script'ini çalıştırın.\n";
}
