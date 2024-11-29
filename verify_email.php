<?php
session_start();
require 'config/db.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    $stmt = $pdo->prepare("SELECT id FROM users WHERE verification_token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        // Update user as verified
        $stmt = $pdo->prepare("UPDATE users SET email_verified = TRUE, verification_token = NULL WHERE id = ?");
        $stmt->execute([$user['id']]);

        $_SESSION['message'] = 'Email verified successfully! You can now login.';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Invalid verification token.';
        $_SESSION['message_type'] = 'error';
    }
    
    header('Location: login.php');
    exit();
} 