# Bike Garage Management System

A web-based system for managing bike servicing and repairs. The legacy application uses PHP and MySQL; the separate customer-facing frontend is built with Next.js and React.

## 🏍️ Features

### User Features
- **User Registration** - Sign up with personal and bike details
- **User Login** - Secure authentication with session management
- **Forgot Password** - Password recovery functionality
- **Book Service** - Schedule bike servicing appointments
- **View Bookings** - Track service booking status
- **View Bills** - Access and download service bills
- **Profile Management** - Update personal and bike information

### Admin Features
- **Admin Dashboard** - Overview of system statistics
- **Manage Bookings** - Approve, update status, and manage service bookings
- **Generate Bills** - Create bills with labor and parts cost breakdown
- **Reports** - Daily and monthly reports with export options
- **User Management** - View all registered users

## 📁 Project Structure

```
bike-garage-system/
├── react-frontend/             # Next.js customer-facing frontend
│   ├── app/                    # App Router pages and shared layout
│   └── src/                    # React page components and light theme
├── config/
│   └── db_config.php          # Database configuration
├── css/
│   └── style.css              # Main stylesheet
├── js/
│   └── validation.js          # Client-side validation
├── admin/
│   ├── admin_login.php        # Admin login page
│   ├── admin_dashboard.php    # Admin dashboard
│   ├── manage_booking.php     # Manage service bookings
│   └── report.php             # Reports page
├── user/
│   ├── user_dashboard.php     # User dashboard
│   ├── book_service.php       # Book service page
│   └── view_bill.php          # View bills page
├── database.sql               # Database schema and sample data
├── index.html                 # Landing page
├── login.php                  # User login page
├── register.php               # User registration page
└── forgot_password.php        # Password recovery page
```

## Next.js React Frontend

The frontend runs as a Next.js application and uses the existing PHP application for authentication, registration, booking, and billing.

```bash
cd react-frontend
npm install
npm run dev
```

Open `http://localhost:3000`. For local MAMP setups, `react-frontend/.env.local` should set `NEXT_PUBLIC_PHP_BACKEND_URL=http://localhost:8888`. Set that variable to the deployed PHP origin in the production environment before publishing. The PHP server and its MySQL database must be running for account and service forms to submit successfully.

Production commands are `npm run build` and `npm run start`. Netlify uses the `react-frontend` base directory configured in `netlify.toml`.

## 🚀 Installation Steps

### 1. Install XAMPP/WAMP
- Download and install XAMPP (for Windows/Linux) or MAMP (for Mac)
- Start Apache and MySQL services

### 2. Setup Database
1. Open phpMyAdmin (http://localhost/phpmyadmin)
2. Create a new database named `bike_garage`
3. Import the `database.sql` file from this project
4. The database will be created with sample data

### 3. Configure Database Connection
Edit `config/db_config.php` if needed:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'bike_garage');
define('DB_USER', 'root');
define('DB_PASS', ''); // Default XAMPP password is empty
```

### 4. Setup Project
1. Copy the `bike-garage-system` folder to XAMPP's htdocs directory:
   - Windows: `C:\xampp\htdocs\`
   - Mac: `/Applications/XAMPP/htdocs/`
   - Linux: `/var/www/html/`

2. Access the application:
   ```
   http://localhost/bike-garage-system/
   ```

## 🔐 Login Credentials

### Admin Account
- **Username:** admin
- **Password:** admin123

### User Accounts (Demo)
- **Email:** john@example.com
- **Password:** user123

- **Email:** jane@example.com
- **Password:** user123

- **Email:** mike@example.com
- **Password:** user123

## 📋 Database Tables

| Table | Description |
|-------|-------------|
| `users` | User registration data |
| `admin` | Admin credentials |
| `service_booking` | Service booking records |
| `billing` | Billing and payment records |

## 🎨 Technology Stack

- **Frontend:** Next.js 16, React 19, CSS3
- **Legacy pages/backend:** PHP 7.0+
- **Database:** MySQL
- **Server:** Apache (XAMPP/WAMP)
- **Validation:** Browser-side form constraints + server-side (PHP)

## 📱 Features Implemented

### Authentication
- [x] User Registration with validation
- [x] User Login with session management
- [x] Admin Login
- [x] Password Recovery
- [x] Session timeout (24 hours)

### Service Booking
- [x] Book new service
- [x] Select service type
- [x] Choose date and time
- [x] View booking status
- [x] Booking history

### Admin Panel
- [x] Dashboard with statistics
- [x] Manage all bookings
- [x] Update booking status
- [x] Generate bills
- [x] Daily/Monthly reports
- [x] Export to CSV

### Billing
- [x] Labor charge entry
- [x] Parts cost entry
- [x] Automatic tax calculation (9%)
- [x] Payment status tracking
- [x] Print bills

## 🔒 Security Features

- Password hashing using `password_hash()` and `password_verify()`
- SQL injection prevention using prepared statements
- Session-based authentication
- Input validation and sanitization
- XSS protection with `htmlspecialchars()`

## 📊 Reports Available

- **Daily Report:** Bookings and revenue for a specific date
- **Monthly Report:** Monthly breakdown with daily statistics
- **Export Options:** CSV export for data analysis

## 🛠️ Customization

### Adding New Service Types
Edit `user/book_service.php` and add new options to the service type dropdown:
```php
<option value="New Service">New Service Name</option>
```

### Modifying Tax Rate
Edit `admin/manage_booking.php` and change the tax rate:
```php
$taxRate = 0.09; // Change this value
```

## 📝 Notes

1. **Passwords** are hashed using PHP's `password_hash()` function
2. **Sessions** last for 24 hours of inactivity
3. **Email validation** is implemented with regex
4. **Responsive design** works on mobile and desktop
5. **Font Awesome** icons are used throughout

## 📄 License

This project is for educational purposes as a college project.

## 👨‍💻 Developer

Created for college project demonstration.
