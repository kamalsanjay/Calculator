/**
 * Base Calculator Class
 * Provides core functionality for all calculator types
 * @version 1.0.0
 */

class Calculator {
  /**
   * Create a calculator instance
   * @param {string} formId - ID of the calculator form
   * @param {Object} options - Configuration options
   */
  constructor(formId, options = {}) {
    this.form = document.getElementById(formId);
    this.options = {
      validateOnInput: true,
      formatNumbers: true,
      showSteps: false,
      animateResults: true,
      ...options
    };
    
    this.inputs = {};
    this.results = {};
    this.isCalculating = false;
    
    if (this.form) {
      this.init();
    }
  }

  /**
   * Initialize calculator
   */
  init() {
    this.cacheElements();
    this.bindEvents();
    this.loadSavedInputs();
  }

  /**
   * Cache form elements
   */
  cacheElements() {
    // Cache all input fields
    this.form.querySelectorAll('input, select, textarea').forEach(element => {
      if (element.id || element.name) {
        const key = element.id || element.name;
        this.inputs[key] = element;
      }
    });

    // Cache result display elements
    this.resultContainer = this.form.querySelector('.result-container');
    this.calculateBtn = this.form.querySelector('.calculate-btn');
    this.resetBtn = this.form.querySelector('.reset-btn');
    this.copyBtn = this.form.querySelector('.copy-btn');
  }

  /**
   * Bind event listeners
   */
  bindEvents() {
    // Form submission
    this.form.addEventListener('submit', (e) => {
      e.preventDefault();
      this.calculate();
    });

    // Calculate button
    if (this.calculateBtn) {
      this.calculateBtn.addEventListener('click', () => this.calculate());
    }

    // Reset button
    if (this.resetBtn) {
      this.resetBtn.addEventListener('click', () => this.reset());
    }

    // Copy button
    if (this.copyBtn) {
      this.copyBtn.addEventListener('click', () => this.copyResults());
    }

    // Real-time validation on input
    if (this.options.validateOnInput) {
      Object.values(this.inputs).forEach(input => {
        input.addEventListener('input', () => {
          this.validateInput(input);
          this.saveInputs();
        });

        input.addEventListener('blur', () => {
          this.formatInput(input);
        });
      });
    }

    // Number formatting for numeric inputs
    if (this.options.formatNumbers) {
      Object.values(this.inputs).forEach(input => {
        if (input.type === 'number' || input.type === 'text') {
          input.addEventListener('focus', () => this.removeFormatting(input));
          input.addEventListener('blur', () => this.formatInput(input));
        }
      });
    }
  }

  /**
   * Validate single input field
   * @param {HTMLElement} input - Input element to validate
   * @returns {boolean} Validation result
   */
  validateInput(input) {
    const value = input.value.trim();
    const type = input.type;
    let isValid = true;
    let errorMessage = '';

    // Check required fields
    if (input.required && !value) {
      isValid = false;
      errorMessage = 'This field is required';
    }

    // Validate number inputs
    if (type === 'number' || input.dataset.type === 'number') {
      const num = parseFloat(value.replace(/,/g, ''));
      
      if (value && isNaN(num)) {
        isValid = false;
        errorMessage = 'Please enter a valid number';
      }

      // Check min/max constraints
      if (isValid && input.min && num < parseFloat(input.min)) {
        isValid = false;
        errorMessage = `Value must be at least ${input.min}`;
      }

      if (isValid && input.max && num > parseFloat(input.max)) {
        isValid = false;
        errorMessage = `Value must be at most ${input.max}`;
      }
    }

    // Validate email
    if (type === 'email' && value) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(value)) {
        isValid = false;
        errorMessage = 'Please enter a valid email address';
      }
    }

    // Update UI
    this.updateValidationUI(input, isValid, errorMessage);

    return isValid;
  }

  /**
   * Update validation UI for input
   * @param {HTMLElement} input - Input element
   * @param {boolean} isValid - Validation status
   * @param {string} errorMessage - Error message
   */
  updateValidationUI(input, isValid, errorMessage) {
    const wrapper = input.closest('.form-group') || input.parentElement;
    const errorElement = wrapper.querySelector('.error-message') || 
                        this.createErrorElement();

    if (isValid) {
      input.classList.remove('error');
      input.classList.add('valid');
      errorElement.textContent = '';
      errorElement.style.display = 'none';
    } else {
      input.classList.add('error');
      input.classList.remove('valid');
      errorElement.textContent = errorMessage;
      errorElement.style.display = 'block';
      
      if (!wrapper.contains(errorElement)) {
        wrapper.appendChild(errorElement);
      }
    }
  }

  /**
   * Create error message element
   * @returns {HTMLElement} Error element
   */
  createErrorElement() {
    const error = document.createElement('div');
    error.className = 'error-message';
    error.style.color = 'var(--error-color, #e74c3c)';
    error.style.fontSize = '0.875rem';
    error.style.marginTop = '0.25rem';
    return error;
  }

  /**
   * Format input value for display
   * @param {HTMLElement} input - Input element
   */
  formatInput(input) {
    if (!this.options.formatNumbers) return;
    
    const value = input.value.trim();
    if (!value) return;

    if (input.type === 'number' || input.dataset.type === 'number') {
      const num = parseFloat(value.replace(/,/g, ''));
      if (!isNaN(num)) {
        input.value = this.formatNumber(num);
      }
    }
  }

  /**
   * Remove formatting from input
   * @param {HTMLElement} input - Input element
   */
  removeFormatting(input) {
    if (input.type === 'number' || input.dataset.type === 'number') {
      const value = input.value.replace(/,/g, '');
      input.value = value;
    }
  }

  /**
   * Format number with commas and decimals
   * @param {number} num - Number to format
   * @param {number} decimals - Number of decimal places
   * @returns {string} Formatted number
   */
  formatNumber(num, decimals = 2) {
    if (isNaN(num)) return '0';
    
    const fixed = parseFloat(num).toFixed(decimals);
    const parts = fixed.split('.');
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    
    // Remove trailing zeros after decimal
    if (parts[1]) {
      parts[1] = parts[1].replace(/0+$/, '');
      if (parts[1] === '') {
        return parts[0];
      }
    }
    
    return parts.join('.');
  }

  /**
   * Format currency value
   * @param {number} num - Number to format
   * @param {string} currency - Currency symbol
   * @returns {string} Formatted currency
   */
  formatCurrency(num, currency = '$') {
    return `${currency}${this.formatNumber(num, 2)}`;
  }

  /**
   * Format percentage value
   * @param {number} num - Number to format
   * @param {number} decimals - Decimal places
   * @returns {string} Formatted percentage
   */
  formatPercentage(num, decimals = 2) {
    return `${this.formatNumber(num, decimals)}%`;
  }

  /**
   * Parse input value to number
   * @param {string|number} value - Value to parse
   * @returns {number} Parsed number
   */
  parseNumber(value) {
    if (typeof value === 'number') return value;
    const cleaned = String(value).replace(/[^0-9.-]/g, '');
    return parseFloat(cleaned) || 0;
  }

  /**
   * Get input value as number
   * @param {string} inputId - Input ID
   * @returns {number} Input value as number
   */
  getInputValue(inputId) {
    const input = this.inputs[inputId];
    if (!input) return 0;
    return this.parseNumber(input.value);
  }

  /**
   * Set input value
   * @param {string} inputId - Input ID
   * @param {string|number} value - Value to set
   */
  setInputValue(inputId, value) {
    const input = this.inputs[inputId];
    if (input) {
      input.value = value;
    }
  }

  /**
   * Validate all form inputs
   * @returns {boolean} Overall validation result
   */
  validateForm() {
    let isValid = true;

    Object.values(this.inputs).forEach(input => {
      if (!this.validateInput(input)) {
        isValid = false;
      }
    });

    return isValid;
  }

  /**
   * Calculate results (to be overridden by child classes)
   * @returns {Object} Calculation results
   */
  performCalculation() {
    throw new Error('performCalculation() must be implemented by child class');
  }

  /**
   * Execute calculation
   */
  async calculate() {
    if (this.isCalculating) return;

    // Validate form
    if (!this.validateForm()) {
      this.showError('Please fix the errors before calculating');
      return;
    }

    try {
      this.isCalculating = true;
      this.showLoading();

      // Perform calculation (with slight delay for UX)
      await new Promise(resolve => setTimeout(resolve, 300));
      
      this.results = this.performCalculation();
      
      this.displayResults();
      this.saveInputs();
      
      if (this.options.animateResults) {
        this.animateResults();
      }

    } catch (error) {
      console.error('Calculation error:', error);
      this.showError('An error occurred during calculation. Please check your inputs.');
    } finally {
      this.isCalculating = false;
      this.hideLoading();
    }
  }

  /**
   * Display calculation results
   */
  displayResults() {
    if (!this.resultContainer) return;

    this.resultContainer.style.display = 'block';
    this.resultContainer.innerHTML = this.formatResults();
  }

  /**
   * Format results for display (to be overridden by child classes)
   * @returns {string} Formatted HTML
   */
  formatResults() {
    let html = '<div class="results">';
    
    for (const [key, value] of Object.entries(this.results)) {
      html += `
        <div class="result-item">
          <span class="result-label">${this.formatLabel(key)}:</span>
          <span class="result-value">${value}</span>
        </div>
      `;
    }
    
    html += '</div>';
    return html;
  }

  /**
   * Format label from camelCase
   * @param {string} str - String to format
   * @returns {string} Formatted label
   */
  formatLabel(str) {
    return str
      .replace(/([A-Z])/g, ' $1')
      .replace(/^./, str => str.toUpperCase())
      .trim();
  }

  /**
   * Animate results display
   */
  animateResults() {
    if (!this.resultContainer) return;

    this.resultContainer.style.opacity = '0';
    this.resultContainer.style.transform = 'translateY(20px)';

    requestAnimationFrame(() => {
      this.resultContainer.style.transition = 'all 0.3s ease-out';
      this.resultContainer.style.opacity = '1';
      this.resultContainer.style.transform = 'translateY(0)';
    });
  }

  /**
   * Show loading state
   */
  showLoading() {
    if (this.calculateBtn) {
      this.calculateBtn.disabled = true;
      this.calculateBtn.classList.add('loading');
      this.calculateBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Calculating...';
    }
  }

  /**
   * Hide loading state
   */
  hideLoading() {
    if (this.calculateBtn) {
      this.calculateBtn.disabled = false;
      this.calculateBtn.classList.remove('loading');
      this.calculateBtn.innerHTML = '<i class="fas fa-calculator"></i> Calculate';
    }
  }

  /**
   * Show error message
   * @param {string} message - Error message
   */
  showError(message) {
    if (!this.resultContainer) return;

    this.resultContainer.style.display = 'block';
    this.resultContainer.innerHTML = `
      <div class="error-box" style="background-color: #fee; border: 1px solid #e74c3c; border-radius: 8px; padding: 1rem; color: #c0392b;">
        <i class="fas fa-exclamation-circle"></i> ${message}
      </div>
    `;
  }

  /**
   * Reset calculator
   */
  reset() {
    this.form.reset();
    
    Object.values(this.inputs).forEach(input => {
      input.classList.remove('valid', 'error');
    });

    if (this.resultContainer) {
      this.resultContainer.style.display = 'none';
      this.resultContainer.innerHTML = '';
    }

    this.results = {};
    this.clearSavedInputs();
  }

  /**
   * Copy results to clipboard
   */
  async copyResults() {
    const text = this.getResultsText();
    
    try {
      await navigator.clipboard.writeText(text);
      this.showCopySuccess();
    } catch (err) {
      console.error('Failed to copy:', err);
    }
  }

  /**
   * Get results as plain text
   * @returns {string} Results text
   */
  getResultsText() {
    let text = 'Calculation Results:\n\n';
    
    for (const [key, value] of Object.entries(this.results)) {
      text += `${this.formatLabel(key)}: ${value}\n`;
    }
    
    return text;
  }

  /**
   * Show copy success message
   */
  showCopySuccess() {
    if (!this.copyBtn) return;

    const originalText = this.copyBtn.innerHTML;
    this.copyBtn.innerHTML = '<i class="fas fa-check"></i> Copied!';
    this.copyBtn.classList.add('success');

    setTimeout(() => {
      this.copyBtn.innerHTML = originalText;
      this.copyBtn.classList.remove('success');
    }, 2000);
  }

  /**
   * Save input values to localStorage
   */
  saveInputs() {
    const formId = this.form.id;
    if (!formId) return;

    const data = {};
    Object.entries(this.inputs).forEach(([key, input]) => {
      data[key] = input.value;
    });

    try {
      localStorage.setItem(`calculator_${formId}`, JSON.stringify(data));
    } catch (e) {
      console.warn('Failed to save inputs:', e);
    }
  }

  /**
   * Load saved input values from localStorage
   */
  loadSavedInputs() {
    const formId = this.form.id;
    if (!formId) return;

    try {
      const saved = localStorage.getItem(`calculator_${formId}`);
      if (saved) {
        const data = JSON.parse(saved);
        Object.entries(data).forEach(([key, value]) => {
          if (this.inputs[key]) {
            this.inputs[key].value = value;
          }
        });
      }
    } catch (e) {
      console.warn('Failed to load saved inputs:', e);
    }
  }

  /**
   * Clear saved inputs from localStorage
   */
  clearSavedInputs() {
    const formId = this.form.id;
    if (!formId) return;

    try {
      localStorage.removeItem(`calculator_${formId}`);
    } catch (e) {
      console.warn('Failed to clear saved inputs:', e);
    }
  }
}

// Export for use in other modules
if (typeof module !== 'undefined' && module.exports) {
  module.exports = Calculator;
}  
