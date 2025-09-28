# Documentation Index

## Overview
This directory contains all technical documentation for the HexService Laravel application.

## Core Documentation

### Setup & Installation
- [Setup Guide](SETUP.md) - Complete installation and configuration instructions
- [Local Installation Guide](LOCAL-INSTALLATION-GUIDE.md) - Local development environment setup
- [Restore Instructions](RESTORE-INSTRUCTIONS.md) - Backup and restore procedures

### Security
- [Security Implementation](SECURITY_IMPLEMENTATION.md) - Comprehensive security features and best practices
- [Security Headers Documentation](SECURITY_HEADERS_DOCUMENTATION.md) - Detailed security headers configuration
- [Security Audit Report](SECURITY_AUDIT_REPORT.md) - Security audit findings and resolutions
- [HTML Purification Implementation](HTML_PURIFICATION_IMPLEMENTATION.md) - XSS prevention implementation details
- [HTMLPurifier Fix Audit](HTMLPURIFIER_FIX_AUDIT.md) - HTMLPurifier configuration and fixes

### Accessibility
- [Accessibility Implementation](ACCESSIBILITY_IMPLEMENTATION.md) - WCAG 2.1 compliance and accessibility features

### Database & Seeding
- [Safe Seeding Guide](SAFE_SEEDING_GUIDE.md) - Database seeding best practices
- [Seeder Safety Implementation](SEEDER_SAFETY_IMPLEMENTATION.md) - Safe seeder implementation details

### Template & Frontend
- [Template Optimization Guide](TEMPLATE_OPTIMIZATION_GUIDE.md) - Template performance best practices
- [Blade Template Audit](BLADE_TEMPLATE_AUDIT.md) - Blade template security and optimization audit
- [Unescaped Output Audit](UNESCAPED_OUTPUT_AUDIT.md) - Audit of unescaped output vulnerabilities

### Features
- [Blog Author Implementation](BLOG_AUTHOR_IMPLEMENTATION.md) - Blog author feature implementation details

## Documentation Standards

### File Naming Convention
- Use UPPERCASE_WITH_UNDERSCORES.md for documentation files
- Keep names descriptive and specific
- Group related documentation with common prefixes (e.g., SECURITY_*, TEMPLATE_*)

### Content Structure
Each documentation file should include:
1. **Overview** - Brief description of what the document covers
2. **Implementation Details** - Technical implementation specifics
3. **Usage Examples** - Code examples and usage instructions
4. **Best Practices** - Recommended approaches
5. **Testing** - How to test the implementation
6. **Resources** - Links to related documentation

### Maintenance
- Update documentation when making significant changes
- Review documentation quarterly for accuracy
- Archive outdated documentation with _ARCHIVED suffix

## Quick Links

### External Documentation
- [Laravel Documentation](https://laravel.com/docs)
- [Filament Documentation](https://filamentphp.com/docs)
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)
- [OWASP Top Ten](https://owasp.org/www-project-top-ten/)

### Project Structure
```
Documentation/
├── README.md (this file)
├── Setup & Installation/
│   ├── SETUP.md
│   ├── LOCAL-INSTALLATION-GUIDE.md
│   └── RESTORE-INSTRUCTIONS.md
├── Security/
│   ├── SECURITY_IMPLEMENTATION.md
│   ├── SECURITY_HEADERS_DOCUMENTATION.md
│   ├── SECURITY_AUDIT_REPORT.md
│   └── HTML_PURIFICATION_IMPLEMENTATION.md
├── Accessibility/
│   └── ACCESSIBILITY_IMPLEMENTATION.md
├── Database/
│   ├── SAFE_SEEDING_GUIDE.md
│   └── SEEDER_SAFETY_IMPLEMENTATION.md
└── Templates/
    ├── TEMPLATE_OPTIMIZATION_GUIDE.md
    ├── BLADE_TEMPLATE_AUDIT.md
    └── UNESCAPED_OUTPUT_AUDIT.md
```

## Contributing to Documentation

When adding new documentation:
1. Place it in the Documentation folder
2. Use the appropriate naming convention
3. Add a reference in this index
4. Update the main README.md if necessary
5. Include creation/update date in the document

---

Last Updated: 2025-09-27