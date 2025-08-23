/**
 * Single Product Page JavaScript
 * 
 * @package ScodeTheme
 */

console.log('=== SINGLE PRODUCT JS LOADED ===');

jQuery(document).ready(function($) {
    'use strict';
    
    console.log('=== JQUERY READY ===');
    console.log('Body classes:', $('body').attr('class'));
    console.log('Single product elements:', $('.single-product-page').length);
    console.log('WooCommerce elements:', $('.woocommerce').length);

    // ===== PRODUCT GALLERY FUNCTIONALITY =====
    function initProductGallery() {
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

    // ===== PRODUCT TABS =====
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

    // ===== QUANTITY CONTROLS =====
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

    // ===== BUY NOW BUTTON =====
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

    // ===== FLASH SALE COUNTDOWN =====
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

    // ===== STICKY CART BAR =====
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

    // ===== LIGHTBOX GALLERY =====
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

    // ===== VIDEO MODAL =====
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

    // ===== READ MORE FUNCTIONALITY =====
    function initReadMore() {
        console.log('=== INIT READ MORE START ===');
        
        const $readMoreBtn = $('#read-more-btn');
        const $descriptionContent = $('#description-content');
        
        console.log('Elements found:', {
            readMoreBtn: $readMoreBtn.length,
            descriptionContent: $descriptionContent.length
        });
        
        if ($readMoreBtn.length === 0) {
            console.error('Read more button not found!');
            return;
        }
        
        if ($descriptionContent.length === 0) {
            console.error('Description content not found!');
            return;
        }
        
        // Always show button initially
        $readMoreBtn.show();
        console.log('Button shown initially');
        
        // Check content height after delay
        setTimeout(() => {
            const contentHeight = $descriptionContent[0].scrollHeight;
            const containerHeight = $descriptionContent.outerHeight();
            
            console.log('Height check:', {
                scrollHeight: contentHeight,
                containerHeight: containerHeight,
                maxHeight: 200
            });
            
            // Show button if content is long
            if (contentHeight > 250) {
                $readMoreBtn.show();
                console.log('Content is long, showing button');
            } else {
                $readMoreBtn.hide();
                console.log('Content is short, hiding button');
            }
        }, 1000);
        
        // Click handler
        $readMoreBtn.on('click', function(e) {
            e.preventDefault();
            console.log('Button clicked!');
            
            const isExpanded = $descriptionContent.hasClass('expanded');
            console.log('Current state:', { isExpanded });
            
            if (isExpanded) {
                // Collapse
                $descriptionContent.removeClass('expanded');
                $('.read-more-text').show();
                $('.read-less-text').hide();
                $('.read-more-icon').show();
                $('.read-less-icon').hide();
                $readMoreBtn.removeClass('expanded');
                console.log('Content collapsed');
            } else {
                // Expand
                $descriptionContent.addClass('expanded');
                $('.read-more-text').hide();
                $('.read-less-text').show();
                $('.read-more-icon').hide();
                $('.read-less-icon').show();
                $readMoreBtn.addClass('expanded');
                console.log('Content expanded');
            }
        });
        
        console.log('=== INIT READ MORE COMPLETE ===');
    }

    // ===== ADD TO CART FUNCTIONALITY =====
    function initAddToCart() {
        $('.add-to-cart-btn, .sticky-add-to-cart').on('click', function(e) {
            e.preventDefault();
            
            const $btn = $(this);
            const productId = $btn.data('product-id');
            const quantity = parseInt($('#quantity').val()) || 1;
            
            // Show loading
            $btn.html('<i class="fas fa-spinner fa-spin"></i> ĐANG THÊM...').prop('disabled', true);
            
            // Simulate AJAX call
            setTimeout(() => {
                showNotification('Đã thêm sản phẩm vào giỏ hàng!', 'success');
                
                // Reset button
                $btn.html('<i class="fas fa-shopping-cart"></i> THÊM VÀO GIỎ').prop('disabled', false);
                
                // Update cart count if exists
                updateCartCount();
                
                // Add success animation
                $btn.addClass('success');
                setTimeout(() => {
                    $btn.removeClass('success');
                }, 2000);
            }, 1000);
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

    // ===== INITIALIZE ALL FUNCTIONS =====
    function init() {
        console.log('=== INIT FUNCTION START ===');
        console.log('Single product page elements:', $('.single-product-page').length);
        console.log('Body classes:', $('body')[0].className);
        
        // Initialize on any page that might be a product page
        console.log('Initializing single product functionality...');
        
        initProductGallery();
        initProductTabs();
        initQuantityControls();
        initBuyNow();
        initFlashSaleCountdown();
        initStickyCartBar();
        initLightboxGallery();
        initVideoModal();
        initReadMore();
        initAddToCart();
        
        console.log('=== INIT FUNCTION COMPLETE ===');
    }

    // Start initialization
    init();

    // Add CSS animations
    $('<style>')
        .prop('type', 'text/css')
        .html(`
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            
            .notification {
                z-index: 10001;
            }
            
            .add-to-cart-btn.success {
                background-color: #28a745 !important;
                transform: scale(1.05);
            }
            
            .cart-count.pulse {
                animation: pulse 0.6s ease-in-out;
            }
            
            .flash-sale-countdown.urgent {
                animation: pulse 1s infinite;
            }
            
            @keyframes pulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.05); }
                100% { transform: scale(1); }
            }
        `)
        .appendTo('head');
});
