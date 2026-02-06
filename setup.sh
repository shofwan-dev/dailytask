#!/bin/bash

# DailyTask - Quick Setup Script
# This script will setup DailyTask on a fresh Ubuntu 22.04 server

set -e

echo "🚀 DailyTask - Automated Setup Script"
echo "======================================"
echo ""

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if running as root
if [ "$EUID" -ne 0 ]; then 
    echo -e "${RED}Please run as root (use sudo)${NC}"
    exit 1
fi

echo -e "${GREEN}✓${NC} Running as root"

# Update system
echo ""
echo "📦 Updating system packages..."
apt update && apt upgrade -y

# Install PHP 8.2
echo ""
echo "🐘 Installing PHP 8.2..."
apt install -y software-properties-common
add-apt-repository -y ppa:ondrej/php
apt update
apt install -y php8.2 php8.2-fpm php8.2-mysql php8.2-sqlite3 php8.2-pgsql php8.2-mbstring php8.2-xml php8.2-curl php8.2-zip php8.2-gd

echo -e "${GREEN}✓${NC} PHP 8.2 installed"

# Install Composer
echo ""
echo "🎼 Installing Composer..."
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer

echo -e "${GREEN}✓${NC} Composer installed"

# Install Nginx
echo ""
echo "🌐 Installing Nginx..."
apt install -y nginx

echo -e "${GREEN}✓${NC} Nginx installed"

# Install Git
echo ""
echo "📥 Installing Git..."
apt install -y git

echo -e "${GREEN}✓${NC} Git installed"

# Create project directory
echo ""
echo "📁 Setting up project directory..."
mkdir -p /var/www
cd /var/www

# Prompt for repository URL
echo ""
read -p "Enter your Git repository URL (or press Enter to skip): " REPO_URL

if [ ! -z "$REPO_URL" ]; then
    echo "Cloning repository..."
    git clone $REPO_URL dailytask
    cd dailytask
else
    echo -e "${YELLOW}⚠${NC}  Skipping git clone. Please manually upload your project to /var/www/dailytask"
    exit 0
fi

# Install dependencies
echo ""
echo "📦 Installing Composer dependencies..."
composer install --optimize-autoloader --no-dev

# Setup environment
echo ""
echo "⚙️  Setting up environment..."
cp .env.example .env
php artisan key:generate

# Prompt for database choice
echo ""
echo "Select database:"
echo "1) SQLite (recommended for small apps)"
echo "2) MySQL"
echo "3) PostgreSQL"
read -p "Enter choice (1, 2, or 3): " DB_CHOICE

if [ "$DB_CHOICE" == "1" ]; then
    echo "Using SQLite..."
    sed -i 's/DB_CONNECTION=.*/DB_CONNECTION=sqlite/' .env
    touch database/database.sqlite
elif [ "$DB_CHOICE" == "2" ]; then
    echo ""
    echo "MySQL Configuration:"
    read -p "Enter MySQL database name: " DB_NAME
    read -p "Enter MySQL username: " DB_USER
    read -sp "Enter MySQL password: " DB_PASS
    echo ""
    
    sed -i "s/DB_CONNECTION=.*/DB_CONNECTION=mysql/" .env
    sed -i "s/# DB_HOST=.*/DB_HOST=127.0.0.1/" .env
    sed -i "s/# DB_PORT=.*/DB_PORT=3306/" .env
    sed -i "s/# DB_DATABASE=.*/DB_DATABASE=$DB_NAME/" .env
    sed -i "s/# DB_USERNAME=.*/DB_USERNAME=$DB_USER/" .env
    sed -i "s/# DB_PASSWORD=.*/DB_PASSWORD=$DB_PASS/" .env
elif [ "$DB_CHOICE" == "3" ]; then
    echo ""
    echo "PostgreSQL Configuration:"
    
    # Install PostgreSQL if not installed
    if ! command -v psql &> /dev/null; then
        echo "Installing PostgreSQL..."
        apt install -y postgresql postgresql-contrib
        systemctl start postgresql
        systemctl enable postgresql
    fi
    
    read -p "Enter PostgreSQL database name: " DB_NAME
    read -p "Enter PostgreSQL username: " DB_USER
    read -sp "Enter PostgreSQL password: " DB_PASS
    echo ""
    
    # Create database and user
    sudo -u postgres psql -c "CREATE DATABASE $DB_NAME;"
    sudo -u postgres psql -c "CREATE USER $DB_USER WITH PASSWORD '$DB_PASS';"
    sudo -u postgres psql -c "GRANT ALL PRIVILEGES ON DATABASE $DB_NAME TO $DB_USER;"
    
    sed -i "s/DB_CONNECTION=.*/DB_CONNECTION=pgsql/" .env
    sed -i "s/# DB_HOST=.*/DB_HOST=127.0.0.1/" .env
    sed -i "s/# DB_PORT=.*/DB_PORT=5432/" .env
    sed -i "s/# DB_DATABASE=.*/DB_DATABASE=$DB_NAME/" .env
    sed -i "s/# DB_USERNAME=.*/DB_USERNAME=$DB_USER/" .env
    sed -i "s/# DB_PASSWORD=.*/DB_PASSWORD=$DB_PASS/" .env
    
    echo -e "${GREEN}✓${NC} PostgreSQL configured"
fi

# WhatsApp API configuration
echo ""
echo "📱 WhatsApp API Configuration"
read -p "Enter WhatsApp API Key: " WA_KEY
read -p "Enter WhatsApp Sender Number (628xxx): " WA_SENDER

sed -i "s/WA_API_KEY=.*/WA_API_KEY=$WA_KEY/" .env
sed -i "s/WA_SENDER=.*/WA_SENDER=$WA_SENDER/" .env

# Run migrations
echo ""
echo "🗄️  Running database migrations..."
php artisan migrate --force

# Set permissions
echo ""
echo "🔐 Setting permissions..."
chown -R www-data:www-data /var/www/dailytask
chmod -R 755 /var/www/dailytask
chmod -R 775 /var/www/dailytask/storage
chmod -R 775 /var/www/dailytask/bootstrap/cache

echo -e "${GREEN}✓${NC} Permissions set"

# Configure Nginx
echo ""
read -p "Enter your domain name (e.g., dailytask.yourdomain.com): " DOMAIN

cat > /etc/nginx/sites-available/dailytask <<EOF
server {
    listen 80;
    server_name $DOMAIN;
    root /var/www/dailytask/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
EOF

ln -sf /etc/nginx/sites-available/dailytask /etc/nginx/sites-enabled/
rm -f /etc/nginx/sites-enabled/default

nginx -t
systemctl restart nginx

echo -e "${GREEN}✓${NC} Nginx configured"

# Setup cron
echo ""
echo "⏰ Setting up cron job..."
(crontab -u www-data -l 2>/dev/null; echo "* * * * * cd /var/www/dailytask && php artisan schedule:run >> /dev/null 2>&1") | crontab -u www-data -

echo -e "${GREEN}✓${NC} Cron job configured"

# SSL Setup
echo ""
read -p "Do you want to setup SSL with Let's Encrypt? (y/n): " SETUP_SSL

if [ "$SETUP_SSL" == "y" ]; then
    echo "Installing Certbot..."
    apt install -y certbot python3-certbot-nginx
    certbot --nginx -d $DOMAIN --non-interactive --agree-tos --email admin@$DOMAIN
    echo -e "${GREEN}✓${NC} SSL configured"
fi

echo ""
echo "======================================"
echo -e "${GREEN}✅ Installation Complete!${NC}"
echo "======================================"
echo ""
echo "Your DailyTask application is now running at:"
echo "http://$DOMAIN"
echo ""
echo "Default credentials (if you ran seeder):"
echo "Email: demo@dailytask.com"
echo "Password: password"
echo ""
echo "Next steps:"
echo "1. Visit your domain and test the application"
echo "2. Create your first user account"
echo "3. Test WhatsApp notifications"
echo "4. Monitor logs: tail -f /var/www/dailytask/storage/logs/laravel.log"
echo ""
echo "To test the scheduler manually:"
echo "cd /var/www/dailytask && php artisan tasks:send-reminders"
echo ""
echo -e "${GREEN}Happy tasking! 📋${NC}"
