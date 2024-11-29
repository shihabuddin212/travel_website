<?php 
session_start();
$pageTitle = "Login - BD Adventures";
include 'components/header.php';
include 'components/nav.php';
?>

<div class="login-container">
    <div class="login-wrapper">
        <!-- Left Side - Image -->
        <div class="login-image">
            <img src="assets/images/travel-adventure.jpg" alt="Travel Adventure">
            <div class="overlay">
                <h1>Welcome Back</h1>
                <p>Your next adventure awaits!</p>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="login-form-container">
            <div class="login-header">
                <h2>Sign In</h2>
                <p>Continue your journey with us</p>
            </div>

            <!-- Google Sign-in Button -->
            <div class="google-btn" onclick="signInWithGoogle()">
                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google">
                <span>Continue with Google</span>
            </div>

            <div class="divider">
                <span>or sign in with email</span>
            </div>

            <form action="login_process.php" method="POST">
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email Address" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>
                    <a href="forgot_password.php">Forgot password?</a>
                </div>
                <button type="submit" class="signin-btn">Sign In</button>
            </form>

            <p class="signup-link">
                Don't have an account? <a href="register.php">Create Account</a>
            </p>
        </div>
    </div>
</div>

<style>
.login-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f5f5f5;
    padding: 20px;
}

.login-wrapper {
    display: flex;
    width: 900px;
    max-width: 100%;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.login-image {
    flex: 1;
    position: relative;
}

.login-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.6));
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 40px;
    color: white;
}

.overlay h1 {
    font-size: 36px;
    font-weight: 600;
    margin-bottom: 10px;
}

.overlay p {
    font-size: 18px;
    opacity: 0.9;
}

.login-form-container {
    flex: 1;
    padding: 40px;
    max-width: 450px;
}

.login-header {
    text-align: center;
    margin-bottom: 30px;
}

.login-header h2 {
    font-size: 24px;
    color: #333;
    margin-bottom: 8px;
}

.login-header p {
    color: #666;
    font-size: 15px;
}

.google-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 10px 15px;
    background: white;
    border: 1px solid #dadce0;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.3s ease;
    margin-bottom: 20px;
}

.google-btn img {
    width: 20px;
    height: 20px;
}

.google-btn span {
    color: #3c4043;
    font-size: 14px;
    font-weight: 500;
}

.google-btn:hover {
    background: #f8f9fa;
}

.divider {
    text-align: center;
    position: relative;
    margin: 20px 0;
}

.divider::before,
.divider::after {
    content: "";
    position: absolute;
    top: 50%;
    width: 45%;
    height: 1px;
    background: #e0e0e0;
}

.divider::before { left: 0; }
.divider::after { right: 0; }

.divider span {
    background: white;
    padding: 0 10px;
    color: #666;
    font-size: 13px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group input {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

.form-group input:focus {
    outline: none;
    border-color: #446A46;
}

.form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 15px 0;
}

.remember-me {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: #666;
}

.form-options a {
    color: #446A46;
    font-size: 13px;
    text-decoration: none;
}

.signin-btn {
    width: 100%;
    padding: 12px;
    background: #446A46;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 15px;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.3s ease;
}

.signin-btn:hover {
    background: #385839;
}

.signup-link {
    text-align: center;
    margin-top: 20px;
    font-size: 14px;
    color: #666;
}

.signup-link a {
    color: #446A46;
    text-decoration: none;
    font-weight: 500;
}

@media (max-width: 768px) {
    .login-wrapper {
        flex-direction: column;
    }

    .login-image {
        display: none;
    }

    .login-form-container {
        padding: 30px 20px;
    }
}
</style>

<!-- Keep your existing Firebase scripts -->
<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/9.6.0/firebase-app.js";
    import { getAuth, signInWithPopup, GoogleAuthProvider } from "https://www.gstatic.com/firebasejs/9.6.0/firebase-auth.js";

    // Your Firebase configuration
    const firebaseConfig = {
        apiKey: "AIzaSyChHLjM98YxkGKae1ciJxQrd-xGDnVuMk0",
        authDomain: "bd-adventures-by-ovisoft.firebaseapp.com",
        projectId: "project-558688844628",
        storageBucket: "bd-adventures-by-ovisoft.appspot.com",
        messagingSenderId: "558688844628",
        appId: "1:558688844628:web:158e80c4c18d031fae66c1"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const auth = getAuth(app);
    const provider = new GoogleAuthProvider();

    // Make signInWithGoogle function global
    window.signInWithGoogle = function() {
        signInWithPopup(auth, provider)
            .then((result) => {
                const user = result.user;
                console.log("Google Sign-in successful:", user);
                
                // Prepare user data
                const userData = {
                    email: user.email,
                    firebase_uid: user.uid,
                    first_name: user.displayName?.split(' ')[0] || '',
                    last_name: user.displayName?.split(' ').slice(1).join(' ') || '',
                    profile_picture: user.photoURL || ''
                };

                // Send to check_firebase_user.php
                fetch('check_firebase_user.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(userData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = 'dashboard.php';
                    } else {
                        console.error('Server Error:', data.error);
                        alert('Error processing login: ' + (data.error || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    alert('Failed to process login: ' + error.message);
                });
            })
            .catch((error) => {
                console.error("Google Sign-in error:", error);
                alert('Failed to sign in with Google: ' + error.message);
            });
    };
</script>

<?php include 'components/footer.php'; ?> 