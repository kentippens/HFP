/**
 * Lazy Loading Implementation
 * Uses Intersection Observer API for performance
 */

document.addEventListener('DOMContentLoaded', function() {
    // Check if browser supports Intersection Observer
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    
                    // Load the image
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                    }
                    
                    // Load srcset if available
                    if (img.dataset.srcset) {
                        img.srcset = img.dataset.srcset;
                        img.removeAttribute('data-srcset');
                    }
                    
                    // Add loaded class for animation
                    img.classList.add('lazy-loaded');
                    
                    // Stop observing this image
                    observer.unobserve(img);
                }
            });
        }, {
            rootMargin: '50px 0px', // Start loading 50px before the image is visible
            threshold: 0.01
        });

        // Observe all images with lazy class
        document.querySelectorAll('img.lazy').forEach(img => {
            imageObserver.observe(img);
        });

        // Also handle background images
        const bgObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const element = entry.target;
                    const bgImage = element.dataset.background;
                    
                    if (bgImage) {
                        element.style.backgroundImage = `url(${bgImage})`;
                        element.removeAttribute('data-background');
                        element.classList.add('lazy-loaded');
                    }
                    
                    observer.unobserve(element);
                }
            });
        }, {
            rootMargin: '50px 0px',
            threshold: 0.01
        });

        // Observe all elements with lazy-bg class
        document.querySelectorAll('.lazy-bg').forEach(element => {
            bgObserver.observe(element);
        });
    } else {
        // Fallback for browsers that don't support Intersection Observer
        const lazyImages = document.querySelectorAll('img.lazy');
        lazyImages.forEach(img => {
            if (img.dataset.src) {
                img.src = img.dataset.src;
            }
            if (img.dataset.srcset) {
                img.srcset = img.dataset.srcset;
            }
        });
        
        const lazyBgs = document.querySelectorAll('.lazy-bg');
        lazyBgs.forEach(element => {
            const bgImage = element.dataset.background;
            if (bgImage) {
                element.style.backgroundImage = `url(${bgImage})`;
            }
        });
    }
});

// Utility function to manually trigger lazy loading for dynamically added content
window.initLazyLoading = function(container = document) {
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                    }
                    if (img.dataset.srcset) {
                        img.srcset = img.dataset.srcset;
                        img.removeAttribute('data-srcset');
                    }
                    img.classList.add('lazy-loaded');
                    observer.unobserve(img);
                }
            });
        }, {
            rootMargin: '50px 0px',
            threshold: 0.01
        });

        container.querySelectorAll('img.lazy:not(.lazy-loaded)').forEach(img => {
            imageObserver.observe(img);
        });
    }
};