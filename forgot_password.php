<?php
/**
 * Forgot Password Page
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
$email = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email'] ?? '');

    // Validate email
    if (empty($email)) {
        $error = 'Please enter your email address';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address';
    } else {
        // Check if email exists in database
        $stmt = $conn->prepare("SELECT id, full_name FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Generate reset token (in production, use secure token generation)
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            // Store token in database (you might want to add a password_reset_tokens table)
            // For demo purposes, we'll simulate the reset process
            
            // In production, you would:
            // 1. Store the token in a password_reset_tokens table
            // 2. Send an email with reset link
            // 3. Implement reset_password.php page
            
            $success = 'Password reset instructions have been sent to your email address.';
            $email = ''; // Clear email field
        } else {
            $error = 'Email address not found in our records';
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
    <title>Forgot Password - Bike Garage Management System</title>
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
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
                <li><a href="../admin_login.php">Admin</a></li>
            </ul>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1><i class="fas fa-key"></i> Forgot Password</h1>
            <div class="breadcrumb">
                <a href="../index.html">Home</a> / <a href="login.php">Login</a> / <span>Forgot Password</span>
            </div>
        </div>
    </section>

    <!-- Forgot Password Form Section -->
    <section class="content-section">
        <div class="container">
            <div class="form-container">
                <!-- Info Box -->
                <div class="alert alert-info" style="margin-bottom: 20px;">
                    <i class="fas fa-info-circle"></i> 
                    Enter your email address and we'll send you instructions to reset your password.
                </div>

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

                <form id="forgotPasswordForm" method="POST" action="">
                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope"></i> Email Address
                        </label>
                        <input type="email" class="form-control" id="email" name="email" 
                               placeholder="Enter your registered email" 
                               value="<?php echo htmlspecialchars($email); ?>">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-paper-plane"></i> Send Reset Link
                        </button>
                    </div>

                    <div class="text-center mt-20">
                        <a href="login.php">
                            <i class="fas fa-arrow-left"></i> Back to Login
                        </a>
                    </div>
                </form>
            </div>

            <!-- Additional Help -->
            <div class="form-container mt-20" style="max-width: 500px;">
                <h4 class="text-center mb-20"><i class="fas fa-question-circle"></i> Need Help?</h4>
                <div class="card">
                    <p><strong>Contact Support:</strong></p>
                    <p><i class="fas fa-envelope"></i> support@bikeGarage.com</p>
                    <p><i class="fas fa-phone"></i> +91 9876543210</p>
                    <p class="text-muted mt-20" style="font-size: 0.9rem;">
                        Our support team is available Monday to Saturday, 9 AM to 6 PM.
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

