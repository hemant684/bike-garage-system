<?php
/**
 * About Us Page
 * Bike Garage Management System
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Bike Garage Management System</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Page-specific styles */
        .about-hero {
            background: linear-gradient(135deg, rgba(230, 57, 70, 0.9) 0%, rgba(247, 127, 0, 0.9) 100%);
            padding: 80px 0;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .about-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="2"/></svg>') repeat;
            background-size: 100px;
            animation: rotate 20s linear infinite;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .about-hero .container {
            position: relative;
            z-index: 1;
        }
        
        .about-hero h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .about-hero p {
            font-size: 1.2rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .about-content {
            padding: 60px 0;
        }
        
        .about-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
            margin-bottom: 60px;
        }
        
        .about-section:nth-child(even) {
            direction: rtl;
        }
        
        .about-section:nth-child(even) > * {
            direction: ltr;
        }
        
        .about-text h2 {
            color: var(--garage-red);
            font-size: 2rem;
            margin-bottom: 20px;
        }
        
        .about-text h2 i {
            margin-right: 10px;
        }
        
        .about-text p {
            color: var(--text-secondary);
            line-height: 1.8;
            margin-bottom: 15px;
        }
        
        .about-image {
            background: linear-gradient(135deg, var(--dark-card), var(--dark-secondary));
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        
        .about-image i {
            font-size: 8rem;
            background: linear-gradient(135deg, var(--garage-red), var(--garage-orange));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Stats Section */
        .stats-section {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            padding: 60px 0;
            margin: 60px 0;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            text-align: center;
        }
        
        .stat-item {
            padding: 30px;
        }
        
        .stat-item i {
            font-size: 3rem;
            color: var(--garage-orange);
            margin-bottom: 15px;
        }
        
        .stat-item .number {
            font-size: 3rem;
            font-weight: bold;
            color: white;
            margin-bottom: 10px;
        }
        
        .stat-item .label {
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.9rem;
        }
        
        /* Team Section */
        .team-section {
            padding: 60px 0;
        }
        
        .team-section h2 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 50px;
            color: var(--text-primary);
        }
        
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }
        
        .team-card {
            background: var(--bg-card);
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid var(--dark-border);
        }
        
        .team-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            border-color: var(--garage-orange);
        }
        
        .team-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--garage-red), var(--garage-orange));
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .team-avatar i {
            font-size: 4rem;
            color: white;
        }
        
        .team-card h3 {
            color: var(--text-primary);
            margin-bottom: 5px;
        }
        
        .team-card .role {
            color: var(--garage-orange);
            font-weight: 500;
            margin-bottom: 15px;
        }
        
        .team-card p {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }
        
        .team-social {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
        
        .team-social a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.3s ease;
        }
        
        .team-social a:hover {
            background: var(--garage-red);
            transform: translateY(-3px);
        }
        
        /* Values Section */
        .values-section {
            padding: 60px 0;
            background: var(--dark-secondary);
        }
        
        .values-section h2 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 50px;
            color: var(--text-primary);
        }
        
        .values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }
        
        .value-card {
            background: var(--bg-card);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid var(--dark-border);
        }
        
        .value-card:hover {
            border-color: var(--garage-orange);
            transform: translateY(-5px);
        }
        
        .value-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(230, 57, 70, 0.2), rgba(247, 127, 0, 0.2));
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .value-icon i {
            font-size: 2rem;
            color: var(--garage-orange);
        }
        
        .value-card h3 {
            color: var(--text-primary);
            margin-bottom: 15px;
        }
        
        .value-card p {
            color: var(--text-secondary);
            font-size: 0.9rem;
            line-height: 1.6;
        }
        
        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--garage-red) 0%, var(--garage-orange) 100%);
            padding: 60px 0;
            text-align: center;
            color: white;
        }
        
        .cta-section h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        
        .cta-section p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        @media (max-width: 768px) {
            .about-section {
                grid-template-columns: 1fr;
            }
            
            .about-section:nth-child(even) {
                direction: ltr;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .about-hero h1 {
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
                <li><a href="about.php" class="active">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="../login.php">Login</a></li>
                <li><a href="../register.php">Register</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="about-hero">
        <div class="container">
            <h1><i class="fas fa-info-circle"></i> About Bike Garage</h1>
            <p>Your trusted partner for professional bike servicing and maintenance since 2010</p>
        </div>
    </section>

    <!-- About Content -->
    <section class="about-content">
        <div class="container">
            <!-- Our Story -->
            <div class="about-section">
                <div class="about-text">
                    <h2><i class="fas fa-history"></i> Our Story</h2>
                    <p>Founded in 2010, Bike Garage Management System started with a simple mission: to make bike maintenance transparent, affordable, and hassle-free for everyone.</p>
                    <p>What began as a small service center has grown into a comprehensive digital platform serving thousands of bike owners across the region. We've combined traditional craftsmanship with modern technology to deliver the best possible service experience.</p>
                    <p>Today, we handle thousands of service bookings annually, with a customer satisfaction rate of over 98%. Our commitment to quality and transparency remains unchanged.</p>
                </div>
                <div class="about-image">
                    <i class="fas fa-store"></i>
                </div>
            </div>

            <!-- Our Mission -->
            <div class="about-section">
                <div class="about-text">
                    <h2><i class="fas fa-bullseye"></i> Our Mission</h2>
                    <p>To revolutionize the bike service industry by providing transparent, reliable, and technology-driven solutions that put customers first.</p>
                    <p>We believe in:</p>
                    <p><i class="fas fa-check" style="color: var(--garage-green);"></i> Complete transparency in pricing</p>
                    <p><i class="fas fa-check" style="color: var(--garage-green);"></i> Certified technicians for all bike brands</p>
                    <p><i class="fas fa-check" style="color: var(--garage-green);"></i> Convenient online booking and tracking</p>
                    <p><i class="fas fa-check" style="color: var(--garage-green);"></i> Quality parts and genuine accessories</p>
                </div>
                <div class="about-image">
                    <i class="fas fa-rocket"></i>
                </div>
            </div>

            <!-- Our Vision -->
            <div class="about-section">
                <div class="about-text">
                    <h2><i class="fas fa-eye"></i> Our Vision</h2>
                    <p>To become the most trusted bike service brand in India, setting new standards for customer service and operational excellence.</p>
                    <p>We envision a future where bike maintenance is as simple as ordering food online - convenient, transparent, and reliable. Through continuous innovation and customer-centric approach, we aim to make this vision a reality.</p>
                </div>
                <div class="about-image">
                    <i class="fas fa-lightbulb"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <i class="fas fa-motorcycle"></i>
                    <div class="number">10,000+</div>
                    <div class="label">Bikes Serviced</div>
                </div>
                <div class="stat-item">
                    <i class="fas fa-users"></i>
                    <div class="number">5,000+</div>
                    <div class="label">Happy Customers</div>
                </div>
                <div class="stat-item">
                    <i class="fas fa-award"></i>
                    <div class="number">15+</div>
                    <div class="label">Awards Won</div>
                </div>
                <div class="stat-item">
                    <i class="fas fa-calendar-check"></i>
                    <div class="number">14+</div>
                    <div class="label">Years Experience</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="values-section">
        <div class="container">
            <h2><i class="fas fa-heart"></i> Our Core Values</h2>
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h3>Trust</h3>
                    <p>We believe in building long-term relationships through honest communication and transparent pricing.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-medal"></i>
                    </div>
                    <h3>Quality</h3>
                    <p>Every service is performed by certified technicians using genuine parts and industry-best practices.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-smile"></i>
                    </div>
                    <h3>Customer First</h3>
                    <p>Your satisfaction is our priority. We go the extra mile to ensure a seamless experience.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3>Innovation</h3>
                    <p>Continuously improving our services through technology and modern solutions.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team-section">
        <div class="container">
            <h2><i class="fas fa-users-cog"></i> Meet Our Team</h2>
            <div class="team-grid">
                <div class="team-card">
                    <div class="team-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <h3>Rajesh Kumar</h3>
                    <div class="role">Founder & CEO</div>
                    <p>15+ years of experience in automotive industry. Passionate about revolutionizing bike services.</p>
                    <div class="team-social">
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div class="team-card">
                    <div class="team-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <h3>Priya Sharma</h3>
                    <div class="role">Operations Manager</div>
                    <p>Ensuring smooth operations and exceptional customer service across all our service centers.</p>
                    <div class="team-social">
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div class="team-card">
                    <div class="team-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <h3>Amit Patel</h3>
                    <div class="role">Technical Head</div>
                    <p>Certified mechanic with expertise in all bike brands. Leads our team of expert technicians.</p>
                    <div class="team-social">
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div class="team-card">
                    <div class="team-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <h3>Sneha Reddy</h3>
                    <div class="role">Customer Success</div>
                    <p>Dedicated to ensuring every customer has an amazing experience with our services.</p>
                    <div class="team-social">
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2><i class="fas fa-wrench"></i> Ready to Experience Quality Service?</h2>
            <p>Join thousands of satisfied customers who trust us with their bikes. Book your first service today!</p>
            <div class="hero-buttons">
                <a href="register.php" class="btn btn-light">
                    <i class="fas fa-user-plus"></i> Create Account
                </a>
                <a href="services.php" class="btn btn-outline" style="border-color: white; color: white;">
                    <i class="fas fa-list"></i> View Services
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

