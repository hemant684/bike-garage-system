<?php
/**
 * User Registration Page
 * Bike Garage Management System
 */

// Start session and include configuration
session_start();
// Auto-setup database if needed
require_once 'config/auto_setup.php';
require_once 'config/db_config.php';

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: user/user_dashboard.php");
    exit();
}

// Handle form submission
$error = '';
$success = '';
$formData = [
    'fullName' => '',
    'email' => '',
    'phone' => '',
    'address' => '',
    'bikeModel' => '',
    'bikeNumber' => ''
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $formData['fullName'] = trim($_POST['fullName'] ?? '');
    $formData['email'] = trim($_POST['email'] ?? '');
    $formData['phone'] = trim($_POST['phone'] ?? '');
    $formData['address'] = trim($_POST['address'] ?? '');
    $formData['bikeModel'] = trim($_POST['bikeModel'] ?? '');
    $formData['bikeNumber'] = trim($_POST['bikeNumber'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    // Validate inputs
    $errors = [];

    if (empty($formData['fullName'])) {
        $errors[] = 'Full name is required';
    } elseif (strlen($formData['fullName']) < 3) {
        $errors[] = 'Name must be at least 3 characters';
    }

    if (empty($formData['email'])) {
        $errors[] = 'Email is required';
    } elseif (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address';
    }

    if (empty($formData['phone'])) {
        $errors[] = 'Phone number is required';
    } elseif (!preg_match('/^[6-9]\d{9}$/', $formData['phone'])) {
        $errors[] = 'Please enter a valid 10-digit phone number';
    }

    if (empty($password)) {
        $errors[] = 'Password is required';
    } elseif (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters';
    } elseif (!preg_match('/[a-zA-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $errors[] = 'Password must contain at least one letter and one number';
    }

    if ($password !== $confirmPassword) {
        $errors[] = 'Passwords do not match';
    }

    if (empty($formData['bikeModel'])) {
        $errors[] = 'Bike model is required';
    }

    if (empty($formData['bikeNumber'])) {
        $errors[] = 'Bike number is required';
    }

    // If no validation errors, proceed with registration
    if (empty($errors)) {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $formData['email']);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors[] = 'Email already registered';
        }
        $stmt->close();

        if (empty($errors)) {
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user
            $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, phone, address, bike_model, bike_number) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", 
                $formData['fullName'],
                $formData['email'],
                $hashedPassword,
                $formData['phone'],
                $formData['address'],
                $formData['bikeModel'],
                $formData['bikeNumber']
            );

            if ($stmt->execute()) {
                $success = 'Registration successful! You can now <a href="login.php">login here</a>';
                // Clear form data on success
                $formData = array_fill_keys(array_keys($formData), '');
            } else {
                $errors[] = 'Registration failed. Please try again.';
            }
            $stmt->close();
        }
    }

    if (!empty($errors)) {
        $error = implode('<br>', $errors);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Bike Garage Management System</title>
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
                <li><a href="register.php" class="active">Register</a></li>
                <li><a href="../admin_login.php">Admin</a></li>
            </ul>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1><i class="fas fa-user-plus"></i> User Registration</h1>
            <div class="breadcrumb">
                <a href="../index.html">Home</a> / <span>Register</span>
            </div>
        </div>
    </section>

    <!-- Registration Form Section -->
    <section class="content-section">
        <div class="container">
            <div class="form-container" style="max-width: 600px;">
                <!-- Error/Success Messages -->
                <?php if ($error): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                    </div>
                <?php endif; ?>

                <form id="registerForm" method="POST" action="">
                    <!-- Personal Information -->
                    <h3 style="margin-bottom: 20px; color: var(--primary-color);">
                        <i class="fas fa-user"></i> Personal Information
                    </h3>
                    
                    <div class="form-group">
                        <label for="fullName">
                            <i class="fas fa-user"></i> Full Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="fullName" name="fullName" 
                               placeholder="Enter your full name" 
                               value="<?php echo htmlspecialchars($formData['fullName']); ?>">
                    </div>

                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope"></i> Email Address <span class="text-danger">*</span>
                        </label>
                        <input type="email" class="form-control" id="email" name="email" 
                               placeholder="Enter your email"
                               value="<?php echo htmlspecialchars($formData['email']); ?>">
                    </div>

                    <div class="form-group">
                        <label for="phone">
                            <i class="fas fa-phone"></i> Phone Number <span class="text-danger">*</span>
                        </label>
                        <input type="tel" class="form-control" id="phone" name="phone" 
                               placeholder="10-digit mobile number (e.g., 9876543210)"
                               value="<?php echo htmlspecialchars($formData['phone']); ?>">
                    </div>

                    <div class="form-group">
                        <label for="address">
                            <i class="fas fa-map-marker-alt"></i> Address
                        </label>
                        <textarea class="form-control" id="address" name="address" rows="2" 
                                  placeholder="Enter your address"><?php echo htmlspecialchars($formData['address']); ?></textarea>
                    </div>

                    <!-- Bike Information -->
                    <h3 style="margin: 30px 0 20px; color: var(--primary-color);">
                        <i class="fas fa-motorcycle"></i> Bike Information
                    </h3>

                    <div class="form-group">
                        <label for="bikeModel">
                            <i class="fas fa-bicycle"></i> Bike Model <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="bikeModel" name="bikeModel" 
                               placeholder="e.g., Honda Activa, Royal Enfield Classic"
                               value="<?php echo htmlspecialchars($formData['bikeModel']); ?>">
                    </div>

                    <div class="form-group">
                        <label for="bikeNumber">
                            <i class="fas fa-tag"></i> Bike Number <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="bikeNumber" name="bikeNumber" 
                               placeholder="e.g., MH12AB1234"
                               value="<?php echo htmlspecialchars($formData['bikeNumber']); ?>">
                    </div>

                    <!-- Password -->
                    <h3 style="margin: 30px 0 20px; color: var(--primary-color);">
                        <i class="fas fa-lock"></i> Account Security
                    </h3>

                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock"></i> Password <span class="text-danger">*</span>
                        </label>
                        <input type="password" class="form-control" id="password" name="password" 
                               placeholder="At least 6 characters with letters and numbers">
                    </div>

                    <div class="form-group">
                        <label for="confirmPassword">
                            <i class="fas fa-lock"></i> Confirm Password <span class="text-danger">*</span>
                        </label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" 
                               placeholder="Re-enter your password">
                    </div>

                    <div class="form-group">
                        <div class="checkbox" style="display: flex; align-items: center; gap: 10px;">
                            <input type="checkbox" id="terms" name="terms" required>
                            <label for="terms" style="margin: 0;">
                                I agree to the <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fas fa-user-plus"></i> Register
                        </button>
                    </div>

                    <div class="text-center mt-20" style="border-top: 1px solid var(--border-color); padding-top: 20px;">
                        <p>Already have an account? 
                            <a href="login.php">
                                <i class="fas fa-sign-in-alt"></i> Login here
                            </a>
                        </p>
                    </div>
                </form>
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

