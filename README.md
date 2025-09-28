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
- **WCAG 2.1 Level AA compliant accessibility features**
- **Comprehensive keyboard navigation support**
- **Screen reader optimized forms and content**

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
- **Accessible form components with ARIA support**
- **Focus management and keyboard navigation**
- **Live region announcements for dynamic content**

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

For detailed installation instructions, see [SETUP.md](Documentation/SETUP.md)

## Requirements

- PHP >= 8.2
- Composer >= 2.0
- Node.js >= 20.x
- MySQL >= 8.0

## Documentation

- [Setup Guide](Documentation/SETUP.md) - Complete installation and configuration instructions
- [Accessibility Implementation](Documentation/ACCESSIBILITY_IMPLEMENTATION.md) - Comprehensive accessibility features and guidelines
- [Security Implementation](Documentation/SECURITY_IMPLEMENTATION.md) - Security features and best practices
- [Laravel Documentation](https://laravel.com/docs) - Laravel framework documentation
- [Filament Documentation](https://filamentphp.com/docs) - Admin panel documentation

### Additional Documentation
- [Local Installation Guide](Documentation/LOCAL-INSTALLATION-GUIDE.md) - Local development setup
- [Security Headers Documentation](Documentation/SECURITY_HEADERS_DOCUMENTATION.md) - Security headers configuration
- [Template Optimization Guide](Documentation/TEMPLATE_OPTIMIZATION_GUIDE.md) - Template performance best practices
- [HTML Purification Implementation](Documentation/HTML_PURIFICATION_IMPLEMENTATION.md) - XSS prevention details
- [Safe Seeding Guide](Documentation/SAFE_SEEDING_GUIDE.md) - Database seeding best practices
- [Restore Instructions](Documentation/RESTORE-INSTRUCTIONS.md) - Backup and restore procedures

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

- **Environment-based configuration** - Sensitive data stored in .env file
- **CSRF protection** - Token validation on all forms
- **XSS prevention** - Input sanitization and HTML Purifier integration
- **SQL injection protection** - Eloquent ORM and parameterized queries
- **Google reCAPTCHA v2 Invisible** - Spam protection on all forms
- **Secure password hashing** - bcrypt algorithm with salt
- **Role-based access control (RBAC)** - Granular permission system
- **Security headers** - X-Frame-Options, X-Content-Type-Options, CSP
- **Rate limiting** - Throttling for form submissions and API endpoints
- **Input validation** - Server-side validation on all user inputs
- **Session security** - Secure, HttpOnly, SameSite cookies

## Accessibility Features

- **WCAG 2.1 Level AA Compliance** - Following international accessibility standards
- **Keyboard Navigation** - Full keyboard support with Tab, Arrow, and Escape keys
- **Screen Reader Support** - Proper ARIA labels, roles, and live regions
- **Focus Management** - Visible focus indicators and focus trapping in modals
- **Accessible Forms** - All inputs have labels, error associations, and help text
- **Skip Links** - Quick navigation to main content for screen reader users
- **High Contrast Mode** - Enhanced borders and contrast for visibility
- **Reduced Motion** - Respects user preferences for motion sensitivity
- **Character Counters** - Live regions announce remaining characters
- **Error Announcements** - Form validation errors announced to screen readers

## Recent Improvements

### Security Enhancements (Completed)
- Implemented comprehensive security headers middleware
- Added Content Security Policy (CSP) configuration
- Enhanced CSRF protection across all forms
- Integrated HTML Purifier for XSS prevention
- Implemented input sanitization middleware
- Added rate limiting for form submissions
- Extracted and optimized inline styles/scripts
- Implemented asset versioning for cache busting

### Performance Optimizations (Completed)
- Optimized database queries with eager loading
- Implemented lazy loading for images
- Minified and combined CSS/JS assets
- Added browser caching headers
- Optimized image assets and formats
- Reduced HTTP requests through asset combining
- Implemented CDN for static assets

### Accessibility Implementation (Completed)
- Created reusable accessible form components
- Added comprehensive ARIA attributes
- Implemented keyboard navigation patterns
- Added skip links for screen readers
- Created focus management system
- Added live regions for dynamic content
- Implemented high contrast mode support
- Added reduced motion preferences
- Created character counters with ARIA
- Enhanced form validation with screen reader support

## Contact

For more information about Hexagon Fiberglass Pools services, please visit our website or contact us through the contact form.

## Repository

- **GitHub:** https://github.com/kentippens/HFP.git

## License

This project is proprietary software. All rights reserved.

---

© 2024 Hexagon Fiberglass Pools. Specializing in fiberglass pool resurfacing, conversions, repairs, and remodeling.