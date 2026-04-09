<?php
/**
 * Admin Dashboard - Enhanced Version
 * Bike Garage Management System
 */

// Start session and include configuration
session_start();
require_once '../config/db_config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Get admin info
$adminName = $_SESSION['admin_name'] ?? $_SESSION['admin_username'] ?? 'Admin';

// Get dashboard statistics with optimized query
$stats = [];

// Single optimized query to get all statistics
$result = $conn->query("
    SELECT
        (SELECT COUNT(*) FROM users) as total_users,
        (SELECT COUNT(*) FROM service_booking) as total_bookings,
        (SELECT COUNT(*) FROM service_booking WHERE status = 'pending') as pending_services,
        (SELECT COUNT(*) FROM service_booking WHERE status = 'approved') as approved_services,
        (SELECT COUNT(*) FROM service_booking WHERE status = 'in_progress') as in_progress_services,
        (SELECT COUNT(*) FROM service_booking WHERE status = 'completed') as completed_services,
        (SELECT COUNT(*) FROM service_booking WHERE status = 'cancelled') as cancelled_services
");

$stats = $result->fetch_assoc();

// Total Revenue
$result = $conn->query("SELECT COALESCE(SUM(total_amount), 0) as total FROM billing WHERE payment_status = 'paid'");
$stats['total_revenue'] = $result->fetch_assoc()['total'] ?? 0;

// Pending Payments
$result = $conn->query("SELECT COALESCE(SUM(total_amount), 0) as total FROM billing WHERE payment_status = 'pending'");
$stats['pending_payments'] = $result->fetch_assoc()['total'] ?? 0;

// Today's Bookings
$result = $conn->query("SELECT COUNT(*) as total FROM service_booking WHERE DATE(created_at) = CURDATE()");
$stats['today_bookings'] = $result->fetch_assoc()['total'] ?? 0;

// This Week Bookings
$result = $conn->query("SELECT COUNT(*) as total FROM service_booking WHERE WEEK(created_at) = WEEK(NOW())");
$stats['week_bookings'] = $result->fetch_assoc()['total'] ?? 0;

// Get monthly revenue data for chart
$monthlyRevenue = [];
for ($i = 1; $i <= 12; $i++) {
    $result = $conn->query("SELECT COALESCE(SUM(total_amount), 0) as total FROM billing WHERE MONTH(bill_generated_at) = $i AND YEAR(bill_generated_at) = YEAR(NOW()) AND payment_status = 'paid'");
    $monthlyRevenue[$i] = $result->fetch_assoc()['total'] ?? 0;
}

// Get booking status distribution
$statusDistribution = [];
$statuses = ['pending', 'approved', 'in_progress', 'completed', 'cancelled'];
foreach ($statuses as $status) {
    $result = $conn->query("SELECT COUNT(*) as total FROM service_booking WHERE status = '$status'");
    $statusDistribution[$status] = $result->fetch_assoc()['total'] ?? 0;
}

// Get recent bookings
$recentBookings = $conn->query("
    SELECT sb.*, u.full_name, u.email, u.phone, u.bike_model, u.bike_number
    FROM service_booking sb 
    JOIN users u ON sb.user_id = u.id 
    ORDER BY sb.created_at DESC 
    LIMIT 10
");

// Get recent users
$recentUsers = $conn->query("
    SELECT * FROM users 
    ORDER BY created_at DESC 
    LIMIT 5
");

// Get recent bills
$recentBills = $conn->query("
    SELECT b.*, u.full_name, u.email, sb.bike_model, sb.bike_number, sb.service_type
    FROM billing b
    JOIN users u ON b.user_id = u.id
    JOIN service_booking sb ON b.booking_id = sb.id
    ORDER BY b.bill_generated_at DESC
    LIMIT 5
");

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Bike Garage Management System</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Dashboard Specific Styles */
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
        
        .stat-box.bookings { border-top: 3px solid #0077b6; }
        .stat-box.bookings .icon { background: rgba(0, 119, 182, 0.2); color: #0077b6; }
        .stat-box.bookings .number { color: #0077b6; }
        
        .stat-box.pending { border-top: 3px solid #f77f00; }
        .stat-box.pending .icon { background: rgba(247, 127, 0, 0.2); color: #f77f00; }
        .stat-box.pending .number { color: #f77f00; }
        
        .stat-box.completed { border-top: 3px solid #2a9d8f; }
        .stat-box.completed .icon { background: rgba(42, 157, 143, 0.2); color: #2a9d8f; }
        .stat-box.completed .number { color: #2a9d8f; }
        
        .stat-box.revenue { border-top: 3px solid #e63946; }
        .stat-box.revenue .icon { background: rgba(230, 57, 70, 0.2); color: #e63946; }
        .stat-box.revenue .number { color: #e63946; }
        
        .stat-box.today { border-top: 3px solid #fcbf49; }
        .stat-box.today .icon { background: rgba(252, 191, 73, 0.2); color: #fcbf49; }
        .stat-box.today .number { color: #fcbf49; }
        
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
        
        /* Status Distribution */
        .status-bars {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .status-bar-item {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .status-bar-item .label {
            width: 120px;
            font-size: 0.9rem;
            color: #888;
        }
        
        .status-bar-item .bar-container {
            flex: 1;
            height: 30px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            overflow: hidden;
        }
        
        .status-bar-item .bar-fill {
            height: 100%;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding-right: 10px;
            font-size: 0.85rem;
            font-weight: bold;
            color: white;
            transition: width 0.5s ease;
        }
        
        .status-bar-item .count {
            width: 40px;
            text-align: right;
            color: #fff;
            font-weight: bold;
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
        
        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .action-btn {
            background: linear-gradient(145deg, #1e1e1e, #2a2a2a);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #fff;
            text-decoration: none;
        }
        
        .action-btn:hover {
            background: linear-gradient(145deg, #2a2a2a, #1e1e1e);
            border-color: #e63946;
            transform: translateY(-3px);
        }
        
        .action-btn i {
            font-size: 1.5rem;
            color: #e63946;
            margin-bottom: 10px;
            display: block;
        }
        
        .action-btn span {
            font-size: 0.9rem;
            color: #888;
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
        
        /* User Avatar */
        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .user-avatar {
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
        
        .user-details {
            display: flex;
            flex-direction: column;
        }
        
        .user-name {
            color: #fff;
            font-weight: 500;
        }
        
        .user-email {
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
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="container">
            <a href="admin_dashboard.php" class="navbar-brand">
                <i class="fas fa-motorcycle"></i> Bike Garage Admin
            </a>
            <ul class="nav-links">
                <li><a href="admin_dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="manage_booking.php"><i class="fas fa-tasks"></i> Manage Bookings</a></li>
                <li><a href="report.php"><i class="fas fa-chart-bar"></i> Reports</a></li>
                <li><a href="?logout=true" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="container">
            <h1><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h1>
            <p>Welcome back, <?php echo htmlspecialchars($adminName); ?>! Here's what's happening with your garage.</p>
            <div class="welcome-badge">
                <i class="fas fa-calendar-alt"></i> <?php echo date('l, F j, Y'); ?>
            </div>
        </div>
    </div>

    <!-- Dashboard Content -->
    <section class="content-section">
        <div class="container">
            <!-- Statistics Grid -->
            <div class="stats-grid">
                <div class="stat-box users">
                    <div class="icon"><i class="fas fa-users"></i></div>
                    <div class="number"><?php echo number_format($stats['total_users']); ?></div>
                    <div class="label">Total Users</div>
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
                <div class="stat-box completed">
                    <div class="icon"><i class="fas fa-check-circle"></i></div>
                    <div class="number"><?php echo number_format($stats['completed_services']); ?></div>
                    <div class="label">Completed Services</div>
                </div>
                <div class="stat-box revenue">
                    <div class="icon"><i class="fas fa-rupee-sign"></i></div>
                    <div class="number">₹<?php echo number_format($stats['total_revenue'], 0); ?></div>
                    <div class="label">Total Revenue</div>
                </div>
                <div class="stat-box today">
                    <div class="icon"><i class="fas fa-calendar-day"></i></div>
                    <div class="number"><?php echo number_format($stats['today_bookings']); ?></div>
                    <div class="label">Today's Bookings</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <a href="manage_booking.php" class="action-btn">
                    <i class="fas fa-tasks"></i>
                    <span>Manage Bookings</span>
                </a>
                <a href="manage_booking.php?action=add" class="action-btn">
                    <i class="fas fa-plus-circle"></i>
                    <span>New Booking</span>
                </a>
                <a href="report.php" class="action-btn">
                    <i class="fas fa-chart-bar"></i>
                    <span>View Reports</span>
                </a>
                <a href="report.php?type=daily" class="action-btn">
                    <i class="fas fa-calendar"></i>
                    <span>Daily Report</span>
                </a>
                <a href="report.php?type=monthly" class="action-btn">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Monthly Report</span>
                </a>
                <a href="#" class="action-btn" onclick="exportAllData(); return false;">
                    <i class="fas fa-download"></i>
                    <span>Export Data</span>
                </a>
            </div>

            <!-- Charts Section -->
            <div class="charts-grid">
                <!-- Monthly Revenue Chart -->
                <div class="chart-card">
                    <h3><i class="fas fa-chart-bar"></i> Monthly Revenue (2024)</h3>
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

                <!-- Booking Status Distribution -->
                <div class="chart-card">
                    <h3><i class="fas fa-chart-pie"></i> Booking Status Distribution</h3>
                    <div class="status-bars">
                        <?php
                        $totalBookings = $stats['total_bookings'] ?: 1;
                        $statusColors = [
                            'pending' => '#f77f00',
                            'approved' => '#00b4d8',
                            'in_progress' => '#fcbf49',
                            'completed' => '#2a9d8f',
                            'cancelled' => '#e63946'
                        ];
                        foreach ($statusDistribution as $status => $count) {
                            $percentage = ($count / $totalBookings) * 100;
                            echo '<div class="status-bar-item">
                                <div class="label">' . ucfirst(str_replace('_', ' ', $status)) . '</div>
                                <div class="bar-container">
                                    <div class="bar-fill" style="width: ' . $percentage . '%; background: ' . $statusColors[$status] . ';">' . round($percentage) . '%</div>
                                </div>
                                <div class="count">' . $count . '</div>
                            </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Data Tables Section -->
            <div class="section-grid">
                <!-- Recent Bookings -->
                <div class="section-card">
                    <div class="section-header">
                        <h3><i class="fas fa-list"></i> Recent Bookings</h3>
                        <a href="manage_booking.php" class="view-all">View All <i class="fas fa-arrow-right"></i></a>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Bike</th>
                                <th>Service</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($recentBookings && $recentBookings->num_rows > 0): ?>
                                <?php while ($booking = $recentBookings->fetch_assoc()): ?>
                                    <tr>
                                        <td>
                                            <div class="user-info">
                                                <div class="user-avatar"><?php echo strtoupper(substr($booking['full_name'], 0, 1)); ?></div>
                                                <div class="user-details">
                                                    <span class="user-name"><?php echo htmlspecialchars($booking['full_name']); ?></span>
                                                    <span class="user-email"><?php echo htmlspecialchars($booking['bike_number']); ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo htmlspecialchars($booking['bike_model']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['service_type']); ?></td>
                                        <td>
                                            <span class="status-badge status-<?php echo $booking['status']; ?>">
                                                <?php echo ucfirst(str_replace('_', ' ', $booking['status'])); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center" style="color: #888;">No bookings found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Recent Users -->
                <div class="section-card">
                    <div class="section-header">
                        <h3><i class="fas fa-users"></i> New Users</h3>
                        <a href="#" class="view-all">View All <i class="fas fa-arrow-right"></i></a>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Bike</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($recentUsers && $recentUsers->num_rows > 0): ?>
                                <?php while ($user = $recentUsers->fetch_assoc()): ?>
                                    <tr>
                                        <td>
                                            <div class="user-info">
                                                <div class="user-avatar"><?php echo strtoupper(substr($user['full_name'], 0, 1)); ?></div>
                                                <div class="user-details">
                                                    <span class="user-name"><?php echo htmlspecialchars($user['full_name']); ?></span>
                                                    <span class="user-email"><?php echo htmlspecialchars($user['email']); ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo htmlspecialchars($user['bike_model']); ?></td>
                                        <td><?php echo date('d M Y', strtotime($user['created_at'])); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center" style="color: #888;">No users found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Bills -->
            <div class="section-card">
                <div class="section-header">
                    <h3><i class="fas fa-file-invoice-dollar"></i> Recent Bills</h3>
                    <a href="manage_booking.php?tab=bills" class="view-all">View All <i class="fas fa-arrow-right"></i></a>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Bill ID</th>
                            <th>User</th>
                            <th>Service</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($recentBills && $recentBills->num_rows > 0): ?>
                            <?php while ($bill = $recentBills->fetch_assoc()): ?>
                                <tr>
                                    <td>#BILL-<?php echo str_pad($bill['id'], 4, '0', STR_PAD_LEFT); ?></td>
                                    <td>
                                        <div class="user-info">
                                            <div class="user-avatar"><?php echo strtoupper(substr($bill['full_name'], 0, 1)); ?></div>
                                            <div class="user-details">
                                                <span class="user-name"><?php echo htmlspecialchars($bill['full_name']); ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($bill['service_type']); ?></td>
                                    <td><strong>₹<?php echo number_format($bill['total_amount'], 2); ?></strong></td>
                                    <td>
                                        <span class="status-badge status-<?php echo $bill['payment_status'] == 'paid' ? 'completed' : 'pending'; ?>">
                                            <?php echo ucfirst($bill['payment_status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('d M Y', strtotime($bill['bill_generated_at'])); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center" style="color: #888;">No bills found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>© 2024 Bike Garage Management System. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function exportAllData() {
            const data = {
                stats: <?php echo json_encode($stats); ?>,
                monthlyRevenue: <?php echo json_encode($monthlyRevenue); ?>,
                statusDistribution: <?php echo json_encode($statusDistribution); ?>,
                exportDate: new Date().toISOString()
            };
            
            const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'garage_dashboard_' + new Date().toISOString().split('T')[0] + '.json';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }
    </script>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
