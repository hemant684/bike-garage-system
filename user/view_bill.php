<?php
/**
 * View Bills Page - User Panel
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

// Get all bills for the user
$billsResult = $conn->query("SELECT b.*, sb.service_type, sb.booking_date, sb.bike_model, sb.bike_number, sb.service_description 
                             FROM billing b 
                             JOIN service_booking sb ON b.booking_id = sb.id 
                             WHERE b.user_id = $userId 
                             ORDER BY b.bill_generated_at DESC");

// Get statistics
$totalBills = $conn->query("SELECT COUNT(*) as total FROM billing WHERE user_id = $userId")->fetch_assoc()['total'];
$paidAmount = $conn->query("SELECT COALESCE(SUM(total_amount), 0) as total FROM billing WHERE user_id = $userId AND payment_status = 'paid'")->fetch_assoc()['total'];
$pendingAmount = $conn->query("SELECT COALESCE(SUM(total_amount), 0) as total FROM billing WHERE user_id = $userId AND payment_status = 'pending'")->fetch_assoc()['total'];

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../login.php");
    exit();
}

// Handle bill ID for modal
$billId = isset($_GET['view_bill']) ? (int)$_GET['view_bill'] : 0;
$selectedBill = null;

if ($billId > 0) {
    $stmt = $conn->prepare("SELECT b.*, sb.service_type, sb.booking_date, sb.bike_model, sb.bike_number, sb.service_description, u.full_name, u.email, u.phone, u.address 
                           FROM billing b 
                           JOIN service_booking sb ON b.booking_id = sb.id 
                           JOIN users u ON b.user_id = u.id 
                           WHERE b.id = ? AND b.user_id = ?");
    $stmt->bind_param("ii", $billId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $selectedBill = $result->fetch_assoc();
    $stmt->close();
}

// Export bills to CSV
if (isset($_GET['export']) && $_GET['export'] == 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="my_bills_' . date('Y-m-d') . '.csv"');
    
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Bill ID', 'Service Type', 'Bike', 'Date', 'Labor Charge', 'Parts Cost', 'Tax', 'Total Amount', 'Status']);
    
    while ($row = $billsResult->fetch_assoc()) {
        fputcsv($output, [
            $row['id'],
            $row['service_type'],
            $row['bike_model'] . ' (' . $row['bike_number'] . ')',
            date('d M Y', strtotime($row['bill_generated_at'])),
            $row['labor_charge'],
            $row['parts_cost'],
            $row['tax_amount'],
            $row['total_amount'],
            $row['payment_status']
        ]);
    }
    
    fclose($output);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bills - Bike Garage Management System</title>
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
                <li><a href="user_dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="book_service.php"><i class="fas fa-calendar-plus"></i> Book Service</a></li>
                <li><a href="view_bill.php" class="active"><i class="fas fa-file-invoice"></i> My Bills</a></li>
                <li><a href="?logout=true" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1><i class="fas fa-file-invoice-dollar"></i> My Bills</h1>
            <div class="breadcrumb">
                <a href="user_dashboard.php">Dashboard</a> / <span>My Bills</span>
            </div>
        </div>
    </section>

    <!-- Dashboard Content -->
    <section class="content-section">
        <div class="container">
            <!-- Statistics Cards -->
            <div class="dashboard-grid">
                <div class="stat-card">
                    <i class="fas fa-file-invoice fa-2x" style="color: var(--secondary-color); margin-bottom: 10px;"></i>
                    <h3><?php echo $totalBills; ?></h3>
                    <p><i class="fas fa-list"></i> Total Bills</p>
                </div>
                <div class="stat-card completed">
                    <i class="fas fa-check-circle fa-2x" style="color: var(--success-color); margin-bottom: 10px;"></i>
                    <h3>₹<?php echo number_format($paidAmount, 2); ?></h3>
                    <p><i class="fas fa-check"></i> Paid Amount</p>
                </div>
                <div class="stat-card pending">
                    <i class="fas fa-clock fa-2x" style="color: var(--warning-color); margin-bottom: 10px;"></i>
                    <h3>₹<?php echo number_format($pendingAmount, 2); ?></h3>
                    <p><i class="fas fa-hourglass-half"></i> Pending Amount</p>
                </div>
                <div class="stat-card revenue">
                    <a href="?export=csv" class="btn btn-outline" style="text-decoration: none;">
                        <i class="fas fa-file-csv"></i> Export CSV
                    </a>
                </div>
            </div>

            <!-- Bills Table -->
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h3 class="card-title"><i class="fas fa-list"></i> All Bills</h3>
                    <a href="?export=csv" class="btn btn-outline" style="padding: 5px 15px; font-size: 0.9rem;">
                        <i class="fas fa-file-csv"></i> Export to CSV
                    </a>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Bill ID</th>
                                <th>Service</th>
                                <th>Bike Details</th>
                                <th>Bill Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($billsResult->num_rows > 0): ?>
                                <?php while ($bill = $billsResult->fetch_assoc()): ?>
                                    <tr>
                                        <td><strong>#BILL-<?php echo str_pad($bill['id'], 4, '0', STR_PAD_LEFT); ?></strong></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($bill['service_type']); ?></strong><br>
                                            <small><?php echo htmlspecialchars(substr($bill['service_description'], 0, 30)); ?>...</small>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($bill['bike_model']); ?><br>
                                            <small><?php echo htmlspecialchars($bill['bike_number']); ?></small>
                                        </td>
                                        <td><?php echo date('d M Y', strtotime($bill['bill_generated_at'])); ?></td>
                                        <td>
                                            <strong style="color: var(--success-color);">₹<?php echo number_format($bill['total_amount'], 2); ?></strong>
                                        </td>
                                        <td>
                                            <span class="status-badge status-<?php echo $bill['payment_status']; ?>">
                                                <?php echo ucfirst($bill['payment_status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-btns">
                                                <a href="?view_bill=<?php echo $bill['id']; ?>" class="btn btn-primary btn-sm" title="View Bill">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button onclick="printBill(<?php echo $bill['id']; ?>)" class="btn btn-outline btn-sm" title="Print Bill">
                                                    <i class="fas fa-print"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <div class="empty-state">
                                            <i class="fas fa-file-invoice-dollar"></i>
                                            <h3>No Bills Yet</h3>
                                            <p>Your service bills will appear here after completion.</p>
                                            <a href="book_service.php" class="btn btn-primary mt-20">
                                                <i class="fas fa-calendar-plus"></i> Book a Service
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
    </section>

    <!-- Bill View Modal (shown when view_bill parameter is set) -->
    <?php if ($selectedBill): ?>
    <div id="billModal" class="modal" style="display: flex;">
        <div class="bill-container" style="max-width: 700px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <button onclick="window.location.href='view_bill.php'" class="btn btn-outline" style="padding: 5px 15px;">
                    <i class="fas fa-times"></i> Close
                </button>
                <button onclick="printBillContent()" class="btn btn-primary" style="padding: 5px 15px;">
                    <i class="fas fa-print"></i> Print
                </button>
            </div>
            
            <div id="billContent">
                <!-- Bill Header -->
                <div class="bill-header">
                    <h2><i class="fas fa-motorcycle"></i> Bike Garage Service Center</h2>
                    <p>Professional Bike Servicing & Repair</p>
                    <p style="font-size: 0.9rem;">123 Service Road, Auto Nagar, City - 123456</p>
                    <p style="font-size: 0.9rem;">Phone: +91 9876543210 | Email: info@bikeGarage.com</p>
                </div>

                <!-- Bill Info -->
                <div style="display: flex; justify-content: space-between; margin-bottom: 30px;">
                    <div>
                        <h4>Bill To:</h4>
                        <p><strong><?php echo htmlspecialchars($selectedBill['full_name']); ?></strong></p>
                        <p><?php echo htmlspecialchars($selectedBill['email']); ?></p>
                        <p><?php echo htmlspecialchars($selectedBill['phone']); ?></p>
                        <p><?php echo htmlspecialchars($selectedBill['address'] ?: 'Address not provided'); ?></p>
                    </div>
                    <div style="text-align: right;">
                        <h4>Bill Details:</h4>
                        <p><strong>Bill No:</strong> #BILL-<?php echo str_pad($selectedBill['id'], 4, '0', STR_PAD_LEFT); ?></p>
                        <p><strong>Date:</strong> <?php echo date('d M Y', strtotime($selectedBill['bill_generated_at'])); ?></p>
                        <p><strong>Service Date:</strong> <?php echo date('d M Y', strtotime($selectedBill['booking_date'])); ?></p>
                    </div>
                </div>

                <!-- Service Details -->
                <div class="bill-details">
                    <h4>Service Information</h4>
                    <table style="width: 100%; margin-bottom: 20px;">
                        <tr>
                            <td><strong>Service Type:</strong></td>
                            <td><?php echo htmlspecialchars($selectedBill['service_type']); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Bike Model:</strong></td>
                            <td><?php echo htmlspecialchars($selectedBill['bike_model']); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Bike Number:</strong></td>
                            <td><?php echo htmlspecialchars($selectedBill['bike_number']); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Description:</strong></td>
                            <td><?php echo htmlspecialchars($selectedBill['service_description']); ?></td>
                        </tr>
                    </table>
                </div>

                <!-- Bill Table -->
                <table class="bill-table" style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                    <thead>
                        <tr style="background: var(--primary-color); color: white;">
                            <th style="padding: 10px; text-align: left;">Description</th>
                            <th style="padding: 10px; text-align: right;">Amount (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding: 10px; border-bottom: 1px solid var(--border-color);">Labor Charge</td>
                            <td style="padding: 10px; border-bottom: 1px solid var(--border-color); text-align: right;"><?php echo number_format($selectedBill['labor_charge'], 2); ?></td>
                        </tr>
                        <tr>
                            <td style="padding: 10px; border-bottom: 1px solid var(--border-color);">Parts Cost</td>
                            <td style="padding: 10px; border-bottom: 1px solid var(--border-color); text-align: right;"><?php echo number_format($selectedBill['parts_cost'], 2); ?></td>
                        </tr>
                        <tr>
                            <td style="padding: 10px; border-bottom: 1px solid var(--border-color);">Tax (9%)</td>
                            <td style="padding: 10px; border-bottom: 1px solid var(--border-color); text-align: right;"><?php echo number_format($selectedBill['tax_amount'], 2); ?></td>
                        </tr>
                    </tbody>
                </table>

                <!-- Total -->
                <div class="bill-total">
                    <p>Total Amount: <strong style="color: var(--success-color);">₹<?php echo number_format($selectedBill['total_amount'], 2); ?></strong></p>
                    <p style="font-size: 0.9rem; color: var(--text-light);">
                        Payment Status: 
                        <span class="status-badge status-<?php echo $selectedBill['payment_status']; ?>">
                            <?php echo ucfirst($selectedBill['payment_status']); ?>
                        </span>
                    </p>
                </div>

                <!-- Footer -->
                <div style="text-align: center; margin-top: 40px; padding-top: 20px; border-top: 1px solid var(--border-color);">
                    <p style="font-size: 0.9rem; color: var(--text-light);">
                        Thank you for choosing Bike Garage Service Center!
                    </p>
                    <p style="font-size: 0.8rem; color: var(--text-light);">
                        This is a computer-generated bill. No signature required.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 Bike Garage Management System. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function printBill(billId) {
            window.location.href = '?view_bill=' + billId;
        }

        function printBillContent() {
            const content = document.getElementById('billContent').innerHTML;
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Print Bill</title>
                    <link rel="stylesheet" href="../css/style.css">
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
                    <style>
                        body { padding: 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
                        .bill-header { text-align: center; border-bottom: 2px solid #2c3e50; padding-bottom: 20px; margin-bottom: 20px; }
                        .bill-header h2 { color: #2c3e50; margin: 0; }
                        .bill-total { text-align: right; font-size: 1.25rem; font-weight: bold; padding-top: 15px; border-top: 2px solid #dee2e6; }
                        @media print {
                            .modal-header { display: none; }
                        }
                    </style>
                </head>
                <body>
                    ${content}
                </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.print();
        }
    </script>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>

