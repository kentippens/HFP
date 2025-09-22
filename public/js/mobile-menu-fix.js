// Mobile Menu Toggle Fix
document.addEventListener('DOMContentLoaded', function() {
    // Get the hamburger button and mobile menu
    const hamburger = document.querySelector('.bixol-mobile-hamburger');
    const mobileMenu = document.querySelector('.bixol-mobile-menu');
    
    if (hamburger && mobileMenu) {
        // Remove any existing click handlers first
        const newHamburger = hamburger.cloneNode(true);
        hamburger.parentNode.replaceChild(newHamburger, hamburger);
        
        // Add click handler
        newHamburger.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            console.log('Hamburger clicked'); // Debug
            
            // Toggle the mobile menu
            mobileMenu.classList.toggle('mobile-menu-active');
            newHamburger.classList.toggle('active');
            
            // Force visibility
            if (mobileMenu.classList.contains('mobile-menu-active')) {
                mobileMenu.style.left = '0';
                mobileMenu.style.display = 'block';
                mobileMenu.style.visibility = 'visible';
                console.log('Menu should be visible'); // Debug
            } else {
                mobileMenu.style.left = '-280px';
                console.log('Menu hidden'); // Debug
            }
            
            // Create overlay if it doesn't exist
            let overlay = document.querySelector('.mobile-menu-overlay');
            if (!overlay) {
                overlay = document.createElement('div');
                overlay.className = 'mobile-menu-overlay';
                document.body.appendChild(overlay);
            }
            
            // Toggle overlay
            if (mobileMenu.classList.contains('mobile-menu-active')) {
                overlay.style.display = 'block';
                overlay.style.zIndex = '9998'; // Ensure it's below the menu
                document.body.style.overflow = 'hidden'; // Prevent scrolling when menu is open
            } else {
                overlay.style.display = 'none';
                document.body.style.overflow = ''; // Restore scrolling
            }
            
            // Close menu when clicking overlay
            overlay.onclick = function() {
                mobileMenu.classList.remove('mobile-menu-active');
                newHamburger.classList.remove('active');
                overlay.style.display = 'none';
                document.body.style.overflow = '';
            };
        });
        
        // Handle submenu toggles
        const submenuLinks = document.querySelectorAll('.bixol-mobile-menu ul li.has-submenu > a');
        submenuLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const submenu = this.nextElementSibling;
                if (submenu && submenu.tagName === 'UL') {
                    // Toggle submenu
                    if (submenu.style.display === 'block') {
                        submenu.style.display = 'none';
                        this.classList.remove('open');
                    } else {
                        submenu.style.display = 'block';
                        this.classList.add('open');
                    }
                }
            });
        });
    }
});

// Also handle jQuery version if jQuery is loaded
if (typeof jQuery !== 'undefined') {
    jQuery(document).ready(function($) {
        // Ensure the hamburger click works with jQuery too
        $(document).off('click', '.bixol-mobile-hamburger').on('click', '.bixol-mobile-hamburger', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $('.bixol-mobile-menu').toggleClass('mobile-menu-active');
            $(this).toggleClass('active');
        });
        
        // Submenu handling
        $('.bixol-mobile-menu ul li.has-submenu > a').off('click').on('click', function(e) {
            e.preventDefault();
            $(this).siblings('ul').slideToggle();
        });
    });
}