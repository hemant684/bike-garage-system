<?php
/**
 * User Dashboard
 * Bike Garage Management System
 */

// Start session and include configuration
session_start();
require_once '../config/db_config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Get user info
$userId = $_SESSION['user_id'];
$userName = $_SESSION['user_name'];
$userEmail = $_SESSION['user_email'];

// Get user details
$userResult = $conn->query("SELECT * FROM users WHERE id = $userId");
$user = $userResult->fetch_assoc();

// Get user's bookings
$bookingsResult = $conn->query("SELECT * FROM service_booking WHERE user_id = $userId ORDER BY created_at DESC");

// Get user's bills
$billsResult = $conn->query("SELECT b.*, sb.service_type, sb.booking_date, sb.bike_model, sb.bike_number 
                             FROM billing b 
                             JOIN service_booking sb ON b.booking_id = sb.id 
                             WHERE b.user_id = $userId 
                             ORDER BY b.bill_generated_at DESC");

// Get statistics
$totalBookings = $conn->query("SELECT COUNT(*) as total FROM service_booking WHERE user_id = $userId")->fetch_assoc()['total'];
$completedServices = $conn->query("SELECT COUNT(*) as total FROM service_booking WHERE user_id = $userId AND status = 'completed'")->fetch_assoc()['total'];
$pendingServices = $conn->query("SELECT COUNT(*) as total FROM service_booking WHERE user_id = $userId AND status = 'pending'")->fetch_assoc()['total'];
$totalSpent = $conn->query("SELECT COALESCE(SUM(total_amount), 0) as total FROM billing WHERE user_id = $userId AND payment_status = 'paid'")->fetch_assoc()['total'];

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../login.php");
    exit();
}

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $fullName = trim($_POST['full_name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $bikeModel = trim($_POST['bike_model']);
    $bikeNumber = trim($_POST['bike_number']);

    $stmt = $conn->prepare("UPDATE users SET full_name = ?, phone = ?, address = ?, bike_model = ?, bike_number = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $fullName, $phone, $address, $bikeModel, $bikeNumber, $userId);
    
    if ($stmt->execute()) {
        $_SESSION['user_name'] = $fullName;
        $successMessage = "Profile updated successfully!";
    } else {
        $errorMessage = "Failed to update profile.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard - Bike Garage Management System</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="container">
            <a href="user_dashboard.php" class="navbar-brand">
                <i class="fas fa-motorcycle"></i> Bike Garage
            </a>
            <ul class="nav-links">
                <li><a href="user_dashboard.php" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="book_service.php"><i class="fas fa-calendar-plus"></i> Book Service</a></li>
                <li><a href="view_bill.php"><i class="fas fa-file-invoice"></i> My Bills</a></li>
                <li><a href="?logout=true" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout (<?php echo htmlspecialchars($userName); ?>)</a></li>
            </ul>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1><i class="fas fa-user-circle"></i> Welcome, <?php echo htmlspecialchars($userName); ?></h1>
            <div class="breadcrumb">
                <a href="#">Home</a> / <span>Dashboard</span>
            </div>
        </div>
    </section>

    <!-- Dashboard Content -->
    <section class="content-section">
        <div class="container">
            <!-- Success/Error Messages -->
            <?php if (isset($successMessage)): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($successMessage); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($errorMessage)): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($errorMessage); ?>
                </div>
            <?php endif; ?>

            <!-- Statistics Cards -->
            <div class="dashboard-grid">
                <div class="stat-card">
                    <i class="fas fa-calendar-check fa-2x" style="color: var(--secondary-color); margin-bottom: 10px;"></i>
                    <h3><?php echo $totalBookings; ?></h3>
                    <p><i class="fas fa-list"></i> Total Bookings</p>
                </div>
                <div class="stat-card completed">
                    <i class="fas fa-check-circle fa-2x" style="color: var(--success-color); margin-bottom: 10px;"></i>
                    <h3><?php echo $completedServices; ?></h3>
                    <p><i class="fas fa-check"></i> Completed Services</p>
                </div>
                <div class="stat-card pending">
                    <i class="fas fa-clock fa-2x" style="color: var(--warning-color); margin-bottom: 10px;"></i>
                    <h3><?php echo $pendingServices; ?></h3>
                    <p><i class="fas fa-hourglass-half"></i> Pending Services</p>
                </div>
                <div class="stat-card revenue">
                    <i class="fas fa-rupee-sign fa-2x" style="color: var(--success-color); margin-bottom: 10px;"></i>
                    <h3>₹<?php echo number_format($totalSpent, 2); ?></h3>
                    <p><i class="fas fa-wallet"></i> Total Spent</p>
                </div>
            </div>

            <div class="content-wrapper">
                <!-- Main Content -->
                <div class="main-content">
                    <!-- Quick Actions -->
                    <div class="card mb-20">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-bolt"></i> Quick Actions</h3>
                        </div>
                        <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                            <a href="book_service.php" class="btn btn-primary">
                                <i class="fas fa-calendar-plus"></i> Book New Service
                            </a>
                            <a href="view_bill.php" class="btn btn-success">
                                <i class="fas fa-file-invoice"></i> View Bills
                            </a>
                            <button onclick="showModal('profileModal')" class="btn btn-outline">
                                <i class="fas fa-user-edit"></i> Edit Profile
                            </button>
                        </div>
                    </div>

                    <!-- Recent Bookings -->
                    <div class="card">
                        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                            <h3 class="card-title"><i class="fas fa-list"></i> My Service Bookings</h3>
                        </div>
                        <div class="table-container">
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Service</th>
                                        <th>Bike</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($bookingsResult->num_rows > 0): ?>
                                        <?php while ($booking = $bookingsResult->fetch_assoc()): ?>
                                            <tr>
                                                <td><strong>#<?php echo $booking['id']; ?></strong></td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($booking['service_type']); ?></strong><br>
                                                    <small><?php echo htmlspecialchars(substr($booking['service_description'], 0, 40)); ?><?php echo strlen($booking['service_description']) > 40 ? '...' : ''; ?></small>
                                                </td>
                                                <td>
                                                    <?php echo htmlspecialchars($booking['bike_model']); ?><br>
                                                    <small><?php echo htmlspecialchars($booking['bike_number']); ?></small>
                                                </td>
                                                <td>
                                                    <?php echo date('d M Y', strtotime($booking['booking_date'])); ?><br>
                                                    <small><?php echo date('h:i A', strtotime($booking['preferred_time'])); ?></small>
                                                </td>
                                                <td>
                                                    <span class="status-badge status-<?php echo $booking['status']; ?>">
                                                        <?php echo ucfirst(str_replace('_', ' ', $booking['status'])); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <div class="empty-state">
                                                    <i class="fas fa-motorcycle"></i>
                                                    <h3>No Bookings Yet</h3>
                                                    <p>Book your first bike service today!</p>
                                                    <a href="book_service.php" class="btn btn-primary mt-20">
                                                        <i class="fas fa-calendar-plus"></i> Book Service
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Profile Summary -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-user"></i> My Profile</h3>
                        </div>
                        <div style="text-align: center; padding: 10px 0;">
                            <i class="fas fa-user-circle fa-4x" style="color: var(--secondary-color);"></i>
                            <h4 style="margin-top: 10px;"><?php echo htmlspecialchars($user['full_name']); ?></h4>
                            <p style="color: var(--text-light);"><?php echo htmlspecialchars($user['email']); ?></p>
                        </div>
                        <div style="border-top: 1px solid var(--border-color); padding-top: 15px;">
                            <p><i class="fas fa-phone"></i> <?php echo htmlspecialchars($user['phone']); ?></p>
                            <p><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($user['address'] ?: 'Not provided'); ?></p>
                            <p><i class="fas fa-motorcycle"></i> <?php echo htmlspecialchars($user['bike_model']); ?></p>
                            <p><i class="fas fa-tag"></i> <?php echo htmlspecialchars($user['bike_number']); ?></p>
                        </div>
                        <button onclick="showModal('profileModal')" class="btn btn-outline btn-block mt-20">
                            <i class="fas fa-edit"></i> Edit Profile
                        </button>
                    </div>

                    <!-- Recent Bills -->
                    <div class="card mt-20">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-file-invoice-dollar"></i> Recent Bills</h3>
                        </div>
                        <?php if ($billsResult->num_rows > 0): ?>
                            <?php $billCount = 0; ?>
                            <?php while ($bill = $billsResult->fetch_assoc()): ?>
                                <?php if ($billCount >= 3) break; ?>
                                <div style="padding: 10px 0; border-bottom: 1px solid var(--border-color);">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <div>
                                            <strong><?php echo htmlspecialchars($bill['service_type']); ?></strong><br>
                                            <small style="color: var(--text-light);"><?php echo date('d M Y', strtotime($bill['bill_generated_at'])); ?></small>
                                        </div>
                                        <div style="text-align: right;">
                                            <strong style="color: var(--success-color);">₹<?php echo number_format($bill['total_amount'], 2); ?></strong><br>
                                            <span class="status-badge status-<?php echo $bill['payment_status']; ?>" style="font-size: 0.7rem;">
                                                <?php echo ucfirst($bill['payment_status']); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <?php $billCount++; ?>
                            <?php endwhile; ?>
                            <a href="view_bill.php" class="btn btn-outline btn-block mt-20">
                                <i class="fas fa-eye"></i> View All Bills
                            </a>
                        <?php else: ?>
                            <p class="text-center" style="color: var(--text-light);">No bills yet</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Edit Profile Modal -->
    <div id="profileModal" class="modal">
        <div class="modal-content" style="max-width: 500px;">
            <div class="modal-header">
                <h3><i class="fas fa-user-edit"></i> Edit Profile</h3>
                <button class="modal-close" onclick="hideModal('profileModal')">&times;</button>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="update_profile" value="1">
                
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" 
                           value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone" 
                           value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="2"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="bike_model">Bike Model</label>
                    <input type="text" class="form-control" id="bike_model" name="bike_model" 
                           value="<?php echo htmlspecialchars($user['bike_model']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="bike_number">Bike Number</label>
                    <input type="text" class="form-control" id="bike_number" name="bike_number" 
                           value="<?php echo htmlspecialchars($user['bike_number']); ?>" required>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

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

