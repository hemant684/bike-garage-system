# Deploy PHP Backend to Railway, Heroku, or DigitalOcean

## Quick Comparison

| Service | Cost | Ease | Best For |
|---------|------|------|----------|
| **Railway** | Free tier available | ⭐⭐⭐⭐⭐ Easiest | Start-ups, beginners |
| **Heroku** | $7-25/month | ⭐⭐⭐⭐ Easy | Production apps |
| **DigitalOcean** | $4-12/month | ⭐⭐⭐ Medium | Full control |

---

## 🚀 RECOMMENDED: Deploy to Railway (5 minutes)

### **Why Railway?**
- ✅ Free tier with $5/month credits
- ✅ Connect GitHub directly
- ✅ One-click MySQL database setup
- ✅ Auto-deploys on every push
- ✅ No credit card required for free tier

### **Step 1: Create Railway Account**
1. Go to: https://railway.app
2. Click "Start a new project"
3. Select "Deploy from GitHub"
4. Authorize Railway to access your GitHub

### **Step 2: Deploy Your Repository**
1. Search for: `bike-garage-system`
2. Click to select your repository
3. Railway detects it's a PHP project
4. Click "Create project"

### **Step 3: Add MySQL Database**
1. In Railway dashboard, click "New"
2. Select "MySQL"
3. Railway auto-provisions the database
4. Copy the connection credentials

### **Step 4: Configure Environment Variables**
In Railway, go to: Variables
Add these:

```
DATABASE_URL=mysql://...  (Railway provides this)
DB_HOST=your-railway-mysql-host
DB_NAME=bike_garage
DB_USER=root
DB_PASS=your_password
APP_ENV=production
MYSQL_HOST=your-railway-mysql-host
MYSQL_USER=root
MYSQL_PASSWORD=your_password
MYSQL_DATABASE=bike_garage
```

### **Step 5: Deploy**
1. Railway auto-deploys when you push to GitHub
2. Wait for build to complete
3. You'll get a URL like: `https://bike-garage-system-production.up.railway.app`

### **Step 6: Update Frontend to Point to Backend**
In Netlify:
1. Go to Site Settings → Build & deploy → Environment
2. Set `NEXT_PUBLIC_PHP_BACKEND_URL` to: `https://your-railway-url.up.railway.app`
3. Trigger a new build
4. Your frontend now connects to your backend!

---

## Alternative: Deploy to Heroku

### **Requirements**
- Heroku account: https://heroku.com
- Credit card (starts at $7/month)
- Heroku CLI installed

### **Steps**
```bash
# 1. Login to Heroku
heroku login

# 2. Create app
cd /Users/hemantchaudhary/Desktop/bike-garage-system
heroku create bike-garage-api

# 3. Set environment variables
heroku config:set DB_HOST=your-db-host
heroku config:set DB_NAME=bike_garage
heroku config:set DB_USER=root
heroku config:set DB_PASS=your_password

# 4. Add MySQL database (using JawsDB or ClearDB add-on)
heroku addons:create jawsdb:kitefin

# 5. Deploy
git push heroku main

# 6. View logs
heroku logs --tail
```

---

## Alternative: Deploy to DigitalOcean

### **Requirements**
- DigitalOcean account: https://digitalocean.com
- $200 free credits for new users
- GitHub connected

### **Steps**
1. Create account at: https://digitalocean.com
2. Go to "Apps" → "Create App"
3. Connect your GitHub repository
4. Select: `bike-garage-system`
5. Choose: PHP 8.2 buildpack
6. DigitalOcean detects `index.php`
7. Configure:
   - Build command: `composer install`
   - HTTP port: 8080
8. Add managed database:
   - MySQL 8.0
   - Select region
   - Generate credentials
9. Deploy!

---

## 🔗 Connect Frontend to Backend

Once your backend is deployed:

### **Update Netlify Environment Variable**

1. Go to: https://app.netlify.com
2. Select: `bike-garage-system`
3. Go to: Site settings → Build & deploy → Environment
4. Add variable:
   ```
   NEXT_PUBLIC_PHP_BACKEND_URL=https://your-backend-domain.com
   ```
5. Or for specific services:
   - Railway: `https://your-project.up.railway.app`
   - Heroku: `https://bike-garage-api.herokuapp.com`
   - DigitalOcean: `https://your-app-xxxxx.ondigitalocean.app`

6. Click "Trigger deploy" to rebuild frontend

---

## ✅ Verify Everything Works

### **Test Backend**
```bash
curl https://your-backend-url/index.html
```

### **Test Admin Login**
1. Go to: `https://your-netlify-url/admin/admin_login.php`
2. (This proxies to your backend)
3. Login with: `admin` / `admin123`

### **Test Database Connection**
1. Go to: `https://your-backend-url/verify_dashboard.php`
2. Should show all green checkmarks

---

## 🎯 Quick Start Commands

### Railway (Recommended)
```bash
# Nothing to do locally - GitHub connects directly!
# Just push changes and Railway auto-deploys
git push origin main
```

### Heroku
```bash
# Deploy at any time
git push heroku main

# View logs if something fails
heroku logs --tail

# Reset database
heroku pg:reset DATABASE --confirm bike-garage-api
```

### DigitalOcean
```bash
# Set up GitHub Actions
# DigitalOcean auto-deploys on push
git push origin main
```

---

## 🆘 Troubleshooting

### "Database connection failed"
- Verify credentials in environment variables
- Check if database is ready
- For Railway: Wait 2-3 minutes for MySQL to boot

### "404 on admin page"
- Check `NEXT_PUBLIC_PHP_BACKEND_URL` is set in Netlify
- Verify backend domain is correct
- Check CORS headers in PHP config

### "Build failed"
- Check Netlify/Railway build logs
- Verify `php.ini`, `composer.json` exist
- Check for syntax errors in PHP

---

## 📞 Support Links

- **Railway Docs:** https://docs.railway.app
- **Heroku Docs:** https://devcenter.heroku.com
- **DigitalOcean Docs:** https://docs.digitalocean.com
- **MySQL Connection Strings:** https://www.connectionstrings.com/

---

## 🎉 Final Architecture

```
┌─────────────────────────────────────────────────┐
│  Your Users                                     │
└──────────────────────┬──────────────────────────┘
                       │
        ┌──────────────┴──────────────┐
        │                             │
   ┌────▼─────────────┐         ┌────▼────────────┐
   │ NETLIFY           │         │ YOUR-BACKEND    │
   │ (React Frontend)  │◄────────► (PHP Backend)   │
   │ bike-garage-*.    │         │ Railway/Heroku/ │
   │ netlify.app       │         │ DigitalOcean    │
   └───────────────────┘         └─────────────────┘
                                        │
                                        │
                                   ┌────▼────────┐
                                   │ MySQL DB    │
                                   │ (Railway)   │
                                   └─────────────┘
```

---

**Ready to deploy?** Start with Railway - it's the easiest! 🚀
