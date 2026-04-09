<?php
/**
 * Services Page
 * Bike Garage Management System
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services - Bike Garage Management System</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Services Page Styles */
        .services-hero {
            background: linear-gradient(135deg, rgba(230, 57, 70, 0.9) 0%, rgba(247, 127, 0, 0.9) 100%);
            padding: 100px 0;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .services-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path d="M50 20 L60 45 L85 45 L65 60 L75 85 L50 70 L25 85 L35 60 L15 45 L40 45 Z" fill="rgba(255,255,255,0.1)"/></svg>') repeat;
            background-size: 80px;
        }
        
        .services-hero h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .services-hero p {
            font-size: 1.3rem;
            opacity: 0.95;
            max-width: 700px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }
        
        /* Service Categories */
        .services-section {
            padding: 80px 0;
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .section-header h2 {
            font-size: 2.5rem;
            color: var(--text-primary);
            margin-bottom: 15px;
        }
        
        .section-header p {
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto;
            font-size: 1.1rem;
        }
        
        .section-header h2 i {
            color: var(--garage-orange);
            margin-right: 15px;
        }
        
        /* Main Services Grid */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
        }
        
        .service-card {
            background: var(--bg-card);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s ease;
            border: 1px solid var(--dark-border);
        }
        
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(230, 57, 70, 0.2);
            border-color: var(--garage-orange);
        }
        
        .service-card-header {
            background: linear-gradient(135deg, var(--garage-dark), #16213e);
            padding: 30px;
            text-align: center;
            position: relative;
        }
        
        .service-card-header::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--garage-red), var(--garage-orange));
        }
        
        .service-icon {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(230, 57, 70, 0.2), rgba(247, 127, 0, 0.2));
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .service-icon i {
            font-size: 3rem;
            color: var(--garage-orange);
        }
        
        .service-card-header h3 {
            color: var(--text-primary);
            font-size: 1.5rem;
            margin-bottom: 10px;
        }
        
        .service-card-header .price {
            color: var(--garage-green);
            font-size: 1.3rem;
            font-weight: bold;
        }
        
        .service-card-body {
            padding: 30px;
        }
        
        .service-features {
            list-style: none;
            margin-bottom: 25px;
        }
        
        .service-features li {
            padding: 10px 0;
            border-bottom: 1px solid var(--dark-border);
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .service-features li:last-child {
            border-bottom: none;
        }
        
        .service-features li i {
            color: var(--garage-green);
        }
        
        .service-card-footer {
            padding: 0 30px 30px;
        }
        
        .service-card .btn {
            width: 100%;
            padding: 15px;
            font-size: 1rem;
        }
        
        /* Maintenance Packages */
        .packages-section {
            padding: 80px 0;
            background: var(--dark-secondary);
        }
        
        .packages-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .package-card {
            background: var(--bg-card);
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            transition: all 0.3s ease;
            border: 2px solid var(--dark-border);
            position: relative;
            overflow: hidden;
        }
        
        .package-card:hover {
            border-color: var(--garage-orange);
            transform: scale(1.02);
        }
        
        .package-card.featured {
            border-color: var(--garage-red);
            transform: scale(1.05);
        }
        
        .package-card.featured::before {
            content: 'POPULAR';
            position: absolute;
            top: 20px;
            right: -35px;
            background: var(--garage-red);
            color: white;
            padding: 5px 40px;
            transform: rotate(45deg);
            font-size: 0.7rem;
            font-weight: bold;
        }
        
        .package-card:hover {
            transform: scale(1.05);
        }
        
        .package-name {
            font-size: 1.5rem;
            color: var(--text-primary);
            margin-bottom: 10px;
        }
        
        .package-price {
            font-size: 3rem;
            font-weight: bold;
            color: var(--garage-orange);
            margin-bottom: 5px;
        }
        
        .package-price span {
            font-size: 1rem;
            color: var(--text-secondary);
        }
        
        .package-duration {
            color: var(--text-muted);
            margin-bottom: 30px;
        }
        
        .package-features {
            list-style: none;
            margin-bottom: 30px;
            text-align: left;
        }
        
        .package-features li {
            padding: 12px 0;
            border-bottom: 1px solid var(--dark-border);
            color: var(--text-secondary);
        }
        
        .package-features li i {
            color: var(--garage-green);
            margin-right: 10px;
        }
        
        .package-features li.missing {
            color: var(--text-muted);
        }
        
        .package-features li.missing i {
            color: var(--garage-red);
        }
        
        /* Why Choose Us */
        .why-section {
            padding: 80px 0;
        }
        
        .why-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }
        
        .why-card {
            background: var(--bg-card);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid var(--dark-border);
        }
        
        .why-card:hover {
            border-color: var(--garage-orange);
            transform: translateY(-5px);
        }
        
        .why-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(230, 57, 70, 0.2), rgba(247, 127, 0, 0.2));
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .why-icon i {
            font-size: 2rem;
            color: var(--garage-orange);
        }
        
        .why-card h3 {
            color: var(--text-primary);
            margin-bottom: 15px;
        }
        
        .why-card p {
            color: var(--text-secondary);
            font-size: 0.95rem;
        }
        
        /* Process Section */
        .process-section {
            padding: 80px 0;
            background: var(--dark-secondary);
        }
        
        .process-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }
        
        .process-card {
            text-align: center;
            position: relative;
        }
        
        .process-card::after {
            content: '→';
            position: absolute;
            top: 40px;
            right: -20px;
            font-size: 2rem;
            color: var(--garage-orange);
        }
        
        .process-card:last-child::after {
            display: none;
        }
        
        .process-number {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--garage-red), var(--garage-orange));
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: bold;
            color: white;
        }
        
        .process-card h3 {
            color: var(--text-primary);
            margin-bottom: 10px;
        }
        
        .process-card p {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }
        
        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            padding: 80px 0;
            text-align: center;
        }
        
        .cta-section h2 {
            font-size: 2.5rem;
            color: var(--text-primary);
            margin-bottom: 20px;
        }
        
        .cta-section p {
            color: var(--text-secondary);
            font-size: 1.1rem;
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        @media (max-width: 768px) {
            .services-hero h1 {
                font-size: 2rem;
            }
            
            .process-grid {
                grid-template-columns: 1fr;
            }
            
            .process-card::after {
                display: none;
            }
            
            .package-card.featured {
                transform: scale(1);
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
                <li><a href="services.php" class="active">Services</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="../login.php">Login</a></li>
                <li><a href="../register.php">Register</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="services-hero">
        <div class="container">
            <h1><i class="fas fa-tools"></i> Our Services</h1>
            <p>Professional bike servicing and repair solutions tailored to keep your bike running smoothly and safely</p>
        </div>
    </section>

    <!-- Main Services -->
    <section class="services-section">
        <div class="container">
            <div class="section-header">
                <h2><i class="fas fa-wrench"></i> Comprehensive Bike Services</h2>
                <p>From routine maintenance to complex repairs, we offer a wide range of services for all bike brands</p>
            </div>
            
            <div class="services-grid">
                <!-- Regular Service -->
                <div class="service-card">
                    <div class="service-card-header">
                        <div class="service-icon">
                            <i class="fas fa-oil-can"></i>
                        </div>
                        <h3>Regular Service</h3>
                        <div class="price">From ₹500</div>
                    </div>
                    <div class="service-card-body">
                        <ul class="service-features">
                            <li><i class="fas fa-check"></i> Oil change & filter cleaning</li>
                            <li><i class="fas fa-check"></i> General inspection</li>
                            <li><i class="fas fa-check"></i> Chain lubrication</li>
                            <li><i class="fas fa-check"></i> Air filter cleaning</li>
                            <li><i class="fas fa-check"></i> Brake adjustment</li>
                            <li><i class="fas fa-check"></i> 100+ point check</li>
                        </ul>
                    </div>
                    <div class="service-card-footer">
                        <a href="register.php" class="btn btn-primary">
                            <i class="fas fa-calendar-check"></i> Book Now
                        </a>
                    </div>
                </div>

                <!-- Major Service -->
                <div class="service-card">
                    <div class="service-card-header">
                        <div class="service-icon">
                            <i class="fas fa-tools"></i>
                        </div>
                        <h3>Major Service</h3>
                        <div class="price">From ₹1,500</div>
                    </div>
                    <div class="service-card-body">
                        <ul class="service-features">
                            <li><i class="fas fa-check"></i> Everything in Regular Service</li>
                            <li><i class="fas fa-check"></i> Complete engine check</li>
                            <li><i class="fas fa-check"></i> Spark plug replacement</li>
                            <li><i class="fas fa-check"></i> Carburetor tuning</li>
                            <li><i class="fas fa-check"></i> Clutch adjustment</li>
                            <li><i class="fas fa-check"></i> Suspension check</li>
                        </ul>
                    </div>
                    <div class="service-card-footer">
                        <a href="register.php" class="btn btn-primary">
                            <i class="fas fa-calendar-check"></i> Book Now
                        </a>
                    </div>
                </div>

                <!-- Repair Services -->
                <div class="service-card">
                    <div class="service-card-header">
                        <div class="service-icon">
                            <i class="fas fa-wrench"></i>
                        </div>
                        <h3>Repair Services</h3>
                        <div class="price">Custom Pricing</div>
                    </div>
                    <div class="service-card-body">
                        <ul class="service-features">
                            <li><i class="fas fa-check"></i> Brake repair & replacement</li>
                            <li><i class="fas fa-check"></i> Chain & sprocket replacement</li>
                            <li><i class="fas fa-check"></i> Engine repairs</li>
                            <li><i class="fas fa-check"></i> Electrical system repair</li>
                            <li><i class="fas fa-check"></i> Clutch & gear issues</li>
                            <li><i class="fas fa-check"></i> Free diagnosis</li>
                        </ul>
                    </div>
                    <div class="service-card-footer">
                        <a href="register.php" class="btn btn-primary">
                            <i class="fas fa-calendar-check"></i> Book Now
                        </a>
                    </div>
                </div>

                <!-- Insurance Claim -->
                <div class="service-card">
                    <div class="service-card-header">
                        <div class="service-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3>Insurance Claims</h3>
                        <div class="price">TPA Supported</div>
                    </div>
                    <div class="service-card-body">
                        <ul class="service-features">
                            <li><i class="fas fa-check"></i> Accidental repair</li>
                            <li><i class="fas fa-check"></i> Cashless claims</li>
                            <li><i class="fas fa-check"></i> Insurance documentation</li>
                            <li><i class="fas fa-check"></i> Claim assistance</li>
                            <li><i class="fas fa-check"></i> All TPA supported</li>
                            <li><i class="fas fa-check"></i> Quick turnaround</li>
                        </ul>
                    </div>
                    <div class="service-card-footer">
                        <a href="register.php" class="btn btn-primary">
                            <i class="fas fa-calendar-check"></i> Book Now
                        </a>
                    </div>
                </div>

                <!-- AC Service -->
                <div class="service-card">
                    <div class="service-card-header">
                        <div class="service-icon">
                            <i class="fas fa-snowflake"></i>
                        </div>
                        <h3>AC Service</h3>
                        <div class="price">From ₹800</div>
                    </div>
                    <div class="service-card-body">
                        <ul class="service-features">
                            <li><i class="fas fa-check"></i> AC gas refill</li>
                            <li><i class="fas fa-check"></i> Cooling system repair</li>
                            <li><i class="fas fa-check"></i> Compressor check</li>
                            <li><i class="fas fa-check"></i> Leak detection</li>
                            <li><i class="fas fa-check"></i> Belt replacement</li>
                            <li><i class="fas fa-check"></i> Performance test</li>
                        </ul>
                    </div>
                    <div class="service-card-footer">
                        <a href="register.php" class="btn btn-primary">
                            <i class="fas fa-calendar-check"></i> Book Now
                        </a>
                    </div>
                </div>

                <!-- Denting & Painting -->
                <div class="service-card">
                    <div class="service-card-header">
                        <div class="service-icon">
                            <i class="fas fa-paint-roller"></i>
                        </div>
                        <h3>Denting & Painting</h3>
                        <div class="price">Custom Pricing</div>
                    </div>
                    <div class="service-card-body">
                        <ul class="service-features">
                            <li><i class="fas fa-check"></i> Scratch removal</li>
                            <li><i class="fas fa-check"></i> Full body painting</li>
                            <li><i class="fas fa-check"></i> Spot painting</li>
                            <li><i class="fas fa-check"></i> Paint protection</li>
                            <li><i class="fas fa-check"></i> Premium paints</li>
                            <li><i class="fas fa-check"></i> Color matching</li>
                        </ul>
                    </div>
                    <div class="service-card-footer">
                        <a href="register.php" class="btn btn-primary">
                            <i class="fas fa-calendar-check"></i> Book Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Maintenance Packages -->
    <section class="packages-section">
        <div class="container">
            <div class="section-header">
                <h2><i class="fas fa-gem"></i> Maintenance Packages</h2>
                <p>Choose from our value-packed annual maintenance packages for hassle-free bike care</p>
            </div>
            
            <div class="packages-grid">
                <!-- Basic Package -->
                <div class="package-card">
                    <h3 class="package-name">Basic</h3>
                    <div class="package-price">₹2,499<span>/year</span></div>
                    <p class="package-duration">2 Services Included</p>
                    <ul class="package-features">
                        <li><i class="fas fa-check"></i> 2 Regular Services</li>
                        <li><i class="fas fa-check"></i> Free Pickup & Drop</li>
                        <li><i class="fas fa-check"></i> 10% Parts Discount</li>
                        <li><i class="fas fa-check"></i> Priority Booking</li>
                        <li class="missing"><i class="fas fa-times"></i> Car Wash Included</li>
                        <li class="missing"><i class="fas fa-times"></i> Free Accessories</li>
                    </ul>
                    <a href="register.php" class="btn btn-outline">
                        <i class="fas fa-shopping-cart"></i> Select Plan
                    </a>
                </div>

                <!-- Standard Package -->
                <div class="package-card featured">
                    <h3 class="package-name">Standard</h3>
                    <div class="package-price">₹4,999<span>/year</span></div>
                    <p class="package-duration">4 Services Included</p>
                    <ul class="package-features">
                        <li><i class="fas fa-check"></i> 4 Regular Services</li>
                        <li><i class="fas fa-check"></i> Free Pickup & Drop</li>
                        <li><i class="fas fa-check"></i> 15% Parts Discount</li>
                        <li><i class="fas fa-check"></i> Priority Booking</li>
                        <li><i class="fas fa-check"></i> 2 Car Washes</li>
                        <li class="missing"><i class="fas fa-times"></i> Free Accessories</li>
                    </ul>
                    <a href="register.php" class="btn btn-primary">
                        <i class="fas fa-shopping-cart"></i> Select Plan
                    </a>
                </div>

                <!-- Premium Package -->
                <div class="package-card">
                    <h3 class="package-name">Premium</h3>
                    <div class="package-price">₹7,999<span>/year</span></div>
                    <p class="package-duration">6 Services Included</p>
                    <ul class="package-features">
                        <li><i class="fas fa-check"></i> 6 Regular Services</li>
                        <li><i class="fas fa-check"></i> Free Pickup & Drop</li>
                        <li><i class="fas fa-check"></i> 25% Parts Discount</li>
                        <li><i class="fas fa-check"></i> VIP Priority</li>
                        <li><i class="fas fa-check"></i> Unlimited Car Wash</li>
                        <li><i class="fas fa-check"></i> ₹1,000 Accessories Voucher</li>
                    </ul>
                    <a href="register.php" class="btn btn-outline">
                        <i class="fas fa-shopping-cart"></i> Select Plan
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="why-section">
        <div class="container">
            <div class="section-header">
                <h2><i class="fas fa-star"></i> Why Choose Bike Garage?</h2>
                <p>What sets us apart from other service centers</p>
            </div>
            
            <div class="why-grid">
                <div class="why-card">
                    <div class="why-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h3>Certified Technicians</h3>
                    <p>Our team consists of factory-trained and certified mechanics with years of experience.</p>
                </div>
                
                <div class="why-card">
                    <div class="why-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>Quick Turnaround</h3>
                    <p>Most services completed within 4-6 hours. Same-day service for urgent repairs.</p>
                </div>
                
                <div class="why-card">
                    <div class="why-icon">
                        <i class="fas fa-tag"></i>
                    </div>
                    <h3>Transparent Pricing</h3>
                    <p>No hidden charges. Get detailed estimates before any work begins.</p>
                </div>
                
                <div class="why-card">
                    <div class="why-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Warranty on Service</h3>
                    <p>All our services come with a minimum 30-day warranty on labor.</p>
                </div>
                
                <div class="why-card">
                    <div class="why-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Real-time Updates</h3>
                    <p>Track your bike's service status in real-time through our app or website.</p>
                </div>
                
                <div class="why-card">
                    <div class="why-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>24/7 Support</h3>
                    <p>Our customer support team is available round the clock for assistance.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Process Section -->
    <section class="process-section">
        <div class="container">
            <div class="section-header">
                <h2><i class="fas fa-route"></i> How It Works</h2>
                <p>Simple and hassle-free service booking process</p>
            </div>
            
            <div class="process-grid">
                <div class="process-card">
                    <div class="process-number">1</div>
                    <h3>Book Online</h3>
                    <p>Fill out the booking form with your bike details and preferred date</p>
                </div>
                
                <div class="process-card">
                    <div class="process-number">2</div>
                    <h3>Pickup</h3>
                    <p>Our executive will pick up your bike from your doorstep</p>
                </div>
                
                <div class="process-card">
                    <div class="process-number">3</div>
                    <h3>Service</h3>
                    <p>Expert technicians service your bike with genuine parts</p>
                </div>
                
                <div class="process-card">
                    <div class="process-number">4</div>
                    <h3>Delivery</h3>
                    <p>Get your bike delivered back, sparkling clean and running smoothly</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2><i class="fas fa-motorcycle"></i> Ready to Book Your Service?</h2>
            <p>Join thousands of satisfied customers who trust Bike Garage with their bikes</p>
            <div class="hero-buttons">
                <a href="register.php" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Create Account
                </a>
                <a href="contact.php" class="btn btn-outline">
                    <i class="fas fa-phone-alt"></i> Call Us Now
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

