/**
 * Contact Form Validation and Error Handling
 * Provides client-side validation for all contact forms
 */

(function($) {
    'use strict';

    // Configuration
    const config = {
        blockedAreaCodes: ['123', '000', '111', '555'],
        minNameLength: 2,
        minMessageLength: 10,
        minPhoneDigits: 10,
        maxRetries: 3,
        retryDelay: 1000
    };

    // Form validators
    const validators = {
        name: function(value) {
            if (!value || value.trim().length < config.minNameLength) {
                return 'Name must be at least 2 characters';
            }
            if (!/^[a-zA-Z\s'\-]+$/.test(value)) {
                return 'Name can only contain letters, spaces, apostrophes, and hyphens';
            }
            return null;
        },

        email: function(value) {
            if (!value) return null; // Email might be optional
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                return 'Please enter a valid email address';
            }
            return null;
        },

        phone: function(value) {
            if (!value) return 'Phone number is required';
            
            const digitsOnly = value.replace(/\D/g, '');
            
            if (digitsOnly.length < config.minPhoneDigits) {
                return 'Phone number must be at least 10 digits';
            }
            
            const areaCode = digitsOnly.substring(0, 3);
            if (config.blockedAreaCodes.includes(areaCode)) {
                return `Area code ${areaCode} is not valid. Please enter a valid phone number.`;
            }
            
            return null;
        },

        message: function(value, required = false) {
            if (!value && required) {
                return 'Message is required';
            }
            if (value && value.trim().length < config.minMessageLength) {
                return 'Message must be at least 10 characters';
            }
            return null;
        },

        service: function(value) {
            if (!value || value === '') {
                return 'Please select a service';
            }
            return null;
        }
    };

    // Error display functions
    const errorDisplay = {
        show: function($field, message) {
            // Remove any existing error
            this.clear($field);
            
            // Add error class
            $field.addClass('error');
            
            // Create and insert error message
            const $error = $('<span class="error-message">' + message + '</span>');
            $error.css({
                'color': '#dc3545',
                'font-size': '12px',
                'display': 'block',
                'margin-top': '5px'
            });
            $field.closest('.col-sm-12, .col-sm-6').append($error);
        },

        clear: function($field) {
            $field.removeClass('error');
            $field.closest('.col-sm-12, .col-sm-6').find('.error-message').remove();
        },

        clearAll: function($form) {
            $form.find('.error').removeClass('error');
            $form.find('.error-message').remove();
        }
    };

    // Form submission handler
    const formHandler = {
        submitAttempts: {},

        validateForm: function($form) {
            let isValid = true;
            errorDisplay.clearAll($form);

            // Validate based on form type
            const formType = this.detectFormType($form);
            
            switch(formType) {
                case 'homepage':
                    isValid = this.validateHomepageForm($form) && isValid;
                    break;
                case 'contact':
                    isValid = this.validateContactForm($form) && isValid;
                    break;
                case 'service':
                    isValid = this.validateServiceForm($form) && isValid;
                    break;
                case 'newsletter':
                    isValid = this.validateNewsletterForm($form) && isValid;
                    break;
                case 'investor':
                    isValid = this.validateInvestorForm($form) && isValid;
                    break;
            }

            return isValid;
        },

        detectFormType: function($form) {
            if ($form.find('input[name="type"][value="appointment"]').length) return 'homepage';
            if ($form.find('input[name="type"][value="newsletter"]').length) return 'newsletter';
            if ($form.find('input[name="fname"]').length) return 'service';
            if ($form.find('input[name="investment_interest"]').length) return 'investor';
            return 'contact';
        },

        validateHomepageForm: function($form) {
            let isValid = true;

            // Name validation
            const $name = $form.find('input[name="name"]');
            const nameError = validators.name($name.val());
            if (nameError) {
                errorDisplay.show($name, nameError);
                isValid = false;
            }

            // Phone validation
            const $phone = $form.find('input[name="phone"]');
            const phoneError = validators.phone($phone.val());
            if (phoneError) {
                errorDisplay.show($phone, phoneError);
                isValid = false;
            }

            // Email validation (optional)
            const $email = $form.find('input[name="address"]');
            if ($email.val()) {
                const emailError = validators.email($email.val());
                if (emailError) {
                    errorDisplay.show($email, emailError);
                    isValid = false;
                }
            }

            // Service validation
            const $service = $form.find('select[name="service"]');
            const serviceError = validators.service($service.val());
            if (serviceError) {
                errorDisplay.show($service, serviceError);
                isValid = false;
            }

            // Message validation (optional)
            const $message = $form.find('textarea[name="message"]');
            const messageError = validators.message($message.val(), false);
            if (messageError) {
                errorDisplay.show($message, messageError);
                isValid = false;
            }

            return isValid;
        },

        validateContactForm: function($form) {
            return this.validateHomepageForm($form); // Same validation
        },

        validateServiceForm: function($form) {
            let isValid = true;

            // Name validation
            const $fname = $form.find('input[name="fname"]');
            const nameError = validators.name($fname.val());
            if (nameError) {
                errorDisplay.show($fname, nameError);
                isValid = false;
            }

            // Phone validation (optional)
            const $phone = $form.find('input[name="pnumber"]');
            if ($phone.val()) {
                const phoneError = validators.phone($phone.val());
                if (phoneError) {
                    errorDisplay.show($phone, phoneError);
                    isValid = false;
                }
            }

            // Message validation (required)
            const $message = $form.find('textarea[name="message"]');
            const messageError = validators.message($message.val(), true);
            if (messageError) {
                errorDisplay.show($message, messageError);
                isValid = false;
            }

            return isValid;
        },

        validateNewsletterForm: function($form) {
            let isValid = true;

            // Email validation
            const $email = $form.find('input[name="email"]');
            const emailError = validators.email($email.val());
            if (!$email.val()) {
                errorDisplay.show($email, 'Email address is required');
                isValid = false;
            } else if (emailError) {
                errorDisplay.show($email, emailError);
                isValid = false;
            }

            return isValid;
        },

        validateInvestorForm: function($form) {
            let isValid = true;

            // Name validation
            const $name = $form.find('input[name="name"]');
            const nameError = validators.name($name.val());
            if (nameError) {
                errorDisplay.show($name, nameError);
                isValid = false;
            }

            // Email validation
            const $email = $form.find('input[name="email"]');
            if (!$email.val()) {
                errorDisplay.show($email, 'Email address is required');
                isValid = false;
            } else {
                const emailError = validators.email($email.val());
                if (emailError) {
                    errorDisplay.show($email, emailError);
                    isValid = false;
                }
            }

            // Phone validation
            const $phone = $form.find('input[name="phone"]');
            const phoneError = validators.phone($phone.val());
            if (phoneError) {
                errorDisplay.show($phone, phoneError);
                isValid = false;
            }

            // Investment interest validation
            const $interest = $form.find('select[name="investment_interest"]');
            if (!$interest.val()) {
                errorDisplay.show($interest, 'Please select your investment interest');
                isValid = false;
            }

            return isValid;
        },

        handleSubmit: function(e) {
            const $form = $(this);
            const formId = $form.attr('id') || 'contact-form';

            // Validate form
            if (!formHandler.validateForm($form)) {
                e.preventDefault();
                
                // Scroll to first error
                const $firstError = $form.find('.error').first();
                if ($firstError.length) {
                    $('html, body').animate({
                        scrollTop: $firstError.offset().top - 100
                    }, 500);
                }
                
                return false;
            }

            // Add loading state
            const $submitBtn = $form.find('button[type="submit"]');
            const originalText = $submitBtn.html();
            $submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Sending...');

            // Track submission attempts
            if (!formHandler.submitAttempts[formId]) {
                formHandler.submitAttempts[formId] = 0;
            }
            formHandler.submitAttempts[formId]++;

            // Re-enable button after submission (in case of error)
            setTimeout(function() {
                $submitBtn.prop('disabled', false).html(originalText);
            }, 5000);

            return true;
        }
    };

    // Phone number formatting
    const phoneFormatter = {
        format: function(value) {
            const cleaned = value.replace(/\D/g, '');
            const match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/);
            if (match) {
                return '(' + match[1] + ') ' + match[2] + '-' + match[3];
            }
            return value;
        },

        init: function() {
            $('input[name="phone"], input[name="pnumber"]').on('blur', function() {
                const $this = $(this);
                const formatted = phoneFormatter.format($this.val());
                $this.val(formatted);
            });
        }
    };

    // Real-time validation
    const realtimeValidation = {
        init: function() {
            // Name fields
            $('input[name="name"], input[name="fname"]').on('blur', function() {
                const $this = $(this);
                const error = validators.name($this.val());
                if (error) {
                    errorDisplay.show($this, error);
                } else {
                    errorDisplay.clear($this);
                }
            });

            // Email fields
            $('input[name="email"], input[name="address"]').on('blur', function() {
                const $this = $(this);
                if ($this.val()) {
                    const error = validators.email($this.val());
                    if (error) {
                        errorDisplay.show($this, error);
                    } else {
                        errorDisplay.clear($this);
                    }
                }
            });

            // Phone fields
            $('input[name="phone"], input[name="pnumber"]').on('blur', function() {
                const $this = $(this);
                if ($this.val()) {
                    const error = validators.phone($this.val());
                    if (error) {
                        errorDisplay.show($this, error);
                    } else {
                        errorDisplay.clear($this);
                    }
                }
            });

            // Message fields
            $('textarea[name="message"]').on('blur', function() {
                const $this = $(this);
                if ($this.val()) {
                    const error = validators.message($this.val(), $this.prop('required'));
                    if (error) {
                        errorDisplay.show($this, error);
                    } else {
                        errorDisplay.clear($this);
                    }
                }
            });
        }
    };

    // Initialize on document ready
    $(document).ready(function() {
        // Attach submit handler to all forms
        $('form[action*="contact"]').on('submit', formHandler.handleSubmit);
        
        // Initialize phone formatter
        phoneFormatter.init();
        
        // Initialize real-time validation
        realtimeValidation.init();

        // Clear errors on input focus
        $('input, textarea, select').on('focus', function() {
            errorDisplay.clear($(this));
        });

        // Prevent double submission
        $('form').on('submit', function() {
            const $form = $(this);
            if ($form.data('submitted') === true) {
                return false;
            }
            $form.data('submitted', true);
            
            // Reset flag after 5 seconds
            setTimeout(function() {
                $form.data('submitted', false);
            }, 5000);
        });
    });

})(jQuery);