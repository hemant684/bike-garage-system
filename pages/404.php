<?php
/**
 * 404 Error Page
 * Bike Garage Management System
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found - Bike Garage Management System</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .error-page {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0d0d0d 0%, #1a1a2e 50%, #16213e 100%);
            text-align: center;
            padding: 40px 20px;
        }
        
        .error-content {
            max-width: 600px;
        }
        
        .error-icon {
            font-size: 10rem;
            background: linear-gradient(135deg, var(--garage-red), var(--garage-orange));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 30px;
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        
        .error-content h1 {
            font-size: 3rem;
            color: var(--text-primary);
            margin-bottom: 20px;
        }
        
        .error-content p {
            color: var(--text-secondary);
            font-size: 1.2rem;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        
        .error-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .error-actions .btn {
            padding: 15px 30px;
            font-size: 1rem;
        }
        
        .error-details {
            background: var(--dark-card);
            border-radius: 10px;
            padding: 20px;
            margin-top: 40px;
            border: 1px solid var(--dark-border);
        }
        
        .error-details h3 {
            color: var(--text-primary);
            margin-bottom: 15px;
            font-size: 1.1rem;
        }
        
        .error-details ul {
            list-style: none;
            text-align: left;
        }
        
        .error-details li {
            padding: 10px 0;
            border-bottom: 1px solid var(--dark-border);
            color: var(--text-secondary);
        }
        
        .error-details li:last-child {
            border-bottom: none;
        }
        
        .error-details li i {
            color: var(--garage-orange);
            margin-right: 10px;
        }
        
        @media (max-width: 768px) {
            .error-icon {
                font-size: 6rem;
            }
            
            .error-content h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="error-page">
        <div class="error-content">
            <div class="error-icon">
                <i class="fas fa-wrench"></i>
            </div>
            
            <h1>Oops! Something's Wrong</h1>
            <p>The page you're looking for might have been moved, deleted, or never existed. Don't worry, even the best mechanics sometimes can't find the right part!</p>
            
            <div class="error-actions">
                <a href="index.html" class="btn btn-primary">
                    <i class="fas fa-home"></i> Go Home
                </a>
                <a href="services.php" class="btn btn-outline">
                    <i class="fas fa-tools"></i> Our Services
                </a>
                <a href="contact.php" class="btn btn-warning">
                    <i class="fas fa-envelope"></i> Get Help
                </a>
            </div>
            
            <div class="error-details">
                <h3><i class="fas fa-lightbulb"></i> While you're here, you might want to:</h3>
                <ul>
                    <li><a href="login.php" style="color: var(--garage-orange);">Login to your account</a></li>
                    <li><a href="register.php" style="color: var(--garage-orange);">Create a new account</a></li>
                    <li><a href="book_service.php" style="color: var(--garage-orange);">Book a bike service</a></li>
                    <li><a href="faq.php" style="color: var(--garage-orange);">Check our FAQ</a></li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        // Auto-redirect option after 10 seconds
        let countdown = 10;
        const countdownElement = document.createElement('p');
        countdownElement.style.cssText = 'color: var(--text-muted); margin-top: 30px; font-size: 0.9rem;';
        document.querySelector('.error-content').appendChild(countdownElement);
        
        function updateCountdown() {
            countdown--;
            if (countdown > 0) {
                countdownElement.innerHTML = `Redirecting to homepage in <strong style="color: var(--garage-orange);">${countdown}</strong> seconds...`;
                setTimeout(updateCountdown, 1000);
            } else {
                window.location.href = 'index.html';
            }
        }
        
        setTimeout(updateCountdown, 1000);
    </script>
</body>
</html>

