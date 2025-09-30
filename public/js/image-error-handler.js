/**
 * Image Error Handler
 * Handles image loading errors gracefully by hiding broken images
 */

document.addEventListener('DOMContentLoaded', function() {
    // Handle all service images with error handling
    const serviceImages = document.querySelectorAll('.service-image img');

    serviceImages.forEach(function(img) {
        img.addEventListener('error', function() {
            // Hide the image
            this.style.display = 'none';

            // Hide the parent figure element if it exists
            const parentFigure = this.closest('figure.service-image');
            if (parentFigure) {
                parentFigure.style.display = 'none';
            }

            // Log error for debugging (optional)
            console.warn('Failed to load image:', this.src);
        });
    });

    // Also handle any images that may have already failed before the script loaded
    serviceImages.forEach(function(img) {
        if (img.complete && img.naturalHeight === 0) {
            // Image already failed to load
            img.style.display = 'none';
            const parentFigure = img.closest('figure.service-image');
            if (parentFigure) {
                parentFigure.style.display = 'none';
            }
        }
    });
});

// Alternative: Use a more generic approach for all images with a specific class
function initImageErrorHandling() {
    const images = document.querySelectorAll('img[data-hide-on-error="true"]');

    images.forEach(function(img) {
        img.addEventListener('error', function() {
            this.style.display = 'none';

            // Check for data attribute to hide parent
            if (this.dataset.hideParentOnError === 'true') {
                const parent = this.parentElement;
                if (parent) {
                    parent.style.display = 'none';
                }
            }
        });
    });
}

// Initialize on DOM ready and after any dynamic content loads
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initImageErrorHandling);
} else {
    initImageErrorHandling();
}

// Export for use in other scripts if needed
window.ImageErrorHandler = {
    init: initImageErrorHandling
};