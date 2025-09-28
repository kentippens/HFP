# Local Installation Guide for HexService Laravel

## Prerequisites

Before installing locally, ensure you have:
- **PHP 8.3+** with required extensions (mbstring, xml, curl, mysql, gd, zip)
- **Composer** (PHP dependency manager)
- **Node.js 18+** and NPM
- **MySQL 8.0** or **MariaDB 10.5+**
- **Git**
- A local server environment like:
  - **Laravel Valet** (Mac)
  - **Laravel Herd** (Windows/Mac)
  - **XAMPP/WAMP** (Windows)
  - **MAMP** (Mac)
  - **Docker** with Laravel Sail

## Installation Steps

### 1. Clone the Repository

```bash
# Navigate to your development directory
cd ~/Sites  # or wherever you keep your projects

# Clone from GitHub
git clone https://github.com/kentippens/HexService-Laravel.git

# Enter the project directory
cd HexService-Laravel
```

### 2. Install Dependencies

```bash
# Install PHP packages
composer install

# Install Node packages
npm install
```

### 3. Environment Configuration

```bash
# Copy the example environment file
cp .env.example .env

# Or copy the production .env template
cp .env.local .env

# Generate application key
php artisan key:generate
```

### 4. Configure .env for Local Development

Edit the `.env` file with your local settings:

```env
APP_NAME="Hexagon Service Solutions"
APP_ENV=local
APP_KEY=base64:YOUR_GENERATED_KEY_HERE
APP_DEBUG=true
APP_URL=http://hexservice.test

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hexservice_local
DB_USERNAME=root
DB_PASSWORD=

# Mail (use Mailtrap or MailHog for testing)
MAIL_MAILER=smtp
MAIL_HOST=localhost
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

# For local development, disable these
SESSION_SECURE_COOKIE=false
```

### 5. Create Local Database

```bash
# Access MySQL
mysql -u root -p

# Create database
CREATE DATABASE hexservice_local;
EXIT;
```

### 6. Import Database

#### Option A: Import from Production Backup
```bash
# Download the latest backup from server (if you have SSH access)
scp root@hexagonservicesolutions.com:/home/hexservices/hexservices-backup-*.sql.gz ./

# Or use the backup included in the repo
gunzip < hexservices-backup-20250826-190000.sql.gz | mysql -u root hexservice_local
```

#### Option B: Fresh Installation with Migrations
```bash
# Run migrations
php artisan migrate

# Seed with sample data
php artisan db:seed

# Create admin user
php artisan tinker
>>> \App\Models\User::create([
>>>     'name' => 'Admin',
>>>     'email' => 'admin@example.com',
>>>     'password' => bcrypt('password'),
>>>     'is_admin' => true
>>> ]);
>>> exit
```

### 7. Build Frontend Assets

```bash
# For development (with hot reload)
npm run dev

# For production build
npm run build
```

### 8. Create Storage Symlink

```bash
php artisan storage:link
```

### 9. Set Permissions (Unix/Mac only)

```bash
chmod -R 775 storage bootstrap/cache
```

### 10. Configure Local Domain

#### For Laravel Valet (Mac):
```bash
valet link hexservice
# Site will be available at http://hexservice.test
```

#### For Laravel Herd:
```bash
herd link hexservice
# Site will be available at http://hexservice.test
```

#### For XAMPP/WAMP/MAMP:
Add to your hosts file:
- Windows: `C:\Windows\System32\drivers\etc\hosts`
- Mac/Linux: `/etc/hosts`

```
127.0.0.1    hexservice.test
```

Then add virtual host configuration.

#### For Docker (Laravel Sail):
```bash
# Install Sail
composer require laravel/sail --dev
php artisan sail:install

# Start containers
./vendor/bin/sail up -d

# Site will be available at http://localhost
```

## Running the Application

### Start Development Server

```bash
# Using Laravel's built-in server
php artisan serve
# Visit: http://localhost:8000

# Using Valet/Herd
# Visit: http://hexservice.test

# With hot reload for frontend
npm run dev
```

### Access Points

- **Frontend**: http://localhost:8000 (or http://hexservice.test)
- **Admin Panel**: http://localhost:8000/admin
- **Default Admin Login**:
  - Email: `admin@example.com`
  - Password: `password`

## Common Issues & Solutions

### Issue 1: Database Connection Refused
```bash
# Check MySQL is running
mysql -u root -p

# Verify .env database credentials
DB_HOST=127.0.0.1  # Use 127.0.0.1 instead of localhost
```

### Issue 2: Permission Errors
```bash
# Fix storage permissions
chmod -R 775 storage bootstrap/cache

# Windows users: Run as administrator
```

### Issue 3: Missing PHP Extensions
```bash
# Check PHP extensions
php -m

# Install missing extensions (example for Ubuntu/Mac with Homebrew)
# Ubuntu:
sudo apt-get install php8.3-mbstring php8.3-xml php8.3-mysql

# Mac with Homebrew:
brew install php@8.3
```

### Issue 4: npm run dev/build fails
```bash
# Clear npm cache
npm cache clean --force

# Delete node_modules and reinstall
rm -rf node_modules package-lock.json
npm install
```

## Development Tools

### Useful Artisan Commands
```bash
# Clear all caches
php artisan optimize:clear

# Watch for changes and compile
npm run dev

# Run tests
php artisan test

# Check routes
php artisan route:list

# Create new admin user
php artisan make:admin admin@example.com password
```

### Database Management
```bash
# Backup local database
mysqldump -u root hexservice_local > backup.sql

# Restore database
mysql -u root hexservice_local < backup.sql

# Fresh migration with seed
php artisan migrate:fresh --seed
```

## VS Code Extensions (Recommended)

- Laravel Extension Pack
- PHP Intelephense
- Tailwind CSS IntelliSense
- Alpine.js Support
- DotENV
- GitLens

## Additional Configuration

### Queue Worker (if needed)
```bash
# For local development
php artisan queue:work

# Or use sync driver in .env
QUEUE_CONNECTION=sync
```

### Mail Testing
Use one of these for local email testing:
- **MailHog**: https://github.com/mailhog/MailHog
- **Mailtrap**: https://mailtrap.io
- **Laravel Log Driver**: Set `MAIL_MAILER=log` in .env

### SSL for Local Development
```bash
# Using Valet
valet secure hexservice

# Manual with mkcert
mkcert hexservice.test
# Then configure in your web server
```

## Sync with Production

### Pull Latest Changes
```bash
git pull origin main
composer install
npm install && npm run build
php artisan migrate
```

### Get Production Database (Optional)
```bash
# SSH to server and create backup
ssh root@hexagonservicesolutions.com
mysqldump -u hexservices -pHexServ2025 hexservices | gzip > hexservice-latest.sql.gz

# Download locally
scp root@hexagonservicesolutions.com:~/hexservice-latest.sql.gz ./

# Import to local
gunzip < hexservice-latest.sql.gz | mysql -u root hexservice_local
```

## Support

For issues with the application:
- Check Laravel logs: `storage/logs/laravel.log`
- Enable debug mode: Set `APP_DEBUG=true` in .env
- Run diagnostics: `php artisan about`

## Security Note

**Never commit sensitive data:**
- Don't commit `.env` file
- Don't commit database backups
- Use different passwords for local development
- Keep `APP_DEBUG=false` in production