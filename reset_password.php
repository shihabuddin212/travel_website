<?php
session_start();
$pageTitle = "Reset Password - BD Adventures";
include 'components/header.php';
include 'components/nav.php';
require 'config/db.php';

// Check if token is valid
$token = $_GET['token'] ?? '';
$tokenValid = false;

if ($token) {
    try {
        // Get current time
        $currentTime = date('Y-m-d H:i:s');
        
        // Simplified query to check token
        $stmt = $pdo->prepare("
            SELECT id 
            FROM users 
            WHERE reset_token = ? 
            AND reset_expires >= ?
        ");
        $stmt->execute([$token, $currentTime]);
        $user = $stmt->fetch();
        
        if ($user) {
            $tokenValid = true;
        }
    } catch (PDOException $e) {
        error_log($e->getMessage());
    }
}
?>

<style>
.auth-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-color: #FFF3E4;
    padding: 20px;
    margin-top: 60px;
}

.auth-box {
    background: white;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 400px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group input {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
}

.reset-btn {
    width: 100%;
    padding: 12px;
    background-color: #FF8038;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.reset-btn:hover {
    background-color: #e66a20;
}

.alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 5px;
    text-align: center;
}

.alert-error {
    background-color: #fee;
    color: #c00;
    border: 1px solid #fcc;
}

.password-requirements {
    font-size: 12px;
    color: #666;
    margin-top: 10px;
}
</style>

<div class="auth-container">
    <div class="auth-box">
        <h2>Reset Password</h2>
        
        <?php if ($tokenValid): ?>
            <form action="process_reset_password.php" method="POST">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                
                <div class="form-group">
                    <input type="password" 
                           name="password" 
                           placeholder="New Password" 
                           required 
                           minlength="8">
                    <div class="password-requirements">
                        Password must be at least 8 characters long and include:
                        <ul>
                            <li>One uppercase letter</li>
                            <li>One lowercase letter</li>
                            <li>One number</li>
                        </ul>
                    </div>
                </div>

                <div class="form-group">
                    <input type="password" 
                           name="password_confirm" 
                           placeholder="Confirm Password" 
                           required>
                </div>

                <button type="submit" class="reset-btn">Reset Password</button>
            </form>
        <?php else: ?>
            <div class="alert alert-error">
                Invalid or expired reset token. Please request a new one.
            </div>
            <a href="forgot_password.php" class="reset-btn" style="display: block; text-align: center; text-decoration: none; margin-top: 20px;">
                Request New Reset Link
            </a>
        <?php endif; ?>
    </div>
</div>

<?php include 'components/footer.php'; ?> 