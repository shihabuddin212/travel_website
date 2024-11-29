<?php
require_once '../config/db.php';
require_once '../config/session.php';

$data = json_decode(file_get_contents('php://input'), true);

try {
    $stmt = $pdo->prepare("INSERT INTO users (name, email, photo_url, uid, provider) 
                          VALUES (:name, :email, :photo_url, :uid, :provider)
                          ON DUPLICATE KEY UPDATE 
                          name = :name, photo_url = :photo_url");
    
    $stmt->execute([
        ':name' => $data['name'],
        ':email' => $data['email'],
        ':photo_url' => $data['photoURL'],
        ':uid' => $data['uid'],
        ':provider' => $data['provider']
    ]);

    $_SESSION['user_id'] = $data['uid'];
    echo json_encode(['success' => true]);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?> 