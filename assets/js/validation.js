/**
 * Form Validation and Input Sanitization
 * Provides comprehensive validation and sanitization utilities
 * @version 1.0.0
 */

class Validator {
  /**
   * Validation rules
   */
  static rules = {
    required: (value) => value.trim() !== '',
    email: (value) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
    phone: (value) => /^[\d\s\-\(\)\+]+$/.test(value) && value.replace(/\D/g, '').length >= 10,
    url: (value) => /^https?:\/\/.+\..+/.test(value),
    number: (value) => !isNaN(parseFloat(value.replace(/,/g, ''))) && isFinite(value.replace(/,/g, '')),
    integer: (value) => /^-?\d+$/.test(value.replace(/,/g, '')),
    positive: (value) => parseFloat(value.replace(/,/g, '')) > 0,
    negative: (value) => parseFloat(value.replace(/,/g, '')) < 0,
    min: (value, min) => parseFloat(value.replace(/,/g, '')) >= min,
    max: (value, max) => parseFloat(value.replace(/,/g, '')) <= max,
    minLength: (value, length) => value.length >= length,
    maxLength: (value, length) => value.length <= length,
    pattern: (value, pattern) => new RegExp(pattern).test(value),
    alphanumeric: (value) => /^[a-zA-Z0-9]+$/.test(value),
    alpha: (value) => /^[a-zA-Z]+$/.test(value),
    date: (value) => !isNaN(Date.parse(value)),
    match: (value, matchValue) => value === matchValue
  };

  /**
   * Error messages
   */
  static messages = {
    required: 'This field is required',
    email: 'Please enter a valid email address',
    phone: 'Please enter a valid phone number',
    url: 'Please enter a valid URL',
    number: 'Please enter a valid number',
    integer: 'Please enter a whole number',
    positive: 'Please enter a positive number',
    negative: 'Please enter a negative number',
    min: 'Value must be at least {min}',
    max: 'Value must be at most {max}',
    minLength: 'Must be at least {length} characters',
    maxLength: 'Must be at most {length} characters',
    pattern: 'Invalid format',
    alphanumeric: 'Only letters and numbers allowed',
    alpha: 'Only letters allowed',
    date: 'Please enter a valid date',
    match: 'Fields do not match'
  };

  /**
   * Validate a single field
   * @param {string} value - Field value
   * @param {Array|Object} rules - Validation rules
   * @returns {Object} Validation result
   */
  static validate(value, rules) {
    const errors = [];

    // Convert string rules to array
    if (typeof rules === 'string') {
      rules = rules.split('|').map(r => r.trim());
    }

    // Convert array to object format
    if (Array.isArray(rules)) {
      const rulesObj = {};
      rules.forEach(rule => {
        const [name, ...params] = rule.split(':');
        rulesObj[name] = params.length ? params[0].split(',') : true;
      });
      rules = rulesObj;
    }

    // Validate each rule
    for (const [ruleName, ruleParams] of Object.entries(rules)) {
      const validator = this.rules[ruleName];
      
      if (!validator) {
        console.warn(`Unknown validation rule: ${ruleName}`);
        continue;
      }

      let isValid = false;

      // Apply validator
      if (Array.isArray(ruleParams)) {
        isValid = validator(value, ...ruleParams);
      } else if (ruleParams === true) {
        isValid = validator(value);
      } else {
        isValid = validator(value, ruleParams);
      }

      // Add error if validation fails
      if (!isValid) {
        let message = this.messages[ruleName] || 'Invalid value';
        
        // Replace placeholders in message
        if (Array.isArray(ruleParams)) {
          ruleParams.forEach((param, index) => {
            message = message.replace(`{${Object.keys(rules)[index]}}`, param);
            message = message.replace(`{${index}}`, param);
          });
        } else if (typeof ruleParams === 'string' || typeof ruleParams === 'number') {
          message = message.replace(/\{.+?\}/, ruleParams);
        }

        errors.push(message);
      }
    }

    return {
      isValid: errors.length === 0,
      errors: errors
    };
  }

  /**
   * Validate entire form
   * @param {HTMLFormElement} form - Form element
   * @param {Object} rules - Validation rules for each field
   * @returns {Object} Validation results
   */
  static validateForm(form, rules = {}) {
    const results = {};
    let isValid = true;

    // Get form data
    const formData = new FormData(form);

    // Validate each field
    for (const [fieldName, fieldRules] of Object.entries(rules)) {
      const value = formData.get(fieldName) || '';
      const result = this.validate(value, fieldRules);

      results[fieldName] = result;

      if (!result.isValid) {
        isValid = false;
      }
    }

    return {
      isValid,
      fields: results
    };
  }

  /**
   * Display validation errors on form
   * @param {HTMLFormElement} form - Form element
   * @param {Object} results - Validation results
   */
  static displayErrors(form, results) {
    // Clear existing errors
    form.querySelectorAll('.error-message').forEach(el => el.remove());
    form.querySelectorAll('.error').forEach(el => el.classList.remove('error'));

    // Display new errors
    for (const [fieldName, result] of Object.entries(results.fields)) {
      const field = form.querySelector(`[name="${fieldName}"]`);
      
      if (!field) continue;

      if (!result.isValid) {
        field.classList.add('error');

        // Create and append error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.textContent = result.errors[0]; // Show first error
        errorDiv.style.color = 'var(--error-color, #e74c3c)';
        errorDiv.style.fontSize = '0.875rem';
        errorDiv.style.marginTop = '0.25rem';

        const wrapper = field.closest('.form-group') || field.parentElement;
        wrapper.appendChild(errorDiv);
      } else {
        field.classList.remove('error');
        field.classList.add('valid');
      }
    }
  }

  /**
   * Add custom validation rule
   * @param {string} name - Rule name
   * @param {Function} validator - Validator function
   * @param {string} message - Error message
   */
  static addRule(name, validator, message) {
    this.rules[name] = validator;
    this.messages[name] = message;
  }
}

/**
 * Input Sanitizer
 */
class Sanitizer {
  /**
   * Remove HTML tags from string
   * @param {string} str - Input string
   * @returns {string} Sanitized string
   */
  static stripTags(str) {
    return str.replace(/<[^>]*>/g, '');
  }

  /**
   * Escape HTML special characters
   * @param {string} str - Input string
   * @returns {string} Escaped string
   */
  static escapeHtml(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
  }

  /**
   * Remove script tags and dangerous attributes
   * @param {string} str - Input string
   * @returns {string} Sanitized string
   */
  static removeScripts(str) {
    return str
      .replace(/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi, '')
      .replace(/on\w+\s*=\s*["'][^"']*["']/gi, '')
      .replace(/javascript:/gi, '');
  }

  /**
   * Sanitize email address
   * @param {string} email - Email address
   * @returns {string} Sanitized email
   */
  static sanitizeEmail(email) {
    return email.toLowerCase().trim();
  }

  /**
   * Sanitize phone number
   * @param {string} phone - Phone number
   * @returns {string} Sanitized phone
   */
  static sanitizePhone(phone) {
    return phone.replace(/[^\d+\-\(\)\s]/g, '');
  }

  /**
   * Sanitize URL
   * @param {string} url - URL string
   * @returns {string} Sanitized URL
   */
  static sanitizeUrl(url) {
    try {
      const parsed = new URL(url);
      // Only allow http and https protocols
      if (!['http:', 'https:'].includes(parsed.protocol)) {
        return '';
      }
      return parsed.href;
    } catch (e) {
      return '';
    }
  }

  /**
   * Sanitize number input
   * @param {string} value - Input value
   * @returns {number} Sanitized number
   */
  static sanitizeNumber(value) {
    const cleaned = String(value).replace(/[^0-9.-]/g, '');
    return parseFloat(cleaned) || 0;
  }

  /**
   * Sanitize integer input
   * @param {string} value - Input value
   * @returns {number} Sanitized integer
   */
  static sanitizeInteger(value) {
    const cleaned = String(value).replace(/[^0-9-]/g, '');
    return parseInt(cleaned, 10) || 0;
  }

  /**
   * Sanitize alphanumeric input
   * @param {string} str - Input string
   * @returns {string} Sanitized string
   */
  static sanitizeAlphanumeric(str) {
    return str.replace(/[^a-zA-Z0-9]/g, '');
  }

  /**
   * Sanitize filename
   * @param {string} filename - Filename
   * @returns {string} Sanitized filename
   */
  static sanitizeFilename(filename) {
    return filename
      .replace(/[^a-zA-Z0-9._-]/g, '_')
      .replace(/_{2,}/g, '_')
      .toLowerCase();
  }

  /**
   * Trim whitespace
   * @param {string} str - Input string
   * @returns {string} Trimmed string
   */
  static trim(str) {
    return str.trim().replace(/\s+/g, ' ');
  }

  /**
   * Sanitize all form inputs
   * @param {HTMLFormElement} form - Form element
   * @param {Object} rules - Sanitization rules
   * @returns {Object} Sanitized data
   */
  static sanitizeForm(form, rules = {}) {
    const formData = new FormData(form);
    const sanitized = {};

    for (const [fieldName, value] of formData.entries()) {
      const rule = rules[fieldName] || 'trim';
      
      if (typeof this[rule] === 'function') {
        sanitized[fieldName] = this[rule](value);
      } else {
        sanitized[fieldName] = this.trim(value);
      }
    }

    return sanitized;
  }
}

/**
 * Notification Manager
 */
class Notification {
  /**
   * Show notification
   * @param {string} message - Notification message
   * @param {string} type - Notification type (success, error, warning, info)
   * @param {number} duration - Duration in milliseconds
   */
  static show(message, type = 'info', duration = 3000) {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
      <div class="notification-content">
        <i class="fas fa-${this.getIcon(type)}"></i>
        <span>${message}</span>
      </div>
    `;

    // Apply styles
    Object.assign(notification.style, {
      position: 'fixed',
      top: '20px',
      right: '20px',
      padding: '1rem 1.5rem',
      backgroundColor: this.getBackgroundColor(type),
      color: 'white',
      borderRadius: '8px',
      boxShadow: '0 4px 12px rgba(0, 0, 0, 0.15)',
      zIndex: '10000',
      animation: 'slideInRight 0.3s ease-out',
      minWidth: '300px',
      maxWidth: '500px'
    });

    // Add to document
    document.body.appendChild(notification);

    // Auto remove
    if (duration > 0) {
      setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease-out';
        setTimeout(() => {
          if (notification.parentElement) {
            notification.remove();
          }
        }, 300);
      }, duration);
    }

    // Manual close on click
    notification.addEventListener('click', () => {
      notification.style.animation = 'slideOutRight 0.3s ease-out';
      setTimeout(() => {
        if (notification.parentElement) {
          notification.remove();
        }
      }, 300);
    });

    return notification;
  }

  /**
   * Get icon for notification type
   * @param {string} type - Notification type
   * @returns {string} Icon class
   */
  static getIcon(type) {
    const icons = {
      success: 'check-circle',
      error: 'exclamation-circle',
      warning: 'exclamation-triangle',
      info: 'info-circle'
    };
    return icons[type] || icons.info;
  }

  /**
   * Get background color for notification type
   * @param {string} type - Notification type
   * @returns {string} Background color
   */
  static getBackgroundColor(type) {
    const colors = {
      success: '#27ae60',
      error: '#e74c3c',
      warning: '#f39c12',
      info: '#3498db'
    };
    return colors[type] || colors.info;
  }

  /**
   * Show success notification
   * @param {string} message - Success message
   * @param {number} duration - Duration in milliseconds
   */
  static success(message, duration = 3000) {
    return this.show(message, 'success', duration);
  }

  /**
   * Show error notification
   * @param {string} message - Error message
   * @param {number} duration - Duration in milliseconds
   */
  static error(message, duration = 4000) {
    return this.show(message, 'error', duration);
  }

  /**
   * Show warning notification
   * @param {string} message - Warning message
   * @param {number} duration - Duration in milliseconds
   */
  static warning(message, duration = 3000) {
    return this.show(message, 'warning', duration);
  }

  /**
   * Show info notification
   * @param {string} message - Info message
   * @param {number} duration - Duration in milliseconds
   */
  static info(message, duration = 3000) {
    return this.show(message, 'info', duration);
  }
}

/**
 * Form Manager - Combines validation and sanitization
 */
class FormManager {
  /**
   * Create form manager
   * @param {HTMLFormElement} form - Form element
   * @param {Object} options - Configuration options
   */
  constructor(form, options = {}) {
    this.form = form;
    this.options = {
      validateOnSubmit: true,
      validateOnBlur: true,
      sanitizeOnSubmit: true,
      showNotifications: true,
      ...options
    };

    this.validationRules = options.validationRules || {};
    this.sanitizationRules = options.sanitizationRules || {};

    this.init();
  }

  /**
   * Initialize form manager
   */
  init() {
    if (this.options.validateOnSubmit) {
      this.form.addEventListener('submit', (e) => this.handleSubmit(e));
    }

    if (this.options.validateOnBlur) {
      this.form.querySelectorAll('input, textarea, select').forEach(field => {
        field.addEventListener('blur', () => this.validateField(field));
      });
    }
  }

  /**
   * Handle form submission
   * @param {Event} e - Submit event
   */
  async handleSubmit(e) {
    e.preventDefault();

    // Validate form
    const validation = Validator.validateForm(this.form, this.validationRules);

    if (!validation.isValid) {
      Validator.displayErrors(this.form, validation);
      
      if (this.options.showNotifications) {
        Notification.error('Please fix the errors in the form');
      }
      
      return false;
    }

    // Sanitize form data
    let data = new FormData(this.form);
    
    if (this.options.sanitizeOnSubmit) {
      const sanitized = Sanitizer.sanitizeForm(this.form, this.sanitizationRules);
      data = sanitized;
    }

    // Call submit handler if provided
    if (this.options.onSubmit) {
      try {
        await this.options.onSubmit(data);
        
        if (this.options.showNotifications) {
          Notification.success('Form submitted successfully!');
        }
      } catch (error) {
        console.error('Form submission error:', error);
        
        if (this.options.showNotifications) {
          Notification.error('An error occurred. Please try again.');
        }
      }
    }

    return true;
  }

  /**
   * Validate single field
   * @param {HTMLElement} field - Field element
   */
  validateField(field) {
    const fieldName = field.name;
    const rules = this.validationRules[fieldName];

    if (!rules) return;

    const result = Validator.validate(field.value, rules);
    
    // Clear existing errors
    const wrapper = field.closest('.form-group') || field.parentElement;
    wrapper.querySelectorAll('.error-message').forEach(el => el.remove());
    
    field.classList.remove('error', 'valid');

    if (result.isValid) {
      field.classList.add('valid');
    } else {
      field.classList.add('error');
      
      const errorDiv = document.createElement('div');
      errorDiv.className = 'error-message';
      errorDiv.textContent = result.errors[0];
      errorDiv.style.color = 'var(--error-color, #e74c3c)';
      errorDiv.style.fontSize = '0.875rem';
      errorDiv.style.marginTop = '0.25rem';
      
      wrapper.appendChild(errorDiv);
    }
  }

  /**
   * Reset form
   */
  reset() {
    this.form.reset();
    
    this.form.querySelectorAll('.error-message').forEach(el => el.remove());
    this.form.querySelectorAll('.error, .valid').forEach(el => {
      el.classList.remove('error', 'valid');
    });
  }
}

// Add CSS animations for notifications
const style = document.createElement('style');
style.textContent = `
  @keyframes slideInRight {
    from {
      transform: translateX(100%);
      opacity: 0;
    }
    to {
      transform: translateX(0);
      opacity: 1;
    }
  }

  @keyframes slideOutRight {
    from {
      transform: translateX(0);
      opacity: 1;
    }
    to {
      transform: translateX(100%);
      opacity: 0;
    }
  }

  .notification {
    cursor: pointer;
    transition: transform 0.2s;
  }

  .notification:hover {
    transform: translateX(-5px);
  }

  .notification-content {
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .notification-content i {
    font-size: 1.25rem;
  }
`;
document.head.appendChild(style);

// Export for use in other modules
if (typeof module !== 'undefined' && module.exports) {
  module.exports = { Validator, Sanitizer, Notification, FormManager };
}  
