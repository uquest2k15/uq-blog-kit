/**
 * UQ Blog Kit JavaScript
 * WordPress 테마와 독립적인 블로그 동적 기능
 */

if (window.hasOwnProperty('jQuery') && 'function' === typeof window.jQuery) {

    (function ($) {

        $(document).ready(function () {
            
            // UQ Blog Kit 객체
            var UQBlogKit = {
                
                /**
                 * 초기화
                 */
                init: function() {
                    this.initGroups();
                    this.bindEvents();
                },

                /**
                 * 모든 그룹 초기화
                 */
                initGroups: function() {
                    var self = this;
                    
                    $('.uq-post-card-group').each(function() {
                        var $group = $(this);
                        var layoutType = $group.data('layout');
                        
                        switch(layoutType) {
                            case 'gallery':
                                self.initGalleryLayout($group);
                                break;
                            case 'row':
                                self.initRowLayout($group);
                                break;
                            case 'list':
                                self.initListLayout($group);
                                break;
                        }
                    });
                },

                /**
                 * Gallery 레이아웃 초기화
                 */
                initGalleryLayout: function($group) {
                    // Masonry 초기화
                    if ($group.data('masonry') === true) {
                        this.initMasonry($group);
                    }
                    
                    // 무한 스크롤 초기화
                    if ($group.data('infinite-scroll') === true) {
                        this.initInfiniteScroll($group);
                    }
                    
                    // 페이지네이션 초기화
                    var $pagination = $group.find('.uq-post-card-group__pagination');
                    if ($pagination.length && !$group.data('infinite-scroll')) {
                        this.initPagination($group);
                    }
                },

                /**
                 * Row 레이아웃 초기화
                 */
                initRowLayout: function($group) {
                    // 슬라이더/캐러셀 초기화
                    if ($group.hasClass('uq-post-card-group--slider')) {
                        this.initSlider($group);
                    }
                },

                /**
                 * List 레이아웃 초기화
                 */
                initListLayout: function($group) {
                    // 무한 스크롤 초기화
                    if ($group.data('infinite-scroll') === true) {
                        this.initInfiniteScroll($group);
                    }
                    
                    // 페이지네이션 초기화
                    var $pagination = $group.find('.uq-post-card-group__pagination');
                    if ($pagination.length && !$group.data('infinite-scroll')) {
                        this.initPagination($group);
                    }
                },

                /**
                 * Masonry 레이아웃
                 */
                initMasonry: function($group) {
                    var self = this;
                    var $inner = $group.find('.uq-post-card-group__inner');
                    var $images = $inner.find('img');
                    var loadedImages = 0;
                    var totalImages = $images.length;
                    
                    // 이미지 로드 체크
                    var checkImagesLoaded = function() {
                        loadedImages++;
                        if (loadedImages === totalImages) {
                            self.arrangeMasonry($inner);
                        }
                    };
                    
                    $images.each(function() {
                        var $img = $(this);
                        if (this.complete) {
                            checkImagesLoaded();
                        } else {
                            $img.on('load error', checkImagesLoaded);
                        }
                    });
                    
                    // 윈도우 리사이즈 시 재정렬
                    var resizeTimer;
                    $(window).on('resize', function() {
                        clearTimeout(resizeTimer);
                        resizeTimer = setTimeout(function() {
                            self.arrangeMasonry($inner);
                        }, 250);
                    });
                },

                /**
                 * Masonry 배치
                 */
                arrangeMasonry: function($container) {
                    // CSS columns가 자동으로 처리하므로 추가 로직은 필요시 구현
                },

                /**
                 * 슬라이더 초기화
                 */
                initSlider: function($group) {
                    var $container = $group.find('.uq-post-card-group__inner');
                    var $prevBtn = $group.find('.uq-post-card-group__nav--prev');
                    var $nextBtn = $group.find('.uq-post-card-group__nav--next');
                    var $cards = $container.find('.uq-post-card');
                    
                    if (!$container.length || !$prevBtn.length || !$nextBtn.length || $cards.length === 0) return;
                    
                    var currentIndex = 0;
                    var cardsPerView = parseInt($group.data('cards-per-row')) || 3;
                    var isCarousel = $group.data('carousel') === true;
                    var gap = parseInt($container.css('gap')) || 20;
                    
                    // 슬라이드 이동 함수
                    var slideTo = function(index) {
                        var cardWidth = $cards.first().outerWidth();
                        var totalWidth = cardWidth + gap;
                        var offset = -index * totalWidth;
                        
                        $container.css('transform', 'translateX(' + offset + 'px)');
                        currentIndex = index;
                        
                        updateNavButtons();
                    };
                    
                    // 네비게이션 버튼 업데이트
                    var updateNavButtons = function() {
                        if (!isCarousel) {
                            $prevBtn.prop('disabled', currentIndex === 0);
                            $nextBtn.prop('disabled', currentIndex >= $cards.length - cardsPerView);
                            
                            $prevBtn.css('opacity', $prevBtn.prop('disabled') ? '0.5' : '1');
                            $nextBtn.css('opacity', $nextBtn.prop('disabled') ? '0.5' : '1');
                        }
                    };
                    
                    // 이전 버튼 클릭
                    $prevBtn.on('click', function() {
                        if (isCarousel) {
                            currentIndex = currentIndex === 0 ? $cards.length - cardsPerView : currentIndex - 1;
                        } else {
                            currentIndex = Math.max(0, currentIndex - 1);
                        }
                        slideTo(currentIndex);
                    });
                    
                    // 다음 버튼 클릭
                    $nextBtn.on('click', function() {
                        if (isCarousel) {
                            currentIndex = currentIndex >= $cards.length - cardsPerView ? 0 : currentIndex + 1;
                        } else {
                            currentIndex = Math.min($cards.length - cardsPerView, currentIndex + 1);
                        }
                        slideTo(currentIndex);
                    });
                    
                    // 터치/스와이프 지원
                    var touchStartX = 0;
                    var touchEndX = 0;
                    
                    $container.on('touchstart', function(e) {
                        touchStartX = e.originalEvent.changedTouches[0].screenX;
                    });
                    
                    $container.on('touchend', function(e) {
                        touchEndX = e.originalEvent.changedTouches[0].screenX;
                        handleSwipe();
                    });
                    
                    var handleSwipe = function() {
                        var swipeThreshold = 50;
                        var diff = touchStartX - touchEndX;
                        
                        if (Math.abs(diff) > swipeThreshold) {
                            if (diff > 0) {
                                // 왼쪽으로 스와이프 (다음)
                                $nextBtn.click();
                            } else {
                                // 오른쪽으로 스와이프 (이전)
                                $prevBtn.click();
                            }
                        }
                    };
                    
                    // 초기 상태 설정
                    updateNavButtons();
                    
                    // 반응형 처리
                    var resizeTimer;
                    $(window).on('resize', function() {
                        clearTimeout(resizeTimer);
                        resizeTimer = setTimeout(function() {
                            slideTo(0); // 리사이즈 시 첫 번째로 리셋
                        }, 250);
                    });
                },

                /**
                 * 페이지네이션 초기화
                 */
                initPagination: function($group) {
                    var $paginationContainer = $group.find('.uq-post-card-group__pagination');
                    var $cards = $group.find('.uq-post-card');
                    var cardsPerPage = 9; // 페이지당 카드 수
                    var totalPages = Math.ceil($cards.length / cardsPerPage);
                    var currentPage = 1;
                    
                    // 페이지네이션 버튼 생성
                    var createPaginationButtons = function() {
                        $paginationContainer.empty();
                        
                        // 이전 버튼
                        if (totalPages > 1) {
                            var $prevBtn = $('<button>').text('이전');
                            $prevBtn.prop('disabled', currentPage === 1);
                            $prevBtn.on('click', function() {
                                goToPage(currentPage - 1);
                            });
                            $paginationContainer.append($prevBtn);
                        }
                        
                        // 페이지 번호 버튼
                        for (var i = 1; i <= totalPages; i++) {
                            // 많은 페이지일 경우 일부만 표시
                            if (totalPages > 7) {
                                if (i === 1 || i === totalPages || 
                                    (i >= currentPage - 1 && i <= currentPage + 1) ||
                                    (currentPage <= 3 && i <= 4) ||
                                    (currentPage >= totalPages - 2 && i >= totalPages - 3)) {
                                    
                                    var $pageBtn = $('<button>').text(i);
                                    $pageBtn.toggleClass('active', i === currentPage);
                                    (function(pageNum) {
                                        $pageBtn.on('click', function() {
                                            goToPage(pageNum);
                                        });
                                    })(i);
                                    $paginationContainer.append($pageBtn);
                                } else if ((i === currentPage - 2 && currentPage > 4) || 
                                           (i === currentPage + 2 && currentPage < totalPages - 3)) {
                                    var $dots = $('<span>').text('...').css('padding', '0 8px');
                                    $paginationContainer.append($dots);
                                }
                            } else {
                                var $pageBtn = $('<button>').text(i);
                                $pageBtn.toggleClass('active', i === currentPage);
                                (function(pageNum) {
                                    $pageBtn.on('click', function() {
                                        goToPage(pageNum);
                                    });
                                })(i);
                                $paginationContainer.append($pageBtn);
                            }
                        }
                        
                        // 다음 버튼
                        if (totalPages > 1) {
                            var $nextBtn = $('<button>').text('다음');
                            $nextBtn.prop('disabled', currentPage === totalPages);
                            $nextBtn.on('click', function() {
                                goToPage(currentPage + 1);
                            });
                            $paginationContainer.append($nextBtn);
                        }
                    };
                    
                    // 페이지 이동
                    var isInitialLoad = true; // 초기 로드 플래그 추가
                    var goToPage = function(page) {
                        if (page < 1 || page > totalPages) return;
                        
                        currentPage = page;
                        
                        // 카드 표시/숨김
                        $cards.each(function(index) {
                            var startIndex = (page - 1) * cardsPerPage;
                            var endIndex = startIndex + cardsPerPage;
                            
                            if (index >= startIndex && index < endIndex) {
                                $(this).show();
                            } else {
                                $(this).hide();
                            }
                        });
                        
                        // 페이지네이션 버튼 업데이트
                        createPaginationButtons();
                        
                        // 스크롤 위치 조정
                        // 초기 로드시에는 스크롤 하지 않음
                        if (!isInitialLoad) {
                            // 스크롤 애니메이션 비활성화
                            // $('html, body').animate({
                            //     scrollTop: $group.offset().top - 100
                            // }, 300);
                        }
                        isInitialLoad = false; // 초기 로드 후 플래그 해제
                    };
                    
                    // 초기화
                    createPaginationButtons();
                    goToPage(1);
                },

                /**
                 * 무한 스크롤 초기화
                 */
                initInfiniteScroll: function($group) {
                    var self = this;
                    var $loader = $group.find('.uq-post-card-group__loader');
                    var $inner = $group.find('.uq-post-card-group__inner');
                    
                    if (!$loader.length || !$inner.length) return;
                    
                    var isLoading = false;
                    var currentPage = 1;
                    var hasMore = true;
                    
                    // Intersection Observer 대신 스크롤 이벤트 사용
                    var loadMorePosts = function() {
                        if (isLoading || !hasMore) return;
                        
                        isLoading = true;
                        $loader.show();
                        
                        $.ajax({
                            url: uq_blog_ajax.ajax_url,
                            type: 'POST',
                            data: {
                                action: 'uq_load_more_posts',
                                nonce: uq_blog_ajax.nonce,
                                page: currentPage + 1,
                                per_page: 10,
                                layout_type: $group.data('layout')
                            },
                            success: function(response) {
                                if (response.success && response.data.html) {
                                    // 새 포스트 추가
                                    $inner.append(response.data.html);
                                    
                                    currentPage++;
                                    hasMore = response.data.has_more;
                                    
                                    // Masonry 레이아웃 재정렬
                                    if ($group.data('masonry') === true) {
                                        self.arrangeMasonry($inner);
                                    }
                                } else {
                                    hasMore = false;
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error loading more posts:', error);
                                hasMore = false;
                            },
                            complete: function() {
                                isLoading = false;
                                $loader.hide();
                                
                                if (!hasMore) {
                                    $(window).off('scroll.infiniteScroll' + $group.attr('id'));
                                }
                            }
                        });
                    };
                    
                    // 스크롤 이벤트로 무한 스크롤 구현
                    $(window).on('scroll.infiniteScroll' + $group.attr('id'), function() {
                        var scrollTop = $(window).scrollTop();
                        var windowHeight = $(window).height();
                        var documentHeight = $(document).height();
                        
                        // 페이지 하단 근처에 도달하면 로드
                        if (scrollTop + windowHeight > documentHeight - 200) {
                            loadMorePosts();
                        }
                    });
                },

                /**
                 * 이벤트 바인딩
                 */
                bindEvents: function() {
                    // 카드 호버 효과
                    $(document).on('mouseenter', '.uq-post-card', function() {
                        $(this).addClass('is-hovered');
                    }).on('mouseleave', '.uq-post-card', function() {
                        $(this).removeClass('is-hovered');
                    });
                    
                    // 키보드 네비게이션
                    $(document).on('keydown', function(e) {
                        var $activeElement = $(document.activeElement);
                        var $card = $activeElement.closest('.uq-post-card');
                        
                        if (!$card.length) return;
                        
                        var $group = $card.closest('.uq-post-card-group');
                        var $cards = $group.find('.uq-post-card');
                        var currentIndex = $cards.index($card);
                        var targetIndex = -1;
                        
                        switch(e.key) {
                            case 'ArrowRight':
                                targetIndex = currentIndex + 1;
                                break;
                            case 'ArrowLeft':
                                targetIndex = currentIndex - 1;
                                break;
                            case 'ArrowDown':
                                var columns = parseInt($group.data('columns')) || 3;
                                targetIndex = currentIndex + columns;
                                break;
                            case 'ArrowUp':
                                var columnsUp = parseInt($group.data('columns')) || 3;
                                targetIndex = currentIndex - columnsUp;
                                break;
                        }
                        
                        if (targetIndex >= 0 && targetIndex < $cards.length) {
                            e.preventDefault();
                            var $targetCard = $cards.eq(targetIndex);
                            var $focusableElement = $targetCard.find('a').first();
                            if ($focusableElement.length) {
                                $focusableElement.focus();
                            }
                        }
                    });
                    
                    // 이미지 lazy loading (선택사항)
                    if ('IntersectionObserver' in window) {
                        var imageObserver = new IntersectionObserver(function(entries, observer) {
                            entries.forEach(function(entry) {
                                if (entry.isIntersecting) {
                                    var $img = $(entry.target);
                                    var src = $img.data('src');
                                    if (src) {
                                        $img.attr('src', src);
                                        $img.removeAttr('data-src');
                                        observer.unobserve(entry.target);
                                    }
                                }
                            });
                        });
                        
                        $('.uq-post-card__image[data-src]').each(function() {
                            imageObserver.observe(this);
                        });
                    }
                }
            };
            
            // 초기화 실행
            UQBlogKit.init();
            
            // 전역 객체로 노출 (선택사항)
            window.UQBlogKit = UQBlogKit;
            
        });

    })(window.jQuery);
    
}

// AJAX 설정을 위한 전역 변수 (WordPress에서 제공)
if (typeof uq_blog_ajax === 'undefined') {
    window.uq_blog_ajax = {
        ajax_url: '/wp-admin/admin-ajax.php',
        nonce: ''
    };
}