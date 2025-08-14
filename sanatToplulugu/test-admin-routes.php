<?php

// Önce normal bir kullanıcı olarak giriş yapıp token alalım
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

// Token'ı yazdır ve kaydet
if (isset($data['data']['token'])) {
    $adminToken = $data['data']['token'];
    echo "\nAdmin access token: " . $adminToken . "\n";
    
    // Bu token'ı kullanarak yeni bir enstrüman oluşturalım
    $newInstrument = [
        "name" => "Test Enstrüman " . time(), // Benzersiz olması için timestamp ekliyoruz
        "category" => "Yaylı",
        "description" => "Test açıklaması",
        "image_url" => "https://example.com/image.jpg"
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/api/instruments");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($newInstrument));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Accept: application/json",
        "Authorization: Bearer " . $adminToken
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    echo "\nYeni Enstrüman Oluşturma (HTTP code: " . $httpCode . ")\n";
    echo "Response:\n";
    echo $response . "\n";
    
    // Oluşturulan enstrümanın ID'sini alalım
    $createData = json_decode($response, true);
    if (isset($createData['data']['id'])) {
        $instrumentId = $createData['data']['id'];
        
        echo "\nEnstrüman ID: " . $instrumentId . "\n"; // ID'yi görelim
        
        // Enstrümanı güncelleyelim
        $updateInstrument = [
            "id" => $instrumentId, // ID'yi body'de gönderiyoruz
            "name" => "Güncellenmiş Test Enstrüman",
            "category" => "Yaylı",
            "description" => "Güncellenmiş test açıklaması",
            "image_url" => "https://example.com/updated-image.jpg"
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/api/instruments-update-admin");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($updateInstrument));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Accept: application/json",
            "Authorization: Bearer " . $adminToken
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        echo "\nEnstrüman Güncelleme (HTTP code: " . $httpCode . ")\n";
        echo "Response:\n";
        echo $response . "\n";
        
        // Enstrümanı silelim
        $deleteData = [
            "id" => $instrumentId
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/api/instruments-delete-admin");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($deleteData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Accept: application/json",
            "Authorization: Bearer " . $adminToken
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        echo "\nEnstrüman Silme (HTTP code: " . $httpCode . ")\n";
        echo "Response:\n";
        echo $response . "\n";
    } else {
        echo "\nEnstrüman ID'si alınamadı. Diğer testler atlanıyor.\n";
    }
} else {
    echo "\nAdmin token alınamadı. Lütfen e-posta ve şifre bilgilerinizi kontrol edin.\n";
}
