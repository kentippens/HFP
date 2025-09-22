#!/bin/bash

# HexService Laravel - Local Installation Script
# ==============================================
# This script automates the local installation process

echo "======================================"
echo "HexService Laravel Local Installation"
echo "======================================"
echo ""

# Check prerequisites
echo "Checking prerequisites..."

# Check PHP
if ! command -v php &> /dev/null; then
    echo "❌ PHP is not installed. Please install PHP 8.3+"
    exit 1
fi
echo "✓ PHP installed: $(php -v | head -1)"

# Check Composer
if ! command -v composer &> /dev/null; then
    echo "❌ Composer is not installed. Please install Composer"
    exit 1
fi
echo "✓ Composer installed: $(composer --version | head -1)"

# Check Node
if ! command -v node &> /dev/null; then
    echo "❌ Node.js is not installed. Please install Node.js 18+"
    exit 1
fi
echo "✓ Node.js installed: $(node -v)"

# Check MySQL
if ! command -v mysql &> /dev/null; then
    echo "❌ MySQL is not installed. Please install MySQL 8+"
    exit 1
fi
echo "✓ MySQL installed"

echo ""
echo "Starting installation..."
echo ""

# 1. Clone repository
read -p "Enter directory for installation (default: ~/Sites/HexService-Laravel): " INSTALL_DIR
INSTALL_DIR=${INSTALL_DIR:-~/Sites/HexService-Laravel}

if [ -d "$INSTALL_DIR" ]; then
    echo "Directory already exists. Please remove it or choose another location."
    exit 1
fi

echo "Cloning repository to $INSTALL_DIR..."
git clone https://github.com/kentippens/HexService-Laravel.git "$INSTALL_DIR"
cd "$INSTALL_DIR"

# 2. Install dependencies
echo ""
echo "Installing PHP dependencies..."
composer install

echo ""
echo "Installing Node dependencies..."
npm install

# 3. Setup environment
echo ""
echo "Setting up environment..."
cp .env.local .env

# Generate key
php artisan key:generate

# 4. Database setup
echo ""
echo "Database Setup"
echo "--------------"
echo "Enter MySQL credentials for local development:"
read -p "MySQL username (default: root): " DB_USER
DB_USER=${DB_USER:-root}

read -sp "MySQL password (leave empty if none): " DB_PASS
echo ""

read -p "Database name (default: hexservice_local): " DB_NAME
DB_NAME=${DB_NAME:-hexservice_local}

# Create database
echo ""
echo "Creating database..."
if [ -z "$DB_PASS" ]; then
    mysql -u "$DB_USER" -e "CREATE DATABASE IF NOT EXISTS $DB_NAME;" 2>/dev/null
else
    mysql -u "$DB_USER" -p"$DB_PASS" -e "CREATE DATABASE IF NOT EXISTS $DB_NAME;" 2>/dev/null
fi

if [ $? -ne 0 ]; then
    echo "❌ Failed to create database. Please check your MySQL credentials."
    exit 1
fi
echo "✓ Database created"

# Update .env with database credentials
sed -i.bak "s/DB_DATABASE=hexservice_local/DB_DATABASE=$DB_NAME/" .env
sed -i.bak "s/DB_USERNAME=root/DB_USERNAME=$DB_USER/" .env
sed -i.bak "s/DB_PASSWORD=/DB_PASSWORD=$DB_PASS/" .env

# 5. Import or migrate database
echo ""
echo "Database Data Options:"
echo "1. Import production data (includes all content)"
echo "2. Fresh installation with sample data"
echo "3. Fresh installation (empty)"
read -p "Choose option (1-3): " DB_OPTION

case $DB_OPTION in
    1)
        echo "Downloading database export..."
        curl -O https://raw.githubusercontent.com/kentippens/HexService-Laravel/main/hexservice-local-import.sql
        
        echo "Importing database..."
        if [ -z "$DB_PASS" ]; then
            mysql -u "$DB_USER" "$DB_NAME" < hexservice-local-import.sql
        else
            mysql -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" < hexservice-local-import.sql
        fi
        rm hexservice-local-import.sql
        echo "✓ Database imported"
        ;;
    2)
        echo "Running migrations..."
        php artisan migrate --force
        echo "Seeding database..."
        php artisan db:seed --force
        echo "✓ Database seeded"
        ;;
    3)
        echo "Running migrations..."
        php artisan migrate --force
        echo "✓ Fresh database created"
        ;;
esac

# 6. Create storage link
echo ""
echo "Creating storage link..."
php artisan storage:link

# 7. Build assets
echo ""
echo "Building frontend assets..."
npm run build

# 8. Set permissions
echo ""
echo "Setting permissions..."
chmod -R 775 storage bootstrap/cache 2>/dev/null

# 9. Create admin user (if fresh install)
if [ "$DB_OPTION" != "1" ]; then
    echo ""
    echo "Create Admin User"
    echo "-----------------"
    read -p "Admin email: " ADMIN_EMAIL
    read -sp "Admin password: " ADMIN_PASS
    echo ""
    
    php artisan tinker --execute="
        \$user = \App\Models\User::create([
            'name' => 'Admin',
            'email' => '$ADMIN_EMAIL',
            'password' => bcrypt('$ADMIN_PASS'),
            'is_admin' => true,
            'email_verified_at' => now()
        ]);
        echo 'Admin user created successfully';
    "
fi

# 10. Configure local URL
echo ""
echo "Local URL Configuration"
echo "-----------------------"
echo "Choose your local URL setup:"
echo "1. Laravel built-in server (http://localhost:8000)"
echo "2. Custom domain (requires hosts file configuration)"
read -p "Choose option (1-2): " URL_OPTION

if [ "$URL_OPTION" == "2" ]; then
    read -p "Enter local domain (e.g., hexservice.test): " LOCAL_DOMAIN
    sed -i.bak "s|APP_URL=http://hexservice.test|APP_URL=http://$LOCAL_DOMAIN|" .env
    
    echo ""
    echo "Add this line to your hosts file:"
    echo "127.0.0.1    $LOCAL_DOMAIN"
    echo ""
    echo "Hosts file location:"
    echo "- Mac/Linux: /etc/hosts"
    echo "- Windows: C:\\Windows\\System32\\drivers\\etc\\hosts"
fi

# Clear caches
echo ""
echo "Clearing caches..."
php artisan optimize:clear

echo ""
echo "======================================"
echo "✅ Installation Complete!"
echo "======================================"
echo ""
echo "Next steps:"
echo ""

if [ "$URL_OPTION" == "1" ]; then
    echo "1. Start the development server:"
    echo "   php artisan serve"
    echo ""
    echo "2. Visit: http://localhost:8000"
else
    echo "1. Configure your web server to point to:"
    echo "   $INSTALL_DIR/public"
    echo ""
    echo "2. Visit: http://$LOCAL_DOMAIN"
fi

echo ""
echo "3. Admin panel: /admin"

if [ "$DB_OPTION" == "1" ]; then
    echo "   Email: Use any existing admin email from production"
    echo "   Password: Same as production"
else
    echo "   Email: $ADMIN_EMAIL"
    echo "   Password: [the password you entered]"
fi

echo ""
echo "For development with hot reload:"
echo "   npm run dev"
echo ""
echo "Documentation: $INSTALL_DIR/LOCAL-INSTALLATION-GUIDE.md"
echo ""