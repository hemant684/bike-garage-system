<?php
/**
 * Super Admin Login
 * Bike Garage Management System
 */

session_start();
require_once '../config/db_config.php';
require_once '../config/functions.php';

$pageTitle = 'Super Admin Login';

// Check if already logged in as superadmin
if (isset($_SESSION['admin_id']) && $_SESSION['admin_role'] === 'superadmin') {
    redirect('superadmin_dashboard.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = 'Please enter username and password';
    } else {
        $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? AND role = 'superadmin'");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();
            
            if (verifyPassword($password, $admin['password'])) {
                // Password correct
                initAdminSession($admin);
                logActivity('superadmin_login', 'Super admin logged in successfully');
                redirect('superadmin_dashboard.php');
            } else {
                $error = 'Invalid username or password';
            }
        } else {
            $error = 'Invalid username or password';
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
    <title><?php echo $pageTitle; ?> - Bike Garage</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            padding: 20px;
            position: relative;
            overflow: hidden;
        }
        
        .login-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 50%, rgba(230, 57, 70, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 50%, rgba(247, 127, 0, 0.1) 0%, transparent 50%);
        }
        
        .login-container {
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 1;
        }
        
        .login-card {
            background: rgba(30, 30, 30, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #e63946, #f77f00);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 10px 30px rgba(230, 57, 70, 0.3);
        }
        
        .login-icon i {
            font-size: 2.5rem;
            color: white;
        }
        
        .login-header h1 {
            color: #fff;
            font-size: 1.8rem;
            margin-bottom: 8px;
        }
        
        .login-header p {
            color: #888;
            font-size: 0.95rem;
        }
        
        .superadmin-badge {
            display: inline-block;
            background: linear-gradient(135deg, #e63946, #f77f00);
            color: white;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 10px;
        }
        
        .form-group {
            margin-bottom: 22px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: #b0b0b0;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .form-group label i {
            margin-right: 8px;
            color: #e63946;
        }
        
        .form-control {
            width: 100%;
            padding: 14px 18px;
            background: rgba(0, 0, 0, 0.4);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            font-size: 1rem;
            color: #fff;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #e63946;
            box-shadow: 0 0 20px rgba(230, 57, 70, 0.2);
            background: rgba(0, 0, 0, 0.6);
        }
        
        .form-control::placeholder {
            color: #666;
        }
        
        .btn-login {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #e63946, #f77f00);
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(230, 57, 70, 0.4);
        }
        
        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        
        .alert-danger {
            background: rgba(230, 57, 70, 0.15);
            border: 1px solid rgba(230, 57, 70, 0.3);
            color: #e63946;
        }
        
        .login-footer {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .login-footer a {
            color: #888;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }
        
        .login-footer a:hover {
            color: #e63946;
        }
        
        .login-footer a i {
            margin-right: 5px;
        }
        
        .demo-info {
            background: rgba(255, 193, 7, 0.1);
            border: 1px solid rgba(255, 193, 7, 0.3);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .demo-info p {
            color: #ffc107;
            font-size: 0.85rem;
            margin: 5px 0;
        }
        
        .demo-info strong {
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-card">
                <div class="login-header">
                    <div class="login-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h1>Super Admin</h1>
                    <p>Access System Administration</p>
                    <span class="superadmin-badge"><i class="fas fa-crown"></i> Super Admin</span>
                </div>
                
                <?php if ($error): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> <?php echo escape($error); ?>
                    </div>
                <?php endif; ?>
                
                <div class="demo-info">
                    <p><strong>Username:</strong> superadmin</p>
                    <p><strong>Password:</strong> super123</p>
                </div>
                
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="username"><i class="fas fa-user"></i> Username</label>
                        <input type="text" class="form-control" id="username" name="username" 
                               placeholder="Enter username" value="<?php echo escape($username ?? ''); ?>" required autofocus>
                    </div>
                    
                    <div class="form-group">
                        <label for="password"><i class="fas fa-lock"></i> Password</label>
                        <input type="password" class="form-control" id="password" name="password" 
                               placeholder="Enter password" required>
                    </div>
                    
                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i> Login to Dashboard
                    </button>
                </form>
                
                <div class="login-footer">
                    <a href="../login.php">
                        <i class="fas fa-users"></i> User Login
                    </a>
                    <span style="color: #444; margin: 0 10px;">|</span>
                    <a href="admin_login.php">
                        <i class="fas fa-user-cog"></i> Admin Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>

