<?php
session_start();
require 'config/db.php';

header('Content-Type: application/json');

try {
    // Get POST data
    $jsonData = file_get_contents('php://input');
    $userData = json_decode($jsonData, true);

    // Validate required data
    if (!isset($userData['email']) || !isset($userData['firebase_uid'])) {
        throw new Exception('Missing required user data');
    }

    // Begin transaction
    $pdo->beginTransaction();

    // Check if user exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? OR firebase_uid = ?");
    $stmt->execute([$userData['email'], $userData['firebase_uid']]);
    $existingUser = $stmt->fetch();

    if ($existingUser) {
        // Update existing user
        $stmt = $pdo->prepare("
            UPDATE users 
            SET 
                firebase_uid = ?,
                first_name = COALESCE(?, first_name),
                last_name = COALESCE(?, last_name),
                updated_at = CURRENT_TIMESTAMP
            WHERE id = ?
        ");
        
        $stmt->execute([
            $userData['firebase_uid'],
            $userData['first_name'],
            $userData['last_name'],
            $existingUser['id']
        ]);
        
        $userId = $existingUser['id'];
    } else {
        // Create new user
        $stmt = $pdo->prepare("
            INSERT INTO users (
                firebase_uid,
                first_name,
                last_name,
                email,
                password,
                user_type,
                created_at
            ) VALUES (?, ?, ?, ?, '', 'user', CURRENT_TIMESTAMP)
        ");
        
        $stmt->execute([
            $userData['firebase_uid'],
            $userData['first_name'],
            $userData['last_name'],
            $userData['email']
        ]);
        
        $userId = $pdo->lastInsertId();
    }

    // Set session variables
    $_SESSION['user_id'] = $userId;
    $_SESSION['user_type'] = 'user';
    $_SESSION['email'] = $userData['email'];

    // Commit transaction
    $pdo->commit();

    echo json_encode([
        'success' => true,
        'user_id' => $userId,
        'message' => 'User successfully saved'
    ]);

} catch (Exception $e) {
    // Rollback transaction on error
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    
    error_log("Firebase Auth Error: " . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'message' => 'Error processing user data: ' . $e->getMessage()
    ]);
} 