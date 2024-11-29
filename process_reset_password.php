<?php
session_start();
require 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    
    try {
        // Validate passwords match
        if ($password !== $password_confirm) {
            throw new Exception('Passwords do not match');
        }
        
        // Validate password strength
        if (strlen($password) < 8) {
            throw new Exception('Password must be at least 8 characters long');
        }
        
        // Check if token is valid and not expired
        $stmt = $pdo->prepare("
            SELECT id, email 
            FROM users 
            WHERE reset_token = ? 
            AND reset_expires > NOW()
        ");
        $stmt->execute([$token]);
        $user = $stmt->fetch();
        
        if (!$user) {
            throw new Exception('Invalid or expired reset token');
        }
        
        // Update password and clear reset token
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("
            UPDATE users 
            SET password = ?, 
                reset_token = NULL, 
                reset_expires = NULL 
            WHERE id = ?
        ");
        $stmt->execute([$password_hash, $user['id']]);
        
        // Log the user in
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        
        $_SESSION['message'] = 'Password has been reset successfully.';
        $_SESSION['message_type'] = 'success';
        
        // Redirect to profile page
        header('Location: profile.php');
        exit();
        
    } catch (Exception $e) {
        $_SESSION['message'] = $e->getMessage();
        $_SESSION['message_type'] = 'error';
        header('Location: reset_password.php?token=' . urlencode($token));
        exit();
    }
}

// If not POST request, redirect to forgot password page
header('Location: forgot_password.php');
exit();