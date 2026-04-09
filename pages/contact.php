<?php
/**
 * Contact Page
 * Bike Garage Management System
 */

// Initialize variables
$name = $email = $phone = $subject = $message = '';
$success = $error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    // Validation
    $errors = [];
    
    if (empty($name)) {
        $errors[] = 'Name is required';
    }
    
    if (empty($email)) {
        $errors[] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address';
    }
    
    if (empty($phone)) {
        $errors[] = 'Phone number is required';
    } elseif (!preg_match('/^[6-9]\d{9}$/', $phone)) {
        $errors[] = 'Please enter a valid phone number';
    }
    
    if (empty($message)) {
        $errors[] = 'Message is required';
    }
    
    if (empty($errors)) {
        // In a real application, you would:
        // 1. Save to database
        // 2. Send email notification
        // 3. Send SMS notification
        
        $success = 'Thank you for contacting us! We will get back to you within 24 hours.';
        // Clear form
        $name = $email = $phone = $subject = $message = '';
    } else {
        $error = implode('<br>', $errors);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Bike Garage Management System</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Contact Page Styles */
        .contact-hero {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            padding: 80px 0;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .contact-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 50% 50%, rgba(230, 57, 70, 0.2) 0%, transparent 50%);
        }
        
        .contact-hero h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }
        
        .contact-hero p {
            font-size: 1.2rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }
        
        .contact-section {
            padding: 60px 0;
        }
        
        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
        }
        
        /* Contact Info Cards */
        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .contact-card {
            background: var(--bg-card);
            border-radius: 15px;
            padding: 25px;
            display: flex;
            align-items: flex-start;
            gap: 20px;
            transition: all 0.3s ease;
            border: 1px solid var(--dark-border);
        }
        
        .contact-card:hover {
            transform: translateX(10px);
            border-color: var(--garage-orange);
        }
        
        .contact-card-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            background: linear-gradient(135deg, rgba(230, 57, 70, 0.2), rgba(247, 127, 0, 0.2));
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .contact-card-icon i {
            font-size: 1.5rem;
            color: var(--garage-orange);
        }
        
        .contact-card-content h3 {
            color: var(--text-primary);
            margin-bottom: 5px;
            font-size: 1.1rem;
        }
        
        .contact-card-content p {
            color: var(--text-secondary);
            font-size: 0.95rem;
            margin-bottom: 5px;
        }
        
        .contact-card-content a {
            color: var(--garage-orange);
            text-decoration: none;
        }
        
        .contact-card-content a:hover {
            text-decoration: underline;
        }
        
        /* Business Hours */
        .hours-card {
            background: var(--bg-card);
            border-radius: 15px;
            padding: 25px;
            margin-top: 20px;
            border: 1px solid var(--dark-border);
        }
        
        .hours-card h3 {
            color: var(--text-primary);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .hours-card h3 i {
            color: var(--garage-orange);
        }
        
        .hours-list {
            list-style: none;
        }
        
        .hours-list li {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid var(--dark-border);
            color: var(--text-secondary);
        }
        
        .hours-list li:last-child {
            border-bottom: none;
        }
        
        .hours-list li span:last-child {
            font-weight: 600;
            color: var(--text-primary);
        }
        
        .hours-list li.closed {
            color: var(--garage-red);
        }
        
        /* Contact Form */
        .contact-form-container {
            background: var(--bg-card);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            border: 1px solid var(--dark-border);
        }
        
        .contact-form-container h2 {
            color: var(--text-primary);
            margin-bottom: 30px;
            font-size: 1.8rem;
        }
        
        .contact-form-container h2 i {
            color: var(--garage-orange);
            margin-right: 10px;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        /* Map Section */
        .map-section {
            padding: 60px 0;
            background: var(--dark-secondary);
        }
        
        .map-section h2 {
            text-align: center;
            color: var(--text-primary);
            margin-bottom: 40px;
            font-size: 2rem;
        }
        
        .map-container {
            background: var(--bg-card);
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid var(--dark-border);
        }
        
        .map-placeholder {
            height: 400px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: var(--text-secondary);
        }
        
        .map-placeholder i {
            font-size: 5rem;
            color: var(--garage-orange);
            margin-bottom: 20px;
        }
        
        .map-placeholder p {
            font-size: 1.1rem;
        }
        
        /* Social Section */
        .social-section {
            padding: 60px 0;
        }
        
        .social-section h2 {
            text-align: center;
            color: var(--text-primary);
            margin-bottom: 40px;
            font-size: 2rem;
        }
        
        .social-grid {
            display: flex;
            justify-content: center;
            gap: 30px;
        }
        
        .social-link {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--bg-card);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--text-secondary);
            transition: all 0.3s ease;
            border: 1px solid var(--dark-border);
            text-decoration: none;
        }
        
        .social-link:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(230, 57, 70, 0.3);
        }
        
        .social-link.facebook:hover { color: #1877f2; border-color: #1877f2; }
        .social-link.twitter:hover { color: #1da1f2; border-color: #1da1f2; }
        .social-link.instagram:hover { color: #e4405f; border-color: #e4405f; }
        .social-link.youtube:hover { color: #ff0000; border-color: #ff0000; }
        .social-link.linkedin:hover { color: #0077b5; border-color: #0077b5; }
        
        @media (max-width: 768px) {
            .contact-grid {
                grid-template-columns: 1fr;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .contact-hero h1 {
                font-size: 2rem;
            }
            
            .social-grid {
                flex-wrap: wrap;
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
                <li><a href="contact.php" class="active">Contact</a></li>
                <li><a href="../login.php">Login</a></li>
                <li><a href="../register.php">Register</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="contact-hero">
        <div class="container">
            <h1><i class="fas fa-headset"></i> Get In Touch</h1>
            <p>Have questions or need assistance? We're here to help! Reach out to us through any of the channels below.</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <div class="contact-grid">
                <!-- Contact Info -->
                <div class="contact-info">
                    <div class="contact-card">
                        <div class="contact-card-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-card-content">
                            <h3>Visit Our Garage</h3>
                            <p>Bike Garage Service Center</p>
                            <p>imadol 1, gwarko</p>
                            <p>City - 123456, Nepal</p>
                        </div>
                    </div>
                    
                    <div class="contact-card">
                        <div class="contact-card-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="contact-card-content">
                            <h3>Call Us</h3>
                            <p><a href="tel:+9779876543210">+977 98765 43210</a></p>
                            <p><a href="tel:+9779876543211">+977 98765 43211</a></p>
                            <p class="text-muted">sun-fri: 9AM - 6PM</p>
                        </div>
                    </div>
                    
                    <div class="contact-card">
                        <div class="contact-card-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-card-content">
                            <h3>Email Us</h3>
                            <p><a href="mailto:info@bikeGarage.com">info@bikeGarage.com</a></p>
                            <p><a href="mailto:support@bikeGarage.com">support@bikeGarage.com</a></p>
                            <p><a href="mailto:bookings@bikeGarage.com">bookings@bikeGarage.com</a></p>
                        </div>
                    </div>
                    
                    <div class="contact-card">
                        <div class="contact-card-icon">
                            <i class="fas fa-comment-alt"></i>
                        </div>
                        <div class="contact-card-content">
                            <h3>Live Chat</h3>
                            <p>Available 24/7</p>
                            <p>Average response time: 5 minutes</p>
                            <p><a href="#">Start Chat Now</a></p>
                        </div>
                    </div>
                    
                    <!-- Business Hours -->
                    <div class="hours-card">
                        <h3><i class="fas fa-clock"></i> Business Hours</h3>
                        <ul class="hours-list">
                            <li><span>sunday - thursday</span><span>9:00 AM - 7:00 PM</span></li>
                            <li><span>friday</span><span>9:00 AM - 6:00 PM</span></li>
                            <li class="closed"><span>saturday</span><span>Closed</span></li>
                            <li><span>Emergency Services</span><span>24/7 Available</span></li>
                        </ul>
                    </div>
                </div>
                
                <!-- Contact Form -->
                <div class="contact-form-container">
                    <h2><i class="fas fa-paper-plane"></i> Send Us a Message</h2>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($success): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success); ?>
                        </div>
                    <?php endif; ?>
                    
                    <form id="contactForm" method="POST" action="">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">
                                    <i class="fas fa-user"></i> Your Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       placeholder="Enter your full name"
                                       value="<?php echo htmlspecialchars($name); ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="email">
                                    <i class="fas fa-envelope"></i> Email Address <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       placeholder="Enter your email"
                                       value="<?php echo htmlspecialchars($email); ?>">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="phone">
                                    <i class="fas fa-phone"></i> Phone Number <span class="text-danger">*</span>
                                </label>
                                <input type="tel" class="form-control" id="phone" name="phone" 
                                       placeholder="10-digit mobile number"
                                       value="<?php echo htmlspecialchars($phone); ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="subject">
                                    <i class="fas fa-tag"></i> Subject
                                </label>
                                <select class="form-control" id="subject" name="subject">
                                    <option value="">Select a subject</option>
                                    <option value="General Inquiry" <?php echo $subject == 'General Inquiry' ? 'selected' : ''; ?>>General Inquiry</option>
                                    <option value="Booking Query" <?php echo $subject == 'Booking Query' ? 'selected' : ''; ?>>Booking Query</option>
                                    <option value="Service Complaint" <?php echo $subject == 'Service Complaint' ? 'selected' : ''; ?>>Service Complaint</option>
                                    <option value="Feedback" <?php echo $subject == 'Feedback' ? 'selected' : ''; ?>>Feedback</option>
                                    <option value="Partnership" <?php echo $subject == 'Partnership' ? 'selected' : ''; ?>>Partnership</option>
                                    <option value="Other" <?php echo $subject == 'Other' ? 'selected' : ''; ?>>Other</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">
                                <i class="fas fa-comment-alt"></i> Your Message <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" id="message" name="message" rows="5" 
                                      placeholder="Tell us how we can help you..."><?php echo htmlspecialchars($message); ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block" style="padding: 15px;">
                                <i class="fas fa-paper-plane"></i> Send Message
                            </button>
                        </div>
                        
                        <div class="text-center text-muted mt-20" style="font-size: 0.9rem;">
                            <p><i class="fas fa-shield-alt"></i> Your information is secure and will never be shared.</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section">
        <div class="container">
            <h2><i class="fas fa-map-marked-alt"></i> Find Us</h2>
            <div class="map-container">
                <div class="map-placeholder">
                    <i class="fas fa-map-marked-alt"></i>
                    <p>Interactive Map Loading...</p>
                    <p style="font-size: 0.9rem; margin-top: 10px;">imadol 1, gwarko, City - 123456</p>
                    <a href="https://maps.google.com" target="_blank" class="btn btn-primary mt-20">
                        <i class="fas fa-external-link-alt"></i> Open in Google Maps
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Social Section -->
    <section class="social-section">
        <div class="container">
            <h2><i class="fas fa-share-alt"></i> Connect With Us</h2>
            <div class="social-grid">
                <a href="#" class="social-link facebook" title="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="social-link twitter" title="Twitter">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="social-link instagram" title="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="social-link youtube" title="YouTube">
                    <i class="fab fa-youtube"></i>
                </a>
                <a href="#" class="social-link linkedin" title="LinkedIn">
                    <i class="fab fa-linkedin-in"></i>
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
    <script>
        // Contact form validation
        document.getElementById('contactForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            let isValid = true;
            clearErrors();
            
            const name = document.getElementById('name');
            const email = document.getElementById('email');
            const phone = document.getElementById('phone');
            const message = document.getElementById('message');
            
            if (!name.value.trim()) {
                showError(name, 'Name is required');
                isValid = false;
            }
            
            if (!email.value.trim()) {
                showError(email, 'Email is required');
                isValid = false;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
                showError(email, 'Please enter a valid email');
                isValid = false;
            }
            
            if (!phone.value.trim()) {
                showError(phone, 'Phone is required');
                isValid = false;
            } else if (!/^[6-9]\d{9}$/.test(phone.value)) {
                showError(phone, 'Please enter a valid 10-digit phone');
                isValid = false;
            }
            
            if (!message.value.trim()) {
                showError(message, 'Message is required');
                isValid = false;
            }
            
            if (isValid) {
                this.submit();
            }
        });
    </script>
</body>
</html>

