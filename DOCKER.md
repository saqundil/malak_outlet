# Malak Outlet - Docker Deployment Guide

This guide explains how to deploy the Malak Outlet Laravel e-commerce application using Docker.

## 📋 Prerequisites

- Docker Desktop installed
- Docker Compose installed
- Git (to clone the repository)

## 🚀 Quick Start

### Development Deployment

1. **Clone the repository:**
   ```bash
   git clone <repository-url>
   cd malak_outlet
   ```

2. **Set up environment:**
   ```bash
   cp .env.docker.example .env
   # Edit .env file with your configuration
   ```

3. **Deploy with Docker Compose:**
   ```bash
   docker-compose up -d --build
   ```

4. **Access the application:**
   - Application: http://localhost:8000
   - phpMyAdmin: http://localhost:8080

### Production Deployment

1. **Prepare environment:**
   ```bash
   cp .env.docker.example .env
   # Configure production settings in .env
   ```

2. **Deploy with production compose:**
   ```bash
   docker-compose -f docker-compose.prod.yml up -d --build
   ```

3. **Run migrations and seeders:**
   ```bash
   docker-compose -f docker-compose.prod.yml exec app php artisan migrate --force
   docker-compose -f docker-compose.prod.yml exec app php artisan db:seed --force
   ```

## 🛠️ Using the Deployment Script

Make the script executable and run it:

```bash
chmod +x deploy.sh
./deploy.sh
```

The script will guide you through:
- Environment setup
- Deployment type selection
- Automatic container management
- Laravel setup commands

## 📦 Services Included

### Development Stack
- **app**: Laravel application (PHP 8.2 + Apache)
- **db**: MySQL 8.0 database
- **phpmyadmin**: Database management interface
- **redis**: Caching and session storage

### Production Stack
- **app**: Laravel application
- **nginx**: Reverse proxy and load balancer
- **db**: MySQL database
- **redis**: Caching with authentication
- **queue**: Background job processing
- **scheduler**: Laravel task scheduling

## 🔧 Configuration

### Environment Variables

Key variables to configure in `.env`:

```bash
# Database
DB_PASSWORD=your_secure_password
DB_ROOT_PASSWORD=your_root_password

# Redis
REDIS_PASSWORD=your_redis_password

# Application
APP_KEY=your_generated_key
APP_URL=https://your-domain.com

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
```

### Volume Mounts

The following directories are mounted for data persistence:
- `./storage` - Laravel storage directory
- `./public/images` - Product images
- Database data volumes
- Redis data volumes

## 📊 Management Commands

### View Logs
```bash
# All services
docker-compose logs -f

# Specific service
docker-compose logs -f app
```

### Execute Commands
```bash
# Laravel commands
docker-compose exec app php artisan migrate
docker-compose exec app php artisan cache:clear

# Database access
docker-compose exec db mysql -u root -p malak_outlet
```

### Scaling Services
```bash
# Scale queue workers
docker-compose up -d --scale queue=3
```

## 🔒 Security Considerations

### For Production:
1. Use strong passwords for all services
2. Enable Redis authentication
3. Configure SSL/TLS certificates
4. Set up firewall rules
5. Regular security updates
6. Monitor logs and metrics

### Recommended Security Settings:
```bash
# In .env
APP_DEBUG=false
APP_ENV=production
SESSION_SECURE_COOKIE=true
SANCTUM_STATEFUL_DOMAINS=your-domain.com
```

## 🔄 Updates and Maintenance

### Update Application
```bash
git pull origin main
docker-compose down
docker-compose up -d --build
docker-compose exec app php artisan migrate --force
```

### Backup Database
```bash
docker-compose exec db mysqldump -u root -p malak_outlet > backup.sql
```

### Restore Database
```bash
docker-compose exec -T db mysql -u root -p malak_outlet < backup.sql
```

## 🚨 Troubleshooting

### Common Issues:

1. **Port conflicts:**
   ```bash
   # Change ports in docker-compose.yml
   ports:
     - "8001:80"  # Change from 8000 to 8001
   ```

2. **Permission issues:**
   ```bash
   docker-compose exec app chown -R www-data:www-data /var/www/html/storage
   docker-compose exec app chmod -R 775 /var/www/html/storage
   ```

3. **Database connection issues:**
   ```bash
   # Check if database is ready
   docker-compose exec db mysql -u root -p -e "SHOW DATABASES;"
   ```

### Debug Mode:
```bash
# Enable debug mode temporarily
docker-compose exec app php artisan config:clear
# Set APP_DEBUG=true in .env
```

## 📈 Performance Optimization

### Production Optimizations:
```bash
# Cache configurations
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache

# Optimize Composer autoloader
docker-compose exec app composer install --optimize-autoloader --no-dev
```

### Monitoring:
- Monitor container resources: `docker stats`
- Check service health: `docker-compose ps`
- View real-time logs: `docker-compose logs -f`

## 🆘 Support

For issues and questions:
1. Check container logs: `docker-compose logs`
2. Verify service status: `docker-compose ps`
3. Review environment configuration
4. Check Laravel logs in `storage/logs/`

---

**Happy Deploying! 🚀**
