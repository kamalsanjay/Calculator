/**
 * Main Application JavaScript
 * Handles theme toggling, smooth scrolling, mobile menu, and local storage
 * @version 1.0.0
 */

class App {
  constructor() {
    this.theme = localStorage.getItem('theme') || 'light';
    this.mobileMenuOpen = false;
    this.init();
  }

  /**
   * Initialize application
   */
  init() {
    this.applyTheme();
    this.bindEvents();
    this.initSmoothScroll();
    this.initMobileMenu();
    this.initSearchFunctionality();
  }

  /**
   * Bind all event listeners
   */
  bindEvents() {
    // Theme toggle
    const themeToggle = document.getElementById('theme-toggle');
    if (themeToggle) {
      themeToggle.addEventListener('click', () => this.toggleTheme());
    }

    // Mobile menu toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    if (mobileMenuBtn) {
      mobileMenuBtn.addEventListener('click', () => this.toggleMobileMenu());
    }

    // Close mobile menu on resize
    window.addEventListener('resize', () => {
      if (window.innerWidth > 768 && this.mobileMenuOpen) {
        this.toggleMobileMenu();
      }
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', (e) => {
      const mobileMenu = document.getElementById('mobile-menu');
      const mobileMenuBtn = document.getElementById('mobile-menu-btn');
      
      if (this.mobileMenuOpen && 
          mobileMenu && 
          !mobileMenu.contains(e.target) && 
          !mobileMenuBtn.contains(e.target)) {
        this.toggleMobileMenu();
      }
    });

    // Handle ESC key to close mobile menu
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && this.mobileMenuOpen) {
        this.toggleMobileMenu();
      }
    });
  }

  /**
   * Toggle between light and dark theme
   */
  toggleTheme() {
    this.theme = this.theme === 'light' ? 'dark' : 'light';
    this.applyTheme();
    this.saveTheme();
    this.updateThemeIcon();
  }

  /**
   * Apply current theme to document
   */
  applyTheme() {
    document.documentElement.setAttribute('data-theme', this.theme);
    this.updateThemeIcon();
  }

  /**
   * Update theme toggle icon
   */
  updateThemeIcon() {
    const themeToggle = document.getElementById('theme-toggle');
    if (!themeToggle) return;

    const icon = themeToggle.querySelector('i');
    if (icon) {
      icon.className = this.theme === 'light' ? 'fas fa-moon' : 'fas fa-sun';
    }
  }

  /**
   * Save theme preference to localStorage
   */
  saveTheme() {
    try {
      localStorage.setItem('theme', this.theme);
    } catch (e) {
      console.warn('Failed to save theme preference:', e);
    }
  }

  /**
   * Initialize smooth scrolling for anchor links
   */
  initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', (e) => {
        const href = anchor.getAttribute('href');
        
        // Skip if it's just "#"
        if (href === '#') return;

        const target = document.querySelector(href);
        if (target) {
          e.preventDefault();
          
          // Close mobile menu if open
          if (this.mobileMenuOpen) {
            this.toggleMobileMenu();
          }

          // Smooth scroll to target
          const offsetTop = target.offsetTop - 80; // Account for fixed header
          window.scrollTo({
            top: offsetTop,
            behavior: 'smooth'
          });

          // Update URL without jumping
          history.pushState(null, '', href);
        }
      });
    });
  }

  /**
   * Initialize mobile menu functionality
   */
  initMobileMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    if (mobileMenu) {
      // Close menu when clicking on links
      mobileMenu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
          if (this.mobileMenuOpen) {
            this.toggleMobileMenu();
          }
        });
      });
    }
  }

  /**
   * Toggle mobile menu open/closed
   */
  toggleMobileMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    
    if (!mobileMenu || !mobileMenuBtn) return;

    this.mobileMenuOpen = !this.mobileMenuOpen;

    if (this.mobileMenuOpen) {
      mobileMenu.classList.add('active');
      mobileMenuBtn.classList.add('active');
      mobileMenuBtn.setAttribute('aria-expanded', 'true');
      document.body.style.overflow = 'hidden'; // Prevent scrolling
    } else {
      mobileMenu.classList.remove('active');
      mobileMenuBtn.classList.remove('active');
      mobileMenuBtn.setAttribute('aria-expanded', 'false');
      document.body.style.overflow = ''; // Restore scrolling
    }
  }

  /**
   * Initialize search functionality
   */
  initSearchFunctionality() {
    const searchInput = document.getElementById('search-input');
    const searchBtn = document.getElementById('search-btn');

    if (searchInput && searchBtn) {
      searchBtn.addEventListener('click', () => {
        this.performSearch(searchInput.value);
      });

      searchInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
          this.performSearch(searchInput.value);
        }
      });
    }
  }

  /**
   * Perform search action
   * @param {string} query - Search query
   */
  performSearch(query) {
    if (!query.trim()) return;

    // Save recent search
    this.saveRecentSearch(query);

    // Redirect to search results page or filter calculators
    const searchParams = new URLSearchParams({ q: query });
    window.location.href = `/search.html?${searchParams.toString()}`;
  }

  /**
   * Save recent search to localStorage
   * @param {string} query - Search query
   */
  saveRecentSearch(query) {
    try {
      let recentSearches = JSON.parse(localStorage.getItem('recentSearches') || '[]');
      
      // Remove duplicate if exists
      recentSearches = recentSearches.filter(s => s.toLowerCase() !== query.toLowerCase());
      
      // Add to beginning
      recentSearches.unshift(query);
      
      // Keep only last 10 searches
      recentSearches = recentSearches.slice(0, 10);
      
      localStorage.setItem('recentSearches', JSON.stringify(recentSearches));
    } catch (e) {
      console.warn('Failed to save recent search:', e);
    }
  }

  /**
   * Get recent searches from localStorage
   * @returns {Array<string>} Recent searches
   */
  static getRecentSearches() {
    try {
      return JSON.parse(localStorage.getItem('recentSearches') || '[]');
    } catch (e) {
      console.warn('Failed to get recent searches:', e);
      return [];
    }
  }

  /**
   * Clear recent searches
   */
  static clearRecentSearches() {
    try {
      localStorage.removeItem('recentSearches');
    } catch (e) {
      console.warn('Failed to clear recent searches:', e);
    }
  }
}

/**
 * Utility Functions
 */

/**
 * Format number with commas
 * @param {number} num - Number to format
 * @returns {string} Formatted number
 */
function formatNumberWithCommas(num) {
  return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

/**
 * Debounce function to limit function calls
 * @param {Function} func - Function to debounce
 * @param {number} wait - Wait time in milliseconds
 * @returns {Function} Debounced function
 */
function debounce(func, wait) {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

/**
 * Throttle function to limit function calls
 * @param {Function} func - Function to throttle
 * @param {number} limit - Time limit in milliseconds
 * @returns {Function} Throttled function
 */
function throttle(func, limit) {
  let inThrottle;
  return function executedFunction(...args) {
    if (!inThrottle) {
      func.apply(this, args);
      inThrottle = true;
      setTimeout(() => inThrottle = false, limit);
    }
  };
}

/**
 * Show loading spinner
 * @param {HTMLElement} element - Element to show spinner in
 */
function showLoading(element) {
  if (!element) return;
  element.classList.add('loading');
  element.setAttribute('aria-busy', 'true');
}

/**
 * Hide loading spinner
 * @param {HTMLElement} element - Element to hide spinner from
 */
function hideLoading(element) {
  if (!element) return;
  element.classList.remove('loading');
  element.setAttribute('aria-busy', 'false');
}

/**
 * Copy text to clipboard
 * @param {string} text - Text to copy
 * @returns {Promise<boolean>} Success status
 */
async function copyToClipboard(text) {
  try {
    await navigator.clipboard.writeText(text);
    return true;
  } catch (err) {
    // Fallback for older browsers
    const textArea = document.createElement('textarea');
    textArea.value = text;
    textArea.style.position = 'fixed';
    textArea.style.left = '-999999px';
    document.body.appendChild(textArea);
    textArea.select();
    
    try {
      document.execCommand('copy');
      document.body.removeChild(textArea);
      return true;
    } catch (err) {
      document.body.removeChild(textArea);
      return false;
    }
  }
}

/**
 * Initialize application when DOM is ready
 */
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => {
    window.app = new App();
  });
} else {
  window.app = new App();
}

// Export for use in other modules
if (typeof module !== 'undefined' && module.exports) {
  module.exports = { App, formatNumberWithCommas, debounce, throttle, copyToClipboard };
}  
