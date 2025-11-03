/**
 * Theme Switcher
 * Dark/Light mode functionality
 */

(function() {
    'use strict';

    class ThemeManager {
        constructor() {
            this.currentTheme = localStorage.getItem('theme') || 'light';
            this.toggle = document.getElementById('theme-toggle');
            
            this.init();
        }

        /**
         * Initialize Theme Manager
         */
        init() {
            // Set initial theme
            this.setTheme(this.currentTheme);

            // Add toggle handler
            if (this.toggle) {
                this.toggle.addEventListener('click', () => {
                    this.toggleTheme();
                });
            }

            // Listen for system theme changes
            if (window.matchMedia) {
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                    if (!localStorage.getItem('theme')) {
                        this.setTheme(e.matches ? 'dark' : 'light');
                    }
                });
            }
        }

        /**
         * Set Theme
         */
        setTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            this.currentTheme = theme;
            localStorage.setItem('theme', theme);

            // Update toggle button
            if (this.toggle) {
                this.updateToggleButton(theme);
            }

            // Dispatch theme change event
            window.dispatchEvent(new CustomEvent('themeChanged', {
                detail: { theme: theme }
            }));
        }

        /**
         * Toggle Theme
         */
        toggleTheme() {
            const newTheme = this.currentTheme === 'dark' ? 'light' : 'dark';
            this.setTheme(newTheme);
        }

        /**
         * Update Toggle Button
         */
        updateToggleButton(theme) {
            const icon = this.toggle.querySelector('i');
            if (icon) {
                icon.className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
            }
        }

        /**
         * Get Current Theme
         */
        getCurrentTheme() {
            return this.currentTheme;
        }
    }

    // Initialize theme manager
    window.themeManager = new ThemeManager();

})();