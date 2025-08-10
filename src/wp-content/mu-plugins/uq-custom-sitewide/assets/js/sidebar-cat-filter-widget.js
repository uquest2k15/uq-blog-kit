/**
 * UQ Blog Sidebar Category Filter Widget JavaScript
 * 
 * @package UQ_Blog_Kit
 * @subpackage Widgets
 * @since 1.1.0
 */

(function($) {
    'use strict';
    
    /**
     * Category Filter Widget Handler
     */
    var UQCategoryFilterWidget = {
        
        /**
         * Initialize the widget functionality
         */
        init: function() {
            this.bindEvents();
            this.setupAccessibility();
        },
        
        /**
         * Bind event handlers
         */
        bindEvents: function() {
            // Search button click handler
            $(document).on('click', '.uq_sidebar_cat_filter_widget .widget__search-btn', function(e) {
                e.preventDefault();
                UQCategoryFilterWidget.triggerGlobalSearch();
            });
            
            // Keyboard support for search button
            $(document).on('keydown', '.uq_sidebar_cat_filter_widget .widget__search-btn', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    UQCategoryFilterWidget.triggerGlobalSearch();
                }
            });
            
            // Update active state on page load
            this.updateActiveState();
        },
        
        /**
         * Setup accessibility features
         */
        setupAccessibility: function() {
            // Add keyboard navigation hints
            $('.uq_sidebar_cat_filter_widget .category-list').attr('role', 'list');
            $('.uq_sidebar_cat_filter_widget .category-list__item').attr('role', 'listitem');
            
            // Ensure proper focus management
            $('.uq_sidebar_cat_filter_widget .widget__search-btn').attr('tabindex', '0');
        },
        
        /**
         * Trigger global search popup
         */
        triggerGlobalSearch: function() {
            // Check if global search function exists
            if (typeof openGlobalSearch === 'function') {
                openGlobalSearch();
            } else if (typeof window.openGlobalSearch === 'function') {
                window.openGlobalSearch();
            } else {
                // Fallback: trigger GeneratePress search if available
                var $searchToggle = $('.menu-bar-item.search-item a, .nav-search-icon');
                if ($searchToggle.length) {
                    $searchToggle.trigger('click');
                } else {
                    // Last resort: focus on first search input found
                    var $searchInput = $('input[type="search"], input.search-field').first();
                    if ($searchInput.length) {
                        $searchInput.focus();
                    } else {
                        console.warn('UQ Category Filter Widget: No global search function or search input found');
                    }
                }
            }
        },
        
        /**
         * Update active state based on current page
         */
        updateActiveState: function() {
            // This is already handled by PHP, but we can add dynamic updates here if needed
            var currentUrl = window.location.href;
            
            $('.uq_sidebar_cat_filter_widget .category-list__link').each(function() {
                var $link = $(this);
                var href = $link.attr('href');
                
                // Remove trailing slashes for comparison
                currentUrl = currentUrl.replace(/\/$/, '');
                href = href.replace(/\/$/, '');
                
                if (currentUrl === href) {
                    $link.parent().addClass('category-list__item--active');
                    $link.attr('aria-current', 'page');
                }
            });
        },
        
        /**
         * Helper function to check if element is in viewport
         */
        isInViewport: function(element) {
            var rect = element.getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        }
    };
    
    /**
     * Initialize on document ready
     */
    $(document).ready(function() {
        UQCategoryFilterWidget.init();
    });
    
    /**
     * Re-initialize on widget update (for customizer)
     */
    $(document).on('widget-updated widget-added', function(e, widget) {
        if (widget && widget.find('.uq_sidebar_cat_filter_widget').length) {
            UQCategoryFilterWidget.init();
        }
    });
    
    /**
     * Export for external use
     */
    window.UQCategoryFilterWidget = UQCategoryFilterWidget;
    
})(jQuery);