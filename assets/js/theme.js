/**
 * Theme Management System
 * Handles dark/light mode toggle with localStorage persistence
 * @version 1.0.0
 */

class ThemeManager {
  constructor() {
    this.currentTheme = this.getStoredTheme() || this.getPreferredTheme();
    this.themeToggleBtn = null;
    this.init();
  }

  /**
   * Initialize theme manager
   */
  init() {
    // Apply theme immediately (before page renders)
    this.applyTheme(this.currentTheme);
    
    // Wait for DOM to be ready
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', () => this.setupThemeToggle());
    } else {
      this.setupThemeToggle();
    }

    // Listen for system theme changes
    this.watchSystemTheme();
  }

  /**
   * Setup theme toggle button
   */
  setupThemeToggle() {
    this.themeToggleBtn = document.getElementById('theme-toggle');
    
    if (this.themeToggleBtn) {
      this.themeToggleBtn.addEventListener('click', () => this.toggleTheme());
      this.updateToggleButton();
    }

    // Add keyboard shortcut (Ctrl/Cmd + Shift + T)
    document.addEventListener('keydown', (e) => {
      if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'T') {
        e.preventDefault();
        this.toggleTheme();
      }
    });
  }

  /**
   * Toggle between light and dark theme
   */
  toggleTheme() {
    const newTheme = this.currentTheme === 'light' ? 'dark' : 'light';
    this.setTheme(newTheme);
  }

  /**
   * Set specific theme
   * @param {string} theme - Theme name ('light' or 'dark')
   */
  setTheme(theme) {
    this.currentTheme = theme;
    this.applyTheme(theme);
    this.storeTheme(theme);
    this.updateToggleButton();
    this.dispatchThemeChange(theme);
  }

  /**
   * Apply theme to document
   * @param {string} theme - Theme name
   */
  applyTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    document.documentElement.classList.remove('light-theme', 'dark-theme');
    document.documentElement.classList.add(`${theme}-theme`);

    // Update meta theme-color for mobile browsers
    this.updateMetaThemeColor(theme);

    // Add transition class after initial load
    if (document.readyState === 'complete') {
      document.documentElement.classList.add('theme-transition');
      setTimeout(() => {
        document.documentElement.classList.remove('theme-transition');
      }, 300);
    }
  }

  /**
   * Update theme toggle button appearance
   */
  updateToggleButton() {
    if (!this.themeToggleBtn) return;

    const icon = this.themeToggleBtn.querySelector('i');
    const text = this.themeToggleBtn.querySelector('.theme-text');

    if (icon) {
      icon.className = this.currentTheme === 'light' 
        ? 'fas fa-moon' 
        : 'fas fa-sun';
    }

    if (text) {
      text.textContent = this.currentTheme === 'light' ? 'Dark' : 'Light';
    }

    // Update aria-label for accessibility
    this.themeToggleBtn.setAttribute(
      'aria-label', 
      `Switch to ${this.currentTheme === 'light' ? 'dark' : 'light'} mode`
    );
  }

  /**
   * Update meta theme-color for mobile browsers
   * @param {string} theme - Theme name
   */
  updateMetaThemeColor(theme) {
    let metaThemeColor = document.querySelector('meta[name="theme-color"]');
    
    if (!metaThemeColor) {
      metaThemeColor = document.createElement('meta');
      metaThemeColor.name = 'theme-color';
      document.head.appendChild(metaThemeColor);
    }

    // Set appropriate color based on theme
    const colors = {
      light: '#ffffff',
      dark: '#1a1a2e'
    };

    metaThemeColor.content = colors[theme] || colors.light;
  }

  /**
   * Get stored theme from localStorage
   * @returns {string|null} Stored theme or null
   */
  getStoredTheme() {
    try {
      return localStorage.getItem('theme');
    } catch (e) {
      console.warn('localStorage not available:', e);
      return null;
    }
  }

  /**
   * Store theme in localStorage
   * @param {string} theme - Theme to store
   */
  storeTheme(theme) {
    try {
      localStorage.setItem('theme', theme);
    } catch (e) {
      console.warn('Failed to store theme:', e);
    }
  }

  /**
   * Get preferred theme from system settings
   * @returns {string} Preferred theme ('light' or 'dark')
   */
  getPreferredTheme() {
    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
      return 'dark';
    }
    return 'light';
  }

  /**
   * Watch for system theme changes
   */
  watchSystemTheme() {
    if (!window.matchMedia) return;

    const darkModeQuery = window.matchMedia('(prefers-color-scheme: dark)');
    
    darkModeQuery.addEventListener('change', (e) => {
      // Only auto-switch if user hasn't manually set a preference
      if (!this.getStoredTheme()) {
        this.setTheme(e.matches ? 'dark' : 'light');
      }
    });
  }

  /**
   * Dispatch theme change event
   * @param {string} theme - New theme
   */
  dispatchThemeChange(theme) {
    const event = new CustomEvent('themechange', {
      detail: { theme }
    });
    document.dispatchEvent(event);
  }

  /**
   * Get current theme
   * @returns {string} Current theme
   */
  getCurrentTheme() {
    return this.currentTheme;
  }

  /**
   * Check if dark mode is active
   * @returns {boolean} True if dark mode
   */
  isDarkMode() {
    return this.currentTheme === 'dark';
  }

  /**
   * Reset theme to system preference
   */
  resetTheme() {
    try {
      localStorage.removeItem('theme');
    } catch (e) {
      console.warn('Failed to remove theme:', e);
    }
    this.setTheme(this.getPreferredTheme());
  }
}

/**
 * Theme-aware Chart Colors
 * Provides appropriate colors based on current theme
 */
class ThemeColors {
  static colors = {
    light: {
      primary: '#4e73df',
      secondary: '#858796',
      success: '#1cc88a',
      danger: '#e74a3b',
      warning: '#f6c23e',
      info: '#36b9cc',
      text: '#333333',
      background: '#ffffff',
      border: '#dddddd',
      gridLines: 'rgba(0, 0, 0, 0.1)'
    },
    dark: {
      primary: '#5a8ff7',
      secondary: '#9ca3b4',
      success: '#2ecc71',
      danger: '#e74c3c',
      warning: '#f39c12',
      info: '#3498db',
      text: '#e0e0e0',
      background: '#1a1a2e',
      border: '#2d2d44',
      gridLines: 'rgba(255, 255, 255, 0.1)'
    }
  };

  /**
   * Get color for current theme
   * @param {string} colorName - Name of color
   * @returns {string} Color value
   */
  static get(colorName) {
    const theme = window.themeManager?.getCurrentTheme() || 'light';
    return this.colors[theme][colorName] || this.colors.light[colorName];
  }

  /**
   * Get all colors for current theme
   * @returns {Object} Color object
   */
  static getAll() {
    const theme = window.themeManager?.getCurrentTheme() || 'light';
    return { ...this.colors[theme] };
  }

  /**
   * Get Chart.js compatible colors
   * @returns {Object} Chart colors
   */
  static getChartColors() {
    const theme = window.themeManager?.getCurrentTheme() || 'light';
    const colors = this.colors[theme];

    return {
      backgroundColor: [
        colors.primary,
        colors.success,
        colors.warning,
        colors.danger,
        colors.info,
        colors.secondary
      ],
      borderColor: colors.border,
      gridColor: colors.gridLines,
      textColor: colors.text
    };
  }
}

/**
 * Smooth Scroll with Offset
 * Handles anchor link smooth scrolling with header offset
 */
class SmoothScroll {
  constructor(offset = 80) {
    this.offset = offset;
    this.init();
  }

  /**
   * Initialize smooth scroll
   */
  init() {
    document.addEventListener('click', (e) => {
      const anchor = e.target.closest('a[href^="#"]');
      
      if (anchor) {
        const href = anchor.getAttribute('href');
        
        // Skip empty hash
        if (href === '#') return;

        const target = document.querySelector(href);
        
        if (target) {
          e.preventDefault();
          this.scrollToElement(target);
          
          // Update URL without jumping
          history.pushState(null, '', href);
        }
      }
    });

    // Handle initial hash on page load
    if (window.location.hash) {
      setTimeout(() => {
        const target = document.querySelector(window.location.hash);
        if (target) {
          this.scrollToElement(target);
        }
      }, 100);
    }
  }

  /**
   * Scroll to element with offset
   * @param {HTMLElement} element - Target element
   */
  scrollToElement(element) {
    const elementPosition = element.getBoundingClientRect().top;
    const offsetPosition = elementPosition + window.pageYOffset - this.offset;

    window.scrollTo({
      top: offsetPosition,
      behavior: 'smooth'
    });
  }
}

/**
 * Scroll Progress Indicator
 * Shows reading progress at top of page
 */
class ScrollProgress {
  constructor() {
    this.progressBar = null;
    this.init();
  }

  /**
   * Initialize progress bar
   */
  init() {
    // Create progress bar
    this.progressBar = document.createElement('div');
    this.progressBar.className = 'scroll-progress';
    this.progressBar.style.cssText = `
      position: fixed;
      top: 0;
      left: 0;
      width: 0%;
      height: 3px;
      background: linear-gradient(90deg, var(--primary-color), var(--success-color));
      z-index: 9999;
      transition: width 0.1s ease-out;
    `;
    document.body.appendChild(this.progressBar);

    // Update on scroll
    window.addEventListener('scroll', () => this.updateProgress(), { passive: true });
    this.updateProgress();
  }

  /**
   * Update progress bar
   */
  updateProgress() {
    const windowHeight = window.innerHeight;
    const documentHeight = document.documentElement.scrollHeight;
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    
    const scrollPercent = (scrollTop / (documentHeight - windowHeight)) * 100;
    this.progressBar.style.width = `${Math.min(scrollPercent, 100)}%`;
  }

  /**
   * Show progress bar
   */
  show() {
    this.progressBar.style.display = 'block';
  }

  /**
   * Hide progress bar
   */
  hide() {
    this.progressBar.style.display = 'none';
  }
}

/**
 * Back to Top Button
 * Animated button to scroll to top of page
 */
class BackToTop {
  constructor(showAfter = 300) {
    this.showAfter = showAfter;
    this.button = null;
    this.init();
  }

  /**
   * Initialize back to top button
   */
  init() {
    // Create button
    this.button = document.createElement('button');
    this.button.className = 'back-to-top';
    this.button.innerHTML = '<i class="fas fa-arrow-up"></i>';
    this.button.setAttribute('aria-label', 'Back to top');
    this.button.style.cssText = `
      position: fixed;
      bottom: 30px;
      right: 30px;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background: var(--primary-color);
      color: white;
      border: none;
      cursor: pointer;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
      z-index: 1000;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    `;

    document.body.appendChild(this.button);

    // Show/hide on scroll
    window.addEventListener('scroll', () => this.toggleVisibility(), { passive: true });

    // Click to scroll top
    this.button.addEventListener('click', () => this.scrollToTop());

    // Hover effect
    this.button.addEventListener('mouseenter', () => {
      this.button.style.transform = 'translateY(-5px)';
      this.button.style.boxShadow = '0 6px 20px rgba(0, 0, 0, 0.2)';
    });

    this.button.addEventListener('mouseleave', () => {
      this.button.style.transform = 'translateY(0)';
      this.button.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.15)';
    });
  }

  /**
   * Toggle button visibility based on scroll position
   */
  toggleVisibility() {
    if (window.pageYOffset > this.showAfter) {
      this.button.style.opacity = '1';
      this.button.style.visibility = 'visible';
    } else {
      this.button.style.opacity = '0';
      this.button.style.visibility = 'hidden';
    }
  }

  /**
   * Scroll to top of page
   */
  scrollToTop() {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  }
}

/**
 * Toast Notifications
 * Simple notification system
 */
class Toast {
  static container = null;

  /**
   * Initialize toast container
   */
  static init() {
    if (!this.container) {
      this.container = document.createElement('div');
      this.container.className = 'toast-container';
      this.container.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 10000;
      `;
      document.body.appendChild(this.container);
    }
  }

  /**
   * Show toast notification
   * @param {string} message - Message to display
   * @param {string} type - Type of toast (success, error, warning, info)
   * @param {number} duration - Display duration in ms
   */
  static show(message, type = 'info', duration = 3000) {
    this.init();

    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
      <i class="fas fa-${this.getIcon(type)} me-2"></i>
      <span>${message}</span>
    `;
    toast.style.cssText = `
      background: ${this.getColor(type)};
      color: white;
      padding: 1rem 1.5rem;
      border-radius: 8px;
      margin-bottom: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      animation: slideInRight 0.3s ease-out;
      cursor: pointer;
      display: flex;
      align-items: center;
      min-width: 300px;
      max-width: 500px;
    `;

    this.container.appendChild(toast);

    // Auto remove
    if (duration > 0) {
      setTimeout(() => this.remove(toast), duration);
    }

    // Click to remove
    toast.addEventListener('click', () => this.remove(toast));

    return toast;
  }

  /**
   * Remove toast
   * @param {HTMLElement} toast - Toast element
   */
  static remove(toast) {
    toast.style.animation = 'slideOutRight 0.3s ease-out';
    setTimeout(() => {
      if (toast.parentElement) {
        toast.remove();
      }
    }, 300);
  }

  /**
   * Get icon for toast type
   * @param {string} type - Toast type
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
   * Get color for toast type
   * @param {string} type - Toast type
   * @returns {string} Color
   */
  static getColor(type) {
    const colors = {
      success: '#1cc88a',
      error: '#e74a3b',
      warning: '#f6c23e',
      info: '#36b9cc'
    };
    return colors[type] || colors.info;
  }

  // Convenience methods
  static success(message, duration) {
    return this.show(message, 'success', duration);
  }

  static error(message, duration) {
    return this.show(message, 'error', duration);
  }

  static warning(message, duration) {
    return this.show(message, 'warning', duration);
  }

  static info(message, duration) {
    return this.show(message, 'info', duration);
  }
}

// Add CSS animations
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

  .theme-transition,
  .theme-transition * {
    transition: background-color 0.3s ease, 
                color 0.3s ease, 
                border-color 0.3s ease !important;
  }

  .back-to-top:active {
    transform: scale(0.95) !important;
  }
`;
document.head.appendChild(style);

// Initialize theme manager
window.themeManager = new ThemeManager();

// Initialize other features when DOM is ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initializeThemeFeatures);
} else {
  initializeThemeFeatures();
}

function initializeThemeFeatures() {
  // Initialize smooth scroll
  window.smoothScroll = new SmoothScroll();

  // Initialize scroll progress (optional - can be disabled)
  if (document.body.classList.contains('enable-scroll-progress')) {
    window.scrollProgress = new ScrollProgress();
  }

  // Initialize back to top button
  window.backToTop = new BackToTop();
}

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
  module.exports = { 
    ThemeManager, 
    ThemeColors, 
    SmoothScroll, 
    ScrollProgress, 
    BackToTop,
    Toast 
  };
}  
