/**
 * Product Item Interactions
 * 
 * @package SCODE_Theme
 * @version 1.0.0
 */

(function($) {
    'use strict';

    const ProductItem = {
        init: function() {
            this.bindEvents();
            this.initHeartButtons();
        },

        bindEvents: function() {
            // Heart button click
            $(document).on('click', '.heart-btn', function(e) {
                e.preventDefault();
                ProductItem.toggleHeart($(this));
            });

            // Add to cart button click
            $(document).on('click', '.add-to-cart-btn', function(e) {
                e.preventDefault();
                ProductItem.addToCart($(this));
            });

            // Product image hover effects
            $(document).on('mouseenter', '.product-item', function() {
                ProductItem.handleProductHover($(this), 'enter');
            });

            $(document).on('mouseleave', '.product-item', function() {
                ProductItem.handleProductHover($(this), 'leave');
            });
        },

        initHeartButtons: function() {
            // Check if products are already in wishlist (localStorage)
            $('.heart-btn').each(function() {
                const $btn = $(this);
                const productId = $btn.data('product-id');
                
                if (ProductItem.isInWishlist(productId)) {
                    $btn.addClass('active');
                    $btn.find('i').removeClass('far').addClass('fas');
                }
            });
        },

        toggleHeart: function($btn) {
            const productId = $btn.data('product-id');
            const $icon = $btn.find('i');
            
            if ($btn.hasClass('active')) {
                // Remove from wishlist
                $btn.removeClass('active');
                $icon.removeClass('fas').addClass('far');
                ProductItem.removeFromWishlist(productId);
                
                // Show feedback
                ProductItem.showFeedback($btn, 'Đã xóa khỏi yêu thích', 'success');
            } else {
                // Add to wishlist
                $btn.addClass('active');
                $icon.removeClass('far').addClass('fas');
                ProductItem.addToWishlist(productId);
                
                // Show feedback
                ProductItem.showFeedback($btn, 'Đã thêm vào yêu thích', 'success');
            }

            // Add animation
            $btn.addClass('pulse');
            setTimeout(() => {
                $btn.removeClass('pulse');
            }, 300);
        },

        addToCart: function($btn) {
            const productId = $btn.data('product-id');
            const $originalText = $btn.html();
            
            // Show loading state
            $btn.html('<i class="fas fa-spinner fa-spin"></i> Đang thêm...');
            $btn.prop('disabled', true);
            
            // AJAX request to add to cart
            $.ajax({
                url: scode_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'scode_add_to_cart',
                    product_id: productId,
                    nonce: scode_ajax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        ProductItem.showFeedback($btn, 'Đã thêm vào giỏ hàng!', 'success');
                        
                        // Update cart count if available
                        if (response.data.cart_count !== undefined) {
                            ProductItem.updateCartCount(response.data.cart_count);
                        }
                        
                        // Add success animation
                        $btn.addClass('success');
                        setTimeout(() => {
                            $btn.removeClass('success');
                        }, 1000);
                    } else {
                        ProductItem.showFeedback($btn, response.data.message || 'Có lỗi xảy ra', 'error');
                    }
                },
                error: function() {
                    ProductItem.showFeedback($btn, 'Lỗi kết nối', 'error');
                },
                complete: function() {
                    // Restore original button state
                    setTimeout(() => {
                        $btn.html($originalText);
                        $btn.prop('disabled', false);
                    }, 1500);
                }
            });
        },

        handleProductHover: function($product, action) {
            if (action === 'enter') {
                $product.addClass('hovered');
                
                // Add subtle animation
                $product.find('.product-item-img').addClass('zoomed');
                $product.find('.product-item-photo .onsale, .product-item-photo .new-badge').addClass('bounce');
            } else {
                $product.removeClass('hovered');
                
                // Remove animations
                $product.find('.product-item-img').removeClass('zoomed');
                $product.find('.product-item-photo .onsale, .product-item-photo .new-badge').removeClass('bounce');
            }
        },

        showFeedback: function($element, message, type) {
            // Create feedback element
            const $feedback = $(`
                <div class="product-feedback ${type}">
                    <span>${message}</span>
                </div>
            `);
            
            // Position feedback relative to element
            const offset = $element.offset();
            $feedback.css({
                position: 'absolute',
                top: offset.top - 40,
                left: offset.left + ($element.outerWidth() / 2) - 100,
                zIndex: 1000
            });
            
            // Add to body
            $('body').append($feedback);
            
            // Show and hide with animation
            $feedback.fadeIn(200).delay(2000).fadeOut(200, function() {
                $(this).remove();
            });
        },

        addToWishlist: function(productId) {
            let wishlist = JSON.parse(localStorage.getItem('scode_wishlist') || '[]');
            if (!wishlist.includes(productId)) {
                wishlist.push(productId);
                localStorage.setItem('scode_wishlist', JSON.stringify(wishlist));
            }
        },

        removeFromWishlist: function(productId) {
            let wishlist = JSON.parse(localStorage.getItem('scode_wishlist') || '[]');
            wishlist = wishlist.filter(id => id !== productId);
            localStorage.setItem('scode_wishlist', JSON.stringify(wishlist));
        },

        isInWishlist: function(productId) {
            const wishlist = JSON.parse(localStorage.getItem('scode_wishlist') || '[]');
            return wishlist.includes(productId);
        },

        updateCartCount: function(count) {
            // Update cart count in header if available
            const $cartCount = $('.cart-count, .cart-count-badge');
            if ($cartCount.length) {
                $cartCount.text(count);
                $cartCount.addClass('updated');
                setTimeout(() => {
                    $cartCount.removeClass('updated');
                }, 1000);
            }
        }
    };

    // Initialize when document is ready
    $(document).ready(function() {
        ProductItem.init();
    });

    // Export for global access if needed
    window.ProductItem = ProductItem;

})(jQuery);
