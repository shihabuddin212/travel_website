<?php
session_start();
require 'config/db.php';

// Get JSON data from request
$jsonData = file_get_contents('php://input');
$userData = json_decode($jsonData, true);

try {
    // Check if user already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$userData['email']]);
    $existingUser = $stmt->fetch();

    if ($existingUser) {
        // Update existing user
        $stmt = $pdo->prepare("
            UPDATE users 
            SET firebase_uid = ?, 
                first_name = ?, 
                last_name = ?, 
                phone = ?,
                updated_at = CURRENT_TIMESTAMP
            WHERE email = ?
        ");
        
        $stmt->execute([
            $userData['firebase_uid'],
            $userData['first_name'],
            $userData['last_name'],
            $userData['phone'],
            $userData['email']
        ]);

        $_SESSION['user_id'] = $existingUser['id'];
    } else {
        // Insert new user
        $stmt = $pdo->prepare("
            INSERT INTO users (
                firebase_uid, 
                first_name, 
                last_name, 
                email, 
                phone, 
                user_type,
                password
            ) VALUES (?, ?, ?, ?, ?, 'user', '')
        ");
        
        $stmt->execute([
            $userData['firebase_uid'],
            $userData['first_name'],
            $userData['last_name'],
            $userData['email'],
            $userData['phone']
        ]);

        $_SESSION['user_id'] = $pdo->lastInsertId();
    }

    $_SESSION['user_type'] = 'user';
    
    echo json_encode([
        'success' => true,
        'user_id' => $_SESSION['user_id']
    ]);

} catch (PDOException $e) {
    error_log("Error saving Firebase user: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error' => 'Database error'
    ]);
} 