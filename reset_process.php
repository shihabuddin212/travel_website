<?php
session_start();
require 'vendor/autoload.php';
require 'config/db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    // Check if email exists in database
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // Generate reset token
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        // Store token in database
        $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, reset_expires = ? WHERE email = ?");
        $stmt->execute([$token, $expires, $email]);

        // Send email using PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Update with your SMTP host
            $mail->SMTPAuth = true;
            $mail->Username = 'your-email@gmail.com'; // Update with your email
            $mail->Password = 'your-app-password'; // Update with your app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('your-email@gmail.com', 'BD Adventures');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $resetLink = "http://localhost/travel-website-main/reset_password.php?token=" . $token;
            $mail->Body = "Click the following link to reset your password: <a href='$resetLink'>Reset Password</a>";

            $mail->send();
            $_SESSION['message'] = 'Reset link has been sent to your email';
            $_SESSION['message_type'] = 'success';
        } catch (Exception $e) {
            $_SESSION['message'] = 'Error sending email: ' . $mail->ErrorInfo;
            $_SESSION['message_type'] = 'error';
        }
    } else {
        $_SESSION['message'] = 'Email not found';
        $_SESSION['message_type'] = 'error';
    }
    
    header('Location: forgot_password.php');
    exit();
} 