#!/bin/bash

# Malak Outlet Deployment Script
echo "🚀 Starting Malak Outlet Deployment..."

# Check if Docker is installed
if ! command -v docker &> /dev/null; then
    echo "❌ Docker is not installed. Please install Docker first."
    exit 1
fi

# Check if Docker Compose is installed
if ! command -v docker-compose &> /dev/null; then
    echo "❌ Docker Compose is not installed. Please install Docker Compose first."
    exit 1
fi

# Create environment file if it doesn't exist
if [ ! -f .env ]; then
    echo "📝 Creating .env file from .env.docker.example..."
    cp .env.docker.example .env
    echo "⚠️  Please edit .env file with your configuration before continuing."
    echo "Press Enter to continue..."
    read
fi

# Choose deployment type
echo "Select deployment type:"
echo "1) Development (docker-compose.yml)"
echo "2) Production (docker-compose.prod.yml)"
read -p "Enter choice [1-2]: " choice

case $choice in
    1)
        COMPOSE_FILE="docker-compose.yml"
        echo "🔧 Deploying in Development mode..."
        ;;
    2)
        COMPOSE_FILE="docker-compose.prod.yml"
        echo "🏭 Deploying in Production mode..."
        ;;
    *)
        echo "❌ Invalid choice. Exiting."
        exit 1
        ;;
esac

# Stop existing containers
echo "🛑 Stopping existing containers..."
docker-compose -f $COMPOSE_FILE down

# Pull latest images
echo "📥 Pulling latest images..."
docker-compose -f $COMPOSE_FILE pull

# Build and start containers
echo "🏗️  Building and starting containers..."
docker-compose -f $COMPOSE_FILE up -d --build

# Wait for database to be ready
echo "⏳ Waiting for database to be ready..."
sleep 30

# Run Laravel commands
echo "⚙️  Running Laravel setup commands..."
docker-compose -f $COMPOSE_FILE exec app php artisan migrate --force
docker-compose -f $COMPOSE_FILE exec app php artisan db:seed --force
docker-compose -f $COMPOSE_FILE exec app php artisan storage:link
docker-compose -f $COMPOSE_FILE exec app php artisan config:cache
docker-compose -f $COMPOSE_FILE exec app php artisan route:cache
docker-compose -f $COMPOSE_FILE exec app php artisan view:cache

# Set proper permissions
echo "🔐 Setting proper permissions..."
docker-compose -f $COMPOSE_FILE exec app chown -R www-data:www-data /var/www/html/storage
docker-compose -f $COMPOSE_FILE exec app chmod -R 775 /var/www/html/storage

echo "✅ Deployment completed successfully!"
echo ""
echo "📊 Container Status:"
docker-compose -f $COMPOSE_FILE ps
echo ""
echo "🌐 Application URLs:"
if [ "$choice" = "1" ]; then
    echo "   - Application: http://localhost:8000"
    echo "   - phpMyAdmin: http://localhost:8080"
else
    echo "   - Application: http://localhost"
fi
echo ""
echo "📝 Logs:"
echo "   docker-compose -f $COMPOSE_FILE logs -f"
echo ""
echo "🛑 Stop:"
echo "   docker-compose -f $COMPOSE_FILE down"
