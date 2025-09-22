const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

// Enable versioning in production
if (mix.inProduction()) {
    mix.version();
}

// Combine and minify CSS files
mix.styles([
    'public/css/bootstrap.min.css',
    'public/css/animate.css',
    'public/css/slick.css',
    'public/css/magnific-popup.css',
    'public/css/odometer-theme-car.css',
    'public/css/optimized-icons.css',
    'public/css/style.css',
    'public/css/portfolio-fix.css',
    'public/css/pool-theme.css',
    'public/css/pool-services.css',
    'public/css/phone-cta.css',
    'public/css/mobile-menu-new.css',
    'public/css/how-it-works.css',
    'public/css/pagination-fix.css',
    'public/css/blog-details-fix.css'
], 'public/css/app.min.css');

// Combine and minify JavaScript files
mix.scripts([
    'public/js/vendor/jquery-3.6.0.min.js',
    'public/js/vendor/bootstrap.min.js',
    'public/js/vendor/slick.min.js',
    'public/js/vendor/easing.min.js',
    'public/js/vendor/wow.min.js',
    'public/js/vendor/before-after.js',
    'public/js/vendor/jquery.magnific-popup.min.js',
    'public/js/vendor/odometer.min.js',
    'public/js/vendor/isotope.pkgd.js',
    'public/js/vendor/piechart.js',
    'public/js/vendor/appear.js',
    'public/js/main.js',
    'public/js/mobile-menu-new.js',
    'public/js/form-validation.js'
], 'public/js/app.min.js');

// Process images
mix.copyDirectory('public/images', 'public/build/images');

// BrowserSync for development
if (!mix.inProduction()) {
    mix.browserSync({
        proxy: 'hexagonservicesolutions.test',
        files: [
            'app/**/*.php',
            'resources/views/**/*.php',
            'public/js/**/*.js',
            'public/css/**/*.css'
        ]
    });
}

// Production optimizations
if (mix.inProduction()) {
    mix.options({
        terser: {
            terserOptions: {
                compress: {
                    drop_console: true,
                },
            },
        },
        cssNano: {
            discardComments: {
                removeAll: true,
            },
        },
    });
}