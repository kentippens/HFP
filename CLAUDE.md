# Claude Assistant Instructions for HexService Laravel Setup

## Current Status (As of 2025-08-04)
**FRESH INSTALLATION PENDING** - All previous files and database have been removed for a clean reinstall.

### What Has Been Preserved:
- **SSL Certificate**: Valid Let's Encrypt certificate for hexagonservicesolutions.com
  - Location: `/etc/letsencrypt/live/hexagonservicesolutions.com/`
  - Configured for Cloudflare Full (Strict) SSL/TLS mode
- **Nginx Configuration Template**: Available at `/etc/nginx/sites-available/hexservices`
- **Server Environment**: PHP 8.3, Composer, Node.js 20, MySQL 8, Nginx

### Previous Installation Summary:
The site was successfully deployed with:
- Laravel 12 application
- Database imported from backup at `.database-DELETE/hexdb-08-03-25_08:41PM.sql`
- 9 services with JSON-LD structured data
- Storage symlinks configured
- SSL certificate implemented
- All images and assets working

### Known Requirements for Reinstallation:
1. **Database**: Import from backup file (if provided)
2. **Environment Configuration**:
   - APP_URL=https://hexagonservicesolutions.com
   - Database name: hexservices
   - Create database user with appropriate permissions
3. **Storage**: Run `php artisan storage:link` after installation
4. **Assets**: Build with `npm run build` for production
5. **Permissions**: Set proper ownership to www-data for storage and cache
6. **Nginx**: Re-enable site configuration after setup

### Critical Files/Paths:
- Application root: `/home/hexservices/HexService-Laravel/`
- SSL certificates: `/etc/letsencrypt/live/hexagonservicesolutions.com/`
- Nginx config: `/etc/nginx/sites-available/hexservices`

### Post-Installation Checklist:
- [ ] Import database from backup
- [ ] Run migrations and seeders
- [ ] Create storage symlink
- [ ] Build frontend assets
- [ ] Set file permissions
- [ ] Enable Nginx configuration
- [ ] Clear all caches
- [ ] Test SSL certificate
- [ ] Verify services are loading
- [ ] Check JSON-LD rendering
- [ ] Confirm image assets display

## Important Notes:
- Domain is managed through Cloudflare with Full (Strict) SSL/TLS
- Always preserve SSL certificates during any cleanup
- Database backup should contain all services and JSON-LD data
- Run lint and typecheck commands after code changes