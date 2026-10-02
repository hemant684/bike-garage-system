# 🚀 Railway Deployment - DETAILED STEP-BY-STEP GUIDE

## **PART 1: Create Railway Account & Project**

### **STEP 1A: Go to Railway Website**
1. **Open browser** and go to: `https://railway.app`
2. You should see a white page with "Railway" logo
3. Look for a button that says **"Start a new project"** or **"Get Started"**
4. **Click it**

### **STEP 1B: Sign Up / Log In**
1. If not logged in, you'll see a **"Sign in with GitHub"** button
2. **Click "Sign in with GitHub"**
3. Authorize Railway to access your GitHub account
4. You'll be logged in

### **STEP 1C: Create New Project**
1. After login, click **"Create a new project"** or **"New Project"** button
2. You'll see options:
   - **"Deploy from GitHub"** ← CLICK THIS ONE
   - "Deploy from Template"
   - "Empty Project"
3. **Click "Deploy from GitHub"**

---

## **PART 2: Connect Your Repository**

### **STEP 2A: Authorize GitHub Connection**
1. GitHub will ask to authorize Railway
2. **Click "Authorize"**
3. You'll be taken back to Railway

### **STEP 2B: Select Your Repository**
1. You'll see a search box with heading **"What repository would you like to deploy?"**
2. **Type:** `bike-garage-system`
3. Your repo should appear in dropdown
4. **Click on:** `hemant684/bike-garage-system`

### **STEP 2C: Create Project**
1. The page updates with your repo selected
2. Look for a **"Create Project"** or **"Deploy"** button (usually blue)
3. **Click it**
4. Railway starts analyzing your project
5. **WAIT 2-3 minutes** for the build to complete

---

## **PART 3: Add MySQL Database**

### **STEP 3A: Add Service**
1. Once the build finishes, you're in the Railway dashboard
2. Look for a button that says **"New"** or **"Add Service"** (usually top right)
3. **Click "New"**

### **STEP 3B: Select MySQL**
1. A dropdown menu appears
2. Scroll down to find **"MySQL"** or **"Database"**
3. **Click on "MySQL"**
4. **WAIT 1-2 minutes** for MySQL to provision

### **STEP 3C: View MySQL Credentials**
1. MySQL is now running
2. Click on the **"MySQL"** service in your project
3. Go to the **"Variables"** tab
4. You should see:
   - `MYSQL_HOST` (hostname)
   - `MYSQL_USER` (usually `root`)
   - `MYSQL_PASSWORD` (auto-generated)
   - `MYSQL_DATABASE` (usually `railway`)
5. **COPY these values** - you'll need them

---

## **PART 4: Configure Environment Variables**

### **STEP 4A: Go to Your PHP App Variables**
1. In Railway dashboard, click on your **bike-garage-system** service (not MySQL)
2. Go to **"Variables"** tab

### **STEP 4B: Add Database Variables**
1. Click **"Add Variable"** button
2. Add each of these:

```
Variable Name: DB_HOST
Variable Value: [COPY MYSQL_HOST from MySQL service]

Variable Name: DB_NAME
Variable Value: bike_garage

Variable Name: DB_USER
Variable Value: [COPY MYSQL_USER from MySQL service]

Variable Name: DB_PASS
Variable Value: [COPY MYSQL_PASSWORD from MySQL service]

Variable Name: DATABASE_URL
Variable Value: mysql://[user]:[password]@[host]:3306/bike_garage
```

3. **Click "Add Variable"** for each one
4. They should appear in the list

### **STEP 4C: Deploy with Variables**
1. Once all variables are added, Railway automatically redeploys
2. **Wait 2-3 minutes** for redeployment

---

## **PART 5: Get Your Live URL**

### **STEP 5A: Find Your Domain**
1. In Railway dashboard, look for your **bike-garage-system** service
2. You should see a section labeled **"Domain"** or **"URL"**
3. It will look like: `https://bike-garage-system-production.up.railway.app`
4. **COPY THIS URL** - this is your backend

### **STEP 5B: Test Your Backend**
1. Go to: `https://your-railway-url/verify_dashboard.php`
2. Replace "your-railway-url" with your actual URL
3. Should show all green checkmarks ✅

---

## **PART 6: Connect to Netlify**

### **STEP 6A: Go to Netlify**
1. Open: `https://app.netlify.com`
2. Select your **bike-garage-system** site

### **STEP 6B: Add Environment Variable**
1. Go to: **Site settings** → **Build & deploy** → **Environment**
2. Click **"Edit variables"**
3. Add new variable:
   - **Name:** `VITE_API_URL`
   - **Value:** `https://your-railway-url` (your Railway URL from Step 5A)
4. Click **"Add"**
5. Click **"Save"**

### **STEP 6C: Trigger New Build**
1. Go to: **Deploys** tab
2. Look for **"Trigger deploy"** button
3. Click it
4. **WAIT 2-3 minutes** for build to complete

---

## **✅ DONE! Your System is LIVE!**

### **Test Everything:**

**Test 1: Homepage**
```
https://your-netlify-site.netlify.app
```
Should load your React app homepage

**Test 2: Admin Login**
```
https://your-netlify-site.netlify.app/admin/admin_login.php
```
Should show login form. Try:
- Username: `admin`
- Password: `admin123`

**Test 3: Backend Check**
```
https://your-railway-url/verify_dashboard.php
```
Should show checkmarks for:
- ✅ Database connection
- ✅ Admin user
- ✅ Dashboard statistics
- ✅ Session management

---

## **⚠️ TROUBLESHOOTING**

### Issue: "Build failed on Railway"
**Solution:**
1. Check Railway build logs (click service → "Logs" tab)
2. Look for PHP errors
3. Common fix: Ensure all files were pushed to GitHub

### Issue: "Database connection failed"
**Solution:**
1. Double-check DB_HOST, DB_USER, DB_PASS match MySQL service
2. Wait 5 minutes for MySQL to fully initialize
3. Try accessing verify_dashboard.php again

### Issue: "Netlify shows 404 on admin page"
**Solution:**
1. Verify VITE_API_URL is correctly set in Netlify
2. Check it points to your Railway URL (without trailing slash)
3. Trigger new Netlify deploy

### Issue: "Can't find 'Start a new project' button"
**Solution:**
1. Make sure you're logged into Railway (GitHub profile icon top right)
2. If logged in, look for a "+" icon instead
3. Or go to: `https://railway.app/new`

---

## **🎯 FINAL CHECKLIST**

- [ ] Created Railway account
- [ ] Deployed bike-garage-system from GitHub
- [ ] Added MySQL database
- [ ] Set all DB environment variables
- [ ] Got Railway URL
- [ ] Updated Netlify VITE_API_URL
- [ ] Triggered Netlify rebuild
- [ ] Tested homepage loads
- [ ] Tested admin login works
- [ ] Tested backend verify_dashboard.php

**If all checked: YOU'RE DONE! 🎉**

---

## **📞 HELP**

**Stuck?** Check:
1. Are you logged into Railway? (Check top right)
2. Is GitHub connected properly? (Railway can see your repos?)
3. Are build logs showing errors? (Check Logs tab)
4. Do variables match MySQL credentials exactly?

**Not working?**
- Wait 5-10 minutes (services take time to provision)
- Refresh browser
- Try again

---

**Ready? Start here: https://railway.app 🚀**
