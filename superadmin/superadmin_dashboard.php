<?php
/**
 * Super Admin Dashboard
 * Bike Garage Management System
 */

// Start session and include configuration
session_start();
require_once '../config/db_config.php';

// Check if superadmin is logged in
if (!isset($_SESSION['admin_id']) || $_SESSION['admin_role'] !== 'superadmin') {
    header("Location: superadmin_login.php");
    exit();
}

// Get admin info
$adminName = $_SESSION['admin_name'] ?? $_SESSION['admin_username'] ?? 'Super Admin';

// Get dashboard statistics
$stats = [];

// Total Users
$result = $conn->query("SELECT COUNT(*) as total FROM users");
$stats['total_users'] = $result->fetch_assoc()['total'] ?? 0;

// Total Admins
$result = $conn->query("SELECT COUNT(*) as total FROM admin");
$stats['total_admins'] = $result->fetch_assoc()['total'] ?? 0;

// Total Bookings
$result = $conn->query("SELECT COUNT(*) as total FROM service_booking");
$stats['total_bookings'] = $result->fetch_assoc()['total'] ?? 0;

// Pending Services
$result = $conn->query("SELECT COUNT(*) as total FROM service_booking WHERE status = 'pending'");
$stats['pending_services'] = $result->fetch_assoc()['total'] ?? 0;

// Total Revenue
$result = $conn->query("SELECT COALESCE(SUM(total_amount), 0) as total FROM billing WHERE payment_status = 'paid'");
$stats['total_revenue'] = $result->fetch_assoc()['total'] ?? 0;

// Total Bills
$result = $conn->query("SELECT COUNT(*) as total FROM billing");
$stats['total_bills'] = $result->fetch_assoc()['total'] ?? 0;

// Get all admins
$adminsResult = $conn->query("SELECT * FROM admin ORDER BY created_at DESC");

// Get recent activities
$activityResult = $conn->query("SELECT * FROM activity_logs ORDER BY created_at DESC LIMIT 20");

// Get monthly revenue data
$monthlyRevenue = [];
for ($i = 1; $i <= 12; $i++) {
    $result = $conn->query("SELECT COALESCE(SUM(total_amount), 0) as total FROM billing WHERE MONTH(bill_generated_at) = $i AND YEAR(bill_generated_at) = YEAR(NOW()) AND payment_status = 'paid'");
    $monthlyRevenue[$i] = $result->fetch_assoc()['total'] ?? 0;
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: superadmin_login.php");
    exit();
}

// Handle admin actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action == 'add_admin') {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $fullName = trim($_POST['full_name'] ?? '');
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'admin';
        
        if (!empty($username) && !empty($email) && !empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $conn->prepare("INSERT INTO admin (username, email, full_name, password, role, status) VALUES (?, ?, ?, ?, ?, 'active')");
            $stmt->bind_param("sssss", $username, $email, $fullName, $hashedPassword, $role);
            
            if ($stmt->execute()) {
                $message = "Admin added successfully!";
                $messageType = 'success';
            } else {
                $message = "Failed to add admin. Username or email may already exist.";
                $messageType = 'danger';
            }
            $stmt->close();
        }
    } elseif ($action == 'delete_admin') {
        $adminId = (int)$_POST['admin_id'];
        
        if ($adminId != $_SESSION['admin_id']) {
            $stmt = $conn->prepare("DELETE FROM admin WHERE id = ? AND role != 'superadmin'");
            $stmt->bind_param("i", $adminId);
            if ($stmt->execute()) {
                $message = "Admin deleted successfully!";
                $messageType = 'success';
            } else {
                $message = "Failed to delete admin.";
                $messageType = 'danger';
            }
            $stmt->close();
        } else {
            $message = "You cannot delete your own account!";
            $messageType = 'danger';
        }
    } elseif ($action == 'toggle_status') {
        $adminId = (int)$_POST['admin_id'];
        $currentStatus = $_POST['current_status'];
        $newStatus = $currentStatus == 'active' ? 'inactive' : 'active';
        
        $stmt = $conn->prepare("UPDATE admin SET status = ? WHERE id = ? AND role != 'superadmin'");
        $stmt->bind_param("si", $newStatus, $adminId);
        $stmt->execute();
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard - Bike Garage Management System</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .dashboard-header {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            color: white;
            padding: 40px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .dashboard-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(230, 57, 70, 0.1) 0%, transparent 50%);
        }
        
        .dashboard-header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }
        
        .dashboard-header p {
            opacity: 0.8;
            position: relative;
            z-index: 1;
        }
        
        .welcome-badge {
            background: rgba(230, 57, 70, 0.2);
            border: 1px solid rgba(230, 57, 70, 0.5);
            padding: 8px 20px;
            border-radius: 30px;
            display: inline-block;
            margin-top: 15px;
            font-size: 0.9rem;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: -50px;
            margin-bottom: 30px;
            position: relative;
            z-index: 2;
        }
        
        .stat-box {
            background: linear-gradient(145deg, #1e1e1e, #2a2a2a);
            border-radius: 16px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .stat-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
        }
        
        .stat-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
        }
        
        .stat-box .icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 1.5rem;
        }
        
        .stat-box .number {
            font-size: 2.2rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .stat-box .label {
            color: #888;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        /* Status Colors */
        .stat-box.users { border-top: 3px solid #00b4d8; }
        .stat-box.users .icon { background: rgba(0, 180, 216, 0.2); color: #00b4d8; }
        .stat-box.users .number { color: #00b4d8; }
        
        .stat-box.admins { border-top: 3px solid #f77f00; }
        .stat-box.admins .icon { background: rgba(247, 127, 0, 0.2); color: #f77f00; }
        .stat-box.admins .number { color: #f77f00; }
        
        .stat-box.bookings { border-top: 3px solid #0077b6; }
        .stat-box.bookings .icon { background: rgba(0, 119, 182, 0.2); color: #0077b6; }
        .stat-box.bookings .number { color: #0077b6; }
        
        .stat-box.revenue { border-top: 3px solid #e63946; }
        .stat-box.revenue .icon { background: rgba(230, 57, 70, 0.2); color: #e63946; }
        .stat-box.revenue .number { color: #e63946; }
        
        .stat-box.pending { border-top: 3px solid #fcbf49; }
        .stat-box.pending .icon { background: rgba(252, 191, 73, 0.2); color: #fcbf49; }
        .stat-box.pending .number { color: #fcbf49; }
        
        .stat-box.bills { border-top: 3px solid #2a9d8f; }
        .stat-box.bills .icon { background: rgba(42, 157, 143, 0.2); color: #2a9d8f; }
        .stat-box.bills .number { color: #2a9d8f; }
        
        /* Charts Section */
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        
        .chart-card {
            background: linear-gradient(145deg, #1e1e1e, #2a2a2a);
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .chart-card h3 {
            margin-bottom: 20px;
            color: #fff;
            font-size: 1.2rem;
        }
        
        .chart-card h3 i {
            margin-right: 10px;
            color: #e63946;
        }
        
        /* Bar Chart */
        .bar-chart {
            display: flex;
            align-items: flex-end;
            justify-content: space-around;
            height: 200px;
            padding-top: 20px;
        }
        
        .bar {
            width: 40px;
            background: linear-gradient(to top, #e63946, #f77f00);
            border-radius: 8px 8px 0 0;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .bar:hover {
            opacity: 0.8;
            transform: scaleY(1.05);
        }
        
        .bar span {
            position: absolute;
            bottom: -25px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 0.75rem;
            color: #888;
        }
        
        .bar .value {
            position: absolute;
            top: -25px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 0.8rem;
            color: #fff;
            white-space: nowrap;
        }
        
        /* Tables */
        .data-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
        }
        
        .data-table th {
            padding: 15px;
            color: #888;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
        }
        
        .data-table tbody tr {
            background: rgba(255, 255, 255, 0.02);
            transition: all 0.3s ease;
        }
        
        .data-table tbody tr:hover {
            background: rgba(230, 57, 70, 0.1);
        }
        
        .data-table td {
            padding: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .data-table td:first-child {
            border-left: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 10px 0 0 10px;
        }
        
        .data-table td:last-child {
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 0 10px 10px 0;
        }
        
        /* Section Cards */
        .section-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        
        .section-card {
            background: linear-gradient(145deg, #1e1e1e, #2a2a2a);
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .section-header h3 {
            color: #fff;
            font-size: 1.1rem;
        }
        
        .section-header h3 i {
            margin-right: 10px;
            color: #e63946;
        }
        
        .view-all {
            color: #e63946;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }
        
        .view-all:hover {
            color: #f77f00;
        }
        
        /* Admin User Avatar */
        .admin-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .admin-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e63946, #f77f00);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
        }
        
        .admin-details {
            display: flex;
            flex-direction: column;
        }
        
        .admin-name {
            color: #fff;
            font-weight: 500;
        }
        
        .admin-email {
            color: #888;
            font-size: 0.85rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .charts-grid,
            .section-grid {
                grid-template-columns: 1fr;
            }
            
            .dashboard-header h1 {
                font-size: 1.8rem;
            }
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .status-active {
            background: rgba(42, 157, 143, 0.2);
            color: #2a9d8f;
        }
        
        .status-inactive {
            background: rgba(230, 57, 70, 0.2);
            color: #e63946;
        }
        
        .status-superadmin {
            background: rgba(247, 127, 0, 0.2);
            color: #f77f00;
        }
        
        .status-admin {
            background: rgba(0, 180, 216, 0.2);
            color: #00b4d8;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="container">
            <a href="superadmin_dashboard.php" class="navbar-brand">
                <i class="fas fa-shield-alt"></i> Bike Garage Super Admin
            </a>
            <ul class="nav-links">
                <li><a href="superadmin_dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="#" onclick="showModal('addAdminModal'); return false;"><i class="fas fa-user-plus"></i> Add Admin</a></li>
                <li><a href="?logout=true" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="container">
            <h1><i class="fas fa-shield-alt"></i> Super Admin Dashboard</h1>
            <p>Welcome back, <?php echo htmlspecialchars($adminName); ?>! System Overview</p>
            <div class="welcome-badge">
                <i class="fas fa-calendar-alt"></i> <?php echo date('l, F j, Y'); ?>
            </div>
        </div>
    </div>

    <!-- Dashboard Content -->
    <section class="content-section">
        <div class="container">
            <!-- Messages -->
            <?php if (isset($message)): ?>
                <div class="alert alert-<?php echo $messageType; ?>">
                    <i class="fas fa-<?php echo $messageType == 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <!-- Statistics Grid -->
            <div class="stats-grid">
                <div class="stat-box users">
                    <div class="icon"><i class="fas fa-users"></i></div>
                    <div class="number"><?php echo number_format($stats['total_users']); ?></div>
                    <div class="label">Total Users</div>
                </div>
                <div class="stat-box admins">
                    <div class="icon"><i class="fas fa-user-shield"></i></div>
                    <div class="number"><?php echo number_format($stats['total_admins']); ?></div>
                    <div class="label">Total Admins</div>
                </div>
                <div class="stat-box bookings">
                    <div class="icon"><i class="fas fa-calendar-check"></i></div>
                    <div class="number"><?php echo number_format($stats['total_bookings']); ?></div>
                    <div class="label">Total Bookings</div>
                </div>
                <div class="stat-box pending">
                    <div class="icon"><i class="fas fa-clock"></i></div>
                    <div class="number"><?php echo number_format($stats['pending_services']); ?></div>
                    <div class="label">Pending Services</div>
                </div>
                <div class="stat-box revenue">
                    <div class="icon"><i class="fas fa-rupee-sign"></i></div>
                    <div class="number">₹<?php echo number_format($stats['total_revenue'], 0); ?></div>
                    <div class="label">Total Revenue</div>
                </div>
                <div class="stat-box bills">
                    <div class="icon"><i class="fas fa-file-invoice"></i></div>
                    <div class="number"><?php echo number_format($stats['total_bills']); ?></div>
                    <div class="label">Total Bills</div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="charts-grid">
                <!-- Monthly Revenue Chart -->
                <div class="chart-card">
                    <h3><i class="fas fa-chart-bar"></i> Monthly Revenue (<?php echo date('Y'); ?>)</h3>
                    <div class="bar-chart">
                        <?php 
                        $maxRevenue = max($monthlyRevenue) ?: 1;
                        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                        for ($i = 1; $i <= 12; $i++) {
                            $height = ($monthlyRevenue[$i] / $maxRevenue) * 150;
                            echo '<div class="bar" style="height: ' . $height . 'px;">
                                <span class="value">₹' . number_format($monthlyRevenue[$i], 0) . '</span>
                                <span>' . substr($months[$i-1], 0, 1) . '</span>
                            </div>';
                        }
                        ?>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="chart-card">
                    <h3><i class="fas fa-chart-pie"></i> System Overview</h3>
                    <div style="padding: 20px 0;">
                        <div style="display: flex; justify-content: space-between; padding: 15px 0; border-bottom: 1px solid rgba(255,255,255,0.1);">
                            <span><i class="fas fa-users" style="color: #00b4d8;"></i> Users</span>
                            <strong><?php echo number_format($stats['total_users']); ?></strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 15px 0; border-bottom: 1px solid rgba(255,255,255,0.1);">
                            <span><i class="fas fa-calendar-check" style="color: #0077b6;"></i> Bookings</span>
                            <strong><?php echo number_format($stats['total_bookings']); ?></strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 15px 0; border-bottom: 1px solid rgba(255,255,255,0.1);">
                            <span><i class="fas fa-file-invoice" style="color: #2a9d8f;"></i> Bills Generated</span>
                            <strong><?php echo number_format($stats['total_bills']); ?></strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 15px 0; color: #e63946;">
                            <span><i class="fas fa-clock"></i> Pending Services</span>
                            <strong><?php echo number_format($stats['pending_services']); ?></strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admins Section -->
            <div class="section-card" style="margin-bottom: 30px;">
                <div class="section-header">
                    <h3><i class="fas fa-users-cog"></i> System Administrators</h3>
                    <button onclick="showModal('addAdminModal')" class="btn btn-primary" style="padding: 5px 15px;">
                        <i class="fas fa-plus"></i> Add New Admin
                    </button>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Admin</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($adminsResult && $adminsResult->num_rows > 0): ?>
                            <?php while ($admin = $adminsResult->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <div class="admin-info">
                                            <div class="admin-avatar"><?php echo strtoupper(substr($admin['full_name'] ?: $admin['username'], 0, 1)); ?></div>
                                            <div class="admin-details">
                                                <span class="admin-name"><?php echo htmlspecialchars($admin['full_name'] ?: $admin['username']); ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($admin['email']); ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo $admin['role']; ?>">
                                            <?php echo ucfirst($admin['role']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge <?php echo $admin['status'] == 'active' ? 'status-active' : 'status-inactive'; ?>">
                                            <?php echo ucfirst($admin['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('d M Y', strtotime($admin['created_at'])); ?></td>
                                    <td>
                                        <?php if ($admin['role'] != 'superadmin'): ?>
                                            <div class="action-btns">
                                                <form method="POST" style="display: inline;">
                                                    <input type="hidden" name="action" value="toggle_status">
                                                    <input type="hidden" name="admin_id" value="<?php echo $admin['id']; ?>">
                                                    <input type="hidden" name="current_status" value="<?php echo $admin['status']; ?>">
                                                    <button type="submit" class="btn btn-<?php echo $admin['status'] == 'active' ? 'warning' : 'success'; ?> btn-sm" title="<?php echo $admin['status'] == 'active' ? 'Deactivate' : 'Activate'; ?>">
                                                        <i class="fas fa-<?php echo $admin['status'] == 'active' ? 'ban' : 'check'; ?>"></i>
                                                    </button>
                                                </form>
                                                <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this admin?');">
                                                    <input type="hidden" name="action" value="delete_admin">
                                                    <input type="hidden" name="admin_id" value="<?php echo $admin['id']; ?>">
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-muted"><i class="fas fa-crown"></i> System Owner</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center" style="color: #888;">No admins found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Recent Activity -->
            <div class="section-card">
                <div class="section-header">
                    <h3><i class="fas fa-history"></i> Recent Activity</h3>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>User Type</th>
                            <th>Action</th>
                            <th>Description</th>
                            <th>IP Address</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($activityResult && $activityResult->num_rows > 0): ?>
                            <?php while ($activity = $activityResult->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <span class="status-badge status-<?php echo $activity['user_type']; ?>" style="font-size: 0.7rem;">
                                            <?php echo ucfirst($activity['user_type']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($activity['action']); ?></td>
                                    <td><?php echo htmlspecialchars($activity['description']); ?></td>
                                    <td><?php echo htmlspecialchars($activity['ip_address']); ?></td>
                                    <td><?php echo date('d M Y, h:i A', strtotime($activity['created_at'])); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center" style="color: #888;">No activity logs found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Add Admin Modal -->
    <div id="addAdminModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-user-plus"></i> Add New Admin</h3>
                <button class="modal-close" onclick="hideModal('addAdminModal')">&times;</button>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="action" value="add_admin">
                
                <div class="form-group">
                    <label for="username"><i class="fas fa-user"></i> Username *</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                </div>
                
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email *</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                </div>
                
                <div class="form-group">
                    <label for="full_name"><i class="fas fa-id-card"></i> Full Name</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter full name">
                </div>
                
                <div class="form-group">
                    <label for="role"><i class="fas fa-user-tag"></i> Role</label>
                    <select class="form-control" id="role" name="role">
                        <option value="admin">Admin</option>
                        <option value="superadmin">Super Admin</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password *</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required minlength="6">
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-plus-circle"></i> Add Admin
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>© 2024 Bike Garage Management System. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function showModal(id) {
            document.getElementById(id).style.display = 'flex';
        }
        
        function hideModal(id) {
            document.getElementById(id).style.display = 'none';
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        }
    </script>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>

