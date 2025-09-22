# Hexagon Fiberglass Pools

A modern Laravel 12 application for Hexagon Fiberglass Pools, specializing in premium fiberglass pool services including resurfacing, conversions, repairs, and remodeling.

## About

Hexagon Fiberglass Pools is a comprehensive web application that showcases our expertise in:
- **Fiberglass Pool Resurfacing** - Transform your existing pool with durable fiberglass technology
- **Pool Conversions to Fiberglass** - Convert traditional pools to modern fiberglass
- **Pool Repair** - Professional fiberglass pool repair services
- **Pool Remodeling** - Complete pool renovation and modernization

## Features

### Public Website
- Modern, responsive design optimized for all devices
- Service showcase pages with detailed information
- Contact forms with Google reCAPTCHA v2 Invisible protection
- SEO-optimized content and meta tags
- Fast page load times with optimized assets

### Admin Panel
- Built with Filament v3 for modern administration
- Content management system for services
- Contact form submission management
- User and role management
- Blog/news management capabilities

### Technical Features
- Laravel 12 with PHP 8.2+ support
- MySQL database with optimized queries
- Bootstrap-based responsive frontend
- Google reCAPTCHA integration for spam protection
- Role-based access control (RBAC) system
- Secure authentication and authorization

## Quick Start

```bash
# Clone the repository
git clone https://github.com/kentippens/HFP.git
cd HFP

# Install dependencies
composer install
npm install

# Configure environment
cp .env.example .env
php artisan key:generate

# Set up database
php artisan migrate
php artisan db:seed

# Build assets
npm run build

# Create storage link
php artisan storage:link

# Start development server
php artisan serve
```

For detailed installation instructions, see [SETUP.md](SETUP.md)

## Requirements

- PHP >= 8.2
- Composer >= 2.0
- Node.js >= 20.x
- MySQL >= 8.0

## Documentation

- [Setup Guide](SETUP.md) - Complete installation and configuration instructions
- [Laravel Documentation](https://laravel.com/docs) - Laravel framework documentation
- [Filament Documentation](https://filamentphp.com/docs) - Admin panel documentation

## Services Focus

### Fiberglass Pool Resurfacing
Our flagship service - transforming existing pools with cutting-edge fiberglass technology for:
- Superior durability (25+ year lifespan)
- Smooth, non-porous surface
- Reduced maintenance requirements
- Chemical resistance
- Algae prevention

### Pool Conversions to Fiberglass
Convert your traditional concrete, gunite, or vinyl liner pool to modern fiberglass:
- Complete structural transformation
- Enhanced energy efficiency
- Lower long-term costs
- Improved aesthetics
- Faster installation

### Pool Repair
Professional repair services for all types of pool damage:
- Crack repair
- Surface restoration
- Structural fixes
- Leak detection and repair
- Equipment replacement

### Pool Remodeling
Complete pool renovation services:
- Design updates
- Feature additions
- Deck and coping work
- Lighting upgrades
- Equipment modernization

## Technology Stack

- **Framework:** Laravel 12
- **PHP Version:** 8.2+
- **Database:** MySQL 8.0
- **Frontend:** Bootstrap 5, Vanilla JavaScript
- **Admin Panel:** Filament v3
- **Package Manager:** Composer, NPM
- **Build Tools:** Vite

## Security Features

- Environment-based configuration
- CSRF protection on all forms
- XSS prevention with input sanitization
- SQL injection protection via Eloquent ORM
- Google reCAPTCHA v2 Invisible on all contact forms
- Secure password hashing with bcrypt
- Role-based access control

## Contact

For more information about Hexagon Fiberglass Pools services, please visit our website or contact us through the contact form.

## Repository

- **GitHub:** https://github.com/kentippens/HFP.git

## License

This project is proprietary software. All rights reserved.

---

© 2024 Hexagon Fiberglass Pools. Specializing in fiberglass pool resurfacing, conversions, repairs, and remodeling.