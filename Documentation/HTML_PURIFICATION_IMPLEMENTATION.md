# HTML Purification Implementation

## ✅ Status: COMPLETE

HTML purification for user-generated content has been fully implemented with multiple layers of protection.

## Implementation Overview

### 1. **Automatic Model-Level Sanitization**
All user-generated content models now automatically sanitize HTML on save using the `SanitizesHtml` trait.

#### Protected Models:
- ✅ **ContactSubmission** - User form submissions (strict purification)
- ✅ **BlogPost** - Blog content (admin purification)
- ✅ **CorePage** - Core page content (admin purification) 
- ✅ **LandingPage** - Landing page content (admin purification)
- ✅ **Service** - Service descriptions (default purification)

### 2. **SanitizesHtml Trait** (`app/Traits/SanitizesHtml.php`)
Automatically sanitizes fields before saving to database:
- Purifies HTML fields with HTMLPurifier
- Strips HTML from text-only fields
- Sanitizes JSON fields containing HTML
- Configurable per model

### 3. **Purifier Configuration** (`config/purifier.php`)
Three security levels configured:

#### **Strict** (User-Generated Content)
```php
'strict' => [
    'HTML.Allowed' => 'p,br,strong,em,u,a[href|title],ul,ol,li,blockquote',
    'CSS.AllowedProperties' => '',
    'URI.DisableExternalResources' => true,
]
```
Used for: Contact form messages, user comments

#### **Default** (General Content)
```php
'default' => [
    'HTML.Allowed' => 'div,b,strong,i,em,u,a[href|title|target],ul,ol,li,p[style],br,span[style],img[width|height|alt|src],h1,h2,h3,h4,h5,h6,blockquote,table,thead,tbody,tr,td,th',
    'CSS.AllowedProperties' => 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align,margin',
]
```
Used for: Service descriptions, general content

#### **Admin** (Trusted Content)
```php
'admin' => [
    'HTML.Allowed' => 'div[class|id|style],b,strong,i,em,u,a[href|title|target|class],ul[class|style],ol[class|style],li[class|style],p[style|class],br,span[style|class],img[width|height|alt|src|class],h1[class|id],h2[class|id],h3[class|id],h4[class|id],h5[class|id],h6[class|id],blockquote[class],pre[class],code[class],table[class|style],thead,tbody,tfoot,tr[class],td[colspan|rowspan|class|style],th[colspan|rowspan|class|style],iframe[src|width|height|frameborder],section[class|id],article[class|id],header[class|id],footer[class|id],nav[class|id],figure[class],figcaption[class],video[src|controls|width|height],audio[src|controls]',
    'CSS.AllowedProperties' => 'font,font-size,font-weight,font-style,font-family,text-decoration,padding,padding-left,padding-right,padding-top,padding-bottom,color,background-color,background,text-align,margin,margin-left,margin-right,margin-top,margin-bottom,border,border-width,border-color,border-style,display,width,height,max-width,max-height,min-width,min-height,float,clear,vertical-align,overflow,position,left,right,top,bottom,z-index',
]
```
Used for: Blog posts, core pages, landing pages (admin-created content)

### 4. **HtmlHelper Class** (`app/Helpers/HtmlHelper.php`)
Provides view-level output sanitization:

```php
// In Blade templates:
{!! \App\Helpers\HtmlHelper::safe($content) !!}
{!! \App\Helpers\HtmlHelper::userContent($userMessage) !!}
{!! \App\Helpers\HtmlHelper::adminContent($blogPost->content) !!}
```

## Security Features

### Input Sanitization (Automatic)
- Happens automatically on model save
- Removes dangerous tags like `<script>`, `<iframe>` (in strict mode)
- Strips event handlers (onclick, onload, etc.)
- Removes javascript: and data: URIs
- Cleans CSS to prevent style-based attacks

### Output Sanitization (Manual in Views)
- Use HtmlHelper for additional output filtering
- Returns HtmlString to prevent double-escaping
- Different methods for different trust levels

### XSS Protection Layers
1. **Model Layer**: Automatic sanitization on save
2. **View Layer**: HtmlHelper for output
3. **Middleware Layer**: SecurityHeaders middleware with CSP
4. **Browser Layer**: X-XSS-Protection headers

## Usage Examples

### 1. Model Configuration
```php
class ContactSubmission extends Model
{
    use SanitizesHtml;

    // Define HTML fields (will be purified)
    protected $htmlFields = ['message'];

    // Define text fields (HTML will be stripped)
    protected $stripFields = ['first_name', 'last_name', 'email', 'phone'];

    // Choose purifier config
    protected $purifierConfig = 'strict';
}
```

### 2. In Controllers
```php
// No special handling needed - sanitization is automatic
$contact = new ContactSubmission($request->all());
$contact->save(); // HTML is automatically sanitized
```

### 3. In Blade Views
```blade
{{-- For user-generated content --}}
<div class="message">
    {!! \App\Helpers\HtmlHelper::userContent($contact->message) !!}
</div>

{{-- For admin content --}}
<div class="blog-content">
    {!! \App\Helpers\HtmlHelper::adminContent($post->content) !!}
</div>

{{-- For plain text (no HTML) --}}
<h1>{{ \App\Helpers\HtmlHelper::escape($post->title) }}</h1>
```

## Testing

### Test XSS Protection
```php
// Try to inject script tag
$contact = new ContactSubmission();
$contact->message = '<p>Hello <script>alert("XSS")</script> world</p>';
$contact->save();

// Result: '<p>Hello  world</p>' (script removed)
```

### Test Style Injection
```php
$contact->message = '<p style="background: url(javascript:alert(1))">Text</p>';
$contact->save();

// Result: '<p>Text</p>' (dangerous style removed in strict mode)
```

### Test Event Handler
```php
$contact->message = '<a href="#" onclick="alert(1)">Click</a>';
$contact->save();

// Result: '<a href="#">Click</a>' (onclick removed)
```

## Security Checklist

✅ **Input Sanitization**: All user input is sanitized on save
✅ **Output Escaping**: HtmlHelper provides safe output methods
✅ **Configuration**: Three security levels (strict, default, admin)
✅ **Model Protection**: All content models use SanitizesHtml trait
✅ **JSON Fields**: Arrays in JSON fields are also sanitized
✅ **Event Handlers**: All JavaScript event handlers are removed
✅ **Protocol Filtering**: javascript:, data:, vbscript: URLs blocked
✅ **CSS Filtering**: Dangerous CSS properties are removed
✅ **Logging**: Dangerous content attempts can be logged

## Maintenance

### Adding New Models
1. Add `use SanitizesHtml;` trait
2. Define `$htmlFields` array
3. Define `$stripFields` array  
4. Set `$purifierConfig` ('strict', 'default', or 'admin')

### Updating Allowed HTML
Edit `config/purifier.php` to modify allowed tags and attributes

### Monitoring
- Check logs for XSS attempts: `storage/logs/laravel.log`
- Review failed sanitization attempts
- Update rules based on legitimate use cases

## Summary

The HTML purification system provides comprehensive protection against XSS attacks while allowing legitimate HTML content. The multi-layered approach ensures that even if one layer fails, others provide backup protection. All user-generated content is automatically sanitized, making the application secure by default.