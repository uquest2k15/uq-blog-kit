/**
 * UQ Blog Kit - Related Posts JavaScript
 * 
 * @package UQ_Blog_Kit
 * @subpackage Related_Posts
 * @since 1.1.0
 */

(function($) {
    'use strict';

    /**
     * Related Posts functionality
     */
    var RelatedPosts = {
        /**
         * Initialize
         */
        init: function() {
            this.bindEvents();
            this.observeViewport();
        },

        /**
         * Bind events
         */
        bindEvents: function() {
            // Track related post clicks
            $(document).on('click', '.related-post-card__link', function(e) {
                var $card = $(this).closest('.related-post-card');
                var postTitle = $card.find('.related-post-card__title').text();
                var postUrl = $(this).attr('href');
                
                // Trigger custom event for analytics
                $(document).trigger('relatedPostClick', {
                    title: postTitle,
                    url: postUrl,
                    position: $card.index() + 1
                });
            });

            // Handle dynamic content loading
            $(document).on('relatedPostsLoaded', function() {
                RelatedPosts.applyLazyLoading();
            });
        },

        /**
         * Observe viewport for lazy loading
         */
        observeViewport: function() {
            if ('IntersectionObserver' in window) {
                var imageObserver = new IntersectionObserver(function(entries, observer) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            var img = entry.target;
                            if (img.dataset.src) {
                                img.src = img.dataset.src;
                                img.removeAttribute('data-src');
                                observer.unobserve(img);
                            }
                        }
                    });
                }, {
                    rootMargin: '50px 0px',
                    threshold: 0.01
                });

                // Observe all lazy images
                $('.related-post-card__thumbnail img[data-src]').each(function() {
                    imageObserver.observe(this);
                });
            }
        },

        /**
         * Apply lazy loading to images
         */
        applyLazyLoading: function() {
            $('.related-post-card__thumbnail img').each(function() {
                var $img = $(this);
                if (!$img.attr('loading')) {
                    $img.attr('loading', 'lazy');
                }
            });
        },

        /**
         * Load more related posts via AJAX
         * 
         * @param {number} offset Current offset
         * @param {number} limit Number of posts to load
         */
        loadMorePosts: function(offset, limit) {
            var currentPostId = $('body').hasClass('single-post') ? $('article.post').attr('id').replace('post-', '') : 0;
            
            if (!currentPostId) return;

            $('.related-posts-section').addClass('related-posts-section--loading');

            $.ajax({
                url: ajaxurl || '/wp-admin/admin-ajax.php',
                type: 'POST',
                data: {
                    action: 'uq_load_more_related_posts',
                    post_id: currentPostId,
                    offset: offset,
                    limit: limit,
                    nonce: $('#related_posts_nonce').val()
                },
                success: function(response) {
                    if (response.success && response.data.html) {
                        $('.post-cards-grid').append(response.data.html);
                        $(document).trigger('relatedPostsLoaded');
                    }
                },
                complete: function() {
                    $('.related-posts-section').removeClass('related-posts-section--loading');
                }
            });
        },

        /**
         * Update grid layout based on viewport
         */
        updateGridLayout: function() {
            var $grid = $('.post-cards-grid');
            var viewportWidth = $(window).width();

            // Remove all grid classes
            $grid.removeClass('post-cards-grid--1x3 post-cards-grid--1x4 post-cards-grid--2x2 post-cards-grid--2x3');

            // Apply appropriate grid class based on viewport
            if (viewportWidth > 1024) {
                $grid.addClass('post-cards-grid--1x3');
            } else if (viewportWidth > 768) {
                $grid.addClass('post-cards-grid--2x2');
            }
            // Mobile uses default single column
        },

        /**
         * Track post views for better recommendations
         */
        trackPostView: function() {
            if ($('body').hasClass('single-post')) {
                var postId = $('article.post').attr('id').replace('post-', '');
                
                // Store in localStorage for client-side tracking
                var viewedPosts = JSON.parse(localStorage.getItem('uq_viewed_posts') || '[]');
                if (viewedPosts.indexOf(postId) === -1) {
                    viewedPosts.push(postId);
                    // Keep only last 50 viewed posts
                    if (viewedPosts.length > 50) {
                        viewedPosts = viewedPosts.slice(-50);
                    }
                    localStorage.setItem('uq_viewed_posts', JSON.stringify(viewedPosts));
                }
            }
        }
    };

    /**
     * DOM Ready
     */
    $(document).ready(function() {
        RelatedPosts.init();
        RelatedPosts.trackPostView();

        // Handle responsive grid
        var resizeTimer;
        $(window).on('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                RelatedPosts.updateGridLayout();
            }, 250);
        });
    });

    /**
     * Expose to global scope
     */
    window.UQRelatedPosts = RelatedPosts;

})(jQuery);