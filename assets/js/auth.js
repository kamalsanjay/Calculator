/**
 * Authentication JavaScript
 * Login, Register, Password functionality
 */

(function() {
    'use strict';

    /**
     * Password Toggle
     */
    function initPasswordToggle() {
        const toggleButtons = document.querySelectorAll('.password-toggle-btn');

        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentElement.querySelector('input');
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    }

    /**
     * Password Strength
     */
    function initPasswordStrength() {
        const passwordInputs = document.querySelectorAll('input[name="password"]');

        passwordInputs.forEach(input => {
            const strengthBar = input.parentElement.querySelector('.password-strength-bar');
            const strengthText = input.parentElement.querySelector('.password-strength-text');

            if (strengthBar) {
                input.addEventListener('input', function() {
                    const strength = calculatePasswordStrength(this.value);
                    updatePasswordStrength(strengthBar, strengthText, strength);
                });
            }
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

        if (strength <= 2) return 'weak';
        if (strength <= 4) return 'medium';
        return 'strong';
    }

    /**
     * Update Password Strength UI
     */
    function updatePasswordStrength(bar, text, strength) {
        bar.className = `password-strength-bar ${strength}`;
        
        if (text) {
            const messages = {
                'weak': 'Weak password',
                'medium': 'Medium password',
                'strong': 'Strong password'
            };
            text.textContent = messages[strength];
        }
    }

    /**
     * Form Submission
     */
    function initAuthForms() {
        const authForms = document.querySelectorAll('.auth-form');

        authForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const submitBtn = this.querySelector('.auth-submit');
                const originalText = submitBtn.textContent;

                // Disable button and show loading
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';

                // Get form data
                const formData = new FormData(this);

                // Submit form
                fetch(this.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            showNotification(data.message || 'Success!', 'success');
                        }
                    } else {
                        showNotification(data.message || 'An error occurred', 'error');
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                    }
                })
                .catch(error => {
                    console.error('Form submission error:', error);
                    showNotification('An error occurred. Please try again.', 'error');
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                });
            });
        });
    }

    /**
     * Social Login
     */
    function initSocialLogin() {
        const socialButtons = document.querySelectorAll('.auth-social-btn');

        socialButtons.forEach(button => {
            button.addEventListener('click', function() {
                const provider = this.dataset.provider;
                window.location.href = `/auth/social/${provider}`;
            });
        });
    }

    /**
     * Verification Code Input
     */
    function initVerificationCode() {
        const codeInputs = document.querySelectorAll('.verification-code input');

        codeInputs.forEach((input, index) => {
            input.addEventListener('input', function() {
                if (this.value.length === 1 && index < codeInputs.length - 1) {
                    codeInputs[index + 1].focus();
                }

                // Check if all fields are filled
                const allFilled = Array.from(codeInputs).every(inp => inp.value.length === 1);
                if (allFilled) {
                    submitVerificationCode(codeInputs);
                }
            });

            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && this.value === '' && index > 0) {
                    codeInputs[index - 1].focus();
                }
            });

            input.addEventListener('paste', function(e) {
                e.preventDefault();
                const pastedData = e.clipboardData.getData('text');
                const digits = pastedData.replace(/\D/g, '').split('');

                digits.forEach((digit, i) => {
                    if (index + i < codeInputs.length) {
                        codeInputs[index + i].value = digit;
                    }
                });

                // Focus last filled input
                const lastIndex = Math.min(index + digits.length - 1, codeInputs.length - 1);
                codeInputs[lastIndex].focus();
            });
        });
    }

    /**
     * Submit Verification Code
     */
    function submitVerificationCode(inputs) {
        const code = Array.from(inputs).map(input => input.value).join('');
        
        fetch('/auth/verify-code', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ code: code })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect || '/';
            } else {
                showNotification(data.message || 'Invalid code', 'error');
                inputs.forEach(input => input.value = '');
                inputs[0].focus();
            }
        })
        .catch(error => {
            console.error('Verification error:', error);
            showNotification('Verification failed', 'error');
        });
    }

    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        initPasswordToggle();
        initPasswordStrength();
        initAuthForms();
        initSocialLogin();
        initVerificationCode();
    });

})();