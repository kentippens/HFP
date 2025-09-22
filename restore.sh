#!/bin/bash

# HexService Laravel Restoration Script
# ======================================
# This script automates the restoration of HexService Laravel application
# from either local backups or GitHub repository

# Configuration
BACKUP_DIR="/home/hexservices"
APP_DIR="/home/hexservices/HexService-Laravel"
DB_NAME="hexservices"
DB_USER="hexservices"
DB_PASS="HexServ2025"
GITHUB_REPO="https://github.com/kentippens/HexService-Laravel.git"

echo "================================================"
echo "HexService Laravel Restoration Script"
echo "================================================"
echo ""

# Function to check if command succeeded
check_status() {
    if [ $? -eq 0 ]; then
        echo "✓ $1 completed successfully"
    else
        echo "✗ $1 failed"
        exit 1
    fi
}

# Choose restoration method
echo "Select restoration method:"
echo "1. From local backup files"
echo "2. From GitHub repository"
echo "3. Database only (from backup)"
echo "4. Application files only (from backup)"
read -p "Enter choice (1-4): " choice

case $choice in
    1|3|4)
        # Find latest backups
        LATEST_DB=$(ls -t $BACKUP_DIR/hexservices-backup-*.sql.gz 2>/dev/null | head -1)
        LATEST_APP=$(ls -t $BACKUP_DIR/HexService-Laravel-backup-*.tar.gz 2>/dev/null | head -1)
        
        if [ "$choice" != "4" ] && [ -z "$LATEST_DB" ]; then
            echo "No database backup found!"
            exit 1
        fi
        
        if [ "$choice" != "3" ] && [ -z "$LATEST_APP" ]; then
            echo "No application backup found!"
            exit 1
        fi
        
        if [ "$choice" != "4" ]; then
            echo "Using database backup: $LATEST_DB"
        fi
        if [ "$choice" != "3" ]; then
            echo "Using application backup: $LATEST_APP"
        fi
        ;;
esac

# Confirm before proceeding
echo ""
echo "WARNING: This will replace existing installation!"
read -p "Continue? (y/n): " confirm
if [ "$confirm" != "y" ]; then
    echo "Restoration cancelled"
    exit 0
fi

# Restore based on choice
case $choice in
    1)
        echo ""
        echo "Full restoration from local backups..."
        
        # Restore database
        echo "Dropping and recreating database..."
        mysql -u $DB_USER -p$DB_PASS -e "DROP DATABASE IF EXISTS $DB_NAME; CREATE DATABASE $DB_NAME;" 2>/dev/null
        check_status "Database recreation"
        
        echo "Restoring database from backup..."
        gunzip < $LATEST_DB | mysql -u $DB_USER -p$DB_PASS $DB_NAME 2>/dev/null
        check_status "Database restoration"
        
        # Restore application
        echo "Backing up current installation..."
        if [ -d "$APP_DIR" ]; then
            rm -rf $APP_DIR.old
            mv $APP_DIR $APP_DIR.old
        fi
        check_status "Backup of current installation"
        
        echo "Extracting application files..."
        cd $BACKUP_DIR
        tar -xzf $LATEST_APP
        check_status "Application extraction"
        ;;
        
    2)
        echo ""
        echo "Restoration from GitHub..."
        
        # Backup and remove existing
        if [ -d "$APP_DIR" ]; then
            echo "Backing up current installation..."
            rm -rf $APP_DIR.old
            mv $APP_DIR $APP_DIR.old
            check_status "Backup of current installation"
        fi
        
        # Clone repository
        echo "Cloning repository..."
        cd $BACKUP_DIR
        git clone $GITHUB_REPO
        check_status "Repository clone"
        
        # Restore .env file from old installation if exists
        if [ -f "$APP_DIR.old/.env" ]; then
            echo "Restoring .env file..."
            cp $APP_DIR.old/.env $APP_DIR/.env
            check_status ".env restoration"
        else
            echo "No .env file found. You'll need to configure it manually."
        fi
        ;;
        
    3)
        echo ""
        echo "Database restoration only..."
        
        echo "Dropping and recreating database..."
        mysql -u $DB_USER -p$DB_PASS -e "DROP DATABASE IF EXISTS $DB_NAME; CREATE DATABASE $DB_NAME;" 2>/dev/null
        check_status "Database recreation"
        
        echo "Restoring database from backup..."
        gunzip < $LATEST_DB | mysql -u $DB_USER -p$DB_PASS $DB_NAME 2>/dev/null
        check_status "Database restoration"
        
        echo "Database restored successfully!"
        exit 0
        ;;
        
    4)
        echo ""
        echo "Application files restoration only..."
        
        if [ -d "$APP_DIR" ]; then
            echo "Backing up current installation..."
            rm -rf $APP_DIR.old
            mv $APP_DIR $APP_DIR.old
            check_status "Backup of current installation"
            
            # Preserve .env file
            cp $APP_DIR.old/.env /tmp/.env.backup 2>/dev/null || true
        fi
        
        echo "Extracting application files..."
        cd $BACKUP_DIR
        tar -xzf $LATEST_APP
        check_status "Application extraction"
        
        # Restore .env if backed up
        if [ -f "/tmp/.env.backup" ]; then
            cp /tmp/.env.backup $APP_DIR/.env
            rm /tmp/.env.backup
            check_status ".env restoration"
        fi
        ;;
esac

# Common setup steps for options 1, 2, and 4
if [ "$choice" != "3" ]; then
    cd $APP_DIR
    
    # Install dependencies
    echo ""
    echo "Installing dependencies..."
    composer install --no-dev --optimize-autoloader --no-interaction
    check_status "Composer dependencies"
    
    echo "Installing Node modules..."
    npm install --silent
    check_status "Node modules"
    
    # Build assets
    echo ""
    echo "Building assets..."
    npm run build
    check_status "Asset build"
    
    # Set up Laravel
    echo ""
    echo "Setting up Laravel..."
    
    # Create storage symlink
    if [ -L "public/storage" ]; then
        rm public/storage
    fi
    php artisan storage:link
    check_status "Storage link"
    
    # Clear and optimize caches
    php artisan optimize:clear
    php artisan optimize
    check_status "Laravel optimization"
    
    # Set permissions
    echo ""
    echo "Setting permissions..."
    chown -R www-data:www-data storage bootstrap/cache
    chmod -R 775 storage bootstrap/cache
    check_status "Permissions"
    
    # Restart services
    echo ""
    echo "Restarting services..."
    systemctl reload nginx
    systemctl restart php8.3-fpm
    check_status "Service restart"
fi

# Verification
echo ""
echo "================================================"
echo "Restoration Complete!"
echo "================================================"
echo ""
echo "Please verify:"
echo "1. Website: https://hexagonservicesolutions.com"
echo "2. Admin Panel: https://hexagonservicesolutions.com/admin"
echo "3. Database tables: mysql -u $DB_USER -p$DB_PASS $DB_NAME -e 'SHOW TABLES;'"
echo "4. Laravel status: php artisan about"
echo ""

# Quick health check
echo "Running quick health check..."
cd $APP_DIR
php artisan about | head -20

echo ""
echo "Restoration completed successfully!"