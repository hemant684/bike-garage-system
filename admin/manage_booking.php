<?php
/**
 * Manage Bookings Page - Admin Panel
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

// Handle form submissions
$message = '';
$messageType = '';

// Update booking status
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update_status') {
    $bookingId = (int)$_POST['booking_id'];
    $newStatus = $_POST['status'];
    $adminNotes = trim($_POST['admin_notes'] ?? '');

    $stmt = $conn->prepare("UPDATE service_booking SET status = ?, admin_notes = ?, updated_at = NOW() WHERE id = ?");
    $stmt->bind_param("ssi", $newStatus, $adminNotes, $bookingId);
    
    if ($stmt->execute()) {
        $message = "Booking status updated successfully!";
        $messageType = 'success';
    } else {
        $message = "Failed to update booking status.";
        $messageType = 'danger';
    }
    $stmt->close();
}

// Generate bill for booking
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'generate_bill') {
    $bookingId = (int)$_POST['booking_id'];
    $laborCharge = (float)$_POST['labor_charge'];
    $partsCost = (float)$_POST['parts_cost'];
    $taxRate = 0.09; // 9% tax
    
    $taxAmount = ($laborCharge + $partsCost) * $taxRate;
    $totalAmount = $laborCharge + $partsCost + $taxAmount;

    // Get user_id from booking
    $stmt = $conn->prepare("SELECT user_id, service_type FROM service_booking WHERE id = ?");
    $stmt->bind_param("i", $bookingId);
    $stmt->execute();
    $bookingResult = $stmt->get_result();
    $booking = $bookingResult->fetch_assoc();
    $stmt->close();

    if ($booking) {
        // Check if bill already exists
        $stmt = $conn->prepare("SELECT id FROM billing WHERE booking_id = ?");
        $stmt->bind_param("i", $bookingId);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Update existing bill
            $stmt = $conn->prepare("UPDATE billing SET labor_charge = ?, parts_cost = ?, tax_amount = ?, total_amount = ? WHERE booking_id = ?");
            $stmt->bind_param("ddddi", $laborCharge, $partsCost, $taxAmount, $totalAmount, $bookingId);
        } else {
            // Insert new bill
            $stmt = $conn->prepare("INSERT INTO billing (booking_id, user_id, service_type, labor_charge, parts_cost, tax_amount, total_amount) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iissddd", $bookingId, $booking['user_id'], $booking['service_type'], $laborCharge, $partsCost, $taxAmount, $totalAmount);
        }
        
        if ($stmt->execute()) {
            $message = "Bill generated successfully!";
            $messageType = 'success';
        } else {
            $message = "Failed to generate bill.";
            $messageType = 'danger';
        }
        $stmt->close();
    }
}

// Delete booking
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $bookingId = (int)$_GET['delete'];
    
    // Delete associated bills first
    $stmt = $conn->prepare("DELETE FROM billing WHERE booking_id = ?");
    $stmt->bind_param("i", $bookingId);
    $stmt->execute();
    $stmt->close();
    
    // Delete booking
    $stmt = $conn->prepare("DELETE FROM service_booking WHERE id = ?");
    $stmt->bind_param("i", $bookingId);
    
    if ($stmt->execute()) {
        $message = "Booking deleted successfully!";
        $messageType = 'success';
    } else {
        $message = "Failed to delete booking.";
        $messageType = 'danger';
    }
    $stmt->close();
}

// Get filter values
$statusFilter = $_GET['status'] ?? 'all';
$searchTerm = $_GET['search'] ?? '';

// Build query based on filters
$whereClause = "1=1";
if ($statusFilter != 'all') {
    $whereClause .= " AND sb.status = '" . $conn->real_escape_string($statusFilter) . "'";
}
if (!empty($searchTerm)) {
    $whereClause .= " AND (u.full_name LIKE '%" . $conn->real_escape_string($searchTerm) . "%' OR u.email LIKE '%" . $conn->real_escape_string($searchTerm) . "%' OR sb.bike_number LIKE '%" . $conn->real_escape_string($searchTerm) . "%')";
}

// Get all bookings with user details
$sql = "SELECT sb.*, u.full_name, u.email, u.phone, b.id as bill_id, b.total_amount, b.payment_status 
        FROM service_booking sb 
        JOIN users u ON sb.user_id = u.id 
        LEFT JOIN billing b ON sb.id = b.booking_id 
        WHERE $whereClause 
        ORDER BY sb.created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings - Bike Garage Management System</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                <li><a href="manage_booking.php" class="active"><i class="fas fa-tasks"></i> Manage Bookings</a></li>
                <li><a href="report.php"><i class="fas fa-chart-bar"></i> Reports</a></li>
                <li><a href="?logout=true" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header" style="background: linear-gradient(135deg, #c0392b 0%, #e74c3c 100%);">
        <div class="container">
            <h1><i class="fas fa-tasks"></i> Manage Bookings</h1>
            <div class="breadcrumb">
                <a href="admin_dashboard.php">Admin</a> / <span>Manage Bookings</span>
            </div>
        </div>
    </section>

    <!-- Dashboard Content -->
    <section class="content-section">
        <div class="container">
            <!-- Message -->
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $messageType; ?>">
                    <i class="fas fa-<?php echo $messageType == 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <!-- Filters -->
            <div class="card mb-20">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-filter"></i> Filters</h3>
                </div>
                <form method="GET" action="" style="display: flex; gap: 15px; flex-wrap: wrap; align-items: flex-end;">
                    <div class="form-group" style="flex: 1; min-width: 200px; margin-bottom: 0;">
                        <label for="search">Search</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               placeholder="Search by name, email, bike number..." 
                               value="<?php echo htmlspecialchars($searchTerm); ?>">
                    </div>
                    <div class="form-group" style="min-width: 150px; margin-bottom: 0;">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="all" <?php echo $statusFilter == 'all' ? 'selected' : ''; ?>>All Status</option>
                            <option value="pending" <?php echo $statusFilter == 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="approved" <?php echo $statusFilter == 'approved' ? 'selected' : ''; ?>>Approved</option>
                            <option value="in_progress" <?php echo $statusFilter == 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                            <option value="completed" <?php echo $statusFilter == 'completed' ? 'selected' : ''; ?>>Completed</option>
                            <option value="cancelled" <?php echo $statusFilter == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <a href="manage_booking.php" class="btn btn-outline">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Bookings Table -->
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h3 class="card-title"><i class="fas fa-list"></i> All Bookings (<?php echo $result->num_rows; ?>)</h3>
                    <a href="manage_booking.php?export=csv" class="btn btn-outline" style="padding: 5px 15px; font-size: 0.9rem;">
                        <i class="fas fa-file-csv"></i> Export CSV
                    </a>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Bike Details</th>
                                <th>Service</th>
                                <th>Date/Time</th>
                                <th>Status</th>
                                <th>Bill</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($booking = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><strong>#<?php echo $booking['id']; ?></strong></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($booking['full_name']); ?></strong><br>
                                            <small><?php echo htmlspecialchars($booking['email']); ?></small><br>
                                            <small><i class="fas fa-phone"></i> <?php echo htmlspecialchars($booking['phone']); ?></small>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($booking['bike_model']); ?><br>
                                            <small><?php echo htmlspecialchars($booking['bike_number']); ?></small>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($booking['service_type']); ?><br>
                                            <small><?php echo htmlspecialchars(substr($booking['service_description'], 0, 50)); ?><?php echo strlen($booking['service_description']) > 50 ? '...' : ''; ?></small>
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
                                        <td>
                                            <?php if ($booking['bill_id']): ?>
                                                <span class="text-success"><i class="fas fa-check"></i> ₹<?php echo number_format($booking['total_amount'], 2); ?></span>
                                                <br><small class="status-badge status-<?php echo $booking['payment_status']; ?>" style="font-size: 0.7rem;"><?php echo ucfirst($booking['payment_status']); ?></small>
                                            <?php else: ?>
                                                <span class="text-muted">No bill</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="action-btns">
                                                <button class="btn btn-primary btn-sm" onclick="updateStatus(<?php echo $booking['id']; ?>, '<?php echo $booking['status']; ?>', '<?php echo htmlspecialchars(addslashes($booking['admin_notes'] ?? '')); ?>')" title="Update Status">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-success btn-sm" onclick="generateBill(<?php echo $booking['id']; ?>)" title="Generate Bill">
                                                    <i class="fas fa-file-invoice-dollar"></i>
                                                </button>
                                                <a href="?delete=<?php echo $booking['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this booking?');" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <div class="empty-state">
                                            <i class="fas fa-inbox"></i>
                                            <h3>No bookings found</h3>
                                            <p>Try adjusting your filters or wait for new bookings.</p>
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

    <!-- Update Status Modal -->
    <div id="statusModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-edit"></i> Update Booking Status</h3>
                <button class="modal-close" onclick="hideModal('statusModal')">&times;</button>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="action" value="update_status">
                <input type="hidden" name="booking_id" id="modalBookingId">
                
                <div class="form-group">
                    <label for="modalStatus">New Status</label>
                    <select class="form-control" id="modalStatus" name="status" required>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="modalNotes">Admin Notes</label>
                    <textarea class="form-control" id="modalNotes" name="admin_notes" rows="3" placeholder="Add notes about the status change..."></textarea>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-save"></i> Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Generate Bill Modal -->
    <div id="billModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-file-invoice-dollar"></i> Generate Bill</h3>
                <button class="modal-close" onclick="hideModal('billModal')">&times;</button>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="action" value="generate_bill">
                <input type="hidden" name="booking_id" id="billBookingId">
                
                <div class="form-group">
                    <label for="laborCharge">Labor Charge (₹)</label>
                    <input type="number" class="form-control" id="laborCharge" name="labor_charge" step="0.01" min="0" value="0" required>
                </div>
                
                <div class="form-group">
                    <label for="partsCost">Parts Cost (₹)</label>
                    <input type="number" class="form-control" id="partsCost" name="parts_cost" step="0.01" min="0" value="0" required>
                </div>
                
                <div class="form-group">
                    <label>Tax (9%)</label>
                    <input type="text" class="form-control" id="taxDisplay" readonly>
                </div>
                
                <div class="form-group">
                    <label>Total Amount</label>
                    <input type="text" class="form-control" id="totalDisplay" readonly style="font-weight: bold; font-size: 1.2rem;">
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-block">
                        <i class="fas fa-file-invoice"></i> Generate Bill
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

    <script>
        function updateStatus(id, currentStatus, notes) {
            document.getElementById('modalBookingId').value = id;
            document.getElementById('modalStatus').value = currentStatus;
            document.getElementById('modalNotes').value = notes;
            showModal('statusModal');
        }

        function generateBill(id) {
            document.getElementById('billBookingId').value = id;
            document.getElementById('laborCharge').value = '0';
            document.getElementById('partsCost').value = '0';
            showModal('billModal');
        }

        // Calculate bill totals
        document.getElementById('laborCharge')?.addEventListener('input', calculateBill);
        document.getElementById('partsCost')?.addEventListener('input', calculateBill);

        function calculateBill() {
            const labor = parseFloat(document.getElementById('laborCharge').value) || 0;
            const parts = parseFloat(document.getElementById('partsCost').value) || 0;
            const taxRate = 0.09;
            const tax = (labor + parts) * taxRate;
            const total = labor + parts + tax;

            document.getElementById('taxDisplay').value = '₹' + tax.toFixed(2);
            document.getElementById('totalDisplay').value = '₹' + total.toFixed(2);
        }
    </script>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>

