<?php
session_start();
require 'config/db.php';
header('Content-Type: application/json');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log function
function logMessage($message) {
    error_log(date('Y-m-d H:i:s') . " - " . $message);
}

try {
    // Log raw input
    logMessage("Raw input: " . file_get_contents('php://input'));
    
    $data = json_decode(file_get_contents('php://input'), true);
    logMessage("Decoded data: " . print_r($data, true));
    
    if (!$data || !isset($data['email']) || !isset($data['firebase_uid'])) {
        throw new Exception('Invalid data received: ' . print_r($data, true));
    }

    $pdo->beginTransaction();
    logMessage("Starting transaction");

    // Check if user exists
    $stmt = $pdo->prepare("
        SELECT * FROM users 
        WHERE email = ? OR firebase_uid = ?
    ");
    $stmt->execute([$data['email'], $data['firebase_uid']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    logMessage("User search result: " . ($user ? "Found" : "Not found"));

    if (!$user) {
        // Create new user
        $stmt = $pdo->prepare("
            INSERT INTO users (
                firebase_uid,
                provider,
                first_name,
                last_name,
                email,
                user_type,
                created_at,
                updated_at
            ) VALUES (?, ?, ?, ?, ?, 'user', NOW(), NOW())
        ");

        $nameParts = explode(' ', $data['name']);
        $firstName = $nameParts[0] ?? 'Firebase';
        $lastName = isset($nameParts[1]) ? implode(' ', array_slice($nameParts, 1)) : 'User';

        logMessage("Attempting to insert new user: " . $data['email']);
        
        $stmt->execute([
            $data['firebase_uid'],
            'google',
            $firstName,
            $lastName,
            $data['email']
        ]);

        $_SESSION['user_id'] = $pdo->lastInsertId();
        logMessage("New user created with ID: " . $_SESSION['user_id']);
    } else {
        $_SESSION['user_id'] = $user['id'];
        logMessage("Using existing user ID: " . $user['id']);
        
        // Update the user's Firebase UID if it's not
        $stmt = $pdo->prepare("
            UPDATE users 
            SET firebase_uid = ? 
            WHERE id = ?
        ");
        $stmt->execute([$data['firebase_uid'], $user['id']]);
    }

    // Set session variables
    $_SESSION['firebase_email'] = $data['email'];
    $_SESSION['firebase_uid'] = $data['firebase_uid'];
    $_SESSION['provider'] = 'google';

    $pdo->commit();
    
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log("Firebase sync error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
} 