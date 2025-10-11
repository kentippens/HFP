# Manual Test Scripts

This directory contains standalone PHP scripts for manual testing and validation of various application features.

## Purpose

These scripts are designed for:
- Quick validation during development
- Debugging specific features
- Manual QA testing
- Data verification

**Note:** These are NOT PHPUnit tests. They are standalone scripts that can be run directly with `php <script-name>`.

## Available Scripts

### Blog & Content Tests

**test-blog-workflow.php**
- Tests blog post workflow transitions
- Validates status changes (draft → review → published)
- Checks scope methods and edge cases
- Usage: `php tests/Manual/test-blog-workflow.php`

**test-recent-posts.php**
- Debugs recent posts display
- Validates category relationships
- Checks thumbnail URLs
- Usage: `php tests/Manual/test-recent-posts.php`

**test-markdown.php**
- Tests markdown to HTML conversion
- Validates table rendering
- Usage: `php tests/Manual/test-markdown.php`

### Structure & Navigation Tests

**test-silo-structure.php**
- Validates silo hierarchy structure
- Tests route resolution
- Checks parent-child relationships
- Usage: `php tests/Manual/test-silo-structure.php`

### Admin Panel Tests

**test-dashboard-widgets.php**
- Tests dashboard analytics widgets
- Validates data aggregation
- Checks widget display logic
- Usage: `php tests/Manual/test-dashboard-widgets.php`

**test-bulk-operations.php**
- Tests Filament bulk operations
- Validates mass updates
- Checks permission handling
- Usage: `php tests/Manual/test-bulk-operations.php`

**test-import-export.php**
- Tests CSV/Excel import functionality
- Validates export features
- Checks data transformation
- Usage: `php tests/Manual/test-import-export.php`

**test-activity-logging.php**
- Tests audit trail functionality
- Validates activity logging
- Checks log integrity
- Usage: `php tests/Manual/test-activity-logging.php`

## Running Tests

All scripts should be run from the project root:

```bash
# From project root
php tests/Manual/test-silo-structure.php

# Or from the tests/Manual directory
cd tests/Manual
php test-silo-structure.php
```

## Environment

These scripts use the application's bootstrap and connect to your configured database. Ensure:
- `.env` is configured correctly
- Database connection is available
- Required services are running

## vs PHPUnit Tests

| Manual Scripts | PHPUnit Tests |
|----------------|---------------|
| Run individually with `php` | Run with `php artisan test` |
| Output to console | Formatted test results |
| For debugging/validation | For automated CI/CD |
| Located in `tests/Manual/` | Located in `tests/Feature/` and `tests/Unit/` |

## Maintenance

When adding new manual tests:
1. Place in this directory
2. Use proper autoload path: `require __DIR__ . '/../../vendor/autoload.php';`
3. Bootstrap with Console kernel: `$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();`
4. Document in this README
