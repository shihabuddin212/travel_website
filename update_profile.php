<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_POST['update_profile'])) {
    header('Location: profile.php');
    exit();
}

try {
    $user_id = $_SESSION['user_id'];
    
    // Start transaction
    $pdo->beginTransaction();
    
    // Update basic info
    $updateFields = [];
    $params = [];
    
    // Validate and sanitize inputs
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $phone = trim($_POST['phone']);
    
    if (!empty($first_name)) {
        $updateFields[] = "first_name = ?";
        $params[] = $first_name;
    }
    
    if (!empty($last_name)) {
        $updateFields[] = "last_name = ?";
        $params[] = $last_name;
    }
    
    if (!empty($phone)) {
        $updateFields[] = "phone = ?";
        $params[] = $phone;
    }
    
    // Handle password change
    if (!empty($_POST['current_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
        // Verify current password
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();
        
        if (!$user || !password_verify($_POST['current_password'], $user['password'])) {
            throw new Exception("Current password is incorrect");
        }
        
        if ($_POST['new_password'] !== $_POST['confirm_password']) {
            throw new Exception("New passwords do not match");
        }
        
        if (strlen($_POST['new_password']) < 6) {
            throw new Exception("New password must be at least 6 characters long");
        }
        
        $updateFields[] = "password = ?";
        $params[] = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    }
    
    if (!empty($updateFields)) {
        $params[] = $user_id;
        $sql = "UPDATE users SET " . implode(", ", $updateFields) . ", updated_at = NOW() WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        
        if ($stmt->rowCount() > 0) {
            $pdo->commit();
            $_SESSION['success'] = "Profile updated successfully!";
        } else {
            throw new Exception("No changes were made");
        }
    } else {
        throw new Exception("No data provided for update");
    }
    
} catch (Exception $e) {
    $pdo->rollBack();
    $_SESSION['error'] = "Update failed: " . $e->getMessage();
}

// Redirect back to profile page
header('Location: profile.php');
exit();
?> 