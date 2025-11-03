/**
 * Main JavaScript - COMPLETELY FIXED Mobile Menu
 */

const BASE_URL = window.location.origin + '/Calculator';

// ==================== DOM Ready ====================
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Ready - Initializing...');
    initMobileMenu();
    initSearch();
    initSmoothScroll();
});

// ==================== COMPLETELY FIXED Mobile Menu ====================
function initMobileMenu() {
    const mobileToggle = document.getElementById('mobileMenuToggle');
    const mainNav = document.getElementById('mainNav');
    const mobileOverlay = document.getElementById('mobileOverlay');
    const mobileClose = document.getElementById('mobileClose');
    
    if (!mobileToggle || !mainNav || !mobileOverlay || !mobileClose) {
        console.error('Mobile menu elements missing');
        return;
    }
    
    console.log('Mobile menu elements found');
    
    let isOpen = false;
    
    // Function to open menu
    function openMenu() {
        console.log('Opening menu');
        isOpen = true;
        mainNav.classList.add('active');
        mobileOverlay.classList.add('active');
        document.body.classList.add('menu-open');
        mobileToggle.setAttribute('aria-label', 'Close Menu');
    }
    
    // Function to close menu
    function closeMenu() {
        console.log('Closing menu');
        isOpen = false;
        mainNav.classList.remove('active');
        mobileOverlay.classList.remove('active');
        document.body.classList.remove('menu-open');
        mobileToggle.setAttribute('aria-label', 'Open Menu');
        
        // Close all dropdowns
        document.querySelectorAll('.has-dropdown').forEach(item => {
            item.classList.remove('active');
        });
    }
    
    // Toggle menu on hamburger click
    mobileToggle.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('Toggle clicked, isOpen:', isOpen);
        
        if (isOpen) {
            closeMenu();
        } else {
            openMenu();
        }
    });
    
    // Close button
    mobileClose.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('Close button clicked');
        closeMenu();
    });
    
    // Overlay click
    mobileOverlay.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('Overlay clicked');
        closeMenu();
    });
    
    // ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && isOpen) {
            console.log('ESC pressed');
            closeMenu();
        }
    });
    
    // Dropdown toggles for mobile
    const dropdownToggles = document.querySelectorAll('.has-dropdown > a');
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                e.stopPropagation();
                
                const parent = this.parentElement;
                const wasActive = parent.classList.contains('active');
                
                // Close all dropdowns
                document.querySelectorAll('.has-dropdown').forEach(item => {
                    item.classList.remove('active');
                });
                
                // Toggle current
                if (!wasActive) {
                    parent.classList.add('active');
                }
            }
        });
    });
    
    // Close menu when clicking internal links (not dropdowns)
    const directLinks = document.querySelectorAll('.nav-menu > li:not(.has-dropdown) > a, .nav-dropdown a');
    directLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                setTimeout(closeMenu, 300);
            }
        });
    });
    
    // Handle window resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (window.innerWidth > 768 && isOpen) {
                closeMenu();
            }
        }, 250);
    });
}

// ==================== Search Functionality ====================
function initSearch() {
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');
    const searchButton = document.getElementById('searchButton');
    
    let searchTimeout;
    
    if (searchInput && searchResults) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();
            
            if (query.length < 2) {
                searchResults.classList.remove('active');
                return;
            }
            
            searchTimeout = setTimeout(() => {
                performSearch(query);
            }, 300);
        });
        
        if (searchButton) {
            searchButton.addEventListener('click', function(e) {
                e.preventDefault();
                const query = searchInput.value.trim();
                if (query.length >= 2) {
                    performSearch(query);
                }
            });
        }
        
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.classList.remove('active');
            }
        });
        
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                searchResults.classList.remove('active');
            }
        });
    }
}

async function performSearch(query) {
    const searchResults = document.getElementById('searchResults');
    
    try {
        searchResults.innerHTML = '<div class="search-result-item">Searching...</div>';
        searchResults.classList.add('active');
        
        const response = await fetch(`${BASE_URL}/api/search.php?q=${encodeURIComponent(query)}`);
        
        if (!response.ok) {
            throw new Error('Search failed');
        }
        
        const data = await response.json();
        
        if (!data.success || !data.results || data.results.length === 0) {
            searchResults.innerHTML = `<div class="search-result-item">No results found for "${escapeHtml(query)}"</div>`;
            return;
        }
        
        let html = '';
        data.results.slice(0, 8).forEach(result => {
            const url = `${BASE_URL}/calculators/${result.category}/${result.slug}.php`;
            html += `
                <a href="${url}" class="search-result-item">
                    <div class="search-result-title">${highlightMatch(escapeHtml(result.name), query)}</div>
                    <div class="search-result-category">${escapeHtml(result.category_name || result.category)}</div>
                </a>
            `;
        });
        
        if (data.results.length > 8) {
            html += `<div class="search-result-item search-result-more">+${data.results.length - 8} more results</div>`;
        }
        
        searchResults.innerHTML = html;
        searchResults.classList.add('active');
        
    } catch (error) {
        console.error('Search error:', error);
        searchResults.innerHTML = `<div class="search-result-item">Error performing search</div>`;
    }
}

function highlightMatch(text, query) {
    const regex = new RegExp(`(${escapeRegex(query)})`, 'gi');
    return text.replace(regex, '<strong>$1</strong>');
}

function escapeRegex(string) {
    return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// ==================== Smooth Scroll ====================
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === '#' || href === 'javascript:void(0)') return;
            
            e.preventDefault();
            const target = document.querySelector(href);
            
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}