<?php
session_start();
require 'config/db.php';

// Debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    if (!isset($_SESSION['user_id']) && !isset($_SESSION['firebase_email'])) {
        header('Location: login.php');
        exit();
    }

    // For Firebase users
    if (isset($_SESSION['firebase_email'])) {
        // First try to find existing user by email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$_SESSION['firebase_email']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // If user doesn't exist, create new Firebase user
        if (!$user) {
            $pdo->beginTransaction();
            
            try {
                $stmt = $pdo->prepare("
                    INSERT INTO users (
                        firebase_uid,
                        provider,
                        first_name,
                        last_name,
                        email,
                        password,
                        user_type,
                        created_at,
                        updated_at
                    ) VALUES (?, ?, ?, ?, ?, NULL, 'user', NOW(), NOW())
                ");

                // Split display name into first and last name
                $nameParts = explode(' ', $_SESSION['firebase_name'] ?? 'Firebase User');
                $firstName = $nameParts[0] ?? 'Firebase';
                $lastName = isset($nameParts[1]) ? $nameParts[1] : 'User';

                $stmt->execute([
                    $_SESSION['firebase_uid'],
                    'google',  // or whatever provider is being used
                    $firstName,
                    $lastName,
                    $_SESSION['firebase_email']
                ]);

                $_SESSION['user_id'] = $pdo->lastInsertId();
                
                // Get the newly created user
                $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
                $stmt->execute([$_SESSION['user_id']]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                $pdo->commit();
            } catch (Exception $e) {
                $pdo->rollBack();
                throw new Exception("Failed to create Firebase user: " . $e->getMessage());
            }
        }
    } else {
        // Regular login
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    if (!$user) {
        throw new Exception("User not found in database");
    }

} catch (Exception $e) {
    error_log("Profile Error: " . $e->getMessage());
    $error = $e->getMessage();
}

include 'components/header.php';
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error); ?>
                    <a href="login.php" class="btn btn-primary mt-2">Return to Login</a>
                </div>
            <?php endif; ?>

            <?php if(isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?php 
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    ?>
                </div>
            <?php endif; ?>

            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?php 
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    ?>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">My Profile</h3>
                    <?php if (isset($_SESSION['firebase_email'])): ?>
                        <small class="text-muted">Google Account</small>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <form action="update_profile.php" method="POST" class="profile-form">
                        <div class="profile-info">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>First Name:</strong>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="first_name" class="form-control" 
                                        value="<?php echo htmlspecialchars($user['first_name']); ?>" 
                                        <?php echo isset($_SESSION['firebase_email']) ? 'readonly' : ''; ?>>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Last Name:</strong>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="last_name" class="form-control" 
                                        value="<?php echo htmlspecialchars($user['last_name']); ?>"
                                        <?php echo isset($_SESSION['firebase_email']) ? 'readonly' : ''; ?>>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Email:</strong>
                                </div>
                                <div class="col-md-8">
                                    <input type="email" name="email" class="form-control" 
                                        value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Phone:</strong>
                                </div>
                                <div class="col-md-8">
                                    <input type="tel" name="phone" class="form-control" 
                                        value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                                </div>
                            </div>
                            
                            <!-- Password Change Section -->
                            <div class="password-change-section mt-4">
                                <h4 class="mb-3">Change Password</h4>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <strong>Current Password:</strong>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="password" name="current_password" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <strong>New Password:</strong>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="password" name="new_password" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <strong>Confirm Password:</strong>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="password" name="confirm_password" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.profile-form input.form-control {
    background-color: #fff;
    border: 1px solid #ddd;
    padding: 8px 12px;
    transition: border-color 0.3s;
}

.profile-form input.form-control:focus {
    border-color: #446A46;
    box-shadow: 0 0 0 0.2rem rgba(68, 106, 70, 0.25);
}

.profile-form input[readonly] {
    background-color: #f8f9fa;
}

.btn-primary {
    background-color: #446A46;
    border-color: #446A46;
}

.btn-primary:hover {
    background-color: #385839;
    border-color: #385839;
}

.password-change-section {
    border-top: 1px solid #ddd;
    padding-top: 20px;
}

.alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
}

.alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
}

.alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
}
</style>

<?php include 'components/footer.php'; ?> 