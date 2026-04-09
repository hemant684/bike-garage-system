<?php
/**
 * Privacy Policy Page
 * Bike Garage Management System
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - Bike Garage Management System</title>
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
        
        .highlight-box {
            background: rgba(42, 157, 143, 0.1);
            border: 1px solid var(--garage-green);
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .highlight-box p {
            color: var(--text-primary);
            margin: 0;
        }
        
        .highlight-box i {
            color: var(--garage-green);
            margin-right: 10px;
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
            <h1><i class="fas fa-shield-alt"></i> Privacy Policy</h1>
            <p>How we collect, use, and protect your personal information</p>
        </div>
    </section>

    <!-- Content -->
    <section class="legal-content">
        <div class="container" style="max-width: 900px;">
            <div class="last-updated">
                <i class="fas fa-calendar-alt"></i> Last Updated: January 2024
            </div>
            
            <div class="highlight-box">
                <p>
                    <i class="fas fa-check-circle"></i>
                    <strong>Your Privacy Matters:</strong> We are committed to protecting your personal information. We never sell or share your data with third parties for marketing purposes.
                </p>
            </div>
            
            <div class="legal-section">
                <h2><i class="fas fa-info-circle"></i> 1. Introduction</h2>
                <p>Welcome to Bike Garage Management System ("we," "our," or "us"). We respect your privacy and are committed to protecting your personal data. This privacy policy will inform you as to how we look after your personal data when you visit our website or use our services, and tell you about your privacy rights.</p>
                <p>This privacy policy applies to all information collected through our website, mobile applications, and related services.</p>
            </div>
            
            <div class="legal-section">
                <h2><i class="fas fa-database"></i> 2. Information We Collect</h2>
                <p>We may collect, use, store, and transfer different kinds of personal data about you which we have grouped together as follows:</p>
                
                <h3>Identity Data</h3>
                <ul>
                    <li>First name, last name, username</li>
                    <li>Date of birth</li>
                    <li>Photograph (optional)</li>
                </ul>
                
                <h3>Contact Data</h3>
                <ul>
                    <li>Email address</li>
                    <li>Phone number</li>
                    <li>Home address</li>
                </ul>
                
                <h3>Vehicle Data</h3>
                <ul>
                    <li>Bike make, model, and year</li>
                    <li>Registration number</li>
                    <li>Service history</li>
                </ul>
                
                <h3>Financial Data</h3>
                <ul>
                    <li>Payment card details (processed securely by payment providers)</li>
                    <li>Bank account details</li>
                    <li>Payment history</li>
                </ul>
                
                <h3>Technical Data</h3>
                <ul>
                    <li>IP address</li>
                    <li>Browser type and version</li>
                    <li>Time zone setting and location</li>
                    <li>Operating system and platform</li>
                </ul>
                
                <h3>Usage Data</h3>
                <ul>
                    <li>Information about how you use our website and services</li>
                    <li>Booking history</li>
                    <li>Service preferences</li>
                </ul>
            </div>
            
            <div class="legal-section">
                <h2><i class="fas fa-cookie-bite"></i> 3. How We Collect Your Data</h2>
                <p>We use different methods to collect data from and about you including:</p>
                
                <h3>Direct Interactions</h3>
                <ul>
                    <li>When you register for an account</li>
                    <li>When you book a service</li>
                    <li>When you update your profile</li>
                    <li>When you contact our support team</li>
                    <li>When you complete surveys or provide feedback</li>
                </ul>
                
                <h3>Automated Technologies</h3>
                <ul>
                    <li>Cookies and similar technologies</li>
                    <li>Server logs</li>
                    <li>Analytics tools</li>
                </ul>
            </div>
            
            <div class="legal-section">
                <h2><i class="fas fa-cog"></i> 4. How We Use Your Information</h2>
                <p>We will only use your personal data when the law allows us to. Most commonly, we will use your personal data in the following circumstances:</p>
                
                <ul>
                    <li><strong>To register you as a new customer</strong> - Identity and Contact Data</li>
                    <li><strong>To process and deliver your service</strong> - Identity, Contact, Vehicle, and Financial Data</li>
                    <li><strong>To manage our relationship with you</strong> - Identity, Contact, and Usage Data</li>
                    <li><strong>To send you service updates</strong> - Contact Data (via SMS, Email, or App notifications)</li>
                    <li><strong>To improve our services</strong> - Usage Data and Technical Data</li>
                    <li><strong>To comply with legal obligations</strong> - Any relevant data</li>
                </ul>
            </div>
            
            <div class="legal-section">
                <h2><i class="fas fa-share-alt"></i> 5. Data Sharing and Disclosure</h2>
                <p>We may share your personal data with:</p>
                
                <h3>Service Providers</h3>
                <p>Third-party vendors who perform services on our behalf (hosting, payment processing, SMS delivery, etc.)</p>
                
                <h3>Insurance Companies</h3>
                <p>For processing insurance claims, with your explicit consent</p>
                
                <h3>Legal Requirements</h3>
                <p>When required by law, court order, or government request</p>
                
                <p><strong>We do NOT:</strong></p>
                <ul>
                    <li>Sell your personal data to third parties</li>
                    <li>Share your data for marketing purposes without consent</li>
                    <li>Transfer your data outside India without adequate protection</li>
                </ul>
            </div>
            
            <div class="legal-section">
                <h2><i class="fas fa-lock"></i> 6. Data Security</h2>
                <p>We have implemented appropriate security measures to prevent your personal data from being accidentally lost, used, or accessed in an unauthorized way. These measures include:</p>
                
                <ul>
                    <li>SSL/TLS encryption for all data transmission</li>
                    <li>Encrypted storage of sensitive data</li>
                    <li>Regular security assessments and updates</li>
                    <li>Access controls and authentication</li>
                    <li>Secure server environments</li>
                    <li>Regular backups and disaster recovery</li>
                </ul>
                
                <p>While we strive to protect your personal data, no method of transmission over the Internet is 100% secure. We cannot guarantee absolute security.</p>
            </div>
            
            <div class="legal-section">
                <h2><i class="fas fa-cookie-bite"></i> 7. Cookies and Tracking</h2>
                <p>We use cookies and similar tracking technologies to track activity on our website and hold certain information. You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent.</p>
                
                <h3>Types of Cookies We Use:</h3>
                <ul>
                    <li><strong>Essential Cookies:</strong> Required for the website to function properly</li>
                    <li><strong>Performance Cookies:</strong> Help us understand how visitors use our website</li>
                    <li><strong>Functionality Cookies:</strong> Allow us to remember your preferences</li>
                    <li><strong>Analytics Cookies:</strong> Help us improve our services</li>
                </ul>
            </div>
            
            <div class="legal-section">
                <h2><i class="fas fa-retention"></i> 8. Data Retention</h2>
                <p>We will only retain your personal data for as long as necessary to fulfill the purposes we collected it for, including for the purposes of satisfying any legal, accounting, or reporting requirements.</p>
                
                <p>Generally, we retain:</p>
                <ul>
                    <li>Account data: Duration of account + 2 years</li>
                    <li>Service records: 7 years (as required by law)</li>
                    <li>Financial records: 7 years (as required by law)</li>
                    <li>Marketing data: Until you unsubscribe</li>
                </ul>
            </div>
            
            <div class="legal-section">
                <h2><i class="fas fa-user-edit"></i> 9. Your Legal Rights</h2>
                <p>Under certain circumstances, you have rights under data protection laws in relation to your personal data, including the right to:</p>
                
                <ul>
                    <li><strong>Request access</strong> to your personal data</li>
                    <li><strong>Request correction</strong> of your personal data</li>
                    <li><strong>Request erasure</strong> of your personal data</li>
                    <li><strong>Object to processing</strong> of your personal data</li>
                    <li><strong>Request restriction</strong> of processing</li>
                    <li><strong>Request transfer</strong> of your personal data</li>
                    <li><strong>Withdraw consent</strong> at any time</li>
                </ul>
                
                <p>To exercise any of these rights, please contact us using the information below.</p>
            </div>
            
            <div class="legal-section">
                <h2><i class="fas fa-child"></i> 10. Children's Privacy</h2>
                <p>Our services are not intended for individuals under the age of 18. We do not knowingly collect personal data from children. If you believe we have collected information from a child, please contact us immediately.</p>
            </div>
            
            <div class="legal-section">
                <h2><i class="fas fa-globe"></i> 11. International Transfers</h2>
                <p>Your information may be transferred to and processed in countries other than India. We ensure that any such transfers comply with applicable data protection laws and that your data remains adequately protected.</p>
            </div>
            
            <div class="legal-section">
                <h2><i class="fas fa-edit"></i> 12. Changes to This Policy</h2>
                <p>We may update this privacy policy from time to time. We will notify you of any material changes by:</p>
                <ul>
                    <li>Posting the new policy on this page</li>
                    <li>Updating the "Last Updated" date</li>
                    <li>Sending you an email notification (for material changes)</li>
                </ul>
                <p>We encourage you to review this privacy policy periodically.</p>
            </div>
            
            <div class="contact-box">
                <h3><i class="fas fa-envelope"></i> Questions About This Policy?</h3>
                <p>If you have any questions about this Privacy Policy or our data practices, please contact us</p>
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

