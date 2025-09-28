/**
 * Accessibility Enhancement JavaScript
 * Provides keyboard navigation, ARIA management, and focus handling
 */

(function() {
    'use strict';

    // ========================================
    // 1. Skip Links Implementation
    // ========================================
    function initSkipLinks() {
        const skipLink = document.querySelector('.skip-link');
        if (skipLink) {
            skipLink.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.tabIndex = -1;
                    target.focus();
                }
            });
        }
    }

    // ========================================
    // 2. Keyboard Navigation Manager
    // ========================================
    class KeyboardNavigation {
        constructor() {
            this.isKeyboardNav = false;
            this.init();
        }

        init() {
            // Detect keyboard vs mouse navigation
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Tab') {
                    this.enableKeyboardNav();
                }
            });

            document.addEventListener('mousedown', () => {
                this.disableKeyboardNav();
            });

            // Handle escape key for modals and dropdowns
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    this.handleEscape();
                }
            });

            // Arrow key navigation for menus
            this.initMenuNavigation();

            // Tab trap for modals
            this.initModalTabTrap();
        }

        enableKeyboardNav() {
            if (!this.isKeyboardNav) {
                this.isKeyboardNav = true;
                document.body.classList.add('keyboard-focus-visible');
            }
        }

        disableKeyboardNav() {
            if (this.isKeyboardNav) {
                this.isKeyboardNav = false;
                document.body.classList.remove('keyboard-focus-visible');
            }
        }

        handleEscape() {
            // Close modals
            const activeModal = document.querySelector('[role="dialog"][aria-hidden="false"]');
            if (activeModal) {
                this.closeModal(activeModal);
            }

            // Close dropdowns
            const activeDropdown = document.querySelector('[aria-expanded="true"]');
            if (activeDropdown) {
                activeDropdown.setAttribute('aria-expanded', 'false');
            }
        }

        initMenuNavigation() {
            const menus = document.querySelectorAll('[role="menu"], [role="menubar"]');

            menus.forEach(menu => {
                const menuItems = menu.querySelectorAll('[role="menuitem"]');

                menuItems.forEach((item, index) => {
                    item.addEventListener('keydown', (e) => {
                        switch(e.key) {
                            case 'ArrowDown':
                                e.preventDefault();
                                const nextIndex = (index + 1) % menuItems.length;
                                menuItems[nextIndex].focus();
                                break;
                            case 'ArrowUp':
                                e.preventDefault();
                                const prevIndex = (index - 1 + menuItems.length) % menuItems.length;
                                menuItems[prevIndex].focus();
                                break;
                            case 'Home':
                                e.preventDefault();
                                menuItems[0].focus();
                                break;
                            case 'End':
                                e.preventDefault();
                                menuItems[menuItems.length - 1].focus();
                                break;
                        }
                    });
                });
            });
        }

        initModalTabTrap() {
            const modals = document.querySelectorAll('[role="dialog"]');

            modals.forEach(modal => {
                modal.addEventListener('keydown', (e) => {
                    if (e.key === 'Tab') {
                        this.trapFocus(e, modal);
                    }
                });
            });
        }

        trapFocus(e, container) {
            const focusableElements = container.querySelectorAll(
                'a[href], button, textarea, input[type="text"], input[type="radio"], input[type="checkbox"], select, [tabindex]:not([tabindex="-1"])'
            );
            const firstFocusable = focusableElements[0];
            const lastFocusable = focusableElements[focusableElements.length - 1];

            if (e.shiftKey) {
                if (document.activeElement === firstFocusable) {
                    e.preventDefault();
                    lastFocusable.focus();
                }
            } else {
                if (document.activeElement === lastFocusable) {
                    e.preventDefault();
                    firstFocusable.focus();
                }
            }
        }

        closeModal(modal) {
            modal.setAttribute('aria-hidden', 'true');
            const trigger = document.querySelector(`[aria-controls="${modal.id}"]`);
            if (trigger) {
                trigger.focus();
            }
        }
    }

    // ========================================
    // 3. Form Validation with ARIA
    // ========================================
    class AccessibleFormValidation {
        constructor(form) {
            this.form = form;
            this.init();
        }

        init() {
            if (!this.form) return;

            // Real-time validation
            const inputs = this.form.querySelectorAll('input, textarea, select');

            inputs.forEach(input => {
                // Validate on blur
                input.addEventListener('blur', () => {
                    this.validateField(input);
                });

                // Clear error on input
                input.addEventListener('input', () => {
                    this.clearFieldError(input);
                });
            });

            // Form submission validation
            this.form.addEventListener('submit', (e) => {
                if (!this.validateForm()) {
                    e.preventDefault();
                    this.focusFirstError();
                }
            });
        }

        validateField(field) {
            const isValid = field.checkValidity();

            if (!isValid) {
                this.showFieldError(field);
            } else {
                this.clearFieldError(field);
            }

            return isValid;
        }

        validateForm() {
            const inputs = this.form.querySelectorAll('input, textarea, select');
            let isValid = true;

            inputs.forEach(input => {
                if (!this.validateField(input)) {
                    isValid = false;
                }
            });

            return isValid;
        }

        showFieldError(field) {
            field.setAttribute('aria-invalid', 'true');
            field.classList.add('is-invalid');

            const errorId = field.id + '-error';
            let errorElement = document.getElementById(errorId);

            if (!errorElement) {
                errorElement = document.createElement('span');
                errorElement.id = errorId;
                errorElement.className = 'invalid-feedback';
                errorElement.setAttribute('role', 'alert');
                field.parentNode.appendChild(errorElement);
            }

            errorElement.textContent = field.validationMessage;

            // Update aria-describedby
            const describedBy = field.getAttribute('aria-describedby') || '';
            if (!describedBy.includes(errorId)) {
                field.setAttribute('aria-describedby', (describedBy + ' ' + errorId).trim());
            }

            // Announce error to screen readers
            this.announceError(field.validationMessage);
        }

        clearFieldError(field) {
            field.setAttribute('aria-invalid', 'false');
            field.classList.remove('is-invalid');

            const errorId = field.id + '-error';
            const errorElement = document.getElementById(errorId);

            if (errorElement) {
                errorElement.textContent = '';
            }

            // Update aria-describedby
            const describedBy = field.getAttribute('aria-describedby') || '';
            field.setAttribute('aria-describedby', describedBy.replace(errorId, '').trim());
        }

        focusFirstError() {
            const firstError = this.form.querySelector('[aria-invalid="true"]');
            if (firstError) {
                firstError.focus();
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }

        announceError(message) {
            const announcement = document.createElement('div');
            announcement.setAttribute('role', 'alert');
            announcement.setAttribute('aria-live', 'assertive');
            announcement.className = 'sr-only';
            announcement.textContent = message;

            document.body.appendChild(announcement);

            setTimeout(() => {
                document.body.removeChild(announcement);
            }, 1000);
        }
    }

    // ========================================
    // 4. Character Counter
    // ========================================
    function initCharacterCounters() {
        const textareas = document.querySelectorAll('[data-character-count]');

        textareas.forEach(textarea => {
            const maxLength = parseInt(textarea.dataset.maxLength);
            const counterId = textarea.getAttribute('aria-describedby');
            const counter = document.getElementById(counterId);

            if (counter) {
                const updateCounter = () => {
                    const currentLength = textarea.value.length;
                    const remaining = maxLength - currentLength;

                    counter.querySelector('.current-count').textContent = currentLength;

                    // Update counter state
                    counter.classList.remove('warning', 'error');
                    if (remaining < 20) {
                        counter.classList.add('warning');
                    }
                    if (remaining < 0) {
                        counter.classList.add('error');
                    }

                    // Update ARIA live region
                    if (remaining === 20 || remaining === 10 || remaining === 0) {
                        counter.setAttribute('aria-live', 'polite');
                        counter.textContent = `${remaining} characters remaining`;
                        setTimeout(() => {
                            counter.textContent = `${currentLength} / ${maxLength} characters`;
                        }, 2000);
                    }
                };

                textarea.addEventListener('input', updateCounter);
                updateCounter();
            }
        });
    }

    // ========================================
    // 5. Tab Panel Navigation
    // ========================================
    function initTabPanels() {
        const tabLists = document.querySelectorAll('[role="tablist"]');

        tabLists.forEach(tabList => {
            const tabs = tabList.querySelectorAll('[role="tab"]');
            const panels = [];

            tabs.forEach(tab => {
                const panelId = tab.getAttribute('aria-controls');
                const panel = document.getElementById(panelId);
                if (panel) {
                    panels.push(panel);
                }
            });

            tabs.forEach((tab, index) => {
                tab.addEventListener('click', () => {
                    activateTab(tabs, panels, index);
                });

                tab.addEventListener('keydown', (e) => {
                    let newIndex = index;

                    switch(e.key) {
                        case 'ArrowRight':
                            newIndex = (index + 1) % tabs.length;
                            break;
                        case 'ArrowLeft':
                            newIndex = (index - 1 + tabs.length) % tabs.length;
                            break;
                        case 'Home':
                            newIndex = 0;
                            break;
                        case 'End':
                            newIndex = tabs.length - 1;
                            break;
                        default:
                            return;
                    }

                    e.preventDefault();
                    activateTab(tabs, panels, newIndex);
                    tabs[newIndex].focus();
                });
            });
        });
    }

    function activateTab(tabs, panels, index) {
        // Deactivate all tabs
        tabs.forEach((tab, i) => {
            tab.setAttribute('aria-selected', i === index ? 'true' : 'false');
            tab.setAttribute('tabindex', i === index ? '0' : '-1');
        });

        // Hide all panels
        panels.forEach((panel, i) => {
            panel.hidden = i !== index;
        });
    }

    // ========================================
    // 6. Live Region Announcements
    // ========================================
    class LiveAnnouncer {
        constructor() {
            this.createLiveRegion();
        }

        createLiveRegion() {
            this.liveRegion = document.createElement('div');
            this.liveRegion.setAttribute('aria-live', 'polite');
            this.liveRegion.setAttribute('aria-atomic', 'true');
            this.liveRegion.className = 'sr-only';
            document.body.appendChild(this.liveRegion);
        }

        announce(message, priority = 'polite') {
            this.liveRegion.setAttribute('aria-live', priority);
            this.liveRegion.textContent = message;

            // Clear after announcement
            setTimeout(() => {
                this.liveRegion.textContent = '';
            }, 1000);
        }
    }

    // ========================================
    // 7. Focus Management
    // ========================================
    class FocusManager {
        constructor() {
            this.previousFocus = null;
        }

        saveFocus() {
            this.previousFocus = document.activeElement;
        }

        restoreFocus() {
            if (this.previousFocus && this.previousFocus.focus) {
                this.previousFocus.focus();
            }
        }

        focusFirstElement(container) {
            const focusable = container.querySelector(
                'a[href], button, textarea, input[type="text"], input[type="radio"], input[type="checkbox"], select, [tabindex]:not([tabindex="-1"])'
            );
            if (focusable) {
                focusable.focus();
            }
        }
    }

    // ========================================
    // 8. Initialize Everything
    // ========================================
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize components
        initSkipLinks();
        initCharacterCounters();
        initTabPanels();

        // Initialize managers
        window.keyboardNav = new KeyboardNavigation();
        window.liveAnnouncer = new LiveAnnouncer();
        window.focusManager = new FocusManager();

        // Initialize form validation
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            new AccessibleFormValidation(form);
        });

        // Add loaded class for CSS
        document.body.classList.add('a11y-enhanced');
    });

})();