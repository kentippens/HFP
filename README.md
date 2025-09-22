# HexService Laravel Application

## Hexagon Service Solutions - Professional Building Services Website

A comprehensive Laravel 12 application for Hexagon Service Solutions, providing building services including cleaning, fence installation, gutter services, and more.

## 🚀 Features

- **Service Management**: Complete service catalog with parent-child relationships
- **Blog System**: Full-featured blog with categories, SEO optimization, and rich text editing
- **Contact Forms**: Advanced contact form handling with database storage and validation
- **Admin Panel**: Filament-powered admin dashboard for content management
- **SEO Optimization**: Meta tags, JSON-LD structured data, sitemap generation
- **Security**: Enhanced security features including rate limiting, XSS protection, and secure authentication
- **Performance**: Optimized images, caching, and lazy loading

## 📋 Requirements

- PHP 8.3+
- Composer 2.8+
- Node.js 20+
- MySQL 8.0+
- Nginx or Apache

## 🛠️ Installation

1. Clone the repository:
```bash
git clone https://github.com/kentippens/HexService-Laravel.git
cd HexService-Laravel
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install Node dependencies:
```bash
npm install
```

4. Copy environment file and configure:
```bash
cp .env.example .env
php artisan key:generate
```

5. Configure your database in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hexservices
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. Run migrations and seeders:
```bash
php artisan migrate --seed
```

7. Create storage symlink:
```bash
php artisan storage:link
```

8. Build frontend assets:
```bash
npm run build
```

9. Set proper permissions:
```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

## 🌐 Production Deployment

### SSL Configuration
The application is configured for Cloudflare Full (Strict) SSL/TLS mode with Let's Encrypt certificates.

### Nginx Configuration
Example configuration is available in the project. Key points:
- SSL/TLS with strong ciphers
- Cloudflare IP forwarding
- Security headers
- Gzip compression
- Static asset caching

### Environment Variables
Key production settings:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://hexagonservicesolutions.com
SESSION_SECURE_COOKIE=true
```

## 🔒 Security Features

- Rate limiting on forms and API endpoints
- XSS protection and content sanitization
- CSRF protection
- SQL injection prevention
- Secure password policies
- Session encryption
- Security headers

## 📝 Admin Panel

Access the admin panel at `/admin`

Features:
- Service management
- Blog post creation and editing
- Contact form submissions
- User management
- SEO configuration
- Analytics tracking scripts

## 🧪 Testing

Run the test suite:
```bash
php artisan test
```

Test blog functionality:
```bash
php artisan blog:test
```

## 📁 Project Structure

```
├── app/                  # Application logic
│   ├── Console/         # Console commands
│   ├── Filament/        # Admin panel resources
│   ├── Http/            # Controllers, middleware
│   ├── Models/          # Eloquent models
│   └── Services/        # Business logic
├── database/            # Migrations and seeders
├── public/              # Public assets
├── resources/           # Views and raw assets
├── routes/              # Application routes
├── storage/             # File storage
└── tests/               # Test files
```

## 🔧 Maintenance Commands

Clear all caches:
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

Optimize for production:
```bash
php artisan optimize
php artisan config:cache
php artisan route:cache
```

## 📊 Database Schema

Key tables:
- `services` - Service catalog
- `blog_posts` - Blog articles
- `blog_categories` - Blog categories
- `contact_submissions` - Form submissions
- `core_pages` - Static pages
- `users` - User accounts

## 🐛 Troubleshooting

### 500 Errors
Check Laravel logs:
```bash
tail -f storage/logs/laravel.log
```

### Permission Issues
Reset permissions:
```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### Database Issues
Check connection:
```bash
php artisan db:show
```

## 📄 License

This project is proprietary software for Hexagon Service Solutions.

## 👥 Contributors

- Hexagon Service Solutions Team

## 📞 Support

For support, email: support@hexagonservicesolutions.com

---

**Last Updated**: August 2025
**Laravel Version**: 12.19.3
**PHP Version**: 8.3.24