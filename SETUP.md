# Hexagon Fiberglass Pools - Laravel Application Setup

## Overview
This is a Laravel 12 application for Hexagon Fiberglass Pools, specializing in fiberglass pool resurfacing, conversions, repairs, and remodeling. It includes a public-facing website with service pages, contact forms with reCAPTCHA protection, and a Filament admin panel for content management.

## Requirements

### System Requirements
- PHP >= 8.2
- Composer >= 2.0
- Node.js >= 20.x
- NPM >= 10.x
- MySQL >= 8.0
- Web Server (Apache/Nginx)

### PHP Extensions
- BCMath PHP Extension
- Ctype PHP Extension
- cURL PHP Extension
- DOM PHP Extension
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PCRE PHP Extension
- PDO PHP Extension
- PDO MySQL Extension
- Tokenizer PHP Extension
- XML PHP Extension
- ZIP PHP Extension

## Installation Steps

### 1. Clone Repository
```bash
git clone [repository-url]
cd HexService-Laravel
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Install Node Dependencies
```bash
npm install
```

### 4. Environment Configuration
```bash
# Copy the example environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 5. Configure Environment Variables
Edit `.env` file with your settings:

#### Application Settings
```env
APP_NAME="Hexagon Fiberglass Pools"
APP_ENV=local
APP_KEY=[auto-generated]
APP_DEBUG=true
APP_URL=http://localhost
```

#### Database Configuration
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

#### Mail Configuration (Choose One Option)

**Option 1: Log emails to file (easiest for development)**
```env
MAIL_MAILER=log
```

**Option 2: Use MailHog (for local development)**
```env
MAIL_MAILER=smtp
MAIL_HOST=localhost
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
```

**Option 3: Use Mailtrap (for testing)**
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
```

**Option 4: Production SMTP**
```env
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_smtp_username
MAIL_PASSWORD=your_smtp_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="${APP_NAME}"
```

#### Google reCAPTCHA v2 Invisible
```env
RECAPTCHA_SITE_KEY=your_site_key_here
RECAPTCHA_SECRET_KEY=your_secret_key_here
RECAPTCHA_ENABLED=true
```

**To get reCAPTCHA keys:**
1. Go to https://www.google.com/recaptcha/admin
2. Register a new site
3. Choose "reCAPTCHA v2" → "Invisible reCAPTCHA badge"
4. Add your domains (localhost for development)
5. Copy the Site Key and Secret Key

### 6. Database Setup

#### Create Database
```sql
CREATE DATABASE your_database_name CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### Run Migrations
```bash
php artisan migrate
```

#### Seed Database (Optional - Adds Sample Data)
```bash
# Run all seeders (includes sample services, admin user, etc.)
php artisan db:seed

# Or run specific seeders
php artisan db:seed --class=AdminUserSeeder
php artisan db:seed --class=ServiceSeeder
php artisan db:seed --class=RolesAndPermissionsSeeder
```

#### Import Existing Database (If Provided)
```bash
mysql -u your_username -p your_database_name < database_backup.sql
```

### 7. Build Frontend Assets

#### For Development
```bash
npm run dev
# Or watch for changes
npm run watch
```

#### For Production
```bash
npm run build
# Or if using Mix
npm run production
```

### 8. Storage Setup
```bash
# Create storage symlink for public files
php artisan storage:link

# Set proper permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
```

### 9. Clear Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### 10. Optimize for Production (Optional)
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

## Default Admin Credentials
After running `AdminUserSeeder`:
- **Email:** admin@hexagonpools.com
- **Password:** password123

**Important:** Change these immediately after first login!

## Web Server Configuration

### Apache
Ensure `.htaccess` file is present in `/public` directory and `mod_rewrite` is enabled.

### Nginx Example
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/HexService-Laravel/public;

    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## Testing

### Run Tests
```bash
# Run all tests
php artisan test

# Run with coverage
php artisan test --coverage
```

### Code Quality Checks
```bash
# Check code style (if configured)
npm run lint

# Type checking (if configured)
npm run typecheck
```

## Troubleshooting

### Common Issues

#### 1. 500 Internal Server Error
- Check Laravel logs: `storage/logs/laravel.log`
- Verify `.env` file exists and is configured
- Ensure proper permissions on storage and cache directories
- Run `php artisan key:generate` if APP_KEY is missing

#### 2. Database Connection Error
- Verify database credentials in `.env`
- Ensure MySQL service is running
- Check if database exists
- Test connection: `php artisan tinker` then `DB::connection()->getPdo()`

#### 3. reCAPTCHA Not Working
- Verify site key and secret key are correct
- Add your domain to allowed domains in Google reCAPTCHA console
- For local development, add "localhost" to allowed domains
- Check browser console for JavaScript errors

#### 4. Styles/JavaScript Not Loading
- Run `npm install` and `npm run build`
- Clear browser cache
- Check if `/public/build` directory exists
- Verify `APP_URL` in `.env` matches your actual URL

#### 5. Storage Images Not Showing
- Run `php artisan storage:link`
- Verify symlink exists: `public/storage → storage/app/public`
- Check file permissions

#### 6. Admin Panel Not Accessible
- Ensure you've run migrations and seeders
- Try accessing `/admin/login`
- Check if Filament is properly installed: `composer show filament/filament`
- Clear config cache: `php artisan config:clear`

## Maintenance

### Regular Tasks
```bash
# Clear all caches
php artisan optimize:clear

# Update dependencies
composer update
npm update

# Backup database
mysqldump -u username -p database_name > backup_$(date +%Y%m%d).sql
```

### Monitoring
- Check Laravel logs regularly: `tail -f storage/logs/laravel.log`
- Monitor error logs
- Set up proper logging for production

## Security Considerations

1. **Never commit sensitive data:**
   - `.env` file
   - Database dumps with real data
   - API keys or secrets

2. **Production Security:**
   - Set `APP_DEBUG=false`
   - Use HTTPS only
   - Keep dependencies updated
   - Regular security audits
   - Implement rate limiting
   - Use strong passwords

3. **Environment-Specific Settings:**
   - Different database for production
   - Secure mail configuration
   - Production-ready cache drivers
   - Proper session configuration

## Support

For issues or questions:
1. Check the logs in `storage/logs/`
2. Review this documentation
3. Check Laravel 12 documentation: https://laravel.com/docs
4. Check Filament documentation: https://filamentphp.com/docs

## License

[Your License Here]

---

**Note:** This is a derivative work based on a Laravel service website template. Ensure all customizations are properly documented and tested before deployment.