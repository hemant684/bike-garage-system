<?php
/**
 * Reports Page - Admin Panel
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

// Get report type
$reportType = $_GET['report'] ?? 'daily';
$selectedDate = $_GET['date'] ?? date('Y-m-d');
$selectedMonth = $_GET['month'] ?? date('Y-m');

// Daily Report Data
if ($reportType == 'daily') {
    $date = $selectedDate;
    
    // Bookings on selected date
    $bookingsQuery = "SELECT sb.*, u.full_name, u.email, u.phone, b.total_amount, b.payment_status 
                      FROM service_booking sb 
                      JOIN users u ON sb.user_id = u.id 
                      LEFT JOIN billing b ON sb.id = b.booking_id 
                      WHERE DATE(sb.created_at) = '$date' 
                      ORDER BY sb.created_at DESC";
    $bookingsResult = $conn->query($bookingsQuery);
    
    // Statistics for the day
    $totalBookings = $bookingsResult->num_rows;
    
    $statsResult = $conn->query("SELECT 
        COUNT(*) as total,
        SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
        SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed,
        SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled,
        (SELECT COALESCE(SUM(total_amount), 0) FROM billing WHERE DATE(bill_generated_at) = '$date' AND payment_status = 'paid') as revenue
    FROM service_booking WHERE DATE(created_at) = '$date'");
    $stats = $statsResult->fetch_assoc();
}

// Monthly Report Data
if ($reportType == 'monthly') {
    $month = $selectedMonth;
    $yearMonth = explode('-', $month);
    $year = $yearMonth[0];
    $monthNum = $yearMonth[1];
    
    // Bookings in selected month
    $bookingsQuery = "SELECT sb.*, u.full_name, u.email, u.phone, b.total_amount, b.payment_status 
                      FROM service_booking sb 
                      JOIN users u ON sb.user_id = u.id 
                      LEFT JOIN billing b ON sb.id = b.booking_id 
                      WHERE MONTH(sb.created_at) = '$monthNum' AND YEAR(sb.created_at) = '$year' 
                      ORDER BY sb.created_at DESC";
    $bookingsResult = $conn->query($bookingsQuery);
    
    // Statistics for the month
    $totalBookings = $bookingsResult->num_rows;
    
    $statsResult = $conn->query("SELECT 
        COUNT(*) as total,
        SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
        SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed,
        SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled,
        (SELECT COALESCE(SUM(total_amount), 0) FROM billing WHERE MONTH(bill_generated_at) = '$monthNum' AND YEAR(bill_generated_at) = '$year' AND payment_status = 'paid') as revenue
    FROM service_booking WHERE MONTH(created_at) = '$monthNum' AND YEAR(created_at) = '$year'");
    $stats = $statsResult->fetch_assoc();
    
    // Daily breakdown for the month
    $dailyBreakdown = $conn->query("SELECT 
        DATE(created_at) as date,
        COUNT(*) as bookings,
        (SELECT COALESCE(SUM(total_amount), 0) FROM billing WHERE DATE(bill_generated_at) = DATE(service_booking.created_at) AND payment_status = 'paid') as revenue
    FROM service_booking 
    WHERE MONTH(created_at) = '$monthNum' AND YEAR(created_at) = '$year' 
    GROUP BY DATE(created_at) 
    ORDER BY date");
}

// User Statistics
$userStats = $conn->query("SELECT 
    COUNT(*) as total_users,
    (SELECT COUNT(*) FROM users WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())) as new_this_month,
    (SELECT COUNT(*) FROM service_booking) as total_bookings_per_user
FROM users");

// Export to CSV
if (isset($_GET['export']) && $_GET['export'] == 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $reportType . '_report_' . ($reportType == 'daily' ? $selectedDate : $selectedMonth) . '.csv"');
    
    $output = fopen('php://output', 'w');
    
    if ($reportType == 'daily') {
        fputcsv($output, ['ID', 'User', 'Email', 'Bike Model', 'Bike Number', 'Service Type', 'Status', 'Booking Date', 'Created At']);
        while ($row = $bookingsResult->fetch_assoc()) {
            fputcsv($output, [
                $row['id'],
                $row['full_name'],
                $row['email'],
                $row['bike_model'],
                $row['bike_number'],
                $row['service_type'],
                $row['status'],
                $row['booking_date'],
                $row['created_at']
            ]);
        }
    } else {
        fputcsv($output, ['Date', 'Bookings', 'Revenue']);
        while ($row = $dailyBreakdown->fetch_assoc()) {
            fputcsv($output, [
                $row['date'],
                $row['bookings'],
                $row['revenue']
            ]);
        }
    }
    
    fclose($output);
    exit();
}

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
    <title>Reports - Bike Garage Management System</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .report-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .report-tab {
            padding: 10px 20px;
            background: var(--light-bg);
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
        }
        .report-tab.active {
            background: var(--secondary-color);
            color: var(--white);
            border-color: var(--secondary-color);
        }
        .report-tab:hover:not(.active) {
            background: var(--border-color);
        }
        .chart-container {
            background: var(--white);
            padding: 20px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            margin-bottom: 20px;
        }
        .stat-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        .stat-item {
            text-align: center;
            padding: 20px;
            background: var(--light-bg);
            border-radius: var(--border-radius);
        }
        .stat-item h4 {
            font-size: 2rem;
            color: var(--secondary-color);
            margin-bottom: 5px;
        }
        .stat-item p {
            color: var(--text-light);
            margin: 0;
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
                <li><a href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="manage_booking.php"><i class="fas fa-tasks"></i> Manage Bookings</a></li>
                <li><a href="report.php" class="active"><i class="fas fa-chart-bar"></i> Reports</a></li>
                <li><a href="?logout=true" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header" style="background: linear-gradient(135deg, #c0392b 0%, #e74c3c 100%);">
        <div class="container">
            <h1><i class="fas fa-chart-bar"></i> Reports</h1>
            <div class="breadcrumb">
                <a href="admin_dashboard.php">Admin</a> / <span>Reports</span>
            </div>
        </div>
    </section>

    <!-- Dashboard Content -->
    <section class="content-section">
        <div class="container">
            <!-- Report Type Selection -->
            <div class="report-tabs">
                <a href="?report=daily" class="report-tab <?php echo $reportType == 'daily' ? 'active' : ''; ?>">
                    <i class="fas fa-calendar-day"></i> Daily Report
                </a>
                <a href="?report=monthly" class="report-tab <?php echo $reportType == 'monthly' ? 'active' : ''; ?>">
                    <i class="fas fa-calendar-alt"></i> Monthly Report
                </a>
            </div>

            <!-- Date/Month Selector -->
            <div class="card mb-20">
                <form method="GET" action="" style="display: flex; gap: 15px; align-items: flex-end;">
                    <input type="hidden" name="report" value="<?php echo $reportType; ?>">
                    
                    <?php if ($reportType == 'daily'): ?>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="date">Select Date</label>
                            <input type="date" class="form-control" id="date" name="date" value="<?php echo $selectedDate; ?>">
                        </div>
                    <?php else: ?>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="month">Select Month</label>
                            <input type="month" class="form-control" id="month" name="month" value="<?php echo $selectedMonth; ?>">
                        </div>
                    <?php endif; ?>
                    
                    <div class="form-group" style="margin-bottom: 0;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> View Report
                        </button>
                        <a href="?report=<?php echo $reportType; ?>&export=csv<?php echo $reportType == 'daily' ? '&date=' . $selectedDate : '&month=' . $selectedMonth; ?>" class="btn btn-outline">
                            <i class="fas fa-file-csv"></i> Export CSV
                        </a>
                        <button onclick="printReport()" class="btn btn-outline">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </div>
                </form>
            </div>

            <!-- Statistics Overview -->
            <div class="stat-row">
                <div class="stat-item">
                    <h4><?php echo number_format($stats['total'] ?? 0); ?></h4>
                    <p><i class="fas fa-calendar-check"></i> Total Bookings</p>
                </div>
                <div class="stat-item">
                    <h4><?php echo number_format($stats['pending'] ?? 0); ?></h4>
                    <p><i class="fas fa-clock"></i> Pending</p>
                </div>
                <div class="stat-item">
                    <h4><?php echo number_format($stats['completed'] ?? 0); ?></h4>
                    <p><i class="fas fa-check-circle"></i> Completed</p>
                </div>
                <div class="stat-item">
                    <h4><?php echo number_format($stats['cancelled'] ?? 0); ?></h4>
                    <p><i class="fas fa-times-circle"></i> Cancelled</p>
                </div>
                <div class="stat-item">
                    <h4 style="color: var(--success-color);">₹<?php echo number_format($stats['revenue'] ?? 0, 2); ?></h4>
                    <p><i class="fas fa-rupee-sign"></i> Revenue</p>
                </div>
            </div>

            <?php if ($reportType == 'monthly'): ?>
            <!-- Monthly Daily Breakdown -->
            <div class="card mb-20">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-line"></i> Daily Breakdown</h3>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Bookings</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($dailyBreakdown) && $dailyBreakdown->num_rows > 0): ?>
                                <?php while ($row = $dailyBreakdown->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo date('d M Y', strtotime($row['date'])); ?></td>
                                        <td><?php echo $row['bookings']; ?></td>
                                        <td>₹<?php echo number_format($row['revenue'], 2); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center">No data available for this month</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>

            <!-- Detailed Bookings -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list"></i> 
                        <?php echo $reportType == 'daily' ? 'Bookings on ' . date('d M Y', strtotime($selectedDate)) : 'Bookings in ' . date('F Y', strtotime($selectedMonth . '-01')); ?>
                    </h3>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Bike</th>
                                <th>Service</th>
                                <th>Status</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($bookingsResult) && $bookingsResult->num_rows > 0): ?>
                                <?php while ($booking = $bookingsResult->fetch_assoc()): ?>
                                    <tr>
                                        <td><strong>#<?php echo $booking['id']; ?></strong></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($booking['full_name']); ?></strong><br>
                                            <small><?php echo htmlspecialchars($booking['email']); ?></small>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($booking['bike_model']); ?><br>
                                            <small><?php echo htmlspecialchars($booking['bike_number']); ?></small>
                                        </td>
                                        <td><?php echo htmlspecialchars($booking['service_type']); ?></td>
                                        <td>
                                            <span class="status-badge status-<?php echo $booking['status']; ?>">
                                                <?php echo ucfirst(str_replace('_', ' ', $booking['status'])); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($booking['total_amount']): ?>
                                                ₹<?php echo number_format($booking['total_amount'], 2); ?>
                                                <span class="status-badge status-<?php echo $booking['payment_status']; ?>" style="font-size: 0.7rem;"><?php echo ucfirst($booking['payment_status']); ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <div class="empty-state">
                                            <i class="fas fa-inbox"></i>
                                            <h3>No bookings found</h3>
                                            <p>There are no bookings for the selected period.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
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

    <script>
        function printReport() {
            window.print();
        }
    </script>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>

