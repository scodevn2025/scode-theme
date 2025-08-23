/**
 * Product Detail Page JavaScript - Enhanced Version
 * Handles gallery, tabs, and interactive features
 * 
 * @package SCODE_Theme
 * @version 2.0.0
 */

(function() {
    'use strict';
    
    // Main PDP object
    const OTNT_PDP = {
        
        // Initialize all functionality
        init: function() {
            console.log('=== PDP JS INITIALIZING ===');
            
            if (!this.isProductPage()) {
                console.log('Not a product page, skipping initialization');
                return;
            }
            
            this.initGallery();
            this.initTabs();
            this.initQuantityControls();
            this.initStickyBar();
            this.initSmoothAnimations();
            this.initScrollEffects();
            this.initVariants(); // Add this line
            this.initSuggestedProducts(); // Add this line
            
            console.log('=== PDP JS INITIALIZED ===');
        },
        
        // Check if current page is a product page
        isProductPage: function() {
            return document.body.classList.contains('single-product') || 
                   document.body.classList.contains('woocommerce') ||
                   document.querySelector('.otnt-pdp') !== null;
        },
        
        // Initialize product gallery
        initGallery: function() {
            const mainImage = document.querySelector('.otnt-pdp__main-img');
            const thumbItems = document.querySelectorAll('.otnt-pdp__thumb-item');
            
            if (!mainImage || thumbItems.length === 0) return;
            
            console.log('Initializing gallery with', thumbItems.length, 'thumbnails');
            
            // Handle thumbnail clicks
            thumbItems.forEach((thumb, index) => {
                thumb.addEventListener('click', function() {
                    const newImage = this.querySelector('img');
                    if (newImage && mainImage) {
                        // Update main image
                        mainImage.src = newImage.src.replace('-150x150', '').replace('-300x300', '');
                        mainImage.alt = newImage.alt;
                        
                        // Update active thumbnail
                        thumbItems.forEach(t => t.classList.remove('active'));
                        this.classList.add('active');
                        
                        // Add zoom effect
                        mainImage.style.transform = 'scale(1.1)';
                        setTimeout(() => {
                            mainImage.style.transform = 'scale(1)';
                        }, 200);
                    }
                });
            });
            
            // Handle zoom button
            const zoomBtn = document.querySelector('.otnt-pdp__zoom-btn');
            if (zoomBtn) {
                zoomBtn.addEventListener('click', function() {
                    OTNT_PDP.openLightbox(mainImage.src, mainImage.alt);
                });
            }
        },
        
        // Open lightbox for image zoom
        openLightbox: function(imageSrc, imageAlt) {
            const lightbox = document.createElement('div');
            lightbox.className = 'otnt-lightbox';
            lightbox.innerHTML = `
                <div class="otnt-lightbox__content">
                    <img src="${imageSrc}" alt="${imageAlt}" class="otnt-lightbox__image">
                    <button class="otnt-lightbox__close" aria-label="Đóng">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            // Add styles
            lightbox.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.9);
                z-index: 10000;
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transition: opacity 0.3s ease;
            `;
            
            const content = lightbox.querySelector('.otnt-lightbox__content');
            content.style.cssText = `
                position: relative;
                max-width: 90vw;
                max-height: 90vh;
                transform: scale(0.8);
                transition: transform 0.3s ease;
            `;
            
            const image = lightbox.querySelector('.otnt-lightbox__image');
            image.style.cssText = `
                width: 100%;
                height: auto;
                border-radius: 8px;
            `;
            
            const closeBtn = lightbox.querySelector('.otnt-lightbox__close');
            closeBtn.style.cssText = `
                position: absolute;
                top: -40px;
                right: 0;
                width: 32px;
                height: 32px;
                background: rgba(255, 255, 255, 0.2);
                border: none;
                border-radius: 50%;
                color: #fff;
                font-size: 16px;
                cursor: pointer;
                transition: all 0.3s ease;
            `;
            
            // Add to DOM
            document.body.appendChild(lightbox);
            
            // Show lightbox
            setTimeout(() => {
                lightbox.style.opacity = '1';
                content.style.transform = 'scale(1)';
            }, 10);
            
            // Close functionality
            const closeLightbox = () => {
                lightbox.style.opacity = '0';
                content.style.transform = 'scale(0.8)';
                setTimeout(() => {
                    document.body.removeChild(lightbox);
                }, 300);
            };
            
            closeBtn.addEventListener('click', closeLightbox);
            lightbox.addEventListener('click', function(e) {
                if (e.target === lightbox) closeLightbox();
            });
            
            // ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') closeLightbox();
            });
        },
        
        // Initialize product tabs
        initTabs: function() {
            const tabBtns = document.querySelectorAll('.otnt-pdp__tab-btn');
            const tabPanes = document.querySelectorAll('.otnt-pdp__tab-pane');
            
            if (tabBtns.length === 0) return;
            
            console.log('Initializing tabs with', tabBtns.length, 'tabs');
            
            tabBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');
                    
                    // Update active button
                    tabBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Update active pane
                    tabPanes.forEach(pane => {
                        if (pane.id === targetTab) {
                            pane.classList.add('active');
                        } else {
                            pane.classList.remove('active');
                        }
                    });
                    
                    // Smooth scroll to tab content
                    const targetPane = document.getElementById(targetTab);
                    if (targetPane) {
                        targetPane.scrollIntoView({ 
                            behavior: 'smooth', 
                            block: 'start' 
                        });
                    }
                });
            });
        },
        
        // Initialize quantity controls
        initQuantityControls: function() {
            const quantityInputs = document.querySelectorAll('.otnt-pdp .quantity input[type="number"]');
            
            quantityInputs.forEach(input => {
                // Add min/max validation
                input.addEventListener('change', function() {
                    const value = parseInt(this.value);
                    const min = parseInt(this.min) || 1;
                    const max = parseInt(this.max) || 999;
                    
                    if (value < min) this.value = min;
                    if (value > max) this.value = max;
                });
                
                // Prevent negative values
                input.addEventListener('keydown', function(e) {
                    if (e.key === '-' || e.key === 'e') {
                        e.preventDefault();
                    }
                });
            });
        },
        
        // Initialize sticky bar
        initStickyBar: function() {
            const stickyBar = document.querySelector('.otnt-sticky');
            if (!stickyBar) return;
            
            let isVisible = false;
            let lastScrollTop = 0;
            
            const toggleStickyBar = () => {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                const windowHeight = window.innerHeight;
                const documentHeight = document.documentElement.scrollHeight;
                
                // Show when scrolling down and near bottom
                if (scrollTop > lastScrollTop && 
                    scrollTop > 300 && 
                    scrollTop + windowHeight < documentHeight - 100) {
                    
                    if (!isVisible) {
                        stickyBar.style.bottom = '0';
                        stickyBar.setAttribute('aria-hidden', 'false');
                        isVisible = true;
                    }
                } else {
                    if (isVisible) {
                        stickyBar.style.bottom = '-100px';
                        stickyBar.setAttribute('aria-hidden', 'true');
                        isVisible = false;
                    }
                }
                
                lastScrollTop = scrollTop;
            };
            
            // Throttled scroll handler
            let ticking = false;
            const handleScroll = () => {
                if (!ticking) {
                    requestAnimationFrame(() => {
                        toggleStickyBar();
                        ticking = false;
                    });
                    ticking = true;
                }
            };
            
            window.addEventListener('scroll', handleScroll, { passive: true });
            
            // Handle window resize
            window.addEventListener('resize', this.debounce(() => {
                if (window.innerWidth <= 768) {
                    stickyBar.style.bottom = '-100px';
                    isVisible = false;
                }
            }, 250));
        },
        
        // Initialize smooth animations
        initSmoothAnimations: function() {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);
            
            // Observe elements for animation
            const animatedElements = document.querySelectorAll(`
                .otnt-pdp__gallery-section,
                .otnt-pdp__summary-section,
                .otnt-pdp__tabs-section,
                .otnt-pdp__related-section
            `);
            
            animatedElements.forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(30px)';
                el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(el);
            });
        },
        
        // Initialize scroll effects
        initScrollEffects: function() {
            let ticking = false;
            
            const handleScroll = () => {
                if (!ticking) {
                    requestAnimationFrame(() => {
                        OTNT_PDP.updateScrollEffects();
                        ticking = false;
                    });
                    ticking = true;
                }
            };
            
            window.addEventListener('scroll', handleScroll, { passive: true });
        },
        
        // Update scroll effects
        updateScrollEffects: function() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const windowHeight = window.innerHeight;
            
            // Parallax effect for gallery
            const gallery = document.querySelector('.otnt-pdp__gallery-section');
            if (gallery) {
                const scrolled = scrollTop * 0.1;
                gallery.style.transform = `translateY(${scrolled}px)`;
            }
            
            // Fade effect for summary
            const summary = document.querySelector('.otnt-pdp__summary-section');
            if (summary) {
                const opacity = Math.max(0.8, 1 - (scrollTop / windowHeight) * 0.2);
                summary.style.opacity = opacity;
            }
        },
        
        // Initialize product variants
        initVariants: function() {
            const variantBtns = document.querySelectorAll('.otnt-pdp__variant-btn');
            const optionBtns = document.querySelectorAll('.otnt-pdp__option-btn');
            
            if (variantBtns.length === 0) return;
            
            console.log('Initializing variants with', variantBtns.length, 'variants');
            
            // Handle variant selection
            variantBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const variant = this.getAttribute('data-variant');
                    
                    // Update active variant
                    variantBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Update price based on variant
                    OTNT_PDP.updatePriceByVariant(variant);
                    
                    console.log('Selected variant:', variant);
                });
            });
            
            // Handle option selection
            optionBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const option = this.getAttribute('data-option');
                    
                    // Toggle active state
                    this.classList.toggle('active');
                    
                    // Update price based on options
                    OTNT_PDP.updatePriceByOptions();
                    
                    console.log('Selected option:', option);
                });
            });
        },
        
        // Update price based on selected variant
        updatePriceByVariant: function(variant) {
            const priceElement = document.querySelector('.otnt-pdp__price-current');
            if (!priceElement) return;
            
            const variantPrices = {
                'x8-pro': '17.900.000₫',
                'x5-pro': '16.500.000₫',
                't50-pro': '15.400.000₫',
                't30s-kr': '13.900.000₫',
                'n30-pro': '9.690.000₫',
                't30s-combo': '14.900.000₫'
            };
            
            if (variantPrices[variant]) {
                priceElement.textContent = variantPrices[variant];
                
                // Add animation
                priceElement.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    priceElement.style.transform = 'scale(1)';
                }, 200);
            }
        },
        
        // Update price based on selected options
        updatePriceByOptions: function() {
            const activeOptions = document.querySelectorAll('.otnt-pdp__option-btn.active');
            const basePrice = 17900000; // Base price for X8 Pro Omni
            let additionalCost = 0;
            
            activeOptions.forEach(option => {
                const optionType = option.getAttribute('data-option');
                
                // Add costs for different options
                switch(optionType) {
                    case 'pump-black':
                        additionalCost += 500000; // 500K for water pump
                        break;
                    case 'standard-demo':
                        additionalCost -= 2000000; // 2M discount for demo
                        break;
                    case 'standard-black':
                    case 'standard-white':
                        // No additional cost for standard colors
                        break;
                }
            });
            
            const totalPrice = basePrice + additionalCost;
            const formattedPrice = totalPrice.toLocaleString('vi-VN') + '₫';
            
            const priceElement = document.querySelector('.otnt-pdp__price-current');
            if (priceElement) {
                priceElement.textContent = formattedPrice;
            }
        },
        
        // Initialize suggested products
        initSuggestedProducts: function() {
            const suggestedBtns = document.querySelectorAll('.otnt-pdp__suggested-btn');
            
            if (suggestedBtns.length === 0) return;
            
            console.log('Initializing suggested products with', suggestedBtns.length, 'products');
            
            suggestedBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product');
                    
                    // Show confirmation dialog
                    if (confirm('Bạn có muốn chuyển sang sản phẩm này không?')) {
                        // Redirect to the suggested product
                        OTNT_PDP.redirectToProduct(productId);
                    }
                });
            });
        },
        
        // Redirect to suggested product
        redirectToProduct: function(productId) {
            const productUrls = {
                'dreame-l10s': '/product/dreame-l10s-ultra/',
                'roborock-s8': '/product/roborock-s8-pro-ultra/',
                'irobot-j7': '/product/irobot-roomba-j7-plus/',
                'tineco-ifloor3': '/product/tineco-ifloor-3/'
            };
            
            const url = productUrls[productId];
            if (url) {
                // Add loading state
                const btn = document.querySelector(`[data-product="${productId}"]`);
                if (btn) {
                    btn.textContent = 'Đang chuyển...';
                    btn.disabled = true;
                }
                
                // Redirect after short delay
                setTimeout(() => {
                    window.location.href = url;
                }, 500);
            } else {
                // Fallback to shop page
                window.location.href = '/shop/';
            }
        },
        
        // Utility: Debounce function
        debounce: function(func, wait) {
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
    };
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => OTNT_PDP.init());
    } else {
        OTNT_PDP.init();
    }
    
    // Handle window resize
    window.addEventListener('resize', OTNT_PDP.debounce(() => {
        // Reinitialize sticky bar on resize
        if (OTNT_PDP.isProductPage()) {
            OTNT_PDP.initStickyBar();
        }
    }, 250));
    
    // Handle visibility change (tab switching)
    document.addEventListener('visibilitychange', () => {
        if (!document.hidden && OTNT_PDP.isProductPage()) {
            // Refresh sticky bar when tab becomes visible
            setTimeout(() => OTNT_PDP.initStickyBar(), 100);
        }
    });
    
    // Expose to global scope
    window.OTNT_PDP = OTNT_PDP;
    
})();