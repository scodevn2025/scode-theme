/**
 * ScodeTheme Main JavaScript
 *
 * @package ScodeTheme
 */

jQuery(document).ready(function($) {
    'use strict';

    // ===== HERO SLIDER =====
    function initHeroSlider() {
        const $slider = $('.hero-slider');
        const $slides = $('.hero-slide');
        const $dots = $('.slider-dot');
        const $prevBtn = $('.slider-arrow.prev');
        const $nextBtn = $('.slider-arrow.next');
        
        if ($slides.length <= 1) return;
        
        let currentSlide = 0;
        const totalSlides = $slides.length;
        const autoPlayInterval = 6000; // 6 seconds
        let autoPlayTimer;
        
        function showSlide(index) {
            $slides.removeClass('active');
            $dots.removeClass('active');
            
            $slides.eq(index).addClass('active');
            $dots.eq(index).addClass('active');
            
            currentSlide = index;
            
            // Add entrance animation
            const $currentSlide = $slides.eq(index);
            $currentSlide.find('.slide-content-wrapper').addClass('slide-in');
            
            setTimeout(() => {
                $currentSlide.find('.slide-content-wrapper').removeClass('slide-in');
            }, 1000);
        }
        
        function nextSlide() {
            const nextIndex = (currentSlide + 1) % totalSlides;
            showSlide(nextIndex);
        }
        
        function prevSlide() {
            const prevIndex = (currentSlide - 1 + totalSlides) % totalSlides;
            showSlide(prevIndex);
        }
        
        function startAutoPlay() {
            autoPlayTimer = setInterval(nextSlide, autoPlayInterval);
        }
        
        function stopAutoPlay() {
            clearInterval(autoPlayTimer);
        }
        
        // Event listeners
        $dots.on('click', function() {
            const slideIndex = $(this).data('slide');
            showSlide(slideIndex);
            stopAutoPlay();
            startAutoPlay();
        });
        
        $prevBtn.on('click', function() {
            prevSlide();
            stopAutoPlay();
            startAutoPlay();
        });
        
        $nextBtn.on('click', function() {
            nextSlide();
            stopAutoPlay();
            startAutoPlay();
        });
        
        // Pause auto-play on hover
        $slider.on('mouseenter', stopAutoPlay);
        $slider.on('mouseleave', startAutoPlay);
        
        // Keyboard navigation
        $(document).on('keydown', function(e) {
            if (e.keyCode === 37) { // Left arrow
                prevSlide();
                stopAutoPlay();
                startAutoPlay();
            } else if (e.keyCode === 39) { // Right arrow
                nextSlide();
                stopAutoPlay();
                startAutoPlay();
            }
        });
        
        // Touch/swipe support for mobile
        let startX = 0;
        let endX = 0;
        
        $slider.on('touchstart', function(e) {
            startX = e.originalEvent.touches[0].clientX;
        });
        
        $slider.on('touchend', function(e) {
            endX = e.originalEvent.changedTouches[0].clientX;
            handleSwipe();
        });
        
        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = startX - endX;
            
            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    nextSlide();
                } else {
                    prevSlide();
                }
                stopAutoPlay();
                startAutoPlay();
            }
        }
        
        // Start auto-play
        startAutoPlay();
    }

    // ===== MOBILE MENU TOGGLE =====
    function initMobileMenu() {
        const $menuToggle = $('.mobile-menu-toggle');
        const $primaryMenu = $('.primary-menu-wrapper');
        const $categoryMenu = $('.category-menu-wrapper');
        
        $menuToggle.on('click', function() {
            $primaryMenu.toggleClass('active');
            const isExpanded = $primaryMenu.hasClass('active');
            $menuToggle.attr('aria-expanded', isExpanded);
            
            // Close category menu when mobile menu opens
            if (isExpanded) {
                $categoryMenu.removeClass('active');
            }
        });
        
        // Close menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.main-navigation').length) {
                $primaryMenu.removeClass('active');
                $menuToggle.attr('aria-expanded', 'false');
            }
        });
        
        // Close menu on escape key
        $(document).on('keydown', function(e) {
            if (e.keyCode === 27) { // ESC key
                $primaryMenu.removeClass('active');
                $menuToggle.attr('aria-expanded', 'false');
            }
        });
    }

    // ===== CATEGORY DROPDOWN =====
    function initCategoryDropdown() {
        const $categoryToggle = $('.category-toggle');
        const $categoryDropdown = $('.category-dropdown');
        
        // Show dropdown on click (mobile)
        $categoryToggle.on('click', function() {
            $categoryDropdown.toggleClass('active');
        });
        
        // Hide dropdown when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.category-menu-wrapper').length) {
                $categoryDropdown.removeClass('active');
            }
        });
        
        // Keyboard navigation for category menu
        $categoryToggle.on('keydown', function(e) {
            if (e.keyCode === 13 || e.keyCode === 32) { // Enter or Space
                e.preventDefault();
                $categoryDropdown.toggleClass('active');
            }
        });
    }

    // ===== HEADER SCROLL EFFECTS =====
    function initHeaderScrollEffects() {
        const $header = $('.main-header');
        let lastScrollTop = 0;
        
        $(window).on('scroll', function() {
            const scrollTop = $(this).scrollTop();
            
            if (scrollTop > 100) {
                $header.addClass('scrolled');
            } else {
                $header.removeClass('scrolled');
            }
            
            // Hide/show header on scroll
            if (scrollTop > lastScrollTop && scrollTop > 200) {
                $header.addClass('header-hidden');
            } else {
                $header.removeClass('header-hidden');
            }
            
            lastScrollTop = scrollTop;
        });
    }

    // ===== SEARCH ENHANCEMENTS =====
    function initSearchEnhancements() {
        const $searchInput = $('.search-box input');
        const $searchBox = $('.search-box');
        let searchTimeout;
        
        $searchInput.on('focus', function() {
            $searchBox.addClass('focused');
        });
        
        $searchInput.on('blur', function() {
            $searchBox.removeClass('focused');
        });
        
        $searchInput.on('input', function() {
            clearTimeout(searchTimeout);
            const query = $(this).val().trim();
            
            if (query.length >= 2) {
                searchTimeout = setTimeout(() => {
                    performSearch(query);
                }, 500);
            }
        });
        
        // Search suggestions (placeholder for future implementation)
        function performSearch(query) {
            console.log('Searching for:', query);
            // Here you would implement AJAX search with suggestions
        }
    }

    // ===== FLASH SALE COUNTDOWN =====
    function initCountdownTimer() {
        const $countdown = $('.flash-sale-countdown');
        if (!$countdown.length) return;
        
        // Set deadline (you can make this dynamic via PHP)
        const deadline = new Date();
        deadline.setHours(deadline.getHours() + 24); // 24 hours from now
        
        function updateCountdown() {
            const now = new Date().getTime();
            const distance = deadline.getTime() - now;
            
            if (distance < 0) {
                $countdown.html('<span>Flash Sale đã kết thúc!</span>');
                return;
            }
            
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            $('#countdown-hours').text(hours.toString().padStart(2, '0'));
            $('#countdown-minutes').text(minutes.toString().padStart(2, '0'));
            $('#countdown-seconds').text(seconds.toString().padStart(2, '0'));
            
            // Add pulse effect when time is running out
            if (hours === 0 && minutes < 10) {
                $countdown.addClass('urgent');
            }
        }
        
        updateCountdown();
        setInterval(updateCountdown, 1000);
    }

    // ===== PRODUCT QUICK VIEW =====
    function initQuickView() {
        $('.quick-view').on('click', function(e) {
            e.preventDefault();
            const productId = $(this).data('product-id');
            
            // Show loading
            showNotification('Đang tải thông tin sản phẩm...', 'info');
            
            // Here you would typically make an AJAX call to get product details
            // For now, we'll show a simple modal
            showQuickViewModal(productId);
        });
    }
    
    function showQuickViewModal(productId) {
        const modal = `
            <div class="quick-view-modal" style="
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.8);
                z-index: 10000;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
                animation: fadeIn 0.3s ease;
            ">
                <div class="modal-content" style="
                    background: white;
                    border-radius: 10px;
                    padding: 30px;
                    max-width: 500px;
                    width: 100%;
                    position: relative;
                    animation: slideInUp 0.3s ease;
                ">
                    <button class="close-modal" style="
                        position: absolute;
                        top: 15px;
                        right: 20px;
                        background: none;
                        border: none;
                        font-size: 24px;
                        cursor: pointer;
                        color: #666;
                        transition: color 0.2s ease;
                    ">&times;</button>
                    
                    <h3>Xem nhanh sản phẩm #${productId}</h3>
                    <p>Chức năng này sẽ hiển thị thông tin chi tiết sản phẩm.</p>
                    <p>Bạn có thể tích hợp với WooCommerce để hiển thị thông tin thực tế.</p>
                    
                    <div style="margin-top: 20px;">
                        <button class="add-to-cart" style="
                            background: #f36c21;
                            color: white;
                            border: none;
                            padding: 10px 20px;
                            border-radius: 5px;
                            cursor: pointer;
                            margin-right: 10px;
                            transition: background-color 0.2s ease;
                        ">Thêm vào giỏ</button>
                        
                        <button class="view-details" style="
                            background: #666;
                            color: white;
                            border: none;
                            padding: 10px 20px;
                            border-radius: 5px;
                            cursor: pointer;
                            transition: background-color 0.2s ease;
                        ">Xem chi tiết</button>
                    </div>
                </div>
            </div>
        `;
        
        $('body').append(modal);
        
        // Close modal events
        $('.quick-view-modal').on('click', function(e) {
            if (e.target === this) {
                $(this).remove();
            }
        });
        
        $('.close-modal').on('click', function() {
            $('.quick-view-modal').remove();
        });
        
        // Close on ESC key
        $(document).on('keydown.quickview', function(e) {
            if (e.keyCode === 27) {
                $('.quick-view-modal').remove();
                $(document).off('keydown.quickview');
            }
        });
    }

    // ===== ADD TO CART =====
    function initAddToCart() {
        $('.add-to-cart').on('click', function(e) {
            e.preventDefault();
            const productId = $(this).data('product-id');
            
            // Show loading
            $(this).text('Đang thêm...').prop('disabled', true);
            
            // Simulate AJAX call
            setTimeout(() => {
                showNotification('Đã thêm sản phẩm vào giỏ hàng!', 'success');
                $(this).text('Thêm vào giỏ').prop('disabled', false);
                
                // Update cart count if exists
                updateCartCount();
                
                // Add success animation
                $(this).addClass('success');
                setTimeout(() => {
                    $(this).removeClass('success');
                }, 2000);
            }, 1000);
        });
    }
    
    function updateCartCount() {
        const $cartCount = $('.cart-count');
        if ($cartCount.length) {
            const currentCount = parseInt($cartCount.text()) || 0;
            $cartCount.text(currentCount + 1);
            
            // Add pulse animation
            $cartCount.addClass('pulse');
            setTimeout(() => {
                $cartCount.removeClass('pulse');
            }, 1000);
        }
    }

    // ===== BACK TO TOP =====
    function initBackToTop() {
        const $backToTop = $('#back-to-top');
        
        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 300) {
                $backToTop.addClass('visible');
            } else {
                $backToTop.removeClass('visible');
            }
        });
        
        $backToTop.on('click', function() {
            $('html, body').animate({ scrollTop: 0 }, 600);
        });
    }

    // ===== NEWSLETTER SUBSCRIPTION =====
    function initNewsletter() {
        $('.newsletter-form').on('submit', function(e) {
            e.preventDefault();
            const email = $(this).find('input[name="newsletter_email"]').val().trim();
            
            if (!isValidEmail(email)) {
                showNotification('Vui lòng nhập email hợp lệ!', 'error');
                return;
            }
            
            // Show loading
            const $submitBtn = $(this).find('.newsletter-submit');
            const originalText = $submitBtn.html();
            $submitBtn.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);
            
            // Simulate AJAX call
            setTimeout(() => {
                showNotification('Cảm ơn bạn đã đăng ký nhận tin!', 'success');
                $(this)[0].reset();
                $submitBtn.html(originalText).prop('disabled', false);
            }, 1000);
        });
    }

    // ===== SMOOTH SCROLLING =====
    function initSmoothScroll() {
        $('a[href^="#"]').on('click', function(e) {
            e.preventDefault();
            const target = $($(this).attr('href'));
            
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top - 100
                }, 600);
            }
        });
    }

    // ===== LAZY LOADING =====
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

    // ===== PRODUCT HOVER EFFECTS =====
    function initProductHover() {
        $('.product-card').on('mouseenter', function() {
            $(this).addClass('hover');
        }).on('mouseleave', function() {
            $(this).removeClass('hover');
        });
    }

    // ===== NOTIFICATION SYSTEM =====
    function showNotification(message, type = 'info') {
        const notification = $(`
            <div class="notification notification-${type}" style="
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#17a2b8'};
                color: white;
                padding: 15px 20px;
                border-radius: 5px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                z-index: 10001;
                max-width: 300px;
                animation: slideInRight 0.3s ease;
            ">
                ${message}
            </div>
        `);
        
        $('body').append(notification);
        
        setTimeout(() => {
            notification.fadeOut(300, function() {
                $(this).remove();
            });
        }, 3000);
    }

    // ===== UTILITY FUNCTIONS =====
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
    
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // ===== INITIALIZE ALL FUNCTIONS =====
    function init() {
        initHeroSlider();
        initMobileMenu();
        initCategoryDropdown();
        initHeaderScrollEffects();
        initSearchEnhancements();
        initCountdownTimer();
        initQuickView();
        initAddToCart();
        initBackToTop();
        initNewsletter();
        initSmoothScroll();
        initLazyLoading();
        initProductHover();
    }

    // Start initialization
    init();

    // Add CSS animations and styles
    $('<style>')
        .prop('type', 'text/css')
        .html(`
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            
            @keyframes slideInUp {
                from { transform: translateY(30px); opacity: 0; }
                to { transform: translateY(0); opacity: 1; }
            }
            
            .back-to-top {
                position: fixed;
                bottom: 30px;
                right: 30px;
                width: 50px;
                height: 50px;
                background: #f36c21;
                color: white;
                border: none;
                border-radius: 50%;
                cursor: pointer;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
                z-index: 1000;
            }
            
            .back-to-top.visible {
                opacity: 1;
                visibility: visible;
            }
            
            .back-to-top:hover {
                background: #e55a1a;
                transform: translateY(-3px);
            }
            
            .product-card.hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            }
            
            .main-header.scrolled {
                box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            }
            
            .main-header.header-hidden {
                transform: translateY(-100%);
            }
            
            .search-box.focused {
                transform: scale(1.02);
            }
            
            .search-box.focused input {
                border-color: #f36c21;
                box-shadow: 0 0 0 3px rgba(243, 108, 33, 0.1);
            }
            
            .flash-sale-countdown.urgent {
                animation: pulse 1s infinite;
            }
            
            .add-to-cart.success {
                background-color: #28a745 !important;
                transform: scale(1.05);
            }
            
            .cart-count.pulse {
                animation: pulse 0.6s ease-in-out;
            }
            
            .category-dropdown.active {
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
            }
            
            .primary-menu-wrapper.active {
                display: block;
            }
        `)
        .appendTo('head');
});
