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
            $currentSlide.addClass('slide-in');
            
            setTimeout(() => {
                $currentSlide.removeClass('slide-in');
            }, 1000);
        }
        
        function nextSlide() {
            const nextIndex = (currentSlide + 1) % totalSlides;
            showSlide(nextIndex);
        }
        
        function prevSlide() {
            const prevIndex = (currentSlide - 1 + totalSlides) % totalSlides;
            showSlide(nextIndex);
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

    // ===== VERTICAL MEGA MENU =====
    function initVerticalMegaMenu() {
        const $megaMenuItems = $('.mega-menu-item.has-submenu');
        
        $megaMenuItems.each(function() {
            const $item = $(this);
            const $submenu = $item.find('.submenu-dropdown');
            
            // Show submenu on hover
            $item.on('mouseenter', function() {
                $submenu.addClass('active');
            });
            
            $item.on('mouseleave', function() {
                $submenu.removeClass('active');
            });
            
            // Keyboard navigation
            $item.find('.menu-link').on('keydown', function(e) {
                if (e.keyCode === 13 || e.keyCode === 32) { // Enter or Space
                    e.preventDefault();
                    $submenu.toggleClass('active');
                }
            });
        });
        
        // Close submenus when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.mega-menu-item').length) {
                $('.submenu-dropdown').removeClass('active');
            }
        });
        
        // Close submenus on escape key
        $(document).on('keydown', function(e) {
            if (e.keyCode === 27) { // ESC key
                $('.submenu-dropdown').removeClass('active');
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

    // ===== SHORTCUT CATEGORIES INTERACTION =====
    function initShortcutCategories() {
        $('.shortcut-item').on('click', function() {
            const $item = $(this);
            const label = $item.find('.shortcut-label').text();
            
            // Add click animation
            $item.addClass('clicked');
            setTimeout(() => {
                $item.removeClass('clicked');
            }, 300);
            
            // Log the category clicked (you can implement navigation here)
            console.log('Category clicked:', label);
        });
        
        // Add hover effects for shortcut badges
        $('.shortcut-badge').on('mouseenter', function() {
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

    // ===== SINGLE PRODUCT PAGE - PROFESSIONAL LAYOUT =====
    function initSingleProduct() {
        // Product Gallery Functionality
        initProductGallery();
        
        // Product Tabs
        initProductTabs();
        
        // Quantity Controls
        initQuantityControls();
        
        // Buy Now Button
        initBuyNow();
        
        // Flash Sale Countdown
        initFlashSaleCountdown();
        
        // Sticky Cart Bar
        initStickyCartBar();
        
        // Lightbox Gallery
        initLightboxGallery();
        
        // Video Modal
        initVideoModal();
        
        // Thumbnail Navigation
        initThumbnailNavigation();
    }
    
    function initProductGallery() {
        const $thumbnails = $('.thumb-item');
        const $mainImages = $('.main-image');
        
        $thumbnails.on('click', function() {
            const index = $(this).index();
            
            // Update active states
            $thumbnails.removeClass('active');
            $(this).addClass('active');
            
            $mainImages.removeClass('active');
            $mainImages.eq(index).addClass('active');
        });
        
        // Keyboard navigation for gallery
        $(document).on('keydown', function(e) {
            if (!$('.single-product-page').length) return;
            
            const $activeThumbnail = $('.thumb-item.active');
            let newIndex;
            
            if (e.keyCode === 37) { // Left arrow
                newIndex = Math.max(0, $activeThumbnail.index() - 1);
                $thumbnails.eq(newIndex).click();
            } else if (e.keyCode === 39) { // Right arrow
                newIndex = Math.min($thumbnails.length - 1, $activeThumbnail.index() + 1);
                $thumbnails.eq(newIndex).click();
            }
        });
    }
    
    function initProductTabs() {
        const $tabBtns = $('.tab-btn');
        const $tabPanes = $('.tab-pane');
        
        $tabBtns.on('click', function() {
            const tabId = $(this).data('tab');
            
            // Update active states
            $tabBtns.removeClass('active');
            $(this).addClass('active');
            
            $tabPanes.removeClass('active');
            $('#' + tabId).addClass('active');
        });
    }
    
    function initQuantityControls() {
        const $qtyInput = $('.qty');
        const $minusBtn = $('.qty-btn.minus');
        const $plusBtn = $('.qty-btn.plus');
        
        $minusBtn.on('click', function() {
            const currentValue = parseInt($qtyInput.val()) || 1;
            const minValue = parseInt($qtyInput.attr('min')) || 1;
            
            if (currentValue > minValue) {
                $qtyInput.val(currentValue - 1);
            }
        });
        
        $plusBtn.on('click', function() {
            const currentValue = parseInt($qtyInput.val()) || 1;
            const maxValue = parseInt($qtyInput.attr('max')) || 999;
            
            if (currentValue < maxValue) {
                $qtyInput.val(currentValue + 1);
            }
        });
        
        // Validate quantity input
        $qtyInput.on('input', function() {
            let value = parseInt($(this).val()) || 1;
            const minValue = parseInt($(this).attr('min')) || 1;
            const maxValue = parseInt($(this).attr('max')) || 999;
            
            if (value < minValue) value = minValue;
            if (value > maxValue) value = maxValue;
            
            $(this).val(value);
        });
    }
    
    function initBuyNow() {
        $('.btn-buy-now, .sticky-buy-now').on('click', function(e) {
            e.preventDefault();
            
            // Show loading
            $(this).html('<i class="fas fa-spinner fa-spin"></i> ĐANG XỬ LÝ...').prop('disabled', true);
            
            // Simulate processing
            setTimeout(() => {
                showNotification('Đang chuyển đến trang thanh toán...', 'info');
                
                // Reset button
                $(this).html('<i class="fas fa-bolt"></i> MUA NGAY').prop('disabled', false);
                
                // Here you would redirect to checkout or add to cart and redirect
                // window.location.href = '/checkout';
            }, 1500);
        });
    }
    
    function initFlashSaleCountdown() {
        const $countdown = $('.flash-sale-countdown');
        if (!$countdown.length) return;
        
        const deadline = new Date($countdown.data('deadline'));
        
        function updateCountdown() {
            const now = new Date().getTime();
            const distance = deadline.getTime() - now;
            
            if (distance < 0) {
                $countdown.html('<div class="countdown-label">ƯU ĐÃI ĐÃ KẾT THÚC!</div>');
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
    
    function initStickyCartBar() {
        const $stickyBar = $('#sticky-cart-bar');
        if (!$stickyBar.length) return;
        
        const $summary = $('.product-summary-wrapper');
        const summaryBottom = $summary.offset().top + $summary.outerHeight();
        
        function checkScroll() {
            const scrollTop = $(window).scrollTop();
            const windowHeight = $(window).height();
            
            if (scrollTop + windowHeight > summaryBottom) {
                $stickyBar.addClass('visible');
            } else {
                $stickyBar.removeClass('visible');
            }
        }
        
        $(window).on('scroll', debounce(checkScroll, 100));
        checkScroll();
    }
    
    function initLightboxGallery() {
        const $lightbox = $('#lightbox-modal');
        const $lightboxImage = $('.lightbox-image');
        const $closeBtn = $('.lightbox-close');
        const $prevBtn = $('.lightbox-prev');
        const $nextBtn = $('.lightbox-next');
        
        let currentImageIndex = 0;
        const totalImages = $('.main-image').length;
        
        // Open lightbox on zoom click
        $('.zoom-trigger').on('click', function() {
            const $mainImage = $(this).closest('.main-image');
            currentImageIndex = parseInt($mainImage.data('index'));
            openLightbox(currentImageIndex);
        });
        
        function openLightbox(index) {
            const $mainImage = $('.main-image').eq(index);
            const imageSrc = $mainImage.find('.product-main-img').data('zoom');
            
            $lightboxImage.attr('src', imageSrc);
            $lightbox.addClass('active');
            $('body').addClass('lightbox-open');
            
            currentImageIndex = index;
        }
        
        function closeLightbox() {
            $lightbox.removeClass('active');
            $('body').removeClass('lightbox-open');
        }
        
        function showNextImage() {
            const nextIndex = (currentImageIndex + 1) % totalImages;
            openLightbox(nextIndex);
        }
        
        function showPrevImage() {
            const prevIndex = (currentImageIndex - 1 + totalImages) % totalImages;
            openLightbox(prevIndex);
        }
        
        // Event listeners
        $closeBtn.on('click', closeLightbox);
        $nextBtn.on('click', showNextImage);
        $prevBtn.on('click', showPrevImage);
        
        // Close on background click
        $lightbox.on('click', function(e) {
            if (e.target === this) {
                closeLightbox();
            }
        });
        
        // Keyboard navigation
        $(document).on('keydown.lightbox', function(e) {
            if (!$lightbox.hasClass('active')) return;
            
            switch(e.keyCode) {
                case 27: // ESC
                    closeLightbox();
                    break;
                case 37: // Left arrow
                    showPrevImage();
                    break;
                case 39: // Right arrow
                    showNextImage();
                    break;
            }
        });
        
        // Remove event listener when lightbox closes
        $lightbox.on('close', function() {
            $(document).off('keydown.lightbox');
        });
    }
    
    function initVideoModal() {
        const $videoModal = $('#video-modal');
        const $videoIframe = $videoModal.find('iframe');
        const $closeBtn = $('.video-modal-close');
        
        // Open video modal on video click
        $('.video-main, .video-thumb').on('click', function() {
            const videoUrl = $(this).data('video');
            if (videoUrl) {
                const embedUrl = videoUrl.replace('watch?v=', 'embed/');
                $videoIframe.attr('src', embedUrl);
                $videoModal.addClass('active');
                $('body').addClass('video-modal-open');
            }
        });
        
        function closeVideoModal() {
            $videoModal.removeClass('active');
            $('body').removeClass('video-modal-open');
            $videoIframe.attr('src', ''); // Stop video
        }
        
        $closeBtn.on('click', closeVideoModal);
        
        // Close on background click
        $videoModal.on('click', function(e) {
            if (e.target === this) {
                closeVideoModal();
            }
        });
        
        // Close on ESC key
        $(document).on('keydown.videomodal', function(e) {
            if (!$videoModal.hasClass('active')) return;
            
            if (e.keyCode === 27) {
                closeVideoModal();
            }
        });
    }
    
    function initThumbnailNavigation() {
        const $thumbnails = $('.thumb-item');
        const $mainImages = $('.main-image');
        const $leftNav = $('.thumb-nav.left');
        const $rightNav = $('.thumb-nav.right');
        const $thumbnailsContainer = $('.thumbnails-container');
        
        // Thumbnail click
        $thumbnails.on('click', function() {
            const index = parseInt($(this).data('index'));
            showMainImage(index);
        });
        
        function showMainImage(index) {
            // Update main images
            $mainImages.removeClass('active');
            $mainImages.eq(index).addClass('active');
            
            // Update thumbnails
            $thumbnails.removeClass('active');
            $thumbnails.eq(index).addClass('active');
            
            // Scroll thumbnail into view
            const $activeThumb = $thumbnails.eq(index);
            const containerWidth = $thumbnailsContainer.width();
            const thumbWidth = $activeThumb.outerWidth(true);
            const scrollLeft = $activeThumb.position().left - (containerWidth / 2) + (thumbWidth / 2);
            
            $thumbnailsContainer.animate({
                scrollLeft: scrollLeft
            }, 300);
        }
        
        // Navigation arrows
        $leftNav.on('click', function() {
            const $activeThumb = $('.thumb-item.active');
            const currentIndex = $activeThumb.index();
            const prevIndex = Math.max(0, currentIndex - 1);
            showMainImage(prevIndex);
        });
        
        $rightNav.on('click', function() {
            const $activeThumb = $('.thumb-item.active');
            const currentIndex = $activeThumb.index();
            const nextIndex = Math.min($thumbnails.length - 1, currentIndex + 1);
            showMainImage(nextIndex);
        });
        
        // Keyboard navigation
        $(document).on('keydown', function(e) {
            if (!$('.single-product-page').length) return;
            
            const $activeThumb = $('.thumb-item.active');
            let newIndex;
            
            if (e.keyCode === 37) { // Left arrow
                newIndex = Math.max(0, $activeThumb.index() - 1);
                showMainImage(newIndex);
            } else if (e.keyCode === 39) { // Right arrow
                newIndex = Math.min($thumbnails.length - 1, $activeThumb.index() + 1);
                showMainImage(newIndex);
            }
        });
        
        // Show/hide navigation arrows based on scroll position
        function updateNavArrows() {
            const scrollLeft = $thumbnailsContainer.scrollLeft();
            const maxScrollLeft = $thumbnailsContainer[0].scrollWidth - $thumbnailsContainer.width();
            
            $leftNav.toggle(scrollLeft > 0);
            $rightNav.toggle(scrollLeft < maxScrollLeft);
        }
        
        $thumbnailsContainer.on('scroll', updateNavArrows);
        updateNavArrows();
    }

    // ===== INITIALIZE ALL FUNCTIONS =====
    function init() {
        initHeroSlider();
        initVerticalMegaMenu();
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
        initShortcutCategories();
        
        // Initialize single product page functionality if on single product page
        if ($('.single-product-page').length) {
            initSingleProduct();
        }
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
            
            .submenu-dropdown.active {
                opacity: 1;
                visibility: visible;
                transform: translateX(0);
            }
            
            .shortcut-item.clicked {
                transform: scale(0.95);
            }
            
            .shortcut-badge.hover {
                transform: scale(1.1);
            }
            
            /* Responsive adjustments for mega menu */
            @media (max-width: 992px) {
                .submenu-dropdown {
                    position: static;
                    opacity: 1;
                    visibility: visible;
                    transform: none;
                    min-width: 100%;
                    box-shadow: none;
                    border-top: 1px solid rgba(255, 255, 255, 0.1);
                }
                
                .submenu-content {
                    padding: 16px;
                }
                
                .submenu-column {
                    margin-bottom: 16px;
                }
            }
        `)
        .appendTo('head');
});
