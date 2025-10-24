/**
 * AJAX Search with Autocomplete
 * Provides debounced search, autocomplete, and keyboard navigation
 * @version 1.0.0
 */

class SearchEngine {
  /**
   * Show error message
   * @param {string} message - Error message
   */
  showError(message) {
    this.resultsContainer.innerHTML = `
      <div class="search-error">
        <i class="fas fa-exclamation-circle"></i>
        <p>${message}</p>
      </div>
    `;
    this.showResults();
  }

  /**
   * Show results container
   */
  showResults() {
    this.resultsContainer.style.display = 'block';
    this.isOpen = true;
    this.input.setAttribute('aria-expanded', 'true');
  }

  /**
   * Hide results container
   */
  hideResults() {
    this.resultsContainer.style.display = 'none';
    this.isOpen = false;
    this.selectedIndex = -1;
    this.input.setAttribute('aria-expanded', 'false');
  }

  /**
   * Handle keyboard navigation
   * @param {KeyboardEvent} e - Keyboard event
   */
  handleKeyboard(e) {
    if (!this.isOpen) return;

    switch (e.key) {
      case 'ArrowDown':
        e.preventDefault();
        this.navigateDown();
        break;
      
      case 'ArrowUp':
        e.preventDefault();
        this.navigateUp();
        break;
      
      case 'Enter':
        e.preventDefault();
        if (this.selectedIndex >= 0) {
          this.selectResult(this.selectedIndex);
        }
        break;
      
      case 'Escape':
        e.preventDefault();
        this.hideResults();
        break;
    }
  }

  /**
   * Navigate down in results
   */
  navigateDown() {
    const items = this.resultsContainer.querySelectorAll('.search-result-item');
    
    if (this.selectedIndex < items.length - 1) {
      this.selectedIndex++;
      this.updateSelection();
    }
  }

  /**
   * Navigate up in results
   */
  navigateUp() {
    if (this.selectedIndex > 0) {
      this.selectedIndex--;
      this.updateSelection();
    }
  }

  /**
   * Update visual selection
   */
  updateSelection() {
    const items = this.resultsContainer.querySelectorAll('.search-result-item');
    
    items.forEach((item, index) => {
      if (index === this.selectedIndex) {
        item.classList.add('selected');
        item.setAttribute('aria-selected', 'true');
        item.scrollIntoView({ block: 'nearest' });
      } else {
        item.classList.remove('selected');
        item.setAttribute('aria-selected', 'false');
      }
    });
  }

  /**
   * Select a result
   * @param {number} index - Result index
   */
  selectResult(index) {
    const result = this.results[index];
    
    if (!result) return;

    // Save to recent searches
    this.saveRecentSearch(result.title || this.input.value);

    // Navigate to result
    if (result.url) {
      window.location.href = result.url;
    } else if (result.action) {
      result.action();
      this.hideResults();
    } else {
      // Fill input with selected value
      this.input.value = result.title;
      this.hideResults();
      
      // Trigger custom event
      this.input.dispatchEvent(new CustomEvent('search-select', {
        detail: { result }
      }));
    }
  }

  /**
   * Debounce function
   * @param {Function} func - Function to debounce
   * @param {number} wait - Wait time in milliseconds
   * @returns {Function} Debounced function
   */
  debounce(func, wait) {
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
   * Save recent search
   * @param {string} query - Search query
   */
  saveRecentSearch(query) {
    try {
      let recent = this.getRecentSearches();
      
      // Remove duplicates
      recent = recent.filter(s => s.toLowerCase() !== query.toLowerCase());
      
      // Add to beginning
      recent.unshift(query);
      
      // Keep only last 10
      recent = recent.slice(0, 10);
      
      localStorage.setItem('recentSearches', JSON.stringify(recent));
    } catch (e) {
      console.warn('Failed to save recent search:', e);
    }
  }

  /**
   * Get recent searches
   * @returns {Array<string>} Recent searches
   */
  getRecentSearches() {
    try {
      return JSON.parse(localStorage.getItem('recentSearches') || '[]');
    } catch (e) {
      console.warn('Failed to get recent searches:', e);
      return [];
    }
  }

  /**
   * Remove recent search
   * @param {string} query - Search query to remove
   */
  removeRecentSearch(query) {
    try {
      let recent = this.getRecentSearches();
      recent = recent.filter(s => s !== query);
      localStorage.setItem('recentSearches', JSON.stringify(recent));
    } catch (e) {
      console.warn('Failed to remove recent search:', e);
    }
  }

  /**
   * Clear all recent searches
   */
  clearRecentSearches() {
    try {
      localStorage.removeItem('recentSearches');
    } catch (e) {
      console.warn('Failed to clear recent searches:', e);
    }
  }

  /**
   * Load recent searches
   */
  loadRecentSearches() {
    // Preload recent searches for faster display
    this.recentSearches = this.getRecentSearches();
  }

  /**
   * Clear cache
   */
  clearCache() {
    this.cache.clear();
  }

  /**
   * Destroy search engine
   */
  destroy() {
    // Remove event listeners
    if (this.input) {
      this.input.removeEventListener('input', this.debouncedSearch);
    }

    // Remove results container
    if (this.resultsContainer && this.resultsContainer.parentElement) {
      this.resultsContainer.remove();
    }

    // Clear cache
    this.clearCache();
  }
}

/**
 * Instant Search - Real-time filtering for static content
 */
class InstantSearch {
  /**
   * Create instant search instance
   * @param {string} inputId - Search input ID
   * @param {string} targetSelector - Selector for items to filter
   * @param {Object} options - Configuration options
   */
  constructor(inputId, targetSelector, options = {}) {
    this.input = document.getElementById(inputId);
    this.targetSelector = targetSelector;
    this.options = {
      searchAttributes: ['title', 'description', 'category'],
      minLength: 1,
      debounceDelay: 200,
      highlightMatches: true,
      showCount: true,
      noResultsMessage: 'No items found',
      ...options
    };

    this.items = [];
    this.originalItems = [];

    if (this.input) {
      this.init();
    }
  }

  /**
   * Initialize instant search
   */
  init() {
    this.cacheItems();
    this.bindEvents();
    
    if (this.options.showCount) {
      this.createCountDisplay();
    }
  }

  /**
   * Cache searchable items
   */
  cacheItems() {
    const elements = document.querySelectorAll(this.targetSelector);
    
    this.items = Array.from(elements).map(el => ({
      element: el,
      searchText: this.getSearchText(el).toLowerCase(),
      visible: true
    }));

    this.originalItems = [...this.items];
  }

  /**
   * Get searchable text from element
   * @param {HTMLElement} element - Element
   * @returns {string} Searchable text
   */
  getSearchText(element) {
    const parts = [];

    this.options.searchAttributes.forEach(attr => {
      const el = element.querySelector(`[data-${attr}]`) || element;
      const text = el.dataset[attr] || el.textContent;
      if (text) parts.push(text);
    });

    return parts.join(' ');
  }

  /**
   * Bind event listeners
   */
  bindEvents() {
    const debouncedFilter = this.debounce(
      (query) => this.filter(query),
      this.options.debounceDelay
    );

    this.input.addEventListener('input', (e) => {
      debouncedFilter(e.target.value.trim());
    });

    // Clear button
    const clearBtn = this.input.nextElementSibling;
    if (clearBtn && clearBtn.classList.contains('clear-search')) {
      clearBtn.addEventListener('click', () => {
        this.input.value = '';
        this.filter('');
      });
    }
  }

  /**
   * Filter items based on query
   * @param {string} query - Search query
   */
  filter(query) {
    if (!query || query.length < this.options.minLength) {
      this.showAll();
      return;
    }

    const lowerQuery = query.toLowerCase();
    let visibleCount = 0;

    this.items.forEach(item => {
      const matches = item.searchText.includes(lowerQuery);

      if (matches) {
        item.element.style.display = '';
        item.visible = true;
        visibleCount++;

        // Highlight matches
        if (this.options.highlightMatches) {
          this.highlightElement(item.element, query);
        }
      } else {
        item.element.style.display = 'none';
        item.visible = false;
      }
    });

    // Update count
    if (this.options.showCount) {
      this.updateCount(visibleCount, this.items.length);
    }

    // Show no results message
    if (visibleCount === 0) {
      this.showNoResults();
    } else {
      this.hideNoResults();
    }

    // Dispatch event
    this.input.dispatchEvent(new CustomEvent('instant-search-filter', {
      detail: { query, visibleCount }
    }));
  }

  /**
   * Show all items
   */
  showAll() {
    this.items.forEach(item => {
      item.element.style.display = '';
      item.visible = true;
      this.removeHighlight(item.element);
    });

    if (this.options.showCount) {
      this.updateCount(this.items.length, this.items.length);
    }

    this.hideNoResults();
  }

  /**
   * Highlight search term in element
   * @param {HTMLElement} element - Element to highlight
   * @param {string} query - Search query
   */
  highlightElement(element, query) {
    // Remove existing highlights
    this.removeHighlight(element);

    const walker = document.createTreeWalker(
      element,
      NodeFilter.SHOW_TEXT,
      null,
      false
    );

    const nodes = [];
    while (walker.nextNode()) {
      nodes.push(walker.currentNode);
    }

    const regex = new RegExp(`(${this.escapeRegex(query)})`, 'gi');

    nodes.forEach(node => {
      if (node.nodeValue && regex.test(node.nodeValue)) {
        const span = document.createElement('span');
        span.innerHTML = node.nodeValue.replace(regex, '<mark>$1</mark>');
        node.parentNode.replaceChild(span, node);
      }
    });
  }

  /**
   * Remove highlights from element
   * @param {HTMLElement} element - Element
   */
  removeHighlight(element) {
    element.querySelectorAll('mark').forEach(mark => {
      mark.replaceWith(mark.textContent);
    });
  }

  /**
   * Escape regex special characters
   * @param {string} str - String to escape
   * @returns {string} Escaped string
   */
  escapeRegex(str) {
    return str.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
  }

  /**
   * Create count display
   */
  createCountDisplay() {
    this.countDisplay = document.createElement('div');
    this.countDisplay.className = 'search-count';
    this.countDisplay.style.cssText = `
      margin-top: 0.5rem;
      font-size: 0.875rem;
      color: var(--text-secondary, #666);
    `;

    this.input.parentElement.appendChild(this.countDisplay);
    this.updateCount(this.items.length, this.items.length);
  }

  /**
   * Update count display
   * @param {number} visible - Visible count
   * @param {number} total - Total count
   */
  updateCount(visible, total) {
    if (!this.countDisplay) return;

    this.countDisplay.textContent = `Showing ${visible} of ${total} items`;
  }

  /**
   * Show no results message
   */
  showNoResults() {
    if (this.noResultsElement) return;

    this.noResultsElement = document.createElement('div');
    this.noResultsElement.className = 'no-results';
    this.noResultsElement.innerHTML = `
      <i class="fas fa-search"></i>
      <p>${this.options.noResultsMessage}</p>
    `;
    this.noResultsElement.style.cssText = `
      text-align: center;
      padding: 2rem;
      color: var(--text-secondary, #666);
    `;

    const container = document.querySelector(this.targetSelector)?.parentElement;
    if (container) {
      container.appendChild(this.noResultsElement);
    }
  }

  /**
   * Hide no results message
   */
  hideNoResults() {
    if (this.noResultsElement) {
      this.noResultsElement.remove();
      this.noResultsElement = null;
    }
  }

  /**
   * Debounce function
   * @param {Function} func - Function to debounce
   * @param {number} wait - Wait time
   * @returns {Function} Debounced function
   */
  debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
      clearTimeout(timeout);
      timeout = setTimeout(() => func(...args), wait);
    };
  }

  /**
   * Refresh items cache
   */
  refresh() {
    this.cacheItems();
    this.filter(this.input.value);
  }

  /**
   * Destroy instant search
   */
  destroy() {
    this.showAll();
    
    if (this.countDisplay) {
      this.countDisplay.remove();
    }
    
    this.hideNoResults();
  }
}

// Add CSS styles for search components
const searchStyles = document.createElement('style');
searchStyles.textContent = `
  .search-result-item {
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem;
    cursor: pointer;
    transition: background-color 0.2s;
    border-bottom: 1px solid var(--border-color, #eee);
  }

  .search-result-item:last-child {
    border-bottom: none;
  }

  .search-result-item:hover,
  .search-result-item.selected {
    background-color: var(--hover-bg, #f5f5f5);
  }

  .result-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--primary-color, #3498db);
    color: white;
    border-radius: 8px;
    margin-right: 1rem;
    flex-shrink: 0;
  }

  .result-content {
    flex: 1;
    min-width: 0;
  }

  .result-title {
    font-weight: 600;
    color: var(--text-primary, #333);
    margin-bottom: 0.25rem;
  }

  .result-description {
    font-size: 0.875rem;
    color: var(--text-secondary, #666);
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  .result-category {
    font-size: 0.75rem;
    color: var(--primary-color, #3498db);
    margin-top: 0.25rem;
  }

  .search-section-title {
    padding: 0.75rem 1rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    color: var(--text-secondary, #666);
    background: var(--bg-secondary, #f9f9f9);
  }

  .remove-recent {
    background: none;
    border: none;
    color: var(--text-secondary, #666);
    cursor: pointer;
    padding: 0.25rem 0.5rem;
    opacity: 0;
    transition: opacity 0.2s;
  }

  .search-result-item:hover .remove-recent {
    opacity: 1;
  }

  .remove-recent:hover {
    color: var(--error-color, #e74c3c);
  }

  .search-no-results,
  .search-loading,
  .search-error {
    padding: 2rem;
    text-align: center;
    color: var(--text-secondary, #666);
  }

  .search-no-results i,
  .search-loading i,
  .search-error i {
    font-size: 2rem;
    margin-bottom: 1rem;
    display: block;
  }

  .search-loading i {
    color: var(--primary-color, #3498db);
  }

  .search-error i {
    color: var(--error-color, #e74c3c);
  }

  mark {
    background-color: var(--highlight-bg, #fff59d);
    color: inherit;
    padding: 0 0.125rem;
    border-radius: 2px;
  }
`;
document.head.appendChild(searchStyles);

// Export for use in other modules
if (typeof module !== 'undefined' && module.exports) {
  module.exports = { SearchEngine, InstantSearch };
}
* Create search engine instance
   * @param {string} inputId - Search input ID
   * @param {Object} options - Configuration options
   */
  constructor(inputId, options = {}) {
    this.input = document.getElementById(inputId);
    this.options = {
      minLength: 2,
      debounceDelay: 300,
      maxResults: 10,
      showRecent: true,
      highlightMatches: true,
      enableKeyboard: true,
      searchUrl: '/api/search',
      localData: null, // For client-side search
      ...options
    };

    this.results = [];
    this.selectedIndex = -1;
    this.isOpen = false;
    this.cache = new Map();

    if (this.input) {
      this.init();
    }
  }

  /**
   * Initialize search engine
   */
  init() {
    this.createResultsContainer();
    this.bindEvents();
    this.loadRecentSearches();
  }

  /**
   * Create results container
   */
  createResultsContainer() {
    this.resultsContainer = document.createElement('div');
    this.resultsContainer.className = 'search-results';
    this.resultsContainer.id = `${this.input.id}-results`;
    this.resultsContainer.setAttribute('role', 'listbox');
    this.resultsContainer.style.cssText = `
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      margin-top: 0.5rem;
      background: var(--card-bg, white);
      border: 1px solid var(--border-color, #ddd);
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      max-height: 400px;
      overflow-y: auto;
      z-index: 1000;
      display: none;
    `;

    // Make input container relative
    const wrapper = this.input.parentElement;
    if (wrapper && getComputedStyle(wrapper).position === 'static') {
      wrapper.style.position = 'relative';
    }

    wrapper.appendChild(this.resultsContainer);
  }

  /**
   * Bind event listeners
   */
  bindEvents() {
    // Debounced search on input
    this.debouncedSearch = this.debounce(
      (query) => this.search(query),
      this.options.debounceDelay
    );

    this.input.addEventListener('input', (e) => {
      const query = e.target.value.trim();
      
      if (query.length >= this.options.minLength) {
        this.debouncedSearch(query);
      } else {
        this.hideResults();
      }
    });

    // Show recent searches on focus
    this.input.addEventListener('focus', () => {
      if (!this.input.value && this.options.showRecent) {
        this.showRecentSearches();
      }
    });

    // Keyboard navigation
    if (this.options.enableKeyboard) {
      this.input.addEventListener('keydown', (e) => this.handleKeyboard(e));
    }

    // Click outside to close
    document.addEventListener('click', (e) => {
      if (!this.input.contains(e.target) && !this.resultsContainer.contains(e.target)) {
        this.hideResults();
      }
    });

    // Handle result clicks
    this.resultsContainer.addEventListener('click', (e) => {
      const item = e.target.closest('.search-result-item');
      if (item) {
        this.selectResult(parseInt(item.dataset.index));
      }
    });
  }

  /**
   * Perform search
   * @param {string} query - Search query
   */
  async search(query) {
    if (!query) {
      this.hideResults();
      return;
    }

    // Check cache
    if (this.cache.has(query)) {
      this.results = this.cache.get(query);
      this.displayResults(query);
      return;
    }

    try {
      // Show loading state
      this.showLoading();

      let results;

      // Client-side search
      if (this.options.localData) {
        results = this.searchLocal(query, this.options.localData);
      } 
      // Server-side search
      else {
        results = await this.searchRemote(query);
      }

      // Cache results
      this.cache.set(query, results);
      
      this.results = results;
      this.displayResults(query);

    } catch (error) {
      console.error('Search error:', error);
      this.showError('Search failed. Please try again.');
    }
  }

   /**
   * Client-side search
   * @param {string} query - Search query
   * @param {Array} data - Data to search
   * @returns {Array} Search results
   */
  searchLocal(query, data) {
    const lowerQuery = query.toLowerCase();
    
    return data
      .filter(item => {
        // Search in title and description
        const title = (item.title || '').toLowerCase();
        const description = (item.description || '').toLowerCase();
        const category = (item.category || '').toLowerCase();
        
        return title.includes(lowerQuery) || 
               description.includes(lowerQuery) || 
               category.includes(lowerQuery);
      })
      .sort((a, b) => {
        // Sort by relevance (title matches first)
        const aTitle = (a.title || '').toLowerCase();
        const bTitle = (b.title || '').toLowerCase();
        
        const aStartsWith = aTitle.startsWith(lowerQuery);
        const bStartsWith = bTitle.startsWith(lowerQuery);
        
        if (aStartsWith && !bStartsWith) return -1;
        if (!aStartsWith && bStartsWith) return 1;
        
        return 0;
      })
      .slice(0, this.options.maxResults);
  }

  /**
   * Server-side search
   * @param {string} query - Search query
   * @returns {Promise<Array>} Search results
   */
  async searchRemote(query) {
    const url = new URL(this.options.searchUrl, window.location.origin);
    url.searchParams.set('q', query);
    url.searchParams.set('limit', this.options.maxResults);

    const response = await fetch(url, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json'
      }
    });

    if (!response.ok) {
      throw new Error('Search request failed');
    }

    const data = await response.json();
    return data.results || [];
  }

  /**
   * Display search results
   * @param {string} query - Search query
   */
  displayResults(query) {
    if (this.results.length === 0) {
      this.showNoResults();
      return;
    }

    let html = '<div class="search-results-list" role="list">';

    this.results.forEach((result, index) => {
      const title = this.options.highlightMatches 
        ? this.highlightText(result.title, query)
        : result.title;
      
      const description = result.description 
        ? (this.options.highlightMatches 
            ? this.highlightText(result.description, query)
            : result.description)
        : '';

      html += `
        <div class="search-result-item" 
             data-index="${index}" 
             role="option"
             aria-selected="${index === this.selectedIndex}">
          <div class="result-icon">
            <i class="fas fa-${result.icon || 'calculator'}"></i>
          </div>
          <div class="result-content">
            <div class="result-title">${title}</div>
            ${description ? `<div class="result-description">${description}</div>` : ''}
            ${result.category ? `<div class="result-category">${result.category}</div>` : ''}
          </div>
        </div>
      `;
    });

    html += '</div>';

    this.resultsContainer.innerHTML = html;
    this.showResults();
    this.selectedIndex = -1;
  }

  /**
   * Highlight matched text
   * @param {string} text - Text to highlight
   * @param {string} query - Search query
   * @returns {string} Highlighted text
   */
  highlightText(text, query) {
    if (!text || !query) return text;

    const regex = new RegExp(`(${this.escapeRegex(query)})`, 'gi');
    return text.replace(regex, '<mark>$1</mark>');
  }

  /**
   * Escape regex special characters
   * @param {string} str - String to escape
   * @returns {string} Escaped string
   */
  escapeRegex(str) {
    return str.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
  }

  /**
   * Show recent searches
   */
  showRecentSearches() {
    const recent = this.getRecentSearches();
    
    if (recent.length === 0) return;

    let html = '<div class="search-results-list">';
    html += '<div class="search-section-title">Recent Searches</div>';

    recent.slice(0, 5).forEach((search, index) => {
      html += `
        <div class="search-result-item recent" data-index="${index}">
          <div class="result-icon">
            <i class="fas fa-history"></i>
          </div>
          <div class="result-content">
            <div class="result-title">${search}</div>
          </div>
          <button class="remove-recent" data-search="${search}" aria-label="Remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      `;
    });

    html += '</div>';

    this.resultsContainer.innerHTML = html;
    this.showResults();

    // Bind remove buttons
    this.resultsContainer.querySelectorAll('.remove-recent').forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.stopPropagation();
        this.removeRecentSearch(btn.dataset.search);
        this.showRecentSearches();
      });
    });

    // Use recent search on click
    this.results = recent.map(search => ({
      title: search,
      url: `/search.html?q=${encodeURIComponent(search)}`
    }));
  }

  /**
   * Show no results message
   */
  showNoResults() {
    this.resultsContainer.innerHTML = `
      <div class="search-no-results">
        <i class="fas fa-search"></i>
        <p>No results found</p>
      </div>
    `;
    this.showResults();
  }

  /**
   * Show loading state
   */
  showLoading() {
    this.resultsContainer.innerHTML = `
      <div class="search-loading">
        <i class="fas fa-spinner fa-spin"></i>
        <p>Searching...</p>
      </div>
    `;
    this.showResults();
  }

  /**  
