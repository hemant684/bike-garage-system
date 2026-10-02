# Bike Garage Management System - Complete Setup Guide

## System Overview
A comprehensive PHP/MySQL web application for managing bike servicing and repairs.

---

## Prerequisites

### Required Software
1. **MAMP** (Mac) or **XAMPP** (Windows/Linux)
   - Download: https://www.mamp.info/en/downloads/
   - Recommended: MAMP Pro or Free (includes Apache, PHP, MySQL)

2. **Web Browser** (Chrome, Firefox, Safari)

---

## MAMP Setup (macOS)

### Step 1: Install MAMP
1. Download MAMP from the official website
2. Open the downloaded `.dmg` file
3. Drag MAMP to your Applications folder
4. Open MAMP from Applications

### Step 2: Configure MAMP Ports
1. Open MAMP application
2. Click **Preferences** (gear icon)
3. Go to **Ports** tab
4. Set:
   - Apache Port: `8888` (default)
   - MySQL Port: `3306` (default)
5. Click **OK**

### Step 3: Set PHP Version
1. In MAMP Preferences, go to **PHP** tab
2. Select PHP 8.2 or 8.1 (recommended)
3. Click **OK**

### Step 4: Document Root Setup
1. In MAMP Preferences, go to **Web Server** tab
2. Click the folder icon to select document root
3. Navigate to: `/Users/hemantchaudhary/Desktop/bike-garage-system`
4. Click **Select** then **OK**

### Step 5: Start MAMP Servers
1. Click the green **Start** button
2. Wait for both Apache and MySQL servers to turn green (ready)
3. The MySQL server must be running for database connections

### Step 6: Access phpMyAdmin
1. Open your web browser
2. Go to: http://localhost:8888/phpMyAdmin
3. You should see the phpMyAdmin interface

---

## Database Setup

### Method 1: Using phpMyAdmin (Recommended)

#### Option A: Import from database.sql
1. In phpMyAdmin (http://localhost:8888/phpMyAdmin), click **New** in the left sidebar
2. Under "Create database", enter:
   - Database name: `bike_garage`
   - Collation: `utf8mb4_unicode_ci`
3. Click **Create**

4. Select `bike_garage` from the left sidebar
5. Click the **Import** tab at the top
6. Click **Choose File**
7. Navigate to: `/Users/hemantchaudhary/Desktop/bike-garage-system/database.sql`
8. Click **Go** at the bottom

#### Option B: Using Auto-Setup
The system includes auto-setup. Simply visit any page and it will:
- Create the database `bike_garage` if it doesn't exist
- Create all required tables
- Insert default admin users

### Method 2: Using MySQL Command Line

1. Open Terminal
2. Run:
```bash
/Applications/MAMP/Library/bin/mysql -u root -p < /Users/hemantchaudhary/Desktop/bike-garage-system/database.sql
```
3. When prompted for password, press **Enter** (MAMP default has no password)

---

## Default Login Credentials

| Role | Username | Password |
|------|----------|----------|
| Super Admin | superadmin | super123 |
| Admin | admin | admin123 |
| User | john@example.com | user123 |

---

## Access URLs

| Page | URL |
|------|-----|
| Homepage | http://localhost:8888/ |
| User Login | http://localhost:8888/login.php |
| User Register | http://localhost:8888/register.php |
| Admin Login | http://localhost:8888/admin/admin_login.php |
| Super Admin | http://localhost:8888/superadmin/superadmin_login.php |
| phpMyAdmin | http://localhost:8888/phpMyAdmin |

---

## Fixing Database Connection Issues

### Error: "Access denied for user 'root'@'localhost'"

This error occurs when the MySQL password is incorrect. Here's how to fix it:

#### Step 1: Check MySQL Password in MAMP
1. Open MAMP
2. Click **phpMyAdmin**
3. Look at the top for username (should be `root`)
4. Try logging in without a password

#### Step 2: Update Password (if needed)
If MySQL has a password set:

1. In phpMyAdmin:
   - Click on the `mysql` database
   - Click **SQL** tab
   - Run:
   ```sql
   ALTER USER 'root'@'localhost' IDENTIFIED BY '';
   FLUSH PRIVILEGES;
   ```
   - This sets password to empty (MAMP default)

#### Step 3: Verify Socket Path
The MySQL socket should be at:
```
/Applications/MAMP/tmp/mysql/mysql.sock
```

If it doesn't exist, create a symlink:
```bash
sudo mkdir -p /Applications/MAMP/tmp/mysql
sudo ln -s /Applications/MAMP/tmp/mysql/mysql.sock /var/mysql/mysql.sock
```

---

## Troubleshooting

### Issue: "Connection failed" or "Access denied"

**Solutions:**
1. ✅ Make sure MAMP is running (green lights)
2. ✅ Try password: empty (`''`) or `'root'`
3. ✅ Check socket path exists
4. ✅ Restart MAMP servers

### Issue: Blank White Page

**Solutions:**
1. Enable error reporting by adding at the top of the file:
```php
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

2. Check Apache error logs:
   - Location: `/Applications/MAMP/logs/php_error.log`

### Issue: Session Not Working

**Solutions:**
1. Check session.save_path in php.ini
2. Make sure sessions folder is writable
3. Add at top of file:
```php
session_start();
```

### Issue: phpMyAdmin Not Loading

**Solutions:**
1. Check MAMP is running
2. Try different port: http://localhost:8889/phpMyAdmin
3. Restart MAMP

---

## MySQL Password Reset (if needed)

If you can't connect to MySQL:

1. Stop MAMP servers
2. Edit: `/Applications/MAMP/bin/mamp/MySQL.conf`
3. Add:
```
[mysqld]
skip-grant-tables
```
4. Start MAMP
5. In phpMyAdmin, run:
```sql
UPDATE mysql.user SET authentication_string='' WHERE User='root';
FLUSH PRIVILEGES;
```
6. Stop MAMP and remove the skip-grant-tables line
7. Restart MAMP

---

## Project Structure

```
bike-garage-system/
├── index.html              # Landing page
├── login.php               # User login
├── register.php            # User registration
├── forgot_password.php     # Password recovery
├── logout.php              # Logout handler
├── database.sql            # Database schema
├── setup.php               # Setup script
├── update_database.php     # Update existing database
├── run_update.php          # Run database updates
├── README_SETUP.md         # This file
├── config/
│   ├── db_config.php       # Database connection
│   ├── auto_setup.php      # Auto database setup
│   ├── security.php        # Security functions
│   ├── functions.php       # Helper functions
│   ├── session.php         # Session management
│   └── toast.php           # Toast notifications
├── admin/                  # Admin module
├── superadmin/             # Super admin module
├── user/                   # Customer module
├── css/                    # Stylesheets
├── js/                     # JavaScript files
└── images/                 # Images
```

---

## Features Implemented

### User Features
- Registration & Login
- Book bike service
- View booking status
- View and download bills
- Profile management

### Admin Features
- Dashboard with statistics
- Manage all bookings
- Update booking status
- Generate bills
- Daily/Monthly reports with CSV export

### Super Admin Features
- System overview dashboard
- Manage admin users
- View activity logs
- System settings

---

## Database Schema

| Table | Description |
|-------|-------------|
| users | Customer accounts |
| admin | Admin accounts |
| service_booking | Service bookings |
| billing | Bills/invoices |
| activity_logs | Audit trail |

---

## Security Features
- ✅ Password hashing (bcrypt)
- ✅ SQL injection prevention (prepared statements)
- ✅ Session-based authentication
- ✅ Input sanitization
- ✅ XSS protection

---

## Quick Start Checklist

- [ ] Download and install MAMP
- [ ] Start MAMP servers
- [ ] Open phpMyAdmin (http://localhost:8888/phpMyAdmin)
- [ ] Create database `bike_garage`
- [ ] Import `database.sql`
- [ ] Open http://localhost:8888/ in browser
- [ ] Login with: superadmin / super123

---

## Support

If you encounter issues:
1. Check the Troubleshooting section above
2. Check Apache logs: `/Applications/MAMP/logs/`
3. Restart MAMP servers
4. Verify database was imported correctly

---

Created for educational purposes.

