/**
 * Inline Replacements JavaScript
 * Handles dynamic styling that was previously inline
 */

document.addEventListener('DOMContentLoaded', function() {
    // Set background images from data attributes
    const bgElements = document.querySelectorAll('[data-bg-image]');
    bgElements.forEach(function(element) {
        const imageUrl = element.getAttribute('data-bg-image');
        if (imageUrl) {
            element.style.backgroundImage = `url('${imageUrl}')`;
        }
    });

    // Handle any data-background attributes (commonly used in the template)
    const dataBgElements = document.querySelectorAll('[data-background]');
    dataBgElements.forEach(function(element) {
        const imageUrl = element.getAttribute('data-background');
        if (imageUrl) {
            element.style.backgroundImage = `url('${imageUrl}')`;
            element.style.backgroundSize = 'cover';
            element.style.backgroundPosition = 'center';
            element.style.backgroundRepeat = 'no-repeat';
        }
    });
});