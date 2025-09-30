# Blog Post Import Guide

This system supports multiple methods for importing blog posts in bulk, making it easy to migrate content or create multiple posts efficiently.

## Import Methods Available

### 1. CSV Import
Import multiple blog posts from a CSV file with all metadata.

**Template Files:**
- `blog-posts-import-template.csv` - Basic template with 2 examples
- `sample-blog-posts-bulk.csv` - Ready-to-import file with 10 posts

**Import via CLI:**
```bash
php artisan import:blog-posts yourfile.csv
php artisan import:blog-posts yourfile.csv --preview  # Preview before importing
php artisan import:blog-posts yourfile.csv --skip-errors  # Continue on errors
```

**Import via Admin Panel:**
1. Go to Blog Posts section
2. Click "Import CSV" button
3. Upload your CSV file
4. Map fields if needed
5. Complete import

### 2. Markdown Import
Import blog posts from markdown files with YAML frontmatter.

**Template Files:**
- `blog-post-markdown-template.md` - Comprehensive template with all options
- `blog-post-markdown-minimal.md` - Simple template for quick start
- `sample-markdown-blogs/` - Directory with example markdown posts

**Import via CLI:**
```bash
# Import single file
php artisan import:markdown-blog post.md
php artisan import:markdown-blog post.md --preview

# Import entire directory
php artisan import:markdown-blog /path/to/markdown/folder

# Recursive import (includes subdirectories)
php artisan import:markdown-blog /content --recursive
```

**Import via Admin Panel:**
1. Go to Blog Posts section
2. Click "Import Markdown" button
3. Select one or more .md files
4. Click import

## Field Mapping

### CSV Fields
| Field | Required | Description | Example |
|-------|----------|-------------|---------|
| title | Yes | Post title | "Pool Maintenance Guide" |
| slug | No | URL slug (auto-generated) | "pool-maintenance-guide" |
| content | Yes | HTML content | "<p>Content here...</p>" |
| excerpt | No | Short description | "Learn pool maintenance..." |
| author_email | No | Author's email | "admin@example.com" |
| category_name | No | Category (created if new) | "Pool Care" |
| tags | No | Comma-separated tags | "maintenance, tips, diy" |
| is_published | No | Publication status (1/0) | 1 |
| is_featured | No | Featured status (1/0) | 0 |
| published_at | No | Publication date | "2024-01-15 09:00:00" |
| reading_time | No | Minutes (auto-calculated) | 5 |
| featured_image | No | Image path | "images/blog/image.jpg" |
| meta_title | No | SEO title | "Pool Guide | Your Site" |
| meta_description | No | SEO description | "Complete guide to..." |
| meta_keywords | No | SEO keywords | "pool, maintenance" |

### Markdown Frontmatter
```yaml
---
# Required
title: "Your Post Title"

# Optional - All fields below can be omitted
slug: custom-url-slug
author: email@example.com  # or author name
category: Category Name
tags: [tag1, tag2, tag3]  # or "tag1, tag2, tag3"
published: true  # default: true
featured: false  # default: false
date: 2024-09-15  # various formats accepted
reading_time: 5  # auto-calculated if omitted
featured_image: path/to/image.jpg
meta_title: "SEO Title"
meta_description: "SEO description"
meta_keywords: "keywords, here"
excerpt: "Brief summary"  # auto-generated if omitted
---

# Your markdown content here...
```

## Supported Markdown Features

- **Headers** (h1-h6)
- **Bold**, *italic*, ***bold italic***
- Lists (ordered, unordered, task lists)
- [Links](url) and images
- Tables
- Code blocks with syntax highlighting
- Blockquotes
- Horizontal rules
- HTML within markdown

## Auto-Generated Fields

The following fields are automatically handled if not provided:

1. **Slug**: Generated from title
2. **Excerpt**: First 300 characters of content
3. **Reading Time**: Calculated at 200 words/minute
4. **Author**: Defaults to first admin user
5. **Published Date**: Current date/time if published

## Best Practices

### For CSV Import
1. Ensure HTML content is properly escaped in CSV
2. Use UTF-8 encoding
3. Wrap fields with commas in quotes
4. Test with a small batch first

### For Markdown Import
1. Always include title in frontmatter
2. Use consistent date format
3. Place images in correct directory before import
4. Preview before bulk import

## Troubleshooting

### Common Issues

**CSV Import Errors:**
- "Field 'name' doesn't have a default value" - System uses 'name' internally for title
- "Tags must be string" - Ensure tags are comma-separated string, not array
- "Author not found" - Use valid email from users table

**Markdown Import Errors:**
- "File not found" - Check file path is correct
- "Invalid frontmatter" - Ensure YAML syntax is correct
- "Category creation failed" - Check database permissions

### Validation Rules

- **Title**: Required, max 255 characters
- **Slug**: Must be unique, URL-safe
- **Content**: Required, HTML or markdown
- **Email**: Must exist in users table
- **Dates**: Various formats accepted (ISO, US, etc.)
- **Booleans**: true/false, yes/no, 1/0

## Examples

### Quick CSV Import
```csv
title,content,category_name,tags,is_published
"Pool Safety Tips","<p>Important safety information...</p>","Safety","safety, tips",1
"Winter Pool Care","<p>How to winterize your pool...</p>","Seasonal","winter, maintenance",1
```

### Simple Markdown File
```markdown
---
title: "Pool Opening Checklist"
category: Seasonal Care
tags: spring, opening, maintenance
---

# Pool Opening Checklist

Follow these steps to open your pool for the season...

## Step 1: Remove Cover
...
```

## Advanced Features

### Bulk Operations
- Import hundreds of posts at once
- Automatic duplicate detection (by slug)
- Transaction rollback on errors
- Progress tracking for large imports

### Data Transformation
- Automatic HTML sanitization
- Smart excerpt generation
- Category auto-creation
- Tag normalization

## Support

For issues or questions:
1. Check error logs: `storage/logs/laravel.log`
2. Verify file permissions
3. Ensure database connections
4. Test with provided templates first

## File Locations

- Templates: Project root directory
- Sample files: `sample-markdown-blogs/`
- Imported files: Stored in database
- Temp uploads: `storage/app/temp-markdown-imports/`