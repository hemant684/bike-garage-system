# 🚴 Bike Garage Management System - Admin Dashboard Setup Guide

## ✅ What's Fixed

I've successfully fixed your admin dashboard! Here's what was done:

### Database Issues Resolved:
1. ✅ **Added missing `role` column** to admin table (ENUM: 'admin', 'superadmin')
2. ✅ **Added missing `status` column** to admin table (ENUM: 'active', 'inactive')
3. ✅ **Reset admin password** to `admin123`
4. ✅ **Verified all tables** are properly configured
5. ✅ **Tested all dashboard queries** - working perfectly!

---

## 🔐 Admin Login Credentials

```
Username: admin
Password: admin123
```

---

## 🌐 Access URLs

Open these URLs in your browser (make sure MAMP is running):

1. **Admin Login Page:**
   ```
   http://localhost:8888/bike-garage-system/admin/admin_login.php
   ```

2. **Admin Dashboard (after login):**
   ```
   http://localhost:8888/bike-garage-system/admin/admin_dashboard.php
   ```

3. **Super Admin Login:**
   ```
   http://localhost:8888/bike-garage-system/admin/superadmin/superadmin_login.php
   ```

4. **User Login:**
   ```
   http://localhost:8888/bike-garage-system/login.php
   ```

5. **Homepage:**
   ```
   http://localhost:8888/bike-garage-system/index.html
   ```

---

## 🛠️ Database Status

### Current Data:
- **Users:** 3 registered users
- **Service Bookings:** 4 bookings
- **Billing Records:** 2 bills
- **Total Revenue:** ₹2,343.50

### Admin User:
- **Username:** admin
- **Email:** admin@bikeGarage.com
- **Role:** admin
- **Status:** active

---

## 🚀 How to Use

### Step 1: Start MAMP
Make sure MAMP MySQL server is running on port 8889

### Step 2: Open Admin Login
Go to: `http://localhost:8888/bike-garage-system/admin/admin_login.php`

### Step 3: Login
Use credentials:
- Username: **admin**
- Password: **admin123**

### Step 4: View Dashboard
After successful login, you'll see the admin dashboard with:
- Statistics overview (users, bookings, revenue)
- Recent bookings table
- Service status distribution
- Quick action buttons
- Revenue charts

---

## 📊 Dashboard Features

### Statistics Cards:
- 👥 Total Users
- 📅 Total Bookings
- ⏳ Pending Services  
- ✅ Completed Services
- 💰 Total Revenue
- 📆 Today's Bookings

### Management Options:
- Manage Bookings
- View Reports (Daily/Monthly)
- Export Data
- Generate Bills

---

## 🐛 Troubleshooting

### If MAMP is not running:
1. Open MAMP application
2. Click "Start Servers"
3. Wait for MySQL to turn green

### If login fails:
1. Run the verification script:
   ```
   http://localhost:8888/bike-garage-system/verify_dashboard.php
   ```
2. Check that password was reset to `admin123`

### If pages show blank:
1. Check that MAMP MySQL is running on port 8889
2. Verify database connection in `config/db_config.php`
3. Check PHP error logs

---

## 📁 Important Files

```
bike-garage-system/
├── config/
│   ├── db_config.php          # Database connection
│   ├── session.php            # Session management
│   └── functions.php          # Helper functions
├── admin/
│   ├── admin_login.php        # Admin login page
│   ├── admin_dashboard.php     # Main dashboard
│   └── superadmin/            # Super admin section
├── user/                      # User dashboard
└── verify_dashboard.php        # Verification script (temporary)
```

---

## ✅ Quick Verification

To verify everything is working, visit:
```
http://localhost:8888/bike-garage-system/verify_dashboard.php
```

This will show you:
- Database connection status
- Admin user details
- All dashboard statistics
- Session configuration
- Login simulation

---

## 🎉 You're All Set!

Your Bike Garage Management System admin dashboard is now fully functional. You can:
- ✅ Login with username `admin` and password `admin123`
- ✅ View all statistics and reports
- ✅ Manage service bookings
- ✅ Track revenue and payments
- ✅ Manage users

**Happy managing! 🚴‍♂️📊💰**

---

## 📞 Need Help?

If you encounter any issues:
1. Make sure MAMP MySQL server is running
2. Check that port 8889 is available
3. Verify database was properly set up
4. Check PHP error logs for detailed errors

For immediate verification, run:
```bash
php /Users/hemantchaudhary/Desktop/bike-garage-system/verify_dashboard.php
