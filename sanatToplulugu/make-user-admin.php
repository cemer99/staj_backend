<?php

// Bu script bir kullanıcıyı admin yapmak için kullanılır

// Veritabanı bağlantı bilgileri
$host = 'localhost';
$dbname = 'sanattoplulugu'; // Veritabanı adınız
$username = 'root';         // MySQL kullanıcı adınız
$password = '';             // MySQL şifreniz

try {
    // PDO bağlantısı oluştur
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Admin yapmak istediğiniz kullanıcının email adresi
    $userEmail = 'admin@example.com'; // Bu email adresini değiştirin
    
    // Kullanıcıyı bul
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->execute(['email' => $userEmail]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        // Kullanıcının is_admin alanını güncelle
        $updateStmt = $pdo->prepare("UPDATE users SET is_admin = 1 WHERE id = :id");
        $updateStmt->execute(['id' => $user['id']]);
        
        echo "Kullanıcı '$userEmail' başarıyla admin yapıldı.\n";
    } else {
        echo "Hata: '$userEmail' email adresiyle bir kullanıcı bulunamadı.\n";
    }
} catch (PDOException $e) {
    echo "Veritabanı hatası: " . $e->getMessage() . "\n";
}
