# 🚀 Bike Garage Management System - Live Deployment Guide

## **Deployment Overview**

Your Bike Garage system has **two components** that need separate hosting:

1. **React Frontend** → Netlify (or Vercel)
2. **PHP Backend** → Railway, Heroku, or DigitalOcean

---

## **PART 1: Deploy React Frontend to Netlify**

### **Step 1: Prepare the Project**

The React frontend is already built and ready. The build files are in:
```
react-frontend/dist/
```

### **Step 2: Create GitHub Repository**

1. **Install Git** (if not already installed)
   ```bash
   brew install git
   ```

2. **Initialize Git Repository**
   ```bash
   cd /Users/hemantchaudhary/Desktop/bike-garage-system
   git init
   git add .
   git commit -m "Initial commit: Bike Garage Management System"
   ```

3. **Create GitHub Account** (if you don't have one)
   - Go to https://github.com/
   - Sign up for a free account

4. **Create New Repository on GitHub**
   - Click "New" button
   - Name it: `bike-garage-system`
   - Don't initialize with README (we already have one)
   - Click "Create repository"

5. **Push to GitHub**
   ```bash
   git remote add origin https://github.com/YOUR_USERNAME/bike-garage-system.git
   git branch -M main
   git push -u origin main
   ```

### **Step 3: Deploy to Netlify**

1. **Sign up for Netlify**
   - Go to https://netlify.com
   - Click "Sign up"
   - Choose "GitHub" for authentication
   - Authorize Netlify to access your GitHub account

2. **Deploy from GitHub**
   - Click "Add new site" → "Import an existing project"
   - Select your GitHub repository
   - Click "Deploy site"

3. **Configure Build Settings**
   - Build command: `cd react-frontend && npm install && npm run build`
   - Publish directory: `react-frontend/dist`

4. **Add Environment Variables**
   - Go to Site settings → Build & deploy → Environment
   - Add these variables:
     ```
     VITE_API_URL = https://your-backend-domain.com
     VITE_ADMIN_URL = https://your-backend-domain.com/admin
     ```

5. **Deploy**
   - Netlify will automatically build and deploy
   - You'll get a URL like: `https://your-site-name.netlify.app`

---

## **PART 2: Deploy PHP Backend**

### **Option A: Deploy to Railway (Recommended - Free Tier Available)**

1. **Create Railway Account**
   - Go to https://railway.app
   - Sign up with GitHub
   - Connect your repository

2. **Deploy PHP Backend**
   - Click "New Project"
   - Select "Deploy from GitHub"
   - Choose your `bike-garage-system` repository
   - Railway will detect the PHP project

3. **Configure Environment Variables**
   - Go to Variables
   - Add database credentials:
     ```
     DB_HOST = localhost
     DB_NAME = bike_garage
     DB_USER = your_db_user
     DB_PASS = your_db_password
     ```

4. **Set Up MySQL Database**
   - Add MySQL plugin in Railway
   - Copy the connection string
   - Update PHP config with these credentials

5. **Deploy**
   - Railway will automatically build and deploy
   - You'll get a domain like: `your-project.railway.app`

### **Option B: Deploy to Heroku (Requires Payment)**

1. **Create Heroku Account**
   - Go to https://heroku.com
   - Sign up for account

2. **Install Heroku CLI**
   ```bash
   brew tap heroku/brew && brew install heroku
   ```

3. **Login to Heroku**
   ```bash
   heroku login
   ```

4. **Create Heroku App**
   ```bash
   cd /Users/hemantchaudhary/Desktop/bike-garage-system
   heroku create your-app-name
   ```

5. **Set Environment Variables**
   ```bash
   heroku config:set DB_HOST=your-database-host
   heroku config:set DB_NAME=bike_garage
   heroku config:set DB_USER=your_db_user
   heroku config:set DB_PASS=your_db_password
   ```

6. **Deploy**
   ```bash
   git push heroku main
   ```

### **Option C: Deploy to DigitalOcean App Platform**

1. **Create DigitalOcean Account**
   - Go to https://digitalocean.com
   - Sign up for account (includes $200 free credits)

2. **Create App**
   - Go to "Apps" → "Create App"
   - Connect your GitHub repository
   - Select PHP buildpack

3. **Configure Database**
   - Add managed MySQL database
   - Note the connection details

4. **Deploy**
   - DigitalOcean will automatically build and deploy

---

## **PART 3: Connect Frontend to Backend**

After deploying both frontend and backend:

### **Update Frontend Environment**

1. **On Netlify Dashboard:**
   - Go to Site settings → Build & deploy → Environment
   - Update `VITE_API_URL` with your backend domain:
     ```
     VITE_API_URL = https://your-backend.railway.app
     ```

2. **Update vite.config.js** (for production proxies):
   ```javascript
   proxy: {
     '/api': {
       target: 'https://your-backend.railway.app',
       changeOrigin: true,
       rewrite: (path) => path.replace(/^\/api/, '')
     }
   }
   ```

3. **Trigger new build** on Netlify
   - Go to Deploys
   - Click "Trigger deploy" for a full build

---

## **PART 4: Configure CORS & Security**

### **On PHP Backend (config/security.php)**

Add CORS headers for Netlify domain:

```php
header('Access-Control-Allow-Origin: https://your-site.netlify.app');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
```

---

## **Final URLs After Deployment**

- **Frontend:** `https://your-site.netlify.app`
- **Admin Login:** `https://your-site.netlify.app/admin` (proxied to backend)
- **Admin Dashboard:** `https://your-site.netlify.app/admin/dashboard`
- **Backend API:** `https://your-backend.railway.app`

---

## **Quick Start Commands**

### **Initialize Git & Push to GitHub**
```bash
cd /Users/hemantchaudhary/Desktop/bike-garage-system
git init
git add .
git commit -m "Initial commit"
git remote add origin https://github.com/YOUR_USERNAME/bike-garage-system.git
git push -u origin main
```

### **Build Frontend Locally**
```bash
cd react-frontend
npm run build
```

### **Test Build Locally**
```bash
npm run preview
```

---

## **Troubleshooting**

### **Build Fails on Netlify**
- Check build logs in Netlify dashboard
- Ensure `netlify.toml` has correct paths
- Verify Node.js version compatibility

### **Backend Connection Issues**
- Verify CORS headers are set
- Check environment variables on backend
- Test API endpoint directly in browser

### **Database Connection Issues**
- Verify database credentials
- Check if database is accessible from hosting provider
- Enable remote connections if needed

---

## **Support Resources**

- Netlify Docs: https://docs.netlify.com
- Railway Docs: https://railway.app/docs
- Heroku Docs: https://devcenter.heroku.com
- DigitalOcean Docs: https://docs.digitalocean.com

---

**Your system is ready for deployment! 🚀**
