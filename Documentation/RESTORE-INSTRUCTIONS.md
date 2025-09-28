# HexService Laravel Restoration Guide

## Backup Files Location
- **Database Backup**: `/home/hexservices/hexservices-backup-20250826-190000.sql.gz`
- **Application Backup**: `/home/hexservices/HexService-Laravel-backup-20250826-190000.tar.gz`
- **GitHub Repository**: https://github.com/kentippens/HexService-Laravel.git

## Method 1: Quick Restoration (From Local Backups)

### Step 1: Restore Database
```bash
# Drop existing database (if needed)
mysql -u hexservices -pHexServ2025 -e "DROP DATABASE IF EXISTS hexservices;"

# Create fresh database
mysql -u hexservices -pHexServ2025 -e "CREATE DATABASE hexservices;"

# Restore from backup
gunzip < /home/hexservices/hexservices-backup-20250826-190000.sql.gz | mysql -u hexservices -pHexServ2025 hexservices
```

### Step 2: Restore Application Files
```bash
# Backup current installation (optional)
mv /home/hexservices/HexService-Laravel /home/hexservices/HexService-Laravel.old

# Extract application backup
cd /home/hexservices
tar -xzf HexService-Laravel-backup-20250826-190000.tar.gz

# Restore vendor dependencies
cd HexService-Laravel
composer install --no-dev --optimize-autoloader

# Restore node modules (if needed for development)
npm install

# Build assets
npm run build
```

### Step 3: Set Permissions
```bash
# Set proper ownership
chown -R www-data:www-data /home/hexservices/HexService-Laravel/storage
chown -R www-data:www-data /home/hexservices/HexService-Laravel/bootstrap/cache

# Set proper permissions
chmod -R 775 /home/hexservices/HexService-Laravel/storage
chmod -R 775 /home/hexservices/HexService-Laravel/bootstrap/cache
```

### Step 4: Laravel Setup
```bash
cd /home/hexservices/HexService-Laravel

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Create storage symlink
php artisan storage:link

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Method 2: Restoration from GitHub

### Step 1: Clone Repository
```bash
# Remove existing directory
rm -rf /home/hexservices/HexService-Laravel

# Clone from GitHub
cd /home/hexservices
git clone https://github.com/kentippens/HexService-Laravel.git

# Navigate to project
cd HexService-Laravel
```

### Step 2: Environment Setup
```bash
# Copy environment file (or create new one)
cp .env.example .env

# Edit .env file with your settings
nano .env
```

Required .env settings:
```
APP_NAME="Hexagon Service Solutions"
APP_ENV=production
APP_KEY=base64:u2uzDGfnuhVDDfC3etJ5xrOV2A7GGh6VVpZjYCeDgmc=
APP_DEBUG=false
APP_URL=https://hexagonservicesolutions.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hexservices
DB_USERNAME=hexservices
DB_PASSWORD=HexServ2025
```

### Step 3: Install Dependencies & Build
```bash
# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Install Node dependencies
npm install

# Build frontend assets
npm run build

# Generate application key (if needed)
php artisan key:generate
```

### Step 4: Database Restoration
```bash
# Create database if it doesn't exist
mysql -u hexservices -pHexServ2025 -e "CREATE DATABASE IF NOT EXISTS hexservices;"

# Option A: Restore from backup
gunzip < /home/hexservices/hexservices-backup-20250826-190000.sql.gz | mysql -u hexservices -pHexServ2025 hexservices

# Option B: Run migrations and seeders (fresh install)
php artisan migrate --force
php artisan db:seed --force
```

### Step 5: Final Setup
```bash
# Create storage symlink
php artisan storage:link

# Set permissions
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Clear and optimize caches
php artisan optimize:clear
php artisan optimize
```

## Method 3: Automated Restoration Script

Create and run this script for automatic restoration:

```bash
#!/bin/bash
# Save as: /home/hexservices/restore.sh

echo "HexService Laravel Restoration Script"
echo "====================================="

# Configuration
BACKUP_DIR="/home/hexservices"
APP_DIR="/home/hexservices/HexService-Laravel"
DB_NAME="hexservices"
DB_USER="hexservices"
DB_PASS="HexServ2025"

# Choose restoration method
echo "Select restoration method:"
echo "1. From local backup files"
echo "2. From GitHub repository"
read -p "Enter choice (1 or 2): " choice

case $choice in
    1)
        echo "Restoring from local backups..."
        
        # Find latest backups
        LATEST_DB=$(ls -t $BACKUP_DIR/hexservices-backup-*.sql.gz | head -1)
        LATEST_APP=$(ls -t $BACKUP_DIR/HexService-Laravel-backup-*.tar.gz | head -1)
        
        echo "Using database backup: $LATEST_DB"
        echo "Using application backup: $LATEST_APP"
        
        # Restore database
        echo "Restoring database..."
        mysql -u $DB_USER -p$DB_PASS -e "DROP DATABASE IF EXISTS $DB_NAME; CREATE DATABASE $DB_NAME;"
        gunzip < $LATEST_DB | mysql -u $DB_USER -p$DB_PASS $DB_NAME
        
        # Restore application
        echo "Restoring application files..."
        rm -rf $APP_DIR.old
        mv $APP_DIR $APP_DIR.old 2>/dev/null
        cd $BACKUP_DIR
        tar -xzf $LATEST_APP
        ;;
        
    2)
        echo "Restoring from GitHub..."
        
        # Clone repository
        rm -rf $APP_DIR
        cd $BACKUP_DIR
        git clone https://github.com/kentippens/HexService-Laravel.git
        ;;
esac

# Common setup steps
cd $APP_DIR

# Install dependencies
echo "Installing dependencies..."
composer install --no-dev --optimize-autoloader
npm install

# Build assets
echo "Building assets..."
npm run build

# Set up Laravel
echo "Setting up Laravel..."
php artisan storage:link
php artisan optimize:clear
php artisan optimize

# Set permissions
echo "Setting permissions..."
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Restart services
echo "Restarting services..."
systemctl reload nginx
systemctl restart php8.3-fpm

echo "Restoration complete!"
```

## Verification Steps

After restoration, verify everything is working:

1. **Test website**: Visit https://hexagonservicesolutions.com
2. **Check database**: 
   ```bash
   mysql -u hexservices -pHexServ2025 hexservices -e "SHOW TABLES;"
   ```
3. **Check Laravel status**:
   ```bash
   php artisan about
   ```
4. **Test admin panel**: Visit https://hexagonservicesolutions.com/admin
5. **Check logs for errors**:
   ```bash
   tail -f storage/logs/laravel.log
   ```

## Troubleshooting

### Common Issues:

1. **500 Error**: Check permissions and logs
   ```bash
   chown -R www-data:www-data storage bootstrap/cache
   tail -100 storage/logs/laravel.log
   ```

2. **Database Connection Error**: Verify .env settings
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

3. **Missing Assets**: Rebuild frontend
   ```bash
   npm run build
   ```

4. **Storage Link Issues**: Recreate symlink
   ```bash
   rm public/storage
   php artisan storage:link
   ```

## Important Notes

- Always backup current installation before restoration
- Keep multiple backup versions for safety
- Test restoration process periodically
- Document any custom configurations or changes
- SSL certificates are preserved (not included in backups)