/**
 * Form Validation
 * Client-side form validation
 */

(function() {
    'use strict';

    /**
     * Validator Class
     */
    class Validator {
        constructor(form) {
            this.form = form;
            this.errors = {};
        }

        /**
         * Required Field Validation
         */
        required(fieldName, message = 'This field is required') {
            const field = this.form.elements[fieldName];
            if (!field) return this;

            const value = field.value.trim();
            if (value === '') {
                this.addError(fieldName, message);
            }

            return this;
        }

        /**
         * Email Validation
         */
        email(fieldName, message = 'Please enter a valid email address') {
            const field = this.form.elements[fieldName];
            if (!field) return this;

            const value = field.value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (value && !emailRegex.test(value)) {
                this.addError(fieldName, message);
            }

            return this;
        }

        /**
         * Minimum Length Validation
         */
        minLength(fieldName, min, message = null) {
            const field = this.form.elements[fieldName];
            if (!field) return this;

            const value = field.value.trim();
            if (value.length > 0 && value.length < min) {
                this.addError(fieldName, message || `Minimum length is ${min} characters`);
            }

            return this;
        }

        /**
         * Maximum Length Validation
         */
        maxLength(fieldName, max, message = null) {
            const field = this.form.elements[fieldName];
            if (!field) return this;

            const value = field.value.trim();
            if (value.length > max) {
                this.addError(fieldName, message || `Maximum length is ${max} characters`);
            }

            return this;
        }

        /**
         * Numeric Validation
         */
        numeric(fieldName, message = 'Please enter a valid number') {
            const field = this.form.elements[fieldName];
            if (!field) return this;

            const value = field.value.trim();
            if (value && isNaN(value)) {
                this.addError(fieldName, message);
            }

            return this;
        }

        /**
         * Positive Number Validation
         */
        positive(fieldName, message = 'Please enter a positive number') {
            const field = this.form.elements[fieldName];
            if (!field) return this;

            const value = parseFloat(field.value);
            if (!isNaN(value) && value <= 0) {
                this.addError(fieldName, message);
            }

            return this;
        }

        /**
         * Minimum Value Validation
         */
        min(fieldName, min, message = null) {
            const field = this.form.elements[fieldName];
            if (!field) return this;

            const value = parseFloat(field.value);
            if (!isNaN(value) && value < min) {
                this.addError(fieldName, message || `Minimum value is ${min}`);
            }

            return this;
        }

        /**
         * Maximum Value Validation
         */
        max(fieldName, max, message = null) {
            const field = this.form.elements[fieldName];
            if (!field) return this;

            const value = parseFloat(field.value);
            if (!isNaN(value) && value > max) {
                this.addError(fieldName, message || `Maximum value is ${max}`);
            }

            return this;
        }

        /**
         * Password Strength Validation
         */
        passwordStrength(fieldName, message = 'Password is too weak') {
            const field = this.form.elements[fieldName];
            if (!field) return this;

            const value = field.value;
            const hasUpperCase = /[A-Z]/.test(value);
            const hasLowerCase = /[a-z]/.test(value);
            const hasNumbers = /\d/.test(value);
            const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(value);
            const minLength = value.length >= 8;

            if (value && (!minLength || !hasUpperCase || !hasLowerCase || !hasNumbers || !hasSpecialChar)) {
                this.addError(fieldName, message);
            }

            return this;
        }

        /**
         * Password Match Validation
         */
        matchesField(fieldName, matchFieldName, message = 'Fields do not match') {
            const field = this.form.elements[fieldName];
            const matchField = this.form.elements[matchFieldName];
            
            if (!field || !matchField) return this;

            if (field.value !== matchField.value) {
                this.addError(fieldName, message);
            }

            return this;
        }

        /**
         * Custom Validation
         */
        custom(fieldName, validator, message) {
            const field = this.form.elements[fieldName];
            if (!field) return this;

            if (!validator(field.value)) {
                this.addError(fieldName, message);
            }

            return this;
        }

        /**
         * Add Error
         */
        addError(fieldName, message) {
            if (!this.errors[fieldName]) {
                this.errors[fieldName] = [];
            }
            this.errors[fieldName].push(message);
        }

        /**
         * Display Errors
         */
        displayErrors() {
            // Clear previous errors
            this.clearErrors();

            for (let fieldName in this.errors) {
                const field = this.form.elements[fieldName];
                if (!field) continue;

                const errorMessages = this.errors[fieldName];
                const errorDiv = document.createElement('div');
                errorDiv.className = 'field-error';
                errorDiv.textContent = errorMessages[0];

                // Add error class to field
                field.classList.add('is-invalid');

                // Insert error message after field
                field.parentNode.appendChild(errorDiv);
            }
        }

        /**
         * Clear Errors
         */
        clearErrors() {
            // Remove error classes
            const invalidFields = this.form.querySelectorAll('.is-invalid');
            invalidFields.forEach(field => {
                field.classList.remove('is-invalid');
            });

            // Remove error messages
            const errorDivs = this.form.querySelectorAll('.field-error');
            errorDivs.forEach(div => {
                div.remove();
            });

            this.errors = {};
        }

        /**
         * Check if Valid
         */
        isValid() {
            return Object.keys(this.errors).length === 0;
        }

        /**
         * Get Errors
         */
        getErrors() {
            return this.errors;
        }
    }

    // Make Validator globally available
    window.Validator = Validator;

    /**
     * Real-time Validation
     */
    function initRealtimeValidation() {
        const forms = document.querySelectorAll('form[data-validate]');

        forms.forEach(form => {
            const inputs = form.querySelectorAll('input, textarea, select');

            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    validateField(this);
                });

                input.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid')) {
                        validateField(this);
                    }
                });
            });
        });
    }

    /**
     * Validate Single Field
     */
    function validateField(field) {
        const form = field.form;
        const validator = new Validator(form);
        const fieldName = field.name;

        // Clear previous error for this field
        field.classList.remove('is-invalid');
        const existingError = field.parentNode.querySelector('.field-error');
        if (existingError) {
            existingError.remove();
        }

        // Check required
        if (field.hasAttribute('required')) {
            validator.required(fieldName);
        }

        // Check type-specific validations
        if (field.type === 'email') {
            validator.email(fieldName);
        }

        if (field.type === 'number') {
            validator.numeric(fieldName);
            
            if (field.hasAttribute('min')) {
                validator.min(fieldName, parseFloat(field.getAttribute('min')));
            }
            
            if (field.hasAttribute('max')) {
                validator.max(fieldName, parseFloat(field.getAttribute('max')));
            }
        }

        // Check pattern
        if (field.hasAttribute('pattern')) {
            const pattern = new RegExp(field.getAttribute('pattern'));
            validator.custom(fieldName, (value) => pattern.test(value), 
                'Please match the requested format');
        }

        // Check minlength
        if (field.hasAttribute('minlength')) {
            validator.minLength(fieldName, parseInt(field.getAttribute('minlength')));
        }

        // Check maxlength
        if (field.hasAttribute('maxlength')) {
            validator.maxLength(fieldName, parseInt(field.getAttribute('maxlength')));
        }

        // Display errors for this field only
        if (!validator.isValid()) {
            const errorMessages = validator.getErrors()[fieldName];
            if (errorMessages) {
                field.classList.add('is-invalid');
                const errorDiv = document.createElement('div');
                errorDiv.className = 'field-error';
                errorDiv.textContent = errorMessages[0];
                field.parentNode.appendChild(errorDiv);
            }
        }
    }

    /**
     * Password Strength Indicator
     */
    function initPasswordStrength() {
        const passwordFields = document.querySelectorAll('input[type="password"][data-strength]');

        passwordFields.forEach(field => {
            const strengthBar = document.createElement('div');
            strengthBar.className = 'password-strength';
            strengthBar.innerHTML = '<div class="password-strength-bar"></div>';

            const strengthText = document.createElement('div');
            strengthText.className = 'password-strength-text';

            field.parentNode.appendChild(strengthBar);
            field.parentNode.appendChild(strengthText);

            field.addEventListener('input', function() {
                const strength = calculatePasswordStrength(this.value);
                updateStrengthIndicator(strengthBar, strengthText, strength);
            });
        });
    }

    /**
     * Calculate Password Strength
     */
    function calculatePasswordStrength(password) {
        let strength = 0;

        if (password.length >= 8) strength++;
        if (password.length >= 12) strength++;
        if (/[a-z]/.test(password)) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^a-zA-Z0-9]/.test(password)) strength++;

        if (strength <= 2) return { level: 'weak', text: 'Weak' };
        if (strength <= 4) return { level: 'medium', text: 'Medium' };
        return { level: 'strong', text: 'Strong' };
    }

    /**
     * Update Strength Indicator
     */
    function updateStrengthIndicator(strengthBar, strengthText, strength) {
        const bar = strengthBar.querySelector('.password-strength-bar');
        bar.className = `password-strength-bar ${strength.level}`;
        strengthText.textContent = `Password strength: ${strength.text}`;
    }

    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        initRealtimeValidation();
        initPasswordStrength();
    });

})();