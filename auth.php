<?php 
session_start();
$pageTitle = "Authentication - BD Adventures";
include 'components/header.php';
?>

<div class="auth-container">
    <div class="auth-box">
        <h2>Create Account</h2>
        <p>Join us to start your journey</p>

        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <form action="register_process.php" method="POST" class="auth-form">
            <div class="form-group">
                <input type="text" name="fullname" placeholder="Full Name" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="create-account-btn">Create Account</button>
        </form>

        <p class="auth-link">Already have an account? <a href="#" id="signInLink">Sign In</a></p>
    </div>
</div>

<style>
.auth-container {
    min-height: calc(100vh - 200px);
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 2rem;
    background: #fff;
}

.auth-box {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 400px;
}

.auth-box h2 {
    text-align: center;
    color: #333;
    margin-bottom: 0.5rem;
}

.auth-box p {
    text-align: center;
    color: #666;
    margin-bottom: 1.5rem;
}

.auth-form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.form-group input {
    width: 100%;
    padding: 0.8rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 0.9rem;
}

.form-group input[type="email"],
.form-group input[type="password"] {
    background-color: #ffffcc;
}

.create-account-btn {
    width: 100%;
    padding: 0.8rem;
    background: #333;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.9rem;
}

.create-account-btn:hover {
    background: #444;
}

.auth-link {
    margin-top: 1rem;
    text-align: center;
    font-size: 0.9rem;
}

.auth-link a {
    color: #0066cc;
    text-decoration: none;
}

.auth-link a:hover {
    text-decoration: underline;
}

.alert {
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 1rem;
    text-align: center;
}

.alert-error {
    background: #fee2e2;
    color: #dc2626;
    border: 1px solid #fecaca;
}

@media (max-width: 480px) {
    .auth-container {
        padding: 1rem;
    }
    
    .auth-box {
        padding: 1.5rem;
    }
}
</style>

<?php include 'components/footer.php'; ?> 