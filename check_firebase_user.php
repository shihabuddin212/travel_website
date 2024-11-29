<?php
session_start();
require 'config/db.php';

header('Content-Type: application/json');

try {
    // Get the POST data
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!$data || !isset($data['email'])) {
        throw new Exception('Invalid data received');
    }

    // Check if user exists in database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$data['email']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // User exists - log them in
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['firebase_email'] = $data['email'];
        $_SESSION['firebase_uid'] = $data['firebase_uid'];
        $_SESSION['user_type'] = $user['user_type'];
        
        echo json_encode(['success' => true, 'message' => 'Login successful']);
    } else {
        // User doesn't exist - create new account
        $pdo->beginTransaction();
        
        try {
            $stmt = $pdo->prepare("
                INSERT INTO users (
                    firebase_uid,
                    provider,
                    first_name,
                    last_name,
                    email,
                    password,
                    user_type,
                    created_at,
                    updated_at
                ) VALUES (?, 'google', ?, ?, ?, NULL, 'user', NOW(), NOW())
            ");

            $stmt->execute([
                $data['firebase_uid'],
                $data['first_name'],
                $data['last_name'],
                $data['email']
            ]);

            $userId = $pdo->lastInsertId();

            // Set session variables
            $_SESSION['user_id'] = $userId;
            $_SESSION['firebase_email'] = $data['email'];
            $_SESSION['firebase_uid'] = $data['firebase_uid'];
            $_SESSION['user_type'] = 'user';

            $pdo->commit();
            echo json_encode(['success' => true, 'message' => 'Account created and logged in']);
        } catch (Exception $e) {
            $pdo->rollBack();
            throw new Exception('Failed to create user account: ' . $e->getMessage());
        }
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
} 