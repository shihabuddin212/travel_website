<?php
session_start();
require 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    
    try {
        // Get user from database
        $stmt = $pdo->prepare("SELECT id, email, password, first_name, last_name, user_type FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['user_type'] = $user['user_type'];
            
            // Check if the user is an admin
            if ($user['user_type'] === 'admin') {
                header('Location: admin_panel.php');
            } else {
                header('Location: dashboard.php');
            }
            exit();
        } else {
            $_SESSION['error'] = "Invalid email or password";
            header('Location: login.php');
            exit();
        }
    } catch (PDOException $e) {
        error_log($e->getMessage());
        $_SESSION['error'] = "An error occurred. Please try again later.";
        header('Location: login.php');
        exit();
    }
}

// If not POST request, redirect to login
header('Location: login.php');
exit();
?>