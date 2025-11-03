/**
 * Search Functionality
 * Advanced search with autocomplete
 */

(function() {
    'use strict';

    class Search {
        constructor(inputId, resultsId, options = {}) {
            this.input = document.getElementById(inputId);
            this.results = document.getElementById(resultsId);
            this.options = {
                minLength: options.minLength || 2,
                delay: options.delay || 300,
                maxResults: options.maxResults || 10,
                onSelect: options.onSelect || null
            };
            
            this.searchTimeout = null;
            this.currentIndex = -1;
            this.resultItems = [];

            if (this.input && this.results) {
                this.init();
            }
        }

        /**
         * Initialize Search
         */
        init() {
            this.input.addEventListener('input', (e) => {
                this.handleInput(e.target.value);
            });

            this.input.addEventListener('keydown', (e) => {
                this.handleKeyboard(e);
            });

            this.input.addEventListener('focus', () => {
                if (this.resultItems.length > 0) {
                    this.show();
                }
            });

            // Close on click outside
            document.addEventListener('click', (e) => {
                if (!this.input.contains(e.target) && !this.results.contains(e.target)) {
                    this.hide();
                }
            });
        }

        /**
         * Handle Input
         */
        handleInput(value) {
            clearTimeout(this.searchTimeout);

            const query = value.trim();

            if (query.length < this.options.minLength) {
                this.hide();
                return;
            }

            this.searchTimeout = setTimeout(() => {
                this.performSearch(query);
            }, this.options.delay);
        }

        /**
         * Perform Search
         */
        async performSearch(query) {
            try {
                const response = await fetch(`/api/search?q=${encodeURIComponent(query)}&limit=${this.options.maxResults}`);
                const data = await response.json();
                
                this.resultItems = data.results || [];
                this.displayResults(this.resultItems);
            } catch (error) {
                console.error('Search error:', error);
                this.displayError('Search failed. Please try again.');
            }
        }

        /**
         * Display Results
         */
        displayResults(results) {
            if (results.length === 0) {
                this.results.innerHTML = '<div class="search-no-results">No results found</div>';
                this.show();
                return;
            }

            this.results.innerHTML = results.map((result, index) => `
                <div class="search-result-item" data-index="${index}">
                    <i class="fas fa-${this.getIcon(result.category)}"></i>
                    <div class="search-result-content">
                        <div class="search-result-name">${this.highlightQuery(result.name, this.input.value)}</div>
                        <div class="search-result-category">${result.category}</div>
                    </div>
                </div>
            `).join('');

            // Add click handlers
            this.results.querySelectorAll('.search-result-item').forEach((item, index) => {
                item.addEventListener('click', () => {
                    this.selectResult(results[index]);
                });

                item.addEventListener('mouseenter', () => {
                    this.setActiveIndex(index);
                });
            });

            this.show();
            this.currentIndex = -1;
        }

        /**
         * Display Error
         */
        displayError(message) {
            this.results.innerHTML = `<div class="search-error">${message}</div>`;
            this.show();
        }

        /**
         * Handle Keyboard Navigation
         */
        handleKeyboard(e) {
            const items = this.results.querySelectorAll('.search-result-item');
            
            if (items.length === 0) return;

            switch(e.key) {
                case 'ArrowDown':
                    e.preventDefault();
                    this.currentIndex = Math.min(this.currentIndex + 1, items.length - 1);
                    this.setActiveIndex(this.currentIndex);
                    break;

                case 'ArrowUp':
                    e.preventDefault();
                    this.currentIndex = Math.max(this.currentIndex - 1, -1);
                    this.setActiveIndex(this.currentIndex);
                    break;

                case 'Enter':
                    e.preventDefault();
                    if (this.currentIndex >= 0) {
                        this.selectResult(this.resultItems[this.currentIndex]);
                    }
                    break;

                case 'Escape':
                    this.hide();
                    this.input.blur();
                    break;
            }
        }

        /**
         * Set Active Index
         */
        setActiveIndex(index) {
            const items = this.results.querySelectorAll('.search-result-item');
            items.forEach(item => item.classList.remove('active'));

            if (index >= 0 && index < items.length) {
                items[index].classList.add('active');
                items[index].scrollIntoView({ block: 'nearest' });
            }
        }

        /**
         * Select Result
         */
        selectResult(result) {
            if (this.options.onSelect) {
                this.options.onSelect(result);
            } else {
                window.location.href = result.url;
            }
            this.hide();
        }

        /**
         * Highlight Query in Text
         */
        highlightQuery(text, query) {
            if (!query) return text;

            const regex = new RegExp(`(${query})`, 'gi');
            return text.replace(regex, '<mark>$1</mark>');
        }

        /**
         * Get Icon for Category
         */
        getIcon(category) {
            const icons = {
                'financial': 'dollar-sign',
                'health': 'heartbeat',
                'math': 'calculator',
                'conversion': 'exchange-alt',
                'date-time': 'calendar',
                'construction': 'hammer',
                'electronics': 'bolt',
                'automotive': 'car',
                'education': 'graduation-cap',
                'utility': 'tools',
                'weather': 'cloud',
                'cooking': 'utensils',
                'gaming': 'gamepad',
                'sports': 'football-ball'
            };
            return icons[category] || 'calculator';
        }

        /**
         * Show Results
         */
        show() {
            this.results.classList.add('show');
        }

        /**
         * Hide Results
         */
        hide() {
            this.results.classList.remove('show');
        }

        /**
         * Clear Search
         */
        clear() {
            this.input.value = '';
            this.hide();
            this.resultItems = [];
        }
    }

    // Make Search class globally available
    window.Search = Search;

    // Initialize search on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        const searchResults = document.getElementById('search-results');

        if (searchInput && searchResults) {
            new Search('search-input', 'search-results', {
                minLength: 2,
                delay: 300,
                maxResults: 10
            });
        }
    });

})();