<?php
/**
 * FAQ Page
 * Bike Garage Management System
 */

// Sample FAQ data
$faqCategories = [
    [
        'name' => 'General Questions',
        'icon' => 'fa-question-circle',
        'faqs' => [
            [
                'question' => 'What is Bike Garage Management System?',
                'answer' => 'Bike Garage Management System is a comprehensive platform that helps bike owners manage their bike servicing and repairs. It allows you to book appointments online, track service status, view bills, and maintain your bike\'s service history all in one place.'
            ],
            [
                'question' => 'How do I create an account?',
                'answer' => 'Creating an account is simple! Click on the "Register" button in the navigation bar, fill in your personal details, bike information, and create a password. You\'ll receive a confirmation email (if configured) and can start booking services immediately.'
            ],
            [
                'question' => 'Is there a mobile app available?',
                'answer' => 'Currently, we offer a fully responsive web application that works seamlessly on all devices including smartphones and tablets. A dedicated mobile app is in our development roadmap.'
            ]
        ]
    ],
    [
        'name' => 'Booking & Services',
        'icon' => 'fa-calendar-check',
        'faqs' => [
            [
                'question' => 'How do I book a service appointment?',
                'answer' => 'Log in to your account, navigate to "Book Service", fill in your bike details, select the service type, choose your preferred date and time, and submit the booking. You\'ll receive a confirmation notification.'
            ],
            [
                'question' => 'Can I reschedule or cancel my booking?',
                'answer' => 'Yes, you can reschedule or cancel your booking up to 24 hours before the scheduled appointment. Go to your dashboard, find the booking, and use the reschedule/cancel options. Please note that cancellations within 24 hours may incur a small fee.'
            ],
            [
                'question' => 'What service types are available?',
                'answer' => 'We offer Regular Service, Major Service, Repair Services, Insurance Claims, AC Service, Denting & Painting, Wheel Care, and Custom Repairs. Each service has detailed information about what\'s included.'
            ],
            [
                'question' => 'How long does a typical service take?',
                'answer' => 'A Regular Service typically takes 2-3 hours. Major services may take 4-6 hours. Complex repairs vary based on the issue. We provide real-time status updates so you know exactly when your bike will be ready.'
            ]
        ]
    ],
    [
        'name' => 'Pricing & Payment',
        'icon' => 'fa-rupee-sign',
        'faqs' => [
            [
                'question' => 'How are your prices determined?',
                'answer' => 'Our pricing is transparent and competitive. Regular services have fixed pricing, while repairs are quoted after a free diagnosis. You\'ll always receive an estimate before we proceed with any work.'
            ],
            [
                'question' => 'What payment methods do you accept?',
                'answer' => 'We accept cash, all major credit/debit cards, UPI payments, net banking, and digital wallets. For insurance claims, we work directly with your insurance provider.'
            ],
            [
                'question' => 'Do you offer any discounts or packages?',
                'answer' => 'Yes! We have Annual Maintenance Packages (Basic, Standard, and Premium) that offer significant savings. We also run seasonal promotions and offer discounts for repeat customers and referrals.'
            ],
            [
                'question' => 'Is there a warranty on services?',
                'answer' => 'Absolutely! All our services come with a minimum 30-day warranty on labor. Parts warranty varies by manufacturer and will be clearly communicated at the time of service.'
            ]
        ]
    ],
    [
        'name' => 'Pickup & Delivery',
        'icon' => 'fa-truck',
        'faqs' => [
            [
                'question' => 'Do you offer pickup and delivery?',
                'answer' => 'Yes, we offer free pickup and delivery within 10km of our service center. For locations beyond that, a nominal delivery charge applies based on distance.'
            ],
            [
                'question' => 'How do I track my bike during service?',
                'answer' => 'Once your bike is picked up, you\'ll receive a tracking link via SMS/email. You can also view real-time status updates in your dashboard under "My Bookings".'
            ],
            [
                'question' => 'What are your operating hours?',
                'answer' => 'Our service center is open Monday through Saturday from 9:00 AM to 6:00 PM. Pickup and delivery services are available during these hours. Emergency services are available 24/7 for registered members.'
            ]
        ]
    ],
    [
        'name' => 'Insurance & Claims',
        'icon' => 'fa-shield-alt',
        'faqs' => [
            [
                'question' => 'Do you handle insurance claims?',
                'answer' => 'Yes, we\'re empaneled with all major insurance companies and TPAs. We can process both cashless claims and reimbursement claims. Our team will guide you through the entire claims process.'
            ],
            [
                'question' => 'What documents do I need for insurance claim?',
                'answer' => 'You\'ll need your insurance policy documents, vehicle registration certificate, driving license, and FIR (in case of accident/damage). Our team will assist you with the complete documentation process.'
            ],
            [
                'question' => 'How long does insurance claim processing take?',
                'answer' => 'Cashless claims are typically processed within 3-5 working days after survey completion. Reimbursement claims may take 7-14 days depending on the insurance company\'s processing time.'
            ]
        ]
    ],
    [
        'name' => 'Account & Security',
        'icon' => 'fa-lock',
        'faqs' => [
            [
                'question' => 'How do I reset my password?',
                'answer' => 'Click on "Forgot Password" on the login page, enter your registered email address, and we\'ll send you a password reset link. The link expires in 1 hour for security reasons.'
            ],
            [
                'question' => 'Is my personal information secure?',
                'answer' => 'Yes, we take data security very seriously. All data is encrypted in transit and at rest. We never share your personal information with third parties without your consent. Read our Privacy Policy for more details.'
            ],
            [
                'question' => 'Can I delete my account?',
                'answer' => 'Yes, you can request account deletion by contacting our support team. Please note that this action is irreversible and all your service history and data will be permanently removed within 30 days.'
            ]
        ]
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - Bike Garage Management System</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* FAQ Page Styles */
        .faq-hero {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            padding: 80px 0;
            text-align: center;
            color: white;
        }
        
        .faq-hero h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }
        
        .faq-hero p {
            font-size: 1.2rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto 30px;
        }
        
        /* Search Box */
        .faq-search {
            max-width: 600px;
            margin: 0 auto;
            position: relative;
        }
        
        .faq-search input {
            width: 100%;
            padding: 18px 50px 18px 25px;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            background: rgba(255,255,255,0.1);
            color: white;
            backdrop-filter: blur(10px);
        }
        
        .faq-search input::placeholder {
            color: rgba(255,255,255,0.6);
        }
        
        .faq-search button {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: var(--garage-orange);
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .faq-search button:hover {
            background: var(--garage-red);
        }
        
        /* FAQ Section */
        .faq-section {
            padding: 80px 0;
        }
        
        .faq-category {
            margin-bottom: 50px;
        }
        
        .faq-category-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--dark-border);
        }
        
        .faq-category-header i {
            font-size: 2rem;
            color: var(--garage-orange);
        }
        
        .faq-category-header h2 {
            color: var(--text-primary);
            font-size: 1.8rem;
        }
        
        /* Accordion */
        .faq-accordion {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .faq-item {
            background: var(--bg-card);
            border-radius: 12px;
            border: 1px solid var(--dark-border);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .faq-item:hover {
            border-color: var(--garage-orange);
        }
        
        .faq-item.active {
            border-color: var(--garage-orange);
            box-shadow: 0 5px 20px rgba(230, 57, 70, 0.1);
        }
        
        .faq-question {
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            background: transparent;
            border: none;
            width: 100%;
            text-align: left;
        }
        
        .faq-question h3 {
            color: var(--text-primary);
            font-size: 1.05rem;
            font-weight: 500;
            padding-right: 20px;
        }
        
        .faq-question .icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            transition: all 0.3s ease;
            flex-shrink: 0;
        }
        
        .faq-item.active .faq-question .icon {
            background: var(--garage-orange);
            color: white;
            transform: rotate(180deg);
        }
        
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        
        .faq-answer-content {
            padding: 0 25px 25px;
            color: var(--text-secondary);
            line-height: 1.7;
        }
        
        .faq-answer-content a {
            color: var(--garage-orange);
        }
        
        /* Contact CTA */
        .faq-contact {
            background: linear-gradient(135deg, rgba(230, 57, 70, 0.1), rgba(247, 127, 0, 0.1));
            border-radius: 20px;
            padding: 50px;
            text-align: center;
            margin-top: 60px;
            border: 1px solid var(--dark-border);
        }
        
        .faq-contact i {
            font-size: 4rem;
            color: var(--garage-orange);
            margin-bottom: 20px;
        }
        
        .faq-contact h3 {
            color: var(--text-primary);
            font-size: 1.8rem;
            margin-bottom: 15px;
        }
        
        .faq-contact p {
            color: var(--text-secondary);
            margin-bottom: 25px;
        }
        
        /* Quick Links */
        .faq-quick-links {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 30px;
        }
        
        .quick-link {
            padding: 12px 25px;
            background: var(--bg-card);
            border-radius: 30px;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid var(--dark-border);
        }
        
        .quick-link:hover {
            background: var(--garage-orange);
            color: white;
            border-color: var(--garage-orange);
        }
        
        /* No Results */
        .no-results {
            display: none;
            text-align: center;
            padding: 60px 20px;
            color: var(--text-secondary);
        }
        
        .no-results i {
            font-size: 4rem;
            color: var(--text-muted);
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            .faq-hero h1 {
                font-size: 2rem;
            }
            
            .faq-category-header h2 {
                font-size: 1.4rem;
            }
            
            .faq-question h3 {
                font-size: 0.95rem;
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
    <section class="faq-hero">
        <div class="container">
            <h1><i class="fas fa-question-circle"></i> Frequently Asked Questions</h1>
            <p>Find answers to common questions about our services, booking process, and more</p>
            
            <div class="faq-search">
                <input type="text" id="faqSearch" placeholder="Search your question...">
                <button type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <div id="faqResults">
                <?php foreach ($faqCategories as $category): ?>
                    <div class="faq-category" data-category="<?php echo strtolower(str_replace(' ', '-', $category['name'])); ?>">
                        <div class="faq-category-header">
                            <i class="fas <?php echo $category['icon']; ?>"></i>
                            <h2><?php echo $category['name']; ?></h2>
                        </div>
                        
                        <div class="faq-accordion">
                            <?php foreach ($category['faqs'] as $index => $faq): ?>
                                <div class="faq-item" data-question="<?php echo strtolower(strip_tags($faq['question'])); ?>">
                                    <button class="faq-question">
                                        <h3><?php echo htmlspecialchars($faq['question']); ?></h3>
                                        <span class="icon">
                                            <i class="fas fa-chevron-down"></i>
                                        </span>
                                    </button>
                                    <div class="faq-answer">
                                        <div class="faq-answer-content">
                                            <?php echo htmlspecialchars($faq['answer']); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- No Results Message -->
            <div class="no-results" id="noResults">
                <i class="fas fa-search"></i>
                <h3>No results found</h3>
                <p>Try different keywords or browse the categories above</p>
            </div>
            
            <!-- Contact CTA -->
            <div class="faq-contact">
                <i class="fas fa-headset"></i>
                <h3>Still have questions?</h3>
                <p>Our support team is here to help you with any other queries</p>
                <div class="hero-buttons">
                    <a href="contact.php" class="btn btn-primary">
                        <i class="fas fa-envelope"></i> Contact Us
                    </a>
                    <a href="tel:+919876543210" class="btn btn-outline">
                        <i class="fas fa-phone-alt"></i> Call Us
                    </a>
                </div>
                
                <div class="faq-quick-links">
                    <a href="services.php" class="quick-link">View Services</a>
                    <a href="register.php" class="quick-link">Create Account</a>
                    <a href="login.php" class="quick-link">Login</a>
                    <a href="about.php" class="quick-link">About Us</a>
                </div>
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

    <script>
        // FAQ Accordion functionality
        document.querySelectorAll('.faq-question').forEach(button => {
            button.addEventListener('click', function() {
                const item = this.closest('.faq-item');
                const answer = item.querySelector('.faq-answer');
                const wasActive = item.classList.contains('active');
                
                // Close all items
                document.querySelectorAll('.faq-item').forEach(i => {
                    i.classList.remove('active');
                    i.querySelector('.faq-answer').style.maxHeight = '0';
                });
                
                // Open clicked item if it wasn't active
                if (!wasActive) {
                    item.classList.add('active');
                    answer.style.maxHeight = answer.scrollHeight + 'px';
                }
            });
        });
        
        // FAQ Search functionality
        document.getElementById('faqSearch').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            const faqItems = document.querySelectorAll('.faq-item');
            const categories = document.querySelectorAll('.faq-category');
            let hasResults = false;
            
            // Reset categories
            categories.forEach(cat => cat.style.display = 'block');
            document.getElementById('noResults').style.display = 'none';
            
            if (searchTerm === '') {
                faqItems.forEach(item => {
                    item.style.display = 'block';
                    item.classList.remove('active');
                    item.querySelector('.faq-answer').style.maxHeight = '0';
                });
                return;
            }
            
            let visibleCategories = new Set();
            
            faqItems.forEach(item => {
                const question = item.dataset.question;
                const answer = item.querySelector('.faq-answer-content').textContent.toLowerCase();
                
                if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                    item.style.display = 'block';
                    hasResults = true;
                    visibleCategories.add(item.closest('.faq-category'));
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Hide empty categories
            categories.forEach(cat => {
                const visibleItems = cat.querySelectorAll('.faq-item[style="display: block;"]');
                if (visibleItems.length === 0) {
                    cat.style.display = 'none';
                }
            });
            
            if (!hasResults) {
                document.getElementById('noResults').style.display = 'block';
            }
        });
    </script>
</body>
</html>

