-- Bike Garage Management System Database Schema
-- Database Name: bike_garage

-- Create Database
CREATE DATABASE IF NOT EXISTS bike_garage;
USE bike_garage;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    address TEXT,
    bike_model VARCHAR(100),
    bike_number VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Admin Table
CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    full_name VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Service Booking Table
CREATE TABLE IF NOT EXISTS service_booking (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    bike_model VARCHAR(100) NOT NULL,
    bike_number VARCHAR(20) NOT NULL,
    service_type VARCHAR(50) NOT NULL,
    service_description TEXT,
    booking_date DATE NOT NULL,
    preferred_time TIME,
    status ENUM('pending', 'approved', 'in_progress', 'completed', 'cancelled') DEFAULT 'pending',
    admin_notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Billing Table
CREATE TABLE IF NOT EXISTS billing (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    user_id INT NOT NULL,
    service_type VARCHAR(50) NOT NULL,
    labor_charge DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    parts_cost DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    tax_amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    total_amount DECIMAL(10,2) NOT NULL,
    payment_status ENUM('pending', 'paid') DEFAULT 'pending',
    payment_date TIMESTAMP NULL,
    bill_generated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (booking_id) REFERENCES service_booking(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Activity Logs Table
CREATE TABLE IF NOT EXISTS activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    user_type VARCHAR(20) NOT NULL,
    action VARCHAR(100) NOT NULL,
    description TEXT,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert Default Admin (Password: admin123)
INSERT INTO admin (username, password, email, full_name) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@bikeGarage.com', 'System Administrator');

-- Insert Sample Users (Password: user123 for all)
INSERT INTO users (full_name, email, password, phone, address, bike_model, bike_number) VALUES 
('John Smith', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '9876543210', '123 Main St, City', 'Honda Activa', 'MH12AB1234'),
('Jane Doe', 'jane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '9876543211', '456 Oak Ave, Town', 'Royal Enfield Classic', 'MH14CD5678'),
('Mike Johnson', 'mike@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '9876543212', '789 Pine Rd, Village', 'Bajaj Pulsar', 'MH09EF9012');

-- Sample Service Bookings
INSERT INTO service_booking (user_id, bike_model, bike_number, service_type, service_description, booking_date, preferred_time, status) VALUES 
(1, 'Honda Activa', 'MH12AB1234', 'Regular Service', 'Oil change, air filter cleaning', '2024-01-15', '10:00:00', 'completed'),
(1, 'Honda Activa', 'MH12AB1234', 'Repair', 'Brake pad replacement', '2024-01-20', '14:00:00', 'pending'),
(2, 'Royal Enfield Classic', 'MH14CD5678', 'Regular Service', 'Full service including oil change', '2024-01-18', '11:00:00', 'completed'),
(3, 'Bajaj Pulsar', 'MH09EF9012', 'Repair', 'Chain replacement', '2024-01-22', '09:00:00', 'approved');

-- Sample Bills
INSERT INTO billing (booking_id, user_id, service_type, labor_charge, parts_cost, tax_amount, total_amount, payment_status, payment_date) VALUES 
(1, 1, 'Regular Service', 500.00, 350.00, 76.50, 926.50, 'paid', '2024-01-15 12:00:00'),
(3, 2, 'Regular Service', 800.00, 500.00, 117.00, 1417.00, 'paid', '2024-01-18 14:00:00');

-- Useful Queries:

-- Get all bookings with user details
-- SELECT sb.*, u.full_name, u.email, u.phone FROM service_booking sb 
-- JOIN users u ON sb.user_id = u.id ORDER BY sb.created_at DESC;

-- Get booking with bill details
-- SELECT sb.*, b.labor_charge, b.parts_cost, b.tax_amount, b.total_amount, b.payment_status 
-- FROM service_booking sb LEFT JOIN billing b ON sb.id = b.booking_id;

-- Get daily revenue report
-- SELECT DATE(bill_generated_at) as date, COUNT(*) as total_bills, SUM(total_amount) as total_revenue 
-- FROM billing WHERE payment_status = 'paid' GROUP BY DATE(bill_generated_at);

-- Get monthly revenue report
-- SELECT MONTH(bill_generated_at) as month, YEAR(bill_generated_at) as year, COUNT(*) as total_bills, SUM(total_amount) as total_revenue 
-- FROM billing WHERE payment_status = 'paid' GROUP BY MONTH(bill_generated_at), YEAR(bill_generated_at);

-- Update user password (example)
-- UPDATE users SET password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' WHERE email = 'user@example.com';

-- Get pending bookings count
-- SELECT COUNT(*) as pending_count FROM service_booking WHERE status = 'pending';

