<?php
/**
 * User Login Page
 * Bike Garage Management System
 */

// Start session and include configuration
session_start();
require_once 'config/db_config.php';

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: user/user_dashboard.php");
    exit();
}

// Handle form submission
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validate inputs
    if (empty($email) || empty($password)) {
        $error = 'Please fill in all fields';
    } else {
        // Check database for user
        $stmt = $conn->prepare("SELECT id, full_name, email, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verify password (using password_verify for hashed passwords)
            if (password_verify($password, $user['password'])) {
                // Password correct, set session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['full_name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_login_time'] = time();
                
                // Redirect to dashboard
                header("Location: user/user_dashboard.php");
                exit();
            } else {
                $error = 'Invalid email or password';
            }
        } else {
            $error = 'Invalid email or password';
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bike Garage Management System</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="container">
            <a href="../index.html" class="navbar-brand">
                <i class="fas fa-motorcycle"></i> Bike Garage
            </a>
            <ul class="nav-links">
                <li><a href="../index.html">Home</a></li>
                <li><a href="login.php" class="active">Login</a></li>
                <li><a href="register.php">Register</a></li>
                <li><a href="../admin_login.php">Admin</a></li>
            </ul>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1><i class="fas fa-sign-in-alt"></i> User Login</h1>
            <div class="breadcrumb">
                <a href="../index.html">Home</a> / <span>Login</span>
            </div>
        </div>
    </section>

    <!-- Login Form Section -->
    <section class="content-section">
        <div class="container">
            <div class="form-container">
                <!-- Error/Success Messages -->
                <?php if ($error): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>

                <form id="loginForm" method="POST" action="">
                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope"></i> Email Address
                        </label>
                        <input type="email" class="form-control" id="email" name="email" 
                               placeholder="Enter your email" value="<?php echo htmlspecialchars($email ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock"></i> Password
                        </label>
                        <input type="password" class="form-control" id="password" name="password" 
                               placeholder="Enter your password">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </button>
                    </div>

                    <div class="text-center mt-20">
                        <a href="forgot_password.php" class="forgot-password">
                            <i class="fas fa-question-circle"></i> Forgot Password?
                        </a>
                    </div>

                    <div class="text-center mt-20" style="border-top: 1px solid var(--border-color); padding-top: 20px;">
                        <p>Don't have an account? 
                            <a href="register.php">
                                <i class="fas fa-user-plus"></i> Register here
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Demo Credentials Info -->
            <div class="form-container mt-20" style="max-width: 500px;">
                <h3 class="text-center mb-20"><i class="fas fa-info-circle"></i> Demo Credentials</h3>
                <div class="card">
                    <p><strong>Email:</strong> john@example.com</p>
                    <p><strong>Password:</strong> user123</p>
                    <p class="text-muted mt-20" style="font-size: 0.9rem;">
                        <i class="fas fa-exclamation-triangle"></i> 
                        Note: These are demo credentials. Use registration to create your own account.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 Bike Garage Management System. All rights reserved.</p>
        </div>
    </footer>

    <script src="../js/validation.js"></script>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>

