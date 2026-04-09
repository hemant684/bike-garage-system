<?php
/**
 * Book Service Page
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

// Get user details
$userResult = $conn->query("SELECT * FROM users WHERE id = $userId");
$user = $userResult->fetch_assoc();

// Handle form submission
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bikeModel = trim($_POST['bikeModel'] ?? '');
    $bikeNumber = trim($_POST['bikeNumber'] ?? '');
    $serviceType = $_POST['serviceType'] ?? '';
    $serviceDescription = trim($_POST['serviceDescription'] ?? '');
    $bookingDate = $_POST['bookingDate'] ?? '';
    $preferredTime = $_POST['preferredTime'] ?? '';

    // Validate inputs
    if (empty($bikeModel) || empty($bikeNumber) || empty($serviceType) || 
        empty($serviceDescription) || empty($bookingDate) || empty($preferredTime)) {
        $error = 'Please fill in all fields';
    } else {
        // Check if date is valid (not in the past)
        if (strtotime($bookingDate) < strtotime(date('Y-m-d'))) {
            $error = 'Please select a valid future date';
        } else {
            // Insert booking
            $stmt = $conn->prepare("INSERT INTO service_booking (user_id, bike_model, bike_number, service_type, service_description, booking_date, preferred_time, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')");
            $stmt->bind_param("issssss", 
                $userId, 
                $bikeModel, 
                $bikeNumber, 
                $serviceType, 
                $serviceDescription, 
                $bookingDate, 
                $preferredTime
            );

            if ($stmt->execute()) {
                $success = 'Service booked successfully! Our team will contact you shortly.';
                // Clear form
                $bookingDate = '';
                $preferredTime = '';
                $serviceDescription = '';
            } else {
                $error = 'Failed to book service. Please try again.';
            }
            $stmt->close();
        }
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Service - Bike Garage Management System</title>
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
                <li><a href="book_service.php" class="active"><i class="fas fa-calendar-plus"></i> Book Service</a></li>
                <li><a href="view_bill.php"><i class="fas fa-file-invoice"></i> My Bills</a></li>
                <li><a href="?logout=true" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1><i class="fas fa-calendar-plus"></i> Book Bike Service</h1>
            <div class="breadcrumb">
                <a href="user_dashboard.php">Dashboard</a> / <span>Book Service</span>
            </div>
        </div>
    </section>

    <!-- Booking Form Section -->
    <section class="content-section">
        <div class="container">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                <!-- Booking Form -->
                <div class="form-container" style="max-width: 100%;">
                    <h3 style="margin-bottom: 20px; color: var(--primary-color);">
                        <i class="fas fa-clipboard-list"></i> Service Booking Form
                    </h3>

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

                    <form id="bookingForm" method="POST" action="">
                        <!-- Bike Information -->
                        <h4 style="margin: 20px 0 15px; color: var(--secondary-color);">
                            <i class="fas fa-motorcycle"></i> Bike Information
                        </h4>

                        <div class="form-group">
                            <label for="bikeModel">
                                <i class="fas fa-bicycle"></i> Bike Model <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="bikeModel" name="bikeModel" 
                                   placeholder="e.g., Honda Activa, Royal Enfield Classic"
                                   value="<?php echo htmlspecialchars($user['bike_model']); ?>">
                        </div>

                        <div class="form-group">
                            <label for="bikeNumber">
                                <i class="fas fa-tag"></i> Bike Number <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="bikeNumber" name="bikeNumber" 
                                   placeholder="e.g., MH12AB1234"
                                   value="<?php echo htmlspecialchars($user['bike_number']); ?>">
                        </div>

                        <!-- Service Details -->
                        <h4 style="margin: 30px 0 15px; color: var(--secondary-color);">
                            <i class="fas fa-tools"></i> Service Details
                        </h4>

                        <div class="form-group">
                            <label for="serviceType">
                                <i class="fas fa-cogs"></i> Service Type <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" id="serviceType" name="serviceType" required>
                                <option value="">Select Service Type</option>
                                <option value="Regular Service" <?php echo (isset($serviceType) && $serviceType == 'Regular Service') ? 'selected' : ''; ?>>
                                    Regular Service (Oil change, filter cleaning)
                                </option>
                                <option value="Repair" <?php echo (isset($serviceType) && $serviceType == 'Repair') ? 'selected' : ''; ?>>
                                    Repair Service
                                </option>
                                <option value="Insurance Claim" <?php echo (isset($serviceType) && $serviceType == 'Insurance Claim') ? 'selected' : ''; ?>>
                                    Insurance Claim
                                </option>
                                <option value="AC Service" <?php echo (isset($serviceType) && $serviceType == 'AC Service') ? 'selected' : ''; ?>>
                                    AC Service
                                </option>
                                <option value="Denting & Painting" <?php echo (isset($serviceType) && $serviceType == 'Denting & Painting') ? 'selected' : ''; ?>>
                                    Denting & Painting
                                </option>
                                <option value="Wheel Care" <?php echo (isset($serviceType) && $serviceType == 'Wheel Care') ? 'selected' : ''; ?>>
                                    Wheel Care
                                </option>
                                <option value="Custom Repair" <?php echo (isset($serviceType) && $serviceType == 'Custom Repair') ? 'selected' : ''; ?>>
                                    Custom Repair
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="serviceDescription">
                                <i class="fas fa-align-left"></i> Service Description <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" id="serviceDescription" name="serviceDescription" rows="4" 
                                      placeholder="Please describe the issues or services needed in detail..."><?php echo htmlspecialchars($serviceDescription ?? ''); ?></textarea>
                        </div>

                        <!-- Scheduling -->
                        <h4 style="margin: 30px 0 15px; color: var(--secondary-color);">
                            <i class="fas fa-calendar-alt"></i> Schedule Appointment
                        </h4>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div class="form-group">
                                <label for="bookingDate">
                                    <i class="fas fa-calendar"></i> Preferred Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control" id="bookingDate" name="bookingDate" 
                                       min="<?php echo date('Y-m-d'); ?>"
                                       value="<?php echo htmlspecialchars($bookingDate ?? ''); ?>">
                            </div>

                            <div class="form-group">
                                <label for="preferredTime">
                                    <i class="fas fa-clock"></i> Preferred Time <span class="text-danger">*</span>
                                </label>
                                <select class="form-control" id="preferredTime" name="preferredTime">
                                    <option value="">Select Time</option>
                                    <option value="09:00:00" <?php echo (isset($preferredTime) && $preferredTime == '09:00:00') ? 'selected' : ''; ?>>09:00 AM</option>
                                    <option value="10:00:00" <?php echo (isset($preferredTime) && $preferredTime == '10:00:00') ? 'selected' : ''; ?>>10:00 AM</option>
                                    <option value="11:00:00" <?php echo (isset($preferredTime) && $preferredTime == '11:00:00') ? 'selected' : ''; ?>>11:00 AM</option>
                                    <option value="12:00:00" <?php echo (isset($preferredTime) && $preferredTime == '12:00:00') ? 'selected' : ''; ?>>12:00 PM</option>
                                    <option value="14:00:00" <?php echo (isset($preferredTime) && $preferredTime == '14:00:00') ? 'selected' : ''; ?>>02:00 PM</option>
                                    <option value="15:00:00" <?php echo (isset($preferredTime) && $preferredTime == '15:00:00') ? 'selected' : ''; ?>>03:00 PM</option>
                                    <option value="16:00:00" <?php echo (isset($preferredTime) && $preferredTime == '16:00:00') ? 'selected' : ''; ?>>04:00 PM</option>
                                    <option value="17:00:00" <?php echo (isset($preferredTime) && $preferredTime == '17:00:00') ? 'selected' : ''; ?>>05:00 PM</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group mt-20">
                            <button type="submit" class="btn btn-success btn-block" style="padding: 15px;">
                                <i class="fas fa-calendar-check"></i> Book Service Appointment
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Sidebar - Info -->
                <div>
                    <!-- Service Pricing Info -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-rupee-sign"></i> Estimated Pricing</h3>
                        </div>
                        <table style="width: 100%;">
                            <tr>
                                <td>Regular Service</td>
                                <td style="text-align: right;"><strong>₹500 - ₹800</strong></td>
                            </tr>
                            <tr>
                                <td>Repair Service</td>
                                <td style="text-align: right;"><strong>Custom</strong></td>
                            </tr>
                            <tr>
                                <td>Insurance Claim</td>
                                <td style="text-align: right;"><strong>As per policy</strong></td>
                            </tr>
                            <tr>
                                <td>AC Service</td>
                                <td style="text-align: right;"><strong>₹800 - ₹1500</strong></td>
                            </tr>
                            <tr>
                                <td>Denting & Painting</td>
                                <td style="text-align: right;"><strong>Custom</strong></td>
                            </tr>
                            <tr>
                                <td>Wheel Care</td>
                                <td style="text-align: right;"><strong>₹300 - ₹600</strong></td>
                            </tr>
                        </table>
                        <p class="text-muted mt-20" style="font-size: 0.9rem;">
                            <i class="fas fa-info-circle"></i> 
                            Final pricing may vary based on parts used and actual work required.
                        </p>
                    </div>

                    <!-- Working Hours -->
                    <div class="card mt-20">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-clock"></i> Working Hours</h3>
                        </div>
                        <table style="width: 100%;">
                            <tr>
                                <td>Monday - Saturday</td>
                                <td style="text-align: right;"><strong>9:00 AM - 6:00 PM</strong></td>
                            </tr>
                            <tr>
                                <td>Sunday</td>
                                <td style="text-align: right;"><strong>Closed</strong></td>
                            </tr>
                        </table>
                    </div>

                    <!-- Contact Info -->
                    <div class="card mt-20">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-phone-alt"></i> Contact Us</h3>
                        </div>
                        <p><i class="fas fa-map-marker-alt"></i> Bike Garage Service Center</p>
                        <p>123 Service Road, Auto Nagar</p>
                        <p>City - 123456</p>
                        <p class="mt-20"><i class="fas fa-phone"></i> +91 9876543210</p>
                        <p><i class="fas fa-envelope"></i> info@bikeGarage.com</p>
                    </div>
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

