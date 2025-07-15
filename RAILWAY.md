# 🚂 Railway Deployment Guide - Malak Outlet

Your Laravel e-commerce application is successfully deployed on Railway! 

**Live URL**: https://malakoutlet-production.up.railway.app/

## 📋 Current Deployment Status

✅ **Application**: Successfully deployed and running  
✅ **Docker**: Optimized Dockerfile for Railway  
✅ **Domain**: Custom Railway subdomain configured  
✅ **HTTPS**: Automatic SSL certificate active  

## 🔧 Railway Configuration

### Environment Variables Required

Set these in your Railway project dashboard:

```bash
APP_NAME="Malak Outlet"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://malakoutlet-production.up.railway.app
APP_KEY=base64:your_generated_key_here

# Database (Railway MySQL addon)
DATABASE_URL=mysql://user:password@host:port/database

# Or individual database variables:
DB_CONNECTION=mysql
DB_HOST=your_railway_mysql_host
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=your_railway_mysql_password

# Cache & Storage
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=public

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
```

### Required Railway Services

1. **Web Service** (Current deployment)
   - Source: GitHub repository
   - Build: Dockerfile
   - Port: 80

2. **MySQL Database** (Recommended addon)
   - Railway MySQL addon
   - Automatic DATABASE_URL generation

3. **Redis** (Optional - for caching)
   - Railway Redis addon
   - For better performance

## 🚀 Deployment Process

### Automatic Deployments
Railway automatically deploys when you push to your GitHub repository:

```bash
git add .
git commit -m "Update application"
git push origin main
# Railway automatically rebuilds and deploys
```

### Manual Deployment
1. Go to Railway dashboard
2. Select your project
3. Click "Deploy" on latest commit

## 📊 Monitoring & Logs

### View Logs
1. Railway Dashboard → Your Project
2. Click on "Deployments" tab
3. Select latest deployment
4. View real-time logs

### Metrics
- CPU usage
- Memory consumption  
- Request volume
- Response times

## 🔄 Database Management

### Initial Setup
```bash
# Run migrations (one-time setup)
railway run php artisan migrate --force

# Seed database
railway run php artisan db:seed --force

# Create storage link
railway run php artisan storage:link
```

### Backups
Railway provides automatic database backups for MySQL addon.

## 🔒 Security Configuration

### HTTPS & Domain
- ✅ Automatic HTTPS enabled
- ✅ Custom subdomain: malakoutlet-production.up.railway.app
- ✅ SSL certificate auto-renewal

### Security Headers
Consider adding these to your Apache configuration:
```apache
Header always set X-Frame-Options DENY
Header always set X-Content-Type-Options nosniff
Header always set X-XSS-Protection "1; mode=block"
Header always set Strict-Transport-Security "max-age=31536000"
```

## 📈 Performance Optimization

### Current Optimizations
- ✅ Composer autoloader optimization
- ✅ Laravel config/route/view caching
- ✅ PHP 8.2 with OPcache
- ✅ Apache with mod_rewrite

### Additional Optimizations
1. **Add Redis** for caching and sessions
2. **Enable gzip compression** in Apache
3. **Image optimization** for product images
4. **CDN integration** for static assets

## 🔧 Common Railway Commands

### Environment Variables
```bash
# List all environment variables
railway variables

# Set a variable
railway variables set APP_DEBUG=false

# Get a variable
railway variables get APP_DEBUG
```

### Database Access
```bash
# Connect to database
railway connect

# Run Laravel commands
railway run php artisan migrate
railway run php artisan cache:clear
railway run php artisan queue:work
```

### File Management
```bash
# View files
railway run ls -la

# Check storage permissions
railway run ls -la storage/
```

## 🚨 Troubleshooting

### Common Issues

1. **500 Error - Internal Server Error**
   ```bash
   # Check logs in Railway dashboard
   # Usually caused by missing environment variables
   ```

2. **Database Connection Error**
   ```bash
   # Ensure DATABASE_URL is set correctly
   # Or set individual DB_* variables
   ```

3. **Storage Permission Issues**
   ```bash
   railway run chmod -R 775 storage/
   railway run chown -R www-data:www-data storage/
   ```

4. **Missing Application Key**
   ```bash
   railway run php artisan key:generate --show
   # Copy the generated key to APP_KEY environment variable
   ```

### Debug Mode (Temporary)
```bash
# Enable debug mode temporarily
railway variables set APP_DEBUG=true
# Check error details
# Remember to disable: APP_DEBUG=false
```

## 📱 Mobile & Performance

Your application is optimized for:
- ✅ Mobile responsiveness (Tailwind CSS)
- ✅ Fast loading times
- ✅ SEO optimization
- ✅ Progressive Web App features

## 🔄 Updates & Maintenance

### Regular Tasks
1. **Monitor application logs** daily
2. **Update dependencies** monthly
3. **Database backups** (automatic with Railway)
4. **Security updates** as needed

### Update Process
```bash
# Local development
composer update
npm update

# Test locally
php artisan serve

# Deploy
git add .
git commit -m "Update dependencies"
git push origin main
```

## 📞 Support & Resources

- **Railway Documentation**: https://docs.railway.app
- **Laravel Documentation**: https://laravel.com/docs
- **Your Repository**: https://github.com/saqundil/malak_outlet

---

## 🎉 Congratulations!

Your **Malak Outlet** e-commerce application is successfully running on Railway! 

**Live at**: https://malakoutlet-production.up.railway.app/

The application features:
- 🛍️ Complete e-commerce functionality
- ❤️ Wishlist system with real-time updates
- 🛒 Shopping cart with session persistence
- 👤 User authentication and profiles
- 📱 Mobile-responsive design
- 🔒 Secure payment processing ready
- 📊 Admin dashboard capabilities

**Happy selling! 🚀**
