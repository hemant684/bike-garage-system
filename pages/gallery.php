<?php
/**
 * Gallery Page
 * Bike Garage Management System
 * Showcase of bikes and spare parts
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - Bike Garage Management System</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <style>
        /* Gallery Page Styles */
        .gallery-hero {
            background: linear-gradient(135deg, rgba(0,0,0,0.8) 0%, rgba(230, 57, 70, 0.3) 100%),
                        url('images/bikes/hero-bg.jpg') center/cover no-repeat;
            padding: 100px 0;
            text-align: center;
            color: white;
        }
        
        .gallery-hero h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }
        
        .gallery-hero p {
            font-size: 1.2rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }
        
        /* Filter Tabs */
        .filter-section {
            background: var(--dark-secondary);
            padding: 30px 0;
            position: sticky;
            top: 70px;
            z-index: 100;
        }
        
        .filter-tabs {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        .filter-tab {
            padding: 12px 25px;
            background: var(--bg-card);
            border: 1px solid var(--dark-border);
            border-radius: 30px;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }
        
        .filter-tab:hover,
        .filter-tab.active {
            background: var(--garage-red);
            color: white;
            border-color: var(--garage-red);
        }
        
        /* Gallery Grid */
        .gallery-section {
            padding: 60px 0;
        }
        
        .gallery-section h2 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 40px;
            color: var(--text-primary);
        }
        
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }
        
        .gallery-item {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            aspect-ratio: 4/3;
            cursor: pointer;
            transition: all 0.4s ease;
        }
        
        .gallery-item:hover {
            transform: scale(1.02);
            box-shadow: 0 20px 40px rgba(230, 57, 70, 0.3);
        }
        
        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .gallery-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .gallery-placeholder.sports {
            background: linear-gradient(135deg, #e63946 0%, #1a1a2e 100%);
        }
        
        .gallery-placeholder.cruiser {
            background: linear-gradient(135deg, #f77f00 0%, #1a1a2e 100%);
        }
        
        .gallery-placeholder.scooter {
            background: linear-gradient(135deg, #2a9d8f 0%, #1a1a2e 100%);
        }
        
        .gallery-placeholder.repair {
            background: linear-gradient(135deg, #0077b6 0%, #1a1a2e 100%);
        }
        
        .gallery-placeholder.parts {
            background: linear-gradient(135deg, #7209b7 0%, #1a1a2e 100%);
        }
        
        .gallery-placeholder.service {
            background: linear-gradient(135deg, #3a0ca3 0%, #1a1a2e 100%);
        }
        
        .gallery-placeholder i {
            font-size: 4rem;
            color: rgba(255,255,255,0.3);
        }
        
        .gallery-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 60px 20px 20px;
            background: linear-gradient(transparent, rgba(0,0,0,0.9));
            transform: translateY(100%);
            transition: all 0.3s ease;
        }
        
        .gallery-item:hover .gallery-overlay {
            transform: translateY(0);
        }
        
        .gallery-overlay h4 {
            color: white;
            margin-bottom: 5px;
            font-size: 1.1rem;
        }
        
        .gallery-overlay p {
            color: rgba(255,255,255,0.7);
            font-size: 0.85rem;
            margin-bottom: 10px;
        }
        
        .gallery-icon {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(230, 57, 70, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        
        /* Video Gallery */
        .video-gallery-section {
            padding: 60px 0;
            background: var(--dark-secondary);
        }
        
        .video-gallery-section h2 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 40px;
            color: var(--text-primary);
        }
        
        .video-gallery-section h2 i {
            color: var(--garage-red);
            margin-right: 10px;
        }
        
        .video-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
        }
        
        .video-item {
            background: var(--bg-card);
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid var(--dark-border);
        }
        
        .video-item:hover {
            border-color: var(--garage-orange);
            transform: translateY(-5px);
        }
        
        .video-thumbnail {
            position: relative;
            aspect-ratio: 16/9;
            cursor: pointer;
        }
        
        .video-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .play-btn {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: rgba(230, 57, 70, 0.95);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .video-item:hover .play-btn {
            transform: translate(-50%, -50%) scale(1.1);
            background: var(--garage-red);
        }
        
        .play-btn i {
            color: white;
            font-size: 1.8rem;
            margin-left: 5px;
        }
        
        .video-info {
            padding: 20px;
        }
        
        .video-info h4 {
            color: var(--text-primary);
            margin-bottom: 8px;
        }
        
        .video-info p {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }
        
        .video-duration {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: rgba(0,0,0,0.8);
            color: white;
            padding: 3px 8px;
            border-radius: 5px;
            font-size: 0.8rem;
        }
        
        /* Before After Section */
        .before-after-section {
            padding: 60px 0;
        }
        
        .before-after-section h2 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 40px;
            color: var(--text-primary);
        }
        
        .before-after-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 30px;
        }
        
        .before-after-card {
            background: var(--bg-card);
            border-radius: 15px;
            overflow: hidden;
            border: 1px solid var(--dark-border);
        }
        
        .before-after-images {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }
        
        .before-image,
        .after-image {
            position: relative;
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .before-image {
            background: linear-gradient(135deg, #555 0%, #333 100%);
        }
        
        .after-image {
            background: linear-gradient(135deg, var(--garage-green) 0%, #1a5c50 100%);
        }
        
        .before-image span,
        .after-image span {
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .before-image span {
            background: rgba(255,255,255,0.9);
            color: #333;
        }
        
        .after-image span {
            background: var(--garage-green);
            color: white;
        }
        
        .before-image i,
        .after-image i {
            font-size: 3rem;
            color: rgba(255,255,255,0.3);
        }
        
        .before-after-info {
            padding: 20px;
        }
        
        .before-after-info h4 {
            color: var(--text-primary);
            margin-bottom: 10px;
        }
        
        .before-after-info p {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }
        
        /* Spare Parts Showcase */
        .parts-showcase-section {
            padding: 60px 0;
            background: var(--dark-secondary);
        }
        
        .parts-showcase-section h2 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 40px;
            color: var(--text-primary);
        }
        
        .parts-showcase-section h2 i {
            color: var(--garage-teal);
            margin-right: 10px;
        }
        
        .parts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }
        
        .part-item {
            background: var(--bg-card);
            border-radius: 15px;
            padding: 25px 15px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid var(--dark-border);
        }
        
        .part-item:hover {
            border-color: var(--garage-teal);
            transform: translateY(-5px);
        }
        
        .part-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(0, 180, 216, 0.2), rgba(0, 180, 216, 0.05));
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .part-image i {
            font-size: 2.5rem;
            color: var(--garage-teal);
        }
        
        .part-item h4 {
            color: var(--text-primary);
            margin-bottom: 5px;
            font-size: 1rem;
        }
        
        .part-item p {
            color: var(--text-muted);
            font-size: 0.85rem;
        }
        
        @media (max-width: 768px) {
            .gallery-hero h1 {
                font-size: 2rem;
            }
            
            .before-after-grid {
                grid-template-columns: 1fr;
            }
            
            .video-grid {
                grid-template-columns: 1fr;
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
                <li><a href="faq.php">FAQ</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="gallery.php" class="active">Gallery</a></li>
                <li><a href="../login.php">Login</a></li>
                <li><a href="../register.php">Register</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gallery-hero">
        <div class="container">
            <h1><i class="fas fa-images"></i> Our Gallery</h1>
            <p>Explore our work - from stunning bike transformations to quality repairs and maintenance</p>
        </div>
    </section>

    <!-- Filter Tabs -->
    <div class="filter-section">
        <div class="container">
            <div class="filter-tabs">
                <button class="filter-tab active" data-filter="all">All</button>
                <button class="filter-tab" data-filter="bikes">Bikes</button>
                <button class="filter-tab" data-filter="repairs">Repairs</button>
                <button class="filter-tab" data-filter="parts">Spare Parts</button>
                <button class="filter-tab" data-filter="services">Services</button>
            </div>
        </div>
    </div>

    <!-- Photo Gallery -->
    <section class="gallery-section">
        <div class="container">
            <h2><i class="fas fa-camera"></i> Photo Gallery</h2>
            <div class="gallery-grid">
                <!-- Bike Images -->
                <div class="gallery-item" data-category="bikes">
                    <div class="gallery-placeholder sports">
                        <i class="fas fa-motorcycle"></i>
                    </div>
                    <div class="gallery-icon">
                        <i class="fas fa-motorcycle"></i>
                    </div>
                    <div class="gallery-overlay">
                        <h4>Ducati Panigale V4</h4>
                        <p>Premium sports bike service</p>
                    </div>
                </div>
                
                <div class="gallery-item" data-category="bikes">
                    <div class="gallery-placeholder cruiser">
                        <i class="fas fa-motorcycle"></i>
                    </div>
                    <div class="gallery-icon">
                        <i class="fas fa-motorcycle"></i>
                    </div>
                    <div class="gallery-overlay">
                        <h4>Royal Enfield Classic</h4>
                        <p>Cruiser bike restoration</p>
                    </div>
                </div>
                
                <div class="gallery-item" data-category="bikes">
                    <div class="gallery-placeholder scooter">
                        <i class="fas fa-scooter"></i>
                    </div>
                    <div class="gallery-icon">
                        <i class="fas fa-scooter"></i>
                    </div>
                    <div class="gallery-overlay">
                        <h4>Honda Activa 6G</h4>
                        <p>Regular maintenance</p>
                    </div>
                </div>
                
                <div class="gallery-item" data-category="repairs">
                    <div class="gallery-placeholder repair">
                        <i class="fas fa-wrench"></i>
                    </div>
                    <div class="gallery-icon">
                        <i class="fas fa-wrench"></i>
                    </div>
                    <div class="gallery-overlay">
                        <h4>Engine Overhaul</h4>
                        <p>Complete engine rebuild</p>
                    </div>
                </div>
                
                <div class="gallery-item" data-category="repairs">
                    <div class="gallery-placeholder" style="background: linear-gradient(135deg, #0077b6 0%, #1a1a2e 100%);">
                        <i class="fas fa-tools"></i>
                    </div>
                    <div class="gallery-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <div class="gallery-overlay">
                        <h4>Brake System</h4>
                        <p>Brake pad replacement</p>
                    </div>
                </div>
                
                <div class="gallery-item" data-category="parts">
                    <div class="gallery-placeholder parts">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <div class="gallery-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <div class="gallery-overlay">
                        <h4>Genuine Parts</h4>
                        <p>OEM spare parts</p>
                    </div>
                </div>
                
                <div class="gallery-item" data-category="services">
                    <div class="gallery-placeholder service">
                        <i class="fas fa-oil-can"></i>
                    </div>
                    <div class="gallery-icon">
                        <i class="fas fa-oil-can"></i>
                    </div>
                    <div class="gallery-overlay">
                        <h4>Oil Change</h4>
                        <p>Premium oil service</p>
                    </div>
                </div>
                
                <div class="gallery-item" data-category="services">
                    <div class="gallery-placeholder" style="background: linear-gradient(135deg, #f77f00 0%, #1a1a2e 100%);">
                        <i class="fas fa-paint-brush"></i>
                    </div>
                    <div class="gallery-icon">
                        <i class="fas fa-paint-brush"></i>
                    </div>
                    <div class="gallery-overlay">
                        <h4>Denting & Painting</h4>
                        <p>Custom paint job</p>
                    </div>
                </div>
                
                <div class="gallery-item" data-category="parts">
                    <div class="gallery-placeholder" style="background: linear-gradient(135deg, #4361ee 0%, #1a1a2e 100%);">
                        <i class="fas fa-link"></i>
                    </div>
                    <div class="gallery-icon">
                        <i class="fas fa-link"></i>
                    </div>
                    <div class="gallery-overlay">
                        <h4>Chain Kit</h4>
                        <p>Premium chain & sprocket</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Before After Section -->
    <section class="before-after-section">
        <div class="container">
            <h2><i class="fas fa-exchange-alt"></i> Before & After Transformations</h2>
            <div class="before-after-grid">
                <div class="before-after-card">
                    <div class="before-after-images">
                        <div class="before-image">
                            <i class="fas fa-motorcycle"></i>
                            <span>BEFORE</span>
                        </div>
                        <div class="after-image">
                            <i class="fas fa-star"></i>
                            <span>AFTER</span>
                        </div>
                    </div>
                    <div class="before-after-info">
                        <h4>Complete Restoration</h4>
                        <p>Full paint job and engine restoration of a 2015 model bike that had been neglected for years.</p>
                    </div>
                </div>
                
                <div class="before-after-card">
                    <div class="before-after-images">
                        <div class="before-image">
                            <i class="fas fa-broom"></i>
                            <span>BEFORE</span>
                        </div>
                        <div class="after-image">
                            <i class="fas fa-shine"></i>
                            <span>AFTER</span>
                        </div>
                    </div>
                    <div class="before-after-info">
                        <h4>Premium Detailing</h4>
                        <p>Complete cleaning, polish, and detailing service that brought back the original shine.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Video Gallery -->
    <section class="video-gallery-section">
        <div class="container">
            <h2><i class="fas fa-video"></i> Video Gallery</h2>
            <div class="video-grid">
                <div class="video-item">
                    <div class="video-thumbnail">
                        <div class="gallery-placeholder sports" style="width: 100%; height: 100%;">
                            <i class="fas fa-play-circle" style="font-size: 5rem; color: rgba(255,255,255,0.5);"></i>
                        </div>
                        <div class="play-btn">
                            <i class="fas fa-play"></i>
                        </div>
                        <span class="video-duration">5:30</span>
                    </div>
                    <div class="video-info">
                        <h4>Complete Bike Service Process</h4>
                        <p>Watch our step-by-step process of a full bike service including oil change, filter cleaning, and more.</p>
                    </div>
                </div>
                
                <div class="video-item">
                    <div class="video-thumbnail">
                        <div class="gallery-placeholder cruiser" style="width: 100%; height: 100%;">
                            <i class="fas fa-play-circle" style="font-size: 5rem; color: rgba(255,255,255,0.5);"></i>
                        </div>
                        <div class="play-btn">
                            <i class="fas fa-play"></i>
                        </div>
                        <span class="video-duration">8:15</span>
                    </div>
                    <div class="video-info">
                        <h4>Engine Repair Demonstration</h4>
                        <p>Learn how our expert mechanics diagnose and repair common engine problems.</p>
                    </div>
                </div>
                
                <div class="video-item">
                    <div class="video-thumbnail">
                        <div class="gallery-placeholder" style="width: 100%; height: 100%; background: linear-gradient(135deg, #2a9d8f 0%, #1a1a2e 100%);">
                            <i class="fas fa-play-circle" style="font-size: 5rem; color: rgba(255,255,255,0.5);"></i>
                        </div>
                        <div class="play-btn">
                            <i class="fas fa-play"></i>
                        </div>
                        <span class="video-duration">3:45</span>
                    </div>
                    <div class="video-info">
                        <h4>Customer Testimonials</h4>
                        <p>Hear from our satisfied customers about their experience with Bike Garage.</p>
                    </div>
                </div>
                
                <div class="video-item">
                    <div class="video-thumbnail">
                        <div class="gallery-placeholder" style="width: 100%; height: 100%; background: linear-gradient(135deg, #e63946 0%, #1a1a2e 100%);">
                            <i class="fas fa-play-circle" style="font-size: 5rem; color: rgba(255,255,255,0.5);"></i>
                        </div>
                        <div class="play-btn">
                            <i class="fas fa-play"></i>
                        </div>
                        <span class="video-duration">6:20</span>
                    </div>
                    <div class="video-info">
                        <h4>Custom Modification Showroom</h4>
                        <p>Explore some of the amazing custom modifications we've done for our customers.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Spare Parts Showcase -->
    <section class="parts-showcase-section">
        <div class="container">
            <h2><i class="fas fa-cogs"></i> Quality Spare Parts We Use</h2>
            <div class="parts-grid">
                <div class="part-item">
                    <div class="part-image">
                        <i class="fas fa-oil-can"></i>
                    </div>
                    <h4>Engine Oil</h4>
                    <p>Shell, Motul, Castrol</p>
                </div>
                <div class="part-item">
                    <div class="part-image">
                        <i class="fas fa-circle-notch"></i>
                    </div>
                    <h4>Brake Pads</h4>
                    <p>Brembo, Bosch, ABC</p>
                </div>
                <div class="part-item">
                    <div class="part-image">
                        <i class="fas fa-filter"></i>
                    </div>
                    <h4>Filters</h4>
                    <p>K&N, Bosch, NHK</p>
                </div>
                <div class="part-item">
                    <div class="part-image">
                        <i class="fas fa-link"></i>
                    </div>
                    <h4>Chain Kit</h4>
                    <p>RK, DID, Enuma</p>
                </div>
                <div class="part-item">
                    <div class="part-image">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h4>LED Lights</h4>
                    <p>Philips, OSRAM</p>
                </div>
                <div class="part-item">
                    <div class="part-image">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
<h4>Instrument Clusters</h4>
                    <p>Premium quality parts</p>
                </div>
                <div class="part-item">
                    <div class="part-image">
                        <i class="fas fa-chair"></i>
                    </div>
                    <h4>Seats</h4>
                    <p>Premium seat covers</p>
                </div>
                <div class="part-item">
                    <div class="part-image">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h4>Helmets</h4>
                    <p>Vega, Studds, HRX</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section style="background: linear-gradient(135deg, var(--garage-dark), #16213e); padding: 80px 0; text-align: center;">
        <div class="container">
            <h2 style="color: white; margin-bottom: 20px;">
                <i class="fas fa-camera"></i> Like Our Work?
            </h2>
            <p style="color: var(--text-secondary); margin-bottom: 30px; font-size: 1.1rem;">
                Book a service with us and see the quality firsthand
            </p>
            <div class="hero-buttons">
                <a href="register.php" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Create Account
                </a>
                <a href="contact.php" class="btn btn-outline" style="border-color: white; color: white;">
                    <i class="fas fa-phone-alt"></i> Contact Us
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 Bike Garage Management System. All rights reserved.</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">
                <a href="about.php">About</a> | 
                <a href="services.php">Services</a> | 
                <a href="faq.php">FAQ</a> | 
                <a href="contact.php">Contact</a> |
                <a href="gallery.php">Gallery</a>
            </p>
            <p style="margin-top: 5px; font-size: 0.85rem;">
                <a href="privacy.php">Privacy Policy</a> | 
                <a href="terms.php">Terms & Conditions</a>
            </p>
        </div>
    </footer>

    <script src="../js/validation.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script>
        // Gallery Filter Functionality
        document.querySelectorAll('.filter-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                const filter = this.dataset.filter;
                
                // Update active tab
                document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                // Filter gallery items
                document.querySelectorAll('.gallery-item').forEach(item => {
                    if (filter === 'all' || item.dataset.category === filter) {
                        item.style.display = 'block';
                        item.style.animation = 'fadeIn 0.5s ease';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
        
        // Add fadeIn animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>

