/**
 * Optimized Single Product JavaScript - SCODE Theme
 * Consolidated from pdp.js + single-product.js with error handling
 * 
 * @package SCODE_Theme
 * @version 3.0.0
 */

(function($) {
    'use strict';
    
    // ===== GLOBAL VARIABLES =====
    const PDP = {
        currentImageIndex: 0,
        totalImages: 0,
        isZoomEnabled: false,
        isVideoPlaying: false,
        isStickyCartVisible: false,
        scrollThreshold: 300,
        animationDuration: 300,
        errorRetryAttempts: 3,
        errorRetryDelay: 1000
    };

    // ===== ERROR HANDLING UTILITIES =====
    const ErrorHandler = {
        log: function(message, error = null) {
            if (window.console && console.error) {
                console.error(`[PDP Error] ${message}`, error);
            }
        },

        retry: function(fn, maxAttempts = 3, delay = 1000) {
            return new Promise((resolve, reject) => {
                let attempts = 0;
                
                const attempt = () => {
                    attempts++;
                    try {
                        const result = fn();
                        resolve(result);
                    } catch (error) {
                        if (attempts < maxAttempts) {
                            setTimeout(attempt, delay);
                        } else {
                            reject(error);
                        }
                    }
                };
                
                attempt();
            });
        },

        safeExecute: function(fn, fallback = null) {
            try {
                return fn();
            } catch (error) {
                this.log('Function execution failed', error);
                return fallback;
            }
        }
    };

    // ===== IMAGE GALLERY MANAGEMENT =====
    const ImageGallery = {
        init: function() {
            try {
                this.bindEvents();
                this.setupThumbnails();
                this.updateNavigationState();
            } catch (error) {
                ErrorHandler.log('Image gallery initialization failed', error);
            }
        },

        bindEvents: function() {
            // Thumbnail click events
            $(document).on('click', '.otnt-pdp__thumb-item', function(e) {
                e.preventDefault();
                const index = parseInt($(this).data('index')) || 0;
                ImageGallery.showImage(index);
            });
        
        // Navigation arrows
            $(document).on('click', '.otnt-pdp__nav-prev', function(e) {
                e.preventDefault();
                ImageGallery.showPreviousImage();
            });

            $(document).on('click', '.otnt-pdp__nav-next', function(e) {
                e.preventDefault();
                ImageGallery.showNextImage();
        });
        
        // Keyboard navigation
        $(document).on('keydown', function(e) {
                if (e.key === 'ArrowLeft') {
                    ImageGallery.showPreviousImage();
                } else if (e.key === 'ArrowRight') {
                    ImageGallery.showNextImage();
                }
            });
        },

        setupThumbnails: function() {
            try {
                const thumbnails = $('.otnt-pdp__thumb-item');
                PDP.totalImages = thumbnails.length;
                
                if (PDP.totalImages > 0) {
                    this.updateThumbnailStates();
                }
            } catch (error) {
                ErrorHandler.log('Thumbnail setup failed', error);
            }
        },

        showImage: function(index) {
            try {
                if (index < 0 || index >= PDP.totalImages) {
                    return;
                }

                PDP.currentImageIndex = index;
                
                // Update main image
                const thumbnail = $(`.otnt-pdp__thumb-item[data-index="${index}"]`);
                const mainImage = $('.otnt-pdp__main-img');
                
                if (thumbnail.length && mainImage.length) {
                    const imgSrc = thumbnail.find('img').attr('src');
                    if (imgSrc) {
                        mainImage.attr('src', imgSrc);
                        this.updateThumbnailStates();
                        this.updateNavigationState();
                    }
                }
            } catch (error) {
                ErrorHandler.log('Image display failed', error);
            }
        },

        showPreviousImage: function() {
            const newIndex = PDP.currentImageIndex > 0 ? PDP.currentImageIndex - 1 : PDP.totalImages - 1;
            this.showImage(newIndex);
        },

        showNextImage: function() {
            const newIndex = PDP.currentImageIndex < PDP.totalImages - 1 ? PDP.currentImageIndex + 1 : 0;
            this.showImage(newIndex);
        },

        updateThumbnailStates: function() {
            try {
                $('.otnt-pdp__thumb-item').removeClass('active');
                $(`.otnt-pdp__thumb-item[data-index="${PDP.currentImageIndex}"]`).addClass('active');
            } catch (error) {
                ErrorHandler.log('Thumbnail state update failed', error);
            }
        },

        updateNavigationState: function() {
            try {
                const prevBtn = $('.otnt-pdp__nav-prev');
                const nextBtn = $('.otnt-pdp__nav-next');
                
                if (PDP.totalImages <= 1) {
                    prevBtn.hide();
                    nextBtn.hide();
                } else {
                    prevBtn.show();
                    nextBtn.show();
                }
            } catch (error) {
                ErrorHandler.log('Navigation state update failed', error);
            }
        }
    };

    // ===== TAB SYSTEM =====
    const TabSystem = {
        init: function() {
            try {
                this.bindEvents();
                this.initializeTabs();
            } catch (error) {
                ErrorHandler.log('Tab system initialization failed', error);
            }
        },

        bindEvents: function() {
            $(document).on('click', '.otnt-pdp__tab-btn', function(e) {
            e.preventDefault();
                const tabId = $(this).data('tab');
                TabSystem.switchTab(tabId);
            });
        },

        initializeTabs: function() {
            try {
                const firstTab = $('.otnt-pdp__tab-btn').first();
                if (firstTab.length) {
                    const tabId = firstTab.data('tab');
                    this.switchTab(tabId);
                }
            } catch (error) {
                ErrorHandler.log('Tab initialization failed', error);
            }
        },

        switchTab: function(tabId) {
            try {
                // Update tab buttons
                $('.otnt-pdp__tab-btn').removeClass('active');
                $(`.otnt-pdp__tab-btn[data-tab="${tabId}"]`).addClass('active');

                // Update tab content
                $('.otnt-pdp__tab-pane').removeClass('active');
                $(`#${tabId}`).addClass('active');

                // Trigger custom event
                $(document).trigger('tabChanged', [tabId]);
            } catch (error) {
                ErrorHandler.log('Tab switching failed', error);
            }
        }
    };

    // ===== STICKY CART BAR =====
    const StickyCart = {
        init: function() {
            try {
                this.bindEvents();
                this.checkScrollPosition();
            } catch (error) {
                ErrorHandler.log('Sticky cart initialization failed', error);
            }
        },

        bindEvents: function() {
            $(window).on('scroll', $.throttle(100, () => {
                this.checkScrollPosition();
            }));

            // Add to cart button in sticky bar
            $(document).on('click', '.sticky-add-to-cart', function(e) {
                e.preventDefault();
                $('.single_add_to_cart_button').click();
            });

            // Buy now button in sticky bar
            $(document).on('click', '.sticky-buy-now', function(e) {
                e.preventDefault();
                // Implement buy now functionality
                console.log('Buy now clicked');
            });
        },

        checkScrollPosition: function() {
            try {
            const scrollTop = $(window).scrollTop();
                const shouldShow = scrollTop > PDP.scrollThreshold;
                
                if (shouldShow !== PDP.isStickyCartVisible) {
                    this.toggleStickyCart(shouldShow);
                }
            } catch (error) {
                ErrorHandler.log('Scroll position check failed', error);
            }
        },

        toggleStickyCart: function(show) {
            try {
                PDP.isStickyCartVisible = show;
                const stickyBar = $('.sticky-cart-bar');
                
                if (show) {
                    stickyBar.addClass('visible');
            } else {
                    stickyBar.removeClass('visible');
                }
            } catch (error) {
                ErrorHandler.log('Sticky cart toggle failed', error);
            }
        }
    };

    // ===== PRODUCT FORM ENHANCEMENTS =====
    const ProductForm = {
        init: function() {
            try {
                this.bindEvents();
                this.initializeQuantityControls();
                this.setupVariationHandling();
            } catch (error) {
                ErrorHandler.log('Product form initialization failed', error);
            }
        },

        bindEvents: function() {
            // Quantity controls
            $(document).on('click', '.qty-btn', function(e) {
                e.preventDefault();
                const action = $(this).data('action');
                ProductForm.changeQuantity(action);
            });

            // Add to cart form submission
            $(document).on('submit', '.cart', function(e) {
                return ProductForm.validateForm(e);
            });

            // Variation change events
            $(document).on('change', '.variations select', function() {
                ProductForm.handleVariationChange();
            });
        },

        initializeQuantityControls: function() {
            try {
                const quantityInput = $('.quantity input');
                if (quantityInput.length) {
                    const currentValue = parseInt(quantityInput.val()) || 1;
                    this.updateQuantityDisplay(currentValue);
                }
            } catch (error) {
                ErrorHandler.log('Quantity controls initialization failed', error);
            }
        },

        changeQuantity: function(action) {
            try {
                const quantityInput = $('.quantity input');
                let currentValue = parseInt(quantityInput.val()) || 1;
                
                if (action === 'increase') {
                    currentValue++;
                } else if (action === 'decrease' && currentValue > 1) {
                    currentValue--;
                }
                
                quantityInput.val(currentValue);
                this.updateQuantityDisplay(currentValue);
            } catch (error) {
                ErrorHandler.log('Quantity change failed', error);
            }
        },

        updateQuantityDisplay: function(quantity) {
            try {
                // Update any quantity-dependent displays
                $('.quantity-display').text(quantity);
            } catch (error) {
                ErrorHandler.log('Quantity display update failed', error);
            }
        },

        setupVariationHandling: function() {
            try {
                // Initialize WooCommerce variation form
                if (typeof wc_add_to_cart_variation_params !== 'undefined') {
                    $(document.body).trigger('wc_variation_form');
                }
            } catch (error) {
                ErrorHandler.log('Variation handling setup failed', error);
            }
        },

        handleVariationChange: function() {
            try {
                // Handle variation changes
                $(document.body).trigger('woocommerce_variation_select_change');
            } catch (error) {
                ErrorHandler.log('Variation change handling failed', error);
            }
        },

        validateForm: function(e) {
            try {
                const form = $(e.target);
                const requiredFields = form.find('[required]');
                let isValid = true;

                requiredFields.each(function() {
                    const field = $(this);
                    if (!field.val().trim()) {
                        field.addClass('error');
                        isValid = false;
                    } else {
                        field.removeClass('error');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    this.showErrorMessage('Vui lòng điền đầy đủ thông tin bắt buộc');
                }

                return isValid;
            } catch (error) {
                ErrorHandler.log('Form validation failed', error);
                return false;
            }
        },

        showErrorMessage: function(message) {
            try {
                const errorDiv = $('<div class="form-error-message">').text(message);
                $('.cart').prepend(errorDiv);
                
                setTimeout(() => {
                    errorDiv.fadeOut(() => errorDiv.remove());
                }, 5000);
            } catch (error) {
                ErrorHandler.log('Error message display failed', error);
            }
        }
    };

    // ===== PERFORMANCE OPTIMIZATION =====
    const PerformanceOptimizer = {
        init: function() {
            try {
                this.setupLazyLoading();
                this.optimizeImages();
                this.setupIntersectionObserver();
            } catch (error) {
                ErrorHandler.log('Performance optimization failed', error);
            }
        },

        setupLazyLoading: function() {
            try {
                if ('IntersectionObserver' in window) {
                    const imageObserver = new IntersectionObserver((entries, observer) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                const img = entry.target;
                                img.src = img.dataset.src;
                                img.classList.remove('lazy');
                                observer.unobserve(img);
                            }
                        });
                    });

                    document.querySelectorAll('img[data-src]').forEach(img => {
                        imageObserver.observe(img);
                    });
                }
            } catch (error) {
                ErrorHandler.log('Lazy loading setup failed', error);
            }
        },

        optimizeImages: function() {
            try {
                // Convert images to WebP if supported
                if (this.supportsWebP()) {
                    $('img').each(function() {
                        const img = $(this);
                        const src = img.attr('src');
                        if (src && !src.includes('.webp')) {
                            const webpSrc = src.replace(/\.(jpg|jpeg|png)$/i, '.webp');
                            img.attr('src', webpSrc);
            }
        });
    }
            } catch (error) {
                ErrorHandler.log('Image optimization failed', error);
            }
        },

        supportsWebP: function() {
            try {
                const canvas = document.createElement('canvas');
                canvas.width = 1;
                canvas.height = 1;
                return canvas.toDataURL('image/webp').indexOf('data:image/webp') === 0;
            } catch (error) {
                return false;
            }
        },

        setupIntersectionObserver: function() {
            try {
                if ('IntersectionObserver' in window) {
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                entry.target.classList.add('animate-in');
                            }
                        });
                    }, { threshold: 0.1 });

                    document.querySelectorAll('.otnt-pdp__main-section, .otnt-pdp__tabs-section').forEach(el => {
                        observer.observe(el);
                    });
                }
            } catch (error) {
                ErrorHandler.log('Intersection observer setup failed', error);
            }
        }
    };

    // ===== ANALYTICS AND TRACKING =====
    const Analytics = {
        init: function() {
            try {
                this.trackProductViews();
                this.trackUserInteractions();
            } catch (error) {
                ErrorHandler.log('Analytics initialization failed', error);
            }
        },

        trackProductViews: function() {
            try {
                const productId = $('.otnt-pdp').attr('id')?.replace('product-', '');
                if (productId) {
                    // Track product view
                    if (typeof gtag !== 'undefined') {
                        gtag('event', 'view_item', {
                            'items': [{
                                'id': productId,
                                'name': $('.otnt-pdp__product-title').text(),
                                'category': $('.otnt-pdp__product-categories a').first().text()
                            }]
                        });
                    }
                }
            } catch (error) {
                ErrorHandler.log('Product view tracking failed', error);
            }
        },

        trackUserInteractions: function() {
            try {
                // Track image gallery interactions
                $(document).on('click', '.otnt-pdp__thumb-item', function() {
                    Analytics.trackEvent('gallery_image_click', {
                        'image_index': $(this).data('index')
                    });
                });

                // Track tab interactions
                $(document).on('click', '.otnt-pdp__tab-btn', function() {
                    Analytics.trackEvent('tab_click', {
                        'tab_name': $(this).data('tab')
                    });
                });
            } catch (error) {
                ErrorHandler.log('User interaction tracking failed', error);
            }
        },

        trackEvent: function(eventName, parameters = {}) {
            try {
                if (typeof gtag !== 'undefined') {
                    gtag('event', eventName, parameters);
                }
            } catch (error) {
                ErrorHandler.log('Event tracking failed', error);
            }
        }
    };

    // ===== MAIN INITIALIZATION =====
    const PDPInitializer = {
        init: function() {
            try {
                // Wait for DOM to be ready
                $(document).ready(() => {
                    this.initializeComponents();
                    this.setupErrorBoundaries();
                });

                // Handle page load events
                $(window).on('load', () => {
                    this.onPageLoad();
                });

                // Handle before unload
                $(window).on('beforeunload', () => {
                    this.onBeforeUnload();
                });
            } catch (error) {
                ErrorHandler.log('PDP initialization failed', error);
            }
        },

        initializeComponents: function() {
            try {
                // Initialize all components
                ImageGallery.init();
                TabSystem.init();
                StickyCart.init();
                ProductForm.init();
                PerformanceOptimizer.init();
                Analytics.init();

                // Trigger custom event
                $(document).trigger('pdpInitialized');
            } catch (error) {
                ErrorHandler.log('Component initialization failed', error);
            }
        },

        setupErrorBoundaries: function() {
            try {
                // Global error handler
                window.addEventListener('error', (event) => {
                    ErrorHandler.log('Global error occurred', event.error);
                });

                // Unhandled promise rejection handler
                window.addEventListener('unhandledrejection', (event) => {
                    ErrorHandler.log('Unhandled promise rejection', event.reason);
                });
            } catch (error) {
                ErrorHandler.log('Error boundary setup failed', error);
            }
        },

        onPageLoad: function() {
            try {
                // Remove loading states
                $('.otnt-pdp__loading').removeClass('otnt-pdp__loading');
                
                // Trigger custom event
                $(document).trigger('pdpPageLoaded');
            } catch (error) {
                ErrorHandler.log('Page load handling failed', error);
            }
        },

        onBeforeUnload: function() {
            try {
                // Cleanup any resources
                $(document).trigger('pdpBeforeUnload');
            } catch (error) {
                ErrorHandler.log('Before unload handling failed', error);
            }
        }
    };

    // ===== UTILITY FUNCTIONS =====
    const Utils = {
        debounce: function(func, wait, immediate) {
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
        },

        throttle: function(func, limit) {
            let inThrottle;
            return function() {
                const args = arguments;
                const context = this;
                if (!inThrottle) {
                    func.apply(context, args);
                    inThrottle = true;
                    setTimeout(() => inThrottle = false, limit);
                }
            };
        },

        formatPrice: function(price) {
            try {
                return new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                }).format(price);
            } catch (error) {
                return price + '₫';
            }
        }
    };

    // ===== START INITIALIZATION =====
    PDPInitializer.init();

    // ===== EXPOSE TO GLOBAL SCOPE =====
    window.ScodePDP = {
        ImageGallery,
        TabSystem,
        StickyCart,
        ProductForm,
        PerformanceOptimizer,
        Analytics,
        Utils,
        ErrorHandler
    };

})(jQuery);
