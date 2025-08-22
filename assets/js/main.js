/**
 * ScodeTheme Main JavaScript
 *
 * @package ScodeTheme
 */

(function($) {
    'use strict';

    // DOM Ready
    $(document).ready(function() {
        initTheme();
    });

    // Window Load
    $(window).on('load', function() {
        // Hide loading overlay
        $('#loading-overlay').removeClass('show');
    });

    /**
     * Initialize theme functionality
     */
    function initTheme() {
        initCountdownTimer();
        initQuickView();
        initAddToCart();
        initBackToTop();
        initMobileMenu();
        initSearch();
        initNewsletter();
        initSmoothScroll();
        initLazyLoading();
        initProductHover();
    }

    /**
     * Flash Sale Countdown Timer
     */
    function initCountdownTimer() {
        const countdownElement = $('.flash-sale-countdown');
        if (countdownElement.length === 0) return;

        // Set end time (24 hours from now)
        const endTime = new Date().getTime() + (24 * 60 * 60 * 1000);

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = endTime - now;

            if (distance < 0) {
                // Countdown finished
                $('.countdown-timer').html('<span>Kết thúc!</span>');
                return;
            }

            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            $('#countdown-hours').text(hours.toString().padStart(2, '0'));
            $('#countdown-minutes').text(minutes.toString().padStart(2, '0'));
            $('#countdown-seconds').text(seconds.toString().padStart(2, '0'));
        }

        // Update countdown every second
        updateCountdown();
        setInterval(updateCountdown, 1000);
    }

    /**
     * Quick View Functionality
     */
    function initQuickView() {
        $(document).on('click', '.quick-view', function(e) {
            e.preventDefault();
            
            const productId = $(this).data('product-id');
            const button = $(this);
            
            // Show loading state
            button.html('<i class="fas fa-spinner fa-spin"></i>');
            
            // AJAX request for quick view
            $.ajax({
                url: scode_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'scode_quick_view',
                    product_id: productId,
                    nonce: scode_ajax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        showQuickViewModal(response.data);
                    } else {
                        showNotification('Có lỗi xảy ra khi tải thông tin sản phẩm', 'error');
                    }
                },
                error: function() {
                    showNotification('Có lỗi xảy ra khi tải thông tin sản phẩm', 'error');
                },
                complete: function() {
                    button.html('<i class="fas fa-eye"></i>');
                }
            });
        });
    }

    /**
     * Show Quick View Modal
     */
    function showQuickViewModal(content) {
        // Remove existing modal
        $('.quick-view-modal').remove();
        
        // Create modal HTML
        const modal = $(`
            <div class="quick-view-modal">
                <div class="modal-overlay"></div>
                <div class="modal-content">
                    <button class="modal-close">&times;</button>
                    ${content}
                </div>
            </div>
        `);
        
        // Add to body
        $('body').append(modal);
        
        // Show modal
        setTimeout(() => modal.addClass('show'), 10);
        
        // Close modal events
        modal.find('.modal-close, .modal-overlay').on('click', function() {
            modal.removeClass('show');
            setTimeout(() => modal.remove(), 300);
        });
        
        // Close on ESC key
        $(document).on('keydown.quickview', function(e) {
            if (e.keyCode === 27) {
                modal.removeClass('show');
                setTimeout(() => modal.remove(), 300);
                $(document).off('keydown.quickview');
            }
        });
    }

    /**
     * Add to Cart Functionality
     */
    function initAddToCart() {
        $(document).on('click', '.add-to-cart', function(e) {
            e.preventDefault();
            
            const button = $(this);
            const productId = button.data('product-id');
            
            // Show loading state
            const originalText = button.text();
            button.html('<i class="fas fa-spinner fa-spin"></i>');
            button.prop('disabled', true);
            
            // AJAX add to cart
            $.ajax({
                url: scode_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'woocommerce_ajax_add_to_cart',
                    product_id: productId,
                    nonce: scode_ajax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        showNotification('Đã thêm sản phẩm vào giỏ hàng!', 'success');
                        updateCartCount(response.data.cart_count);
                        button.text('Đã thêm');
                        button.addClass('added');
                        
                        setTimeout(() => {
                            button.text(originalText);
                            button.removeClass('added');
                        }, 2000);
                    } else {
                        showNotification('Có lỗi xảy ra khi thêm vào giỏ hàng', 'error');
                    }
                },
                error: function() {
                    showNotification('Có lỗi xảy ra khi thêm vào giỏ hàng', 'error');
                },
                complete: function() {
                    button.prop('disabled', false);
                }
            });
        });
    }

    /**
     * Update Cart Count
     */
    function updateCartCount(count) {
        $('.cart-count').text(count);
        $('.cart-count').addClass('pulse');
        
        setTimeout(() => {
            $('.cart-count').removeClass('pulse');
        }, 1000);
    }

    /**
     * Back to Top Button
     */
    function initBackToTop() {
        const backToTop = $('#back-to-top');
        
        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 300) {
                backToTop.addClass('show');
            } else {
                backToTop.removeClass('show');
            }
        });
        
        backToTop.on('click', function() {
            $('html, body').animate({
                scrollTop: 0
            }, 800);
        });
    }

    /**
     * Mobile Menu Toggle
     */
    function initMobileMenu() {
        $('.menu-toggle').on('click', function() {
            const navigation = $('.main-navigation');
            navigation.toggleClass('mobile-open');
            
            if (navigation.hasClass('mobile-open')) {
                $('body').addClass('menu-open');
            } else {
                $('body').removeClass('menu-open');
            }
        });
        
        // Close menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.main-navigation, .menu-toggle').length) {
                $('.main-navigation').removeClass('mobile-open');
                $('body').removeClass('menu-open');
            }
        });
    }

    /**
     * Search Functionality
     */
    function initSearch() {
        const searchForm = $('.header-search');
        const searchInput = searchForm.find('input');
        const searchButton = searchForm.find('button');
        
        // Search button click
        searchButton.on('click', function(e) {
            e.preventDefault();
            performSearch();
        });
        
        // Enter key press
        searchInput.on('keypress', function(e) {
            if (e.keyCode === 13) {
                e.preventDefault();
                performSearch();
            }
        });
        
        // Auto-complete (if enabled)
        if (searchInput.length > 0) {
            searchInput.on('input', debounce(function() {
                const query = $(this).val();
                if (query.length >= 3) {
                    performAutoComplete(query);
                }
            }, 300));
        }
    }

    /**
     * Perform Search
     */
    function performSearch() {
        const query = $('.header-search input').val().trim();
        
        if (query.length === 0) {
            showNotification('Vui lòng nhập từ khóa tìm kiếm', 'warning');
            return;
        }
        
        // Redirect to search results
        window.location.href = scode_ajax.site_url + '?s=' + encodeURIComponent(query);
    }

    /**
     * Newsletter Subscription
     */
    function initNewsletter() {
        $('.newsletter-form').on('submit', function(e) {
            e.preventDefault();
            
            const form = $(this);
            const email = form.find('input[name="newsletter_email"]').val();
            const submitBtn = form.find('.newsletter-submit');
            
            if (!isValidEmail(email)) {
                showNotification('Vui lòng nhập email hợp lệ', 'warning');
                return;
            }
            
            // Show loading state
            const originalIcon = submitBtn.html();
            submitBtn.html('<i class="fas fa-spinner fa-spin"></i>');
            submitBtn.prop('disabled', true);
            
            // AJAX subscription
            $.ajax({
                url: scode_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'scode_newsletter',
                    email: email,
                    nonce: scode_ajax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        showNotification('Đăng ký nhận tin thành công!', 'success');
                        form[0].reset();
                    } else {
                        showNotification('Có lỗi xảy ra khi đăng ký', 'error');
                    }
                },
                error: function() {
                    showNotification('Có lỗi xảy ra khi đăng ký', 'error');
                },
                complete: function() {
                    submitBtn.html(originalIcon);
                    submitBtn.prop('disabled', false);
                }
            });
        });
    }

    /**
     * Smooth Scroll for Anchor Links
     */
    function initSmoothScroll() {
        $('a[href^="#"]').on('click', function(e) {
            const target = $(this.getAttribute('href'));
            
            if (target.length) {
                e.preventDefault();
                
                $('html, body').animate({
                    scrollTop: target.offset().top - 100
                }, 800);
            }
        });
    }

    /**
     * Lazy Loading for Images
     */
    function initLazyLoading() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });
            
            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    }

    /**
     * Product Hover Effects
     */
    function initProductHover() {
        $('.product-card').on('mouseenter', function() {
            $(this).addClass('hover');
        }).on('mouseleave', function() {
            $(this).removeClass('hover');
        });
    }

    /**
     * Show Notification
     */
    function showNotification(message, type = 'info') {
        // Remove existing notifications
        $('.notification').remove();
        
        const notification = $(`
            <div class="notification notification-${type}">
                <div class="notification-content">
                    <span class="notification-message">${message}</span>
                    <button class="notification-close">&times;</button>
                </div>
            </div>
        `);
        
        $('body').append(notification);
        
        // Show notification
        setTimeout(() => notification.addClass('show'), 10);
        
        // Auto hide after 5 seconds
        setTimeout(() => {
            notification.removeClass('show');
            setTimeout(() => notification.remove(), 300);
        }, 5000);
        
        // Close button
        notification.find('.notification-close').on('click', function() {
            notification.removeClass('show');
            setTimeout(() => notification.remove(), 300);
        });
    }

    /**
     * Utility Functions
     */
    
    // Debounce function
    function debounce(func, wait, immediate) {
        let timeout;
        return function executedFunction() {
            const context = this;
            const args = arguments;
            const later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }
    
    // Email validation
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    /**
     * WooCommerce Specific Functions
     */
    if (typeof wc_add_to_cart_params !== 'undefined') {
        // Update cart fragments
        $(document.body).on('added_to_cart', function(event, fragments, cart_hash, button) {
            // Update cart count
            if (fragments && fragments['div.widget_shopping_cart_content']) {
                $('.cart-count').text(fragments['div.widget_shopping_cart_content'].find('.cart-count').text());
            }
        });
    }

    /**
     * Performance Optimizations
     */
    
    // Throttle scroll events
    let ticking = false;
    $(window).on('scroll', function() {
        if (!ticking) {
            requestAnimationFrame(function() {
                // Handle scroll events here
                ticking = false;
            });
            ticking = true;
        }
    });
    
    // Preload critical images
    function preloadImages() {
        const criticalImages = [
            // Add critical image URLs here
        ];
        
        criticalImages.forEach(src => {
            const img = new Image();
            img.src = src;
        });
    }
    
    // Initialize preloading
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', preloadImages);
    } else {
        preloadImages();
    }

    /**
     * Accessibility Improvements
     */
    
    // Keyboard navigation for dropdowns
    $('.main-menu > li').on('keydown', function(e) {
        const $this = $(this);
        const $submenu = $this.find('.submenu');
        
        if (e.keyCode === 13 || e.keyCode === 32) { // Enter or Space
            e.preventDefault();
            $submenu.toggle();
        }
    });
    
    // Focus management for modals
    function trapFocus(element) {
        const focusableElements = element.find(
            'a[href], button, textarea, input[type="text"], input[type="radio"], input[type="checkbox"], select'
        );
        
        const firstFocusableElement = focusableElements[0];
        const lastFocusableElement = focusableElements[focusableElements.length - 1];
        
        element.on('keydown', function(e) {
            if (e.keyCode === 9) { // Tab key
                if (e.shiftKey) {
                    if (document.activeElement === firstFocusableElement) {
                        e.preventDefault();
                        lastFocusableElement.focus();
                    }
                } else {
                    if (document.activeElement === lastFocusableElement) {
                        e.preventDefault();
                        firstFocusableElement.focus();
                    }
                }
            }
        });
    }

    /**
     * Error Handling
     */
    window.addEventListener('error', function(e) {
        console.error('JavaScript error:', e.error);
        // You can send error reports to your analytics service here
    });

    // Global error handler for AJAX
    $(document).ajaxError(function(event, xhr, settings, error) {
        console.error('AJAX error:', error);
        showNotification('Có lỗi xảy ra khi tải dữ liệu', 'error');
    });

})(jQuery);
