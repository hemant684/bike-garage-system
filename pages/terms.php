<?php
/**
 * Terms & Conditions Page
 * Bike Garage Management System
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms & Conditions - Bike Garage Management System</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .legal-hero {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            padding: 80px 0;
            text-align: center;
            color: white;
        }
        
        .legal-hero h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }
        
        .legal-hero p {
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .legal-content {
            padding: 60px 0;
        }
        
        .legal-section {
            margin-bottom: 40px;
        }
        
        .legal-section h2 {
            color: var(--garage-orange);
            font-size: 1.5rem;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--dark-border);
        }
        
        .legal-section h3 {
            color: var(--text-primary);
            font-size: 1.2rem;
            margin: 20px 0 10px;
        }
        
        .legal-section p, .legal-section li {
            color: var(--text-secondary);
            line-height: 1.8;
            margin-bottom: 15px;
        }
        
        .legal-section ul {
            padding-left: 25px;
        }
        
        .legal-section li {
            margin-bottom: 10px;
        }
        
        .last-updated {
            background: var(--dark-secondary);
            padding: 15px 25px;
            border-radius: 10px;
            margin-bottom: 40px;
            color: var(--text-muted);
            font-size: 0.9rem;
        }
        
        .contact-box {
            background: linear-gradient(135deg, rgba(230, 57, 70, 0.1), rgba(247, 127, 0, 0.1));
            border: 1px solid var(--dark-border);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            margin-top: 40px;
        }
        
        .contact-box h3 {
            color: var(--text-primary);
            margin-bottom: 15px;
        }
        
        @media (max-width: 768px) {
            .legal-hero h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="container">
            <a href="index.html" class="navbar-brand">
                <i class="fas fa-motorcycle"></i> Bike Garage
            </a>
            <ul class="nav-links">
                <li><a href="../index.html">Home</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="../login.php">Login</a></li>
                <li><a href="../register.php">Register</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="legal-hero">
        <div class="container">
            <h1><i class="fas fa-file-contract"></i> Terms & Conditions</h1>
            <p>Please read these terms and conditions carefully before using our services</p>
        </div>
    </section>

    <!-- Content -->
    <section class="legal-content">
        <div class="container" style="max-width: 900px;">
            <div class="last-updated">
                <i class="fas fa-calendar-alt"></i> Last Updated: January 2024
            </div>
            
            <div class="legal-section">
                <h2><i class="fas fa-handshake"></i> 1. Acceptance of Terms</h2>
                <p>By accessing and using the Bike Garage Management System ("we," "our," or "us"), you accept and agree to be bound by the terms and provisions of this agreement. If you do not agree to abide by these terms, please do not use this service.</p>
                <p>This website and all its contents are owned and operated by Bike Garage Management System. The use of this website constitutes your acceptance of these Terms and Conditions.</p>
            </div>
            
            <div class="legal-section">
                <h2><i class="fas fa-info-circle"></i> 2. Use of Services</h2>
                <p>Our services are available to individuals who are at least 18 years of age and have the legal capacity to form binding contracts. By using our services, you confirm that you meet these requirements.</p>
                
                <h3>You agree to:</h3>
                <ul>
                    <li>Provide accurate, current, and complete information when creating an account</li>
                    <li>Maintain the security of your password and account</li>
                    <li>Use our services only for lawful purposes</li>
                    <li>Not attempt to gain unauthorized access to any part of the website</li>
                    <li>Not use our services in any way that could damage, disable, or impair the website</li>
                </ul>
                
                <h3>You agree not to:</h3>
                <ul>
                    <li>Submit false or misleading information</li>
                    <li>Use the website for any illegal or unauthorized purpose</li>
                    <li>Interfere with or disrupt the website or servers</li>
                    <li>Reproduce, distribute, or publicly display any content from this website</li>
                </ul>
            </div>
            
            <div class="legal-section">
                <h2><i class="fas fa-calendar-check"></i> 3. Booking and Appointments</h2>
                <p>When you book a service appointment through our website:</p>
                <ul>
                    <li>You agree to provide accurate information about your bike and the required service</li>
                    <li>Appointments are subject to availability</li>
                    <li>You must cancel or reschedule at least 24 hours before the scheduled time</li>
                    <li>We reserve the right to refuse or cancel any booking</li>
                    <li>Service times are estimates and may vary based on the actual work required</li>
                </ul>
            </div>
            
            <div class="legal-section">
                <h2><i class="fas fa-rupee-sign"></i> 4. Pricing and Payment</h2>
                <p>All prices are displayed in Indian Rupees (INR) and are subject to change without notice. The price quoted at the time of booking is valid unless there are changes to the required work.</p>
                
                <h3>Payment Terms:</h3>
                <ul>
                    <li>Payment is due upon completion of service unless otherwise agreed</li>
                    <li>We accept cash, credit/debit cards, UPI, and net banking</li>
                    <li>For insurance claims, we work directly with your insurance provider</li>
                    <li>Additional charges may apply for parts not included in the original estimate</li>
                </ul>
            </div>
            
            <div class="legal-section">
                <h2><i class="fas fa-shield-alt"></i> 5. Warranty and Liability</h2>
                <p>We provide a 30-day warranty on all labor performed. Parts warranty is as per the manufacturer's warranty and will be communicated at the time of service.</p>
                
                <h3>Limitation of Liability:</h3>
                <ul>
                    <li>Our liability is limited to the cost of services rendered</li>
                    <li>We are not liable for any indirect, incidental, or consequential damages</li>
                    <li>We are not responsible for any pre-existing conditions or normal wear and tear</li>
                    <li>Customers are responsible for items left in the vehicle</li>
                </ul>
            </div>
            
            <div class="legal-section">
                <h2><i class="fas fa-user-secret"></i> 6. Privacy and Data Protection</h2>
                <p>Your privacy is important to us. Please review our <a href="privacy.php" style="color: var(--garage-orange);">Privacy Policy</a> which also governs your use of the website, to understand our practices regarding your personal information.</p>
            </div>
            
            <div class="legal-section">
                <h2><i class="fas fa-car"></i> 7. Bike Pickup and Delivery</h2>
                <p>For pickup and delivery services:</p>
                <ul>
                    <li>We offer free pickup and delivery within 10km of our service center</li>
                    <li>Customers must ensure someone is available to hand over and receive the bike</li>
                    <li>We are not liable for any damage during transit beyond our control</li>
                    <li>A valid ID is required at the time of pickup and delivery</li>
                </ul>
            </div>
            
            <div class="legal-section">
                <h2><i class="fas fa-ban"></i> 8. Cancellation and Refund Policy</h2>
                <h3>Cancellations:</h3>
                <ul>
                    <li>Cancellations made 24+ hours before appointment: Full refund</li>
                    <li>Cancellations made 12-24 hours before appointment: 50% cancellation fee</li>
                    <li>Cancellations made less than 12 hours before appointment: No refund</li>
                </ul>
                
                <h3>Refunds:</h3>
                <ul>
                    <li>Refunds are processed within 7-10 business days</li>
                    <li>Refunds will be made to the original payment method</li>
                    <li>No cash refunds; only digital payment refunds</li>
                </ul>
            </div>
            
            <div class="legal-section">
                <h2><i class="fas fa-edit"></i> 9. Changes to Terms</h2>
                <p>We reserve the right to modify, alter, or otherwise update these terms at any time. Such changes shall be effective immediately upon posting on this website. Your continued use of the website after any such changes constitutes acceptance of the new terms.</p>
            </div>
            
            <div class="legal-section">
                <h2><i class="fas fa-gavel"></i> 10. Governing Law</h2>
                <p>These terms and conditions are governed by and construed in accordance with the laws of India. Any disputes arising out of or in connection with these terms shall be subject to the exclusive jurisdiction of the courts in the jurisdiction where our service center is located.</p>
            </div>
            
            <div class="contact-box">
                <h3><i class="fas fa-envelope"></i> Questions about these Terms?</h3>
                <p>If you have any questions about these Terms & Conditions, please contact us</p>
                <a href="contact.php" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> Contact Us
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 Bike Garage Management System. All rights reserved.</p>
            <p style="margin-top: 10px;">
                <a href="about.php">About</a> | 
                <a href="services.php">Services</a> | 
                <a href="contact.php">Contact</a> | 
                <a href="privacy.php">Privacy Policy</a> | 
                <a href="terms.php">Terms & Conditions</a>
            </p>
        </div>
    </footer>

    <script src="../js/validation.js"></script>
</body>
</html>

