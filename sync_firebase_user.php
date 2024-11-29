<?php
session_start();
require_once 'config/db.php';

// Get JSON data
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
            SET first_name = ?, 
                last_name = ?, 
                firebase_uid = ?,
                email_verified = 1
            WHERE email = ?
        ");
        $stmt->execute([
            $userData['first_name'],
            $userData['last_name'],
            $userData['firebase_uid'],
            $userData['email']
        ]);
        
        $_SESSION['user_id'] = $existingUser['id'];
    } else {
        // Insert new user
        $stmt = $pdo->prepare("
            INSERT INTO users (
                first_name, 
                last_name, 
                email, 
                firebase_uid,
                email_verified,
                user_type,
                password
            ) VALUES (?, ?, ?, ?, 1, 'user', '')
        ");
        $stmt->execute([
            $userData['first_name'],
            $userData['last_name'],
            $userData['email'],
            $userData['firebase_uid']
        ]);
        
        $_SESSION['user_id'] = $pdo->lastInsertId();
    }

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error' => 'Database error occurred'
    ]);
} 