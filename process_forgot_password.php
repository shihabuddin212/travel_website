<?php
session_start();
require 'vendor/autoload.php';
require 'config/db.php';
require 'helpers/EmailHelper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    try {
        // Check if email exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            // Generate token
            $token = bin2hex(random_bytes(32));
            // Set expiry to 24 hours from now
            $expires = date('Y-m-d H:i:s', strtotime('+24 hours'));
            
            // Debug output
            error_log("Generated token: " . $token);
            error_log("Expiry time: " . $expires);
            
            // First clear any existing tokens
            $stmt = $pdo->prepare("
                UPDATE users 
                SET reset_token = NULL, 
                    reset_expires = NULL 
                WHERE id = ?
            ");
            $stmt->execute([$user['id']]);
            
            // Set new token
            $stmt = $pdo->prepare("
                UPDATE users 
                SET reset_token = ?, 
                    reset_expires = ? 
                WHERE id = ?
            ");
            $stmt->execute([$token, $expires, $user['id']]);
            
            // Verify token was saved
            $stmt = $pdo->prepare("SELECT reset_token, reset_expires FROM users WHERE id = ?");
            $stmt->execute([$user['id']]);
            $updatedUser = $stmt->fetch();
            
            error_log("Saved token: " . $updatedUser['reset_token']);
            error_log("Saved expiry: " . $updatedUser['reset_expires']);

            // Send email
            $emailHelper = new EmailHelper();
            $emailHelper->sendPasswordResetEmail($email, $token);

            $_SESSION['message'] = "Password reset instructions have been sent to your email.";
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = "If that email exists in our system, you will receive reset instructions.";
            $_SESSION['message_type'] = 'info';
        }
    } catch (Exception $e) {
        error_log("Error in reset process: " . $e->getMessage());
        $_SESSION['message'] = "An error occurred. Please try again later.";
        $_SESSION['message_type'] = 'error';
    }
    
    header('Location: forgot_password.php');
    exit();
}

// If not POST request, redirect to forgot password page
if (!isset($_POST['email'])) {
    header('Location: forgot_password.php');
    exit();
} 