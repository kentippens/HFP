/**
 * Modern Mobile Menu JavaScript
 * Industry Best Practices Implementation
 */

(function() {
    'use strict';

    // Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', function() {
        initMobileMenu();
    });

    function initMobileMenu() {
        // Get elements
        const hamburgerButtons = document.querySelectorAll('.bixol-mobile-hamburger');
        const mobileMenu = document.getElementById('mobileMenu');
        const closeButton = document.querySelector('.mobile-menu-close');
        const overlay = document.querySelector('.mobile-menu-overlay');
        const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
        const body = document.body;

        // Check if menu exists
        if (!mobileMenu) {
            console.warn('Mobile menu not found');
            return;
        }

        // Open menu function
        function openMenu() {
            mobileMenu.classList.add('active');
            body.classList.add('mobile-menu-open');
            
            // Animate hamburger
            hamburgerButtons.forEach(btn => {
                btn.classList.add('active');
            });

            // Trap focus in menu for accessibility
            trapFocus(mobileMenu);
            
            // Dispatch custom event
            document.dispatchEvent(new CustomEvent('mobileMenuOpened'));
        }

        // Close menu function
        function closeMenu() {
            mobileMenu.classList.remove('active');
            body.classList.remove('mobile-menu-open');
            
            // Reset hamburger
            hamburgerButtons.forEach(btn => {
                btn.classList.remove('active');
            });

            // Release focus trap
            releaseFocus();
            
            // Close all dropdowns
            closeAllDropdowns();
            
            // Dispatch custom event
            document.dispatchEvent(new CustomEvent('mobileMenuClosed'));
        }

        // Toggle menu function
        function toggleMenu() {
            if (mobileMenu.classList.contains('active')) {
                closeMenu();
            } else {
                openMenu();
            }
        }

        // Handle dropdown toggles
        function toggleDropdown(event) {
            event.preventDefault();
            const parent = this.parentElement;
            const wasOpen = parent.classList.contains('open');
            
            // Close all other dropdowns
            closeAllDropdowns();
            
            // Toggle current dropdown
            if (!wasOpen) {
                parent.classList.add('open');
                const dropdownMenu = parent.querySelector('.dropdown-menu');
                if (dropdownMenu) {
                    slideDown(dropdownMenu);
                }
            }
        }

        // Close all dropdowns
        function closeAllDropdowns() {
            document.querySelectorAll('.has-dropdown.open').forEach(dropdown => {
                dropdown.classList.remove('open');
                const dropdownMenu = dropdown.querySelector('.dropdown-menu');
                if (dropdownMenu) {
                    slideUp(dropdownMenu);
                }
            });
        }

        // Slide animations
        function slideDown(element) {
            element.style.display = 'block';
            const height = element.scrollHeight;
            element.style.maxHeight = '0';
            element.offsetHeight; // Force reflow
            element.style.maxHeight = height + 'px';
        }

        function slideUp(element) {
            element.style.maxHeight = element.scrollHeight + 'px';
            element.offsetHeight; // Force reflow
            element.style.maxHeight = '0';
            setTimeout(() => {
                element.style.display = 'none';
            }, 300);
        }

        // Focus trap for accessibility
        let focusableElements = [];
        let firstFocusableElement = null;
        let lastFocusableElement = null;

        function trapFocus(element) {
            focusableElements = element.querySelectorAll(
                'a[href], button, textarea, input, select, [tabindex]:not([tabindex="-1"])'
            );
            
            if (focusableElements.length > 0) {
                firstFocusableElement = focusableElements[0];
                lastFocusableElement = focusableElements[focusableElements.length - 1];
                
                document.addEventListener('keydown', handleFocusTrap);
                firstFocusableElement.focus();
            }
        }

        function releaseFocus() {
            document.removeEventListener('keydown', handleFocusTrap);
        }

        function handleFocusTrap(e) {
            if (e.key === 'Tab') {
                if (e.shiftKey) {
                    if (document.activeElement === firstFocusableElement) {
                        lastFocusableElement.focus();
                        e.preventDefault();
                    }
                } else {
                    if (document.activeElement === lastFocusableElement) {
                        firstFocusableElement.focus();
                        e.preventDefault();
                    }
                }
            }
            
            if (e.key === 'Escape') {
                closeMenu();
            }
        }

        // Event Listeners
        
        // Hamburger click
        hamburgerButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                toggleMenu();
            });
        });

        // Close button click
        if (closeButton) {
            closeButton.addEventListener('click', function(e) {
                e.preventDefault();
                closeMenu();
            });
        }

        // Overlay click
        if (overlay) {
            overlay.addEventListener('click', function(e) {
                e.preventDefault();
                closeMenu();
            });
        }

        // Dropdown toggles
        dropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', toggleDropdown);
        });

        // Close menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mobileMenu.classList.contains('active')) {
                closeMenu();
            }
        });

        // Handle window resize
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                if (window.innerWidth > 1199 && mobileMenu.classList.contains('active')) {
                    closeMenu();
                }
            }, 250);
        });

        // Prevent menu close when clicking inside menu panel
        const menuPanel = document.querySelector('.mobile-menu-panel');
        if (menuPanel) {
            menuPanel.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }

        // Handle swipe to close (for touch devices)
        let touchStartX = 0;
        let touchEndX = 0;

        if (menuPanel) {
            menuPanel.addEventListener('touchstart', function(e) {
                touchStartX = e.changedTouches[0].screenX;
            }, { passive: true });

            menuPanel.addEventListener('touchend', function(e) {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            }, { passive: true });
        }

        function handleSwipe() {
            const swipeThreshold = 100;
            const diff = touchStartX - touchEndX;
            
            // Swipe right to close (since menu is on right side)
            if (diff < -swipeThreshold) {
                closeMenu();
            }
        }

        // Initialize menu state
        closeMenu();
        
        console.log('Mobile menu initialized successfully');
    }

    // Expose functions globally if needed
    window.mobileMenu = {
        open: function() {
            const menu = document.getElementById('mobileMenu');
            if (menu) {
                menu.classList.add('active');
                document.body.classList.add('mobile-menu-open');
            }
        },
        close: function() {
            const menu = document.getElementById('mobileMenu');
            if (menu) {
                menu.classList.remove('active');
                document.body.classList.remove('mobile-menu-open');
            }
        },
        toggle: function() {
            const menu = document.getElementById('mobileMenu');
            if (menu) {
                if (menu.classList.contains('active')) {
                    this.close();
                } else {
                    this.open();
                }
            }
        }
    };

})();