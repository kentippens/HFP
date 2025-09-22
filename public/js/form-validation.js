/**
 * Comprehensive Form Validation Library
 * Handles client-side validation for all contact forms
 */

(function() {
    'use strict';

    // Validation patterns
    const patterns = {
        email: /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
        phone: /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/,
        phoneClean: /^\d{10,}$/,
        name: /^[a-zA-Z\s'-]{2,}$/,
        url: /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/,
        alphanumeric: /^[a-zA-Z0-9]+$/,
        number: /^\d+$/
    };

    // Blocked phone area codes
    const blockedAreaCodes = ['123', '000', '111', '555'];

    // Validation rules
    const validationRules = {
        name: {
            required: true,
            minLength: 2,
            maxLength: 255,
            pattern: patterns.name,
            message: 'Please enter a valid name (letters, spaces, hyphens, and apostrophes only)'
        },
        email: {
            required: true,
            pattern: patterns.email,
            maxLength: 255,
            message: 'Please enter a valid email address'
        },
        phone: {
            required: true,
            minLength: 10,
            maxLength: 20,
            pattern: patterns.phone,
            customValidator: validatePhone,
            message: 'Please enter a valid phone number'
        },
        message: {
            required: false,
            minLength: 10,
            maxLength: 2000,
            message: 'Message must be between 10 and 2000 characters'
        },
        service: {
            required: true,
            message: 'Please select a service'
        },
        company: {
            required: false,
            maxLength: 255,
            message: 'Company name cannot exceed 255 characters'
        },
        investment_interest: {
            required: true,
            message: 'Please select your investment interest'
        },
        investment_amount: {
            required: false,
            message: 'Please select a valid investment amount'
        }
    };

    // Custom phone validation
    function validatePhone(value) {
        // Remove all non-numeric characters
        const cleanPhone = value.replace(/\D/g, '');
        
        // Check minimum length
        if (cleanPhone.length < 10) {
            return { valid: false, message: 'Phone number must be at least 10 digits' };
        }
        
        // Check for blocked area codes
        const areaCode = cleanPhone.substring(0, 3);
        const usAreaCode = cleanPhone.length > 10 && cleanPhone[0] === '1' ? cleanPhone.substring(1, 4) : areaCode;
        
        if (blockedAreaCodes.includes(areaCode) || blockedAreaCodes.includes(usAreaCode)) {
            return { valid: false, message: `Area code ${areaCode} is not valid. Please enter a valid phone number.` };
        }
        
        return { valid: true };
    }

    // Validate a single field
    function validateField(field, rules) {
        const value = field.value.trim();
        const fieldName = field.name;
        
        if (!rules) return { valid: true };
        
        // Check required
        if (rules.required && !value) {
            return { valid: false, message: `This field is required` };
        }
        
        // Skip other validations if field is empty and not required
        if (!value && !rules.required) {
            return { valid: true };
        }
        
        // Check min length
        if (rules.minLength && value.length < rules.minLength) {
            return { valid: false, message: `Must be at least ${rules.minLength} characters` };
        }
        
        // Check max length
        if (rules.maxLength && value.length > rules.maxLength) {
            return { valid: false, message: `Cannot exceed ${rules.maxLength} characters` };
        }
        
        // Check pattern
        if (rules.pattern && !rules.pattern.test(value)) {
            return { valid: false, message: rules.message || 'Invalid format' };
        }
        
        // Run custom validator
        if (rules.customValidator) {
            const customResult = rules.customValidator(value);
            if (!customResult.valid) {
                return customResult;
            }
        }
        
        return { valid: true };
    }

    // Show field error
    function showFieldError(field, message) {
        // Remove any existing error
        clearFieldError(field);
        
        // Add error class to field
        field.classList.add('is-invalid', 'error');
        
        // Create error message element
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback error-message';
        errorDiv.textContent = message;
        errorDiv.style.color = '#dc3545';
        errorDiv.style.fontSize = '0.875em';
        errorDiv.style.marginTop = '0.25rem';
        
        // Insert error message after field
        if (field.parentNode.classList.contains('form-group') || field.parentNode.classList.contains('mb-3')) {
            field.parentNode.appendChild(errorDiv);
        } else {
            field.parentNode.insertBefore(errorDiv, field.nextSibling);
        }
    }

    // Clear field error
    function clearFieldError(field) {
        field.classList.remove('is-invalid', 'error');
        
        // Remove error message
        const errorMsg = field.parentNode.querySelector('.invalid-feedback, .error-message');
        if (errorMsg) {
            errorMsg.remove();
        }
    }

    // Show form success message
    function showFormSuccess(form, message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-success alert-dismissible fade show';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        `;
        
        // Insert at the beginning of the form
        form.insertBefore(alertDiv, form.firstChild);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }

    // Show form error message
    function showFormError(form, message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger alert-dismissible fade show';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        `;
        
        // Insert at the beginning of the form
        form.insertBefore(alertDiv, form.firstChild);
        
        // Auto-remove after 10 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 10000);
    }

    // Validate entire form
    function validateForm(form) {
        let isValid = true;
        const fields = form.querySelectorAll('input, select, textarea');
        
        fields.forEach(field => {
            // Skip hidden fields and buttons
            if (field.type === 'hidden' || field.type === 'submit' || field.type === 'button') {
                return;
            }
            
            const rules = validationRules[field.name];
            const result = validateField(field, rules);
            
            if (!result.valid) {
                showFieldError(field, result.message);
                isValid = false;
            } else {
                clearFieldError(field);
            }
        });
        
        return isValid;
    }

    // Handle form submission
    function handleFormSubmit(e) {
        const form = e.target;
        
        // Remove any existing alerts
        form.querySelectorAll('.alert').forEach(alert => alert.remove());
        
        // Validate form
        if (!validateForm(form)) {
            e.preventDefault();
            showFormError(form, 'Please correct the errors below and try again.');
            
            // Scroll to first error
            const firstError = form.querySelector('.is-invalid, .error');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
            
            return false;
        }
        
        // Add loading state to submit button
        const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            const originalText = submitBtn.textContent || submitBtn.value;
            if (submitBtn.tagName === 'BUTTON') {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
            } else {
                submitBtn.value = 'Submitting...';
            }
            
            // Restore button after 10 seconds (failsafe)
            setTimeout(() => {
                submitBtn.disabled = false;
                if (submitBtn.tagName === 'BUTTON') {
                    submitBtn.textContent = originalText;
                } else {
                    submitBtn.value = originalText;
                }
            }, 10000);
        }
        
        return true;
    }

    // Real-time validation on blur
    function handleFieldBlur(e) {
        const field = e.target;
        const rules = validationRules[field.name];
        
        if (rules) {
            const result = validateField(field, rules);
            if (!result.valid) {
                showFieldError(field, result.message);
            } else {
                clearFieldError(field);
            }
        }
    }

    // Clear error on input
    function handleFieldInput(e) {
        const field = e.target;
        if (field.classList.contains('is-invalid') || field.classList.contains('error')) {
            clearFieldError(field);
        }
    }

    // Initialize validation for all forms
    function initializeValidation() {
        // Find all contact forms
        const forms = document.querySelectorAll('form[action*="/contact"], form[action*="/investor"], form[action*="/lp/"]');
        
        forms.forEach(form => {
            // Skip newsletter forms
            if (form.querySelector('input[name="type"][value="newsletter"]')) {
                return;
            }
            
            // Add submit handler
            form.addEventListener('submit', handleFormSubmit);
            
            // Add field handlers
            const fields = form.querySelectorAll('input, select, textarea');
            fields.forEach(field => {
                if (field.type !== 'hidden' && field.type !== 'submit' && field.type !== 'button') {
                    field.addEventListener('blur', handleFieldBlur);
                    field.addEventListener('input', handleFieldInput);
                }
            });
        });
    }

    // Phone number formatting
    function formatPhoneNumber(input) {
        // Remove all non-numeric characters
        let value = input.value.replace(/\D/g, '');
        
        // Format as (XXX) XXX-XXXX
        if (value.length > 0) {
            if (value.length <= 3) {
                value = `(${value}`;
            } else if (value.length <= 6) {
                value = `(${value.slice(0, 3)}) ${value.slice(3)}`;
            } else if (value.length <= 10) {
                value = `(${value.slice(0, 3)}) ${value.slice(3, 6)}-${value.slice(6)}`;
            } else {
                value = `(${value.slice(0, 3)}) ${value.slice(3, 6)}-${value.slice(6, 10)}`;
            }
        }
        
        input.value = value;
    }

    // Initialize phone formatting
    function initializePhoneFormatting() {
        const phoneInputs = document.querySelectorAll('input[name="phone"], input[name="pnumber"]');
        phoneInputs.forEach(input => {
            input.addEventListener('input', function() {
                formatPhoneNumber(this);
            });
        });
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            initializeValidation();
            initializePhoneFormatting();
        });
    } else {
        initializeValidation();
        initializePhoneFormatting();
    }

    // Also initialize when Turbo/PJAX loads new content
    document.addEventListener('turbo:load', function() {
        initializeValidation();
        initializePhoneFormatting();
    });

    // Export for use in other scripts
    window.FormValidation = {
        validateForm: validateForm,
        validateField: validateField,
        showFieldError: showFieldError,
        clearFieldError: clearFieldError,
        showFormSuccess: showFormSuccess,
        showFormError: showFormError,
        formatPhoneNumber: formatPhoneNumber
    };

})();