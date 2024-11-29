<?php 
session_start();
$pageTitle = "Forgot Password - BD Adventures";
include 'components/header.php';
include 'components/nav.php';
?>

<div class="auth-container">
    <div class="auth-box">
        <h2>Reset Password</h2>
        <p>Enter your email to receive password reset instructions</p>

        <?php if(isset($_SESSION['message'])): ?>
            <div class="alert <?php echo $_SESSION['message_type'] == 'error' ? 'alert-error' : 'alert-success'; ?>">
                <?php 
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
                ?>
            </div>
        <?php endif; ?>

        <form action="process_forgot_password.php" method="POST" class="auth-form">
            <div class="form-group">
                <input type="email" name="email" placeholder="Email Address" required>
            </div>
            <button type="submit" name="reset_password">Send Reset Link</button>
        </form>

        <p class="auth-link">Remember your password? <a href="login.php">Sign In</a></p>
    </div>
</div>

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
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
}

button[type="submit"] {
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

.alert {
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 20px;
    text-align: center;
}

.alert-error {
    background-color: #fee;
    color: #c00;
    border: 1px solid #fcc;
}

.alert-success {
    background-color: #efe;
    color: #0a0;
    border: 1px solid #cfc;
}

.auth-link {
    text-align: center;
    margin-top: 20px;
}

.auth-link a {
    color: #FF8038;
    text-decoration: none;
}
</style>

<?php include 'components/footer.php'; ?> 